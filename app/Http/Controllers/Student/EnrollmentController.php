<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Section;
use App\Models\Enrollment;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EnrollmentController extends Controller
{
    public function index()
    {
        $courses = Course::with(['department', 'sections'])
            ->where('status', 'Open')
            ->paginate(9);
        $cart = session()->get('cart', []);
        $cartItems = [];
        $totalCredits = 0;
        $totalPrice = 0;
        foreach ($cart as $index => $item) {
            $section = Section::with('course')->find($item['section_id']);
            if ($section) {
                $price = $section->course->credits * 500;
                $cartItems[] = [
                    'index' => $index,
                    'section' => $section,
                    'schedule' => $item['schedule'],
                    'price' => $price
                ];
                $totalCredits += $section->course->credits;
                $totalPrice += $price;
            }
        }
        $departments = \App\Models\Department::all();
        return view('student.enroll', compact('courses', 'cartItems', 'totalCredits', 'totalPrice', 'departments'));
    }

    public function getSections(Course $course)
    {
        $sections = $course->sections()->get();
        foreach ($sections as $section) {
            $section->available_seats = $section->capacity - $section->enrolled_count;
        }
        return response()->json(['course' => $course, 'sections' => $sections]);
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'section_id' => 'required|exists:sections,id',
            'schedule' => 'required|string'
        ]);

        $section = Section::with('course')->find($request->section_id);
        $student = Auth::user()->student;

        // 1. Check seat availability
        if ($section->enrolled_count >= $section->capacity) {
            return response()->json(['success' => false, 'message' => 'This section is full.'], 422);
        }

        // 2. Check for schedule conflicts with existing cart items
        $cart = session()->get('cart', []);
        $conflict = false;
        $conflictCourse = '';

        foreach ($cart as $item) {
            $existingSection = Section::find($item['section_id']);
            if ($existingSection && $this->hasConflict($existingSection, $section)) {
                $conflict = true;
                $conflictCourse = $existingSection->course->course_code . ' - ' . $existingSection->course->title;
                break;
            }
        }

        // 3. Check for schedule conflicts with already enrolled courses
        $enrollments = Enrollment::where('student_id', $student->id)
            ->where('status', 'Enrolled')
            ->with('section')
            ->get();

        foreach ($enrollments as $enrollment) {
            if ($enrollment->section && $this->hasConflict($enrollment->section, $section)) {
                $conflict = true;
                $conflictCourse = $enrollment->section->course->course_code . ' - ' . $enrollment->section->course->title;
                break;
            }
        }

        if ($conflict) {
            return response()->json([
                'success' => false,
                'message' => "Schedule conflict with {$conflictCourse}. Please choose a different schedule."
            ], 422);
        }

        // No conflict, add to cart
        $cart[] = ['section_id' => $request->section_id, 'schedule' => $request->schedule];
        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Added to cart.',
            'cart_count' => count($cart)
        ]);
    }

    /**
     * Check if two sections have overlapping schedule days and times.
     */
    private function hasConflict($section1, $section2)
    {
        $days1 = $this->parseDays($section1->schedule_days);
        $days2 = $this->parseDays($section2->schedule_days);

        // If no common days, no conflict
        $commonDays = array_intersect($days1, $days2);
        if (empty($commonDays)) {
            return false;
        }

        $time1 = $this->parseTimeRange($section1->schedule_time);
        $time2 = $this->parseTimeRange($section2->schedule_time);

        if (!$time1 || !$time2) {
            return false;
        }

        // Overlap if one starts before the other ends and ends after the other starts
        return ($time1['start'] < $time2['end'] && $time1['end'] > $time2['start']);
    }

    private function parseDays($daysString)
    {
        $map = [
            'MWF' => ['Monday', 'Wednesday', 'Friday'],
            'TTh' => ['Tuesday', 'Thursday'],
            'MW'  => ['Monday', 'Wednesday'],
            'TThS'=> ['Tuesday', 'Thursday', 'Saturday'],
            'Sat' => ['Saturday'],
        ];
        return $map[$daysString] ?? [];
    }

    private function parseTimeRange($timeString)
    {
        // Format examples: "8:00 AM - 10:00 AM" or "8:00-10:00 AM"
        $timeString = str_replace(' - ', '-', $timeString);
        preg_match('/(\d{1,2}):(\d{2})\s*(AM|PM)?-(\d{1,2}):(\d{2})\s*(AM|PM)?/i', $timeString, $matches);
        if (count($matches) >= 6) {
            $startHour = (int)$matches[1];
            $startMin = (int)$matches[2];
            $startAmPm = strtoupper($matches[3] ?? '');
            $endHour = (int)$matches[4];
            $endMin = (int)$matches[5];
            $endAmPm = strtoupper($matches[6] ?? '');

            if ($startAmPm == 'PM' && $startHour != 12) $startHour += 12;
            if ($startAmPm == 'AM' && $startHour == 12) $startHour = 0;
            if ($endAmPm == 'PM' && $endHour != 12) $endHour += 12;
            if ($endAmPm == 'AM' && $endHour == 12) $endHour = 0;

            return [
                'start' => $startHour * 60 + $startMin,
                'end'   => $endHour * 60 + $endMin
            ];
        }
        return null;
    }

    public function removeFromCart($cartId)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$cartId])) {
            unset($cart[$cartId]);
            session()->put('cart', array_values($cart));
        }
        return response()->json(['success' => true, 'message' => 'Removed from cart.']);
    }

    public function confirmEnrollment(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('student.enroll.index')->with('error', 'Cart is empty.');
        }
        $student = Auth::user()->student;
        DB::beginTransaction();
        try {
            foreach ($cart as $item) {
                $section = Section::find($item['section_id']);
                if (!$section || $section->enrolled_count >= $section->capacity) {
                    throw new \Exception("{$section->course->title} is no longer available.");
                }
                // Double-check conflict with already enrolled courses (final safety)
                $enrollments = Enrollment::where('student_id', $student->id)
                    ->where('status', 'Enrolled')
                    ->with('section')
                    ->get();
                foreach ($enrollments as $enrollment) {
                    if ($enrollment->section && $this->hasConflict($enrollment->section, $section)) {
                        throw new \Exception("Schedule conflict with {$enrollment->section->course->title}.");
                    }
                }
                $enrollment = Enrollment::create([
                    'student_id' => $student->id,
                    'course_id' => $section->course_id,
                    'section_id' => $section->id,
                    'enrollment_date' => now(),
                    'status' => 'Enrolled'
                ]);
                $section->increment('enrolled_count');
                $amount = $section->course->credits * 500;
                Payment::create([
                    'student_id' => $student->id,
                    'enrollment_id' => $enrollment->id,
                    'amount' => $amount,
                    'payment_date' => now(),
                    'status' => 'pending',
                    'reference_number' => 'INV-' . strtoupper(uniqid()),
                    'payment_method' => null,
                ]);
            }
            session()->forget('cart');
            DB::commit();
            return redirect()->route('student.my-courses')->with('success', 'Enrollment successful!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('student.enroll.index')->with('error', $e->getMessage());
        }
    }
}
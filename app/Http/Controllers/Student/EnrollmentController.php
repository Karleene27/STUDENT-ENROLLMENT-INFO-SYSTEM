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
        $section = Section::find($request->section_id);
        if ($section->enrolled_count >= $section->capacity) {
            return response()->json(['success' => false, 'message' => 'This section is full.'], 422);
        }
        $cart = session()->get('cart', []);
        $cart[] = ['section_id' => $request->section_id, 'schedule' => $request->schedule];
        session()->put('cart', $cart);
        return response()->json(['success' => true, 'message' => 'Added to cart.', 'cart_count' => count($cart)]);
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
                if ($section->enrolled_count >= $section->capacity) {
                    throw new \Exception("{$section->course->title} is full.");
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
            return redirect()->route('student.my-courses')->with('success', 'Enrollment successful! Please pay pending fees.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('student.enroll.index')->with('error', $e->getMessage());
        }
    }
}
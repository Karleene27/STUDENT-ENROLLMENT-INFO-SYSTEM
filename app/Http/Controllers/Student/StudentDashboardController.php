<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $student = $user->student;
        
        if (!$student) {
            return redirect()->back()->with('error', 'Student profile not found.');
        }
        
        // Enrollment data
        $activeEnrollments = $student->enrollments()->where('status', 'Enrolled')->count();
        
        $totalCredits = 0;
        foreach ($student->enrollments()->where('status', 'Enrolled')->get() as $enrollment) {
            $totalCredits += $enrollment->course->credits ?? 0;
        }
        
        $completedCredits = 0;
        foreach ($student->enrollments()->where('status', 'Completed')->get() as $enrollment) {
            $completedCredits += $enrollment->course->credits ?? 0;
        }
        
        $cartCount = count(session()->get('cart', []));
        
        // Payment totals – ensure we use the same status values as in the database
        $pendingPaymentsTotal = $student->payments()->where('status', 'pending')->sum('amount');
        $paidPaymentsTotal = $student->payments()->where('status', 'paid')->sum('amount');
        
        // If your database uses uppercase statuses, change to 'Pending' / 'Paid'
        // $pendingPaymentsTotal = $student->payments()->where('status', 'Pending')->sum('amount');
        
        // Upcoming deadlines (example data – replace with your real logic later)
        $upcomingDeadlines = [
            ['date' => 'May 15, 2025', 'task' => 'Final Exam Period', 'days_left' => 9],
            ['date' => 'May 20, 2025', 'task' => 'Grade Release', 'days_left' => 14],
        ];
        
        // Recommended courses
        $recommendedCourses = Course::where('status', 'Open')->limit(3)->get();
        
        // Current courses
        $currentCourses = $student->enrollments()
            ->where('status', 'Enrolled')
            ->with('course')
            ->get()
            ->pluck('course');
        
        return view('student.dashboard', compact(
            'student', 'activeEnrollments', 'totalCredits', 'completedCredits', 'cartCount',
            'pendingPaymentsTotal', 'paidPaymentsTotal', 'upcomingDeadlines',
            'recommendedCourses', 'currentCourses'
        ));
    }
}
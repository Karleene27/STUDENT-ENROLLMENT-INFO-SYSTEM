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
        
        // Get active enrollments count
        $activeEnrollments = $student->enrollments()->where('status', 'Enrolled')->count();
        
        // Calculate total credits from enrolled courses
        $totalCredits = 0;
        foreach ($student->enrollments()->where('status', 'Enrolled')->get() as $enrollment) {
            if ($enrollment->course) {
                $totalCredits += $enrollment->course->credits;
            }
        }
        
        // Calculate completed credits
        $completedCredits = 0;
        foreach ($student->enrollments()->where('status', 'Completed')->get() as $enrollment) {
            if ($enrollment->course) {
                $completedCredits += $enrollment->course->credits;
            }
        }
        
        // Cart count
        $cartCount = count(session()->get('cart', []));
        
        // NO hardcoded deadlines - only show if there are actual deadlines from database
        $upcomingDeadlines = [];
        
        // You can add real deadlines from assignments or events table here
        // For now, keep it empty
        
        // Recommended courses (only show if student has no enrolled courses)
        $recommendedCourses = [];
        if ($activeEnrollments == 0) {
            $recommendedCourses = Course::where('status', 'Open')->limit(3)->get();
        }
        
        // Current courses (only if enrolled)
        $currentCourses = $student->enrollments()
            ->where('status', 'Enrolled')
            ->with('course')
            ->get()
            ->pluck('course');
        
        return view('student.dashboard', compact(
            'student', 
            'activeEnrollments', 
            'totalCredits',
            'completedCredits', 
            'cartCount', 
            'upcomingDeadlines',
            'recommendedCourses', 
            'currentCourses'
        ));
    }
}
<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MyCoursesController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student;
        $enrollments = $student->enrollments()->with(['course', 'section'])->paginate(6);
        $totalCredits = 0;
        foreach ($enrollments as $enrollment) {
            if ($enrollment->status === 'Enrolled') {
                $totalCredits += $enrollment->course->credits;
            }
        }
        $gpa = $student->gpa;
        return view('student.my-courses', compact('enrollments', 'totalCredits', 'gpa'));
    }
}
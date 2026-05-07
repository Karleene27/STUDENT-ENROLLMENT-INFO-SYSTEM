<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MyGradesController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $student = $user->student;
        
        $grades = $student->enrollments()
            ->whereNotNull('grade')
            ->with('course')
            ->get();
        
        $semesterGpa = 3.63; // Example calculation
        $cumulativeGpa = $student->gpa;
        
        return view('student.my-grades', compact('grades', 'semesterGpa', 'cumulativeGpa'));
    }
}
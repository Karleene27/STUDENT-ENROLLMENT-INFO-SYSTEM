<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Course;

class ReportController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        $enrollments = Enrollment::with(['student', 'course'])->get();
        return view('admin.reports.index', compact('courses', 'enrollments'));
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Course;

class EnrollmentManagementController extends Controller
{
    public function index()
    {
$enrollments = Enrollment::with(['student', 'course'])->paginate(15);
    $courses = Course::withCount('enrollments')->paginate(10);
    return view('admin.enrollments.index', compact('enrollments', 'courses'));
    }
}
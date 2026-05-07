<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalStudents = Student::count();
        $totalEnrolled = Enrollment::where('status', 'Enrolled')->count();
        $pendingApplications = Student::where('status', 'Pending')->count();
        $pendingPayments = Payment::where('status', 'Pending')->count();
        
        // Add this for the pending students card
        $pendingStudents = Student::where('status', 'Pending')->count();
        
        $enrollmentByDept = [
            'CS' => Enrollment::whereHas('course', function($q) {
                $q->where('department_id', 1);
            })->count(),
            'MATH' => Enrollment::whereHas('course', function($q) {
                $q->where('department_id', 2);
            })->count(),
            'ENG' => Enrollment::whereHas('course', function($q) {
                $q->where('department_id', 3);
            })->count(),
            'SCI' => Enrollment::whereHas('course', function($q) {
                $q->where('department_id', 4);
            })->count(),
        ];
        
        $topCourses = Course::withCount('enrollments')
            ->orderBy('enrollments_count', 'desc')
            ->limit(4)
            ->get();
        
        $recentActivities = Enrollment::with(['student', 'course'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        return view('admin.dashboard', compact(
            'totalStudents',
            'totalEnrolled',
            'pendingApplications',
            'pendingPayments',
            'pendingStudents',
            'enrollmentByDept',
            'topCourses',
            'recentActivities'
        ));
    }
}
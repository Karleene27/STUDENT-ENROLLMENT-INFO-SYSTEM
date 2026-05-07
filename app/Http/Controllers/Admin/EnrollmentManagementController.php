<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Course;
use Illuminate\Http\Request;

class EnrollmentManagementController extends Controller
{
    public function index(Request $request)
    {
        $selectedSemester = $request->get('semester', $this->getCurrentSemester());
        // Trim and split by space (handles multiple spaces)
        $parts = preg_split('/\s+/', trim($selectedSemester));
        if (count($parts) !== 3) {
            // Fallback to current semester
            $selectedSemester = $this->getCurrentSemester();
            $parts = preg_split('/\s+/', trim($selectedSemester));
        }
        $semesterLabel = $parts[0] . ' ' . $parts[1]; // e.g., "1st Sem"
        $year = $parts[2];

        // Total enrolled
        $totalEnrolled = Enrollment::whereHas('course', function ($q) use ($semesterLabel, $year) {
            $q->where('semester', $semesterLabel)->where('year', $year);
        })->count();

        $totalCapacity = Course::where('semester', $semesterLabel)->where('year', $year)->sum('capacity') ?? 0;
        $utilizationPercent = $totalCapacity > 0 ? round(($totalEnrolled / $totalCapacity) * 100) : 0;
        $openSeats = max(0, $totalCapacity - $totalEnrolled);
        $waitlistedCount = 0;

        $courses = Course::with('department')
            ->where('semester', $semesterLabel)
            ->where('year', $year)
            ->withCount(['enrollments' => function ($q) {
                $q->where('status', 'Enrolled');
            }])
            ->paginate(10);

        foreach ($courses as $course) {
            $course->utilization = $course->capacity > 0
                ? round(($course->enrollments_count / $course->capacity) * 100)
                : 0;
        }

        // Build dropdown options (ensure they match the exact format used in DB)
        $currentYear = date('Y');
        $years = [$currentYear - 1, $currentYear, $currentYear + 1];
        $semesters = [];
        foreach ($years as $y) {
            $semesters[] = "1st Sem $y";
            $semesters[] = "2nd Sem $y";
        }

        return view('admin.enrollments.index', compact(
            'courses', 'totalEnrolled', 'totalCapacity', 'utilizationPercent',
            'waitlistedCount', 'openSeats', 'semesters', 'selectedSemester'
        ));
    }

    private function getCurrentSemester()
    {
        $month = date('n');
        $year = date('Y');
        $semester = ($month >= 8 || $month <= 1) ? '1st Sem' : '2nd Sem';
        return "$semester $year";
    }
}
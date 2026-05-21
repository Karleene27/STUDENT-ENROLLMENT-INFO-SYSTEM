<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // Generate semester options (1st Sem / 2nd Sem for available years)
        $years = Course::select('year')->distinct()->orderBy('year')->pluck('year')->toArray();
        if (empty($years)) {
            $years = [date('Y')];
        }
        $semesters = [];
        foreach ($years as $year) {
            $semesters[] = "1st Sem $year";
            $semesters[] = "2nd Sem $year";
        }
        // Get all courses for dropdown
        $courses = Course::select('id', 'course_code', 'title')->orderBy('course_code')->get();
        return view('admin.reports.index', compact('semesters', 'courses'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'report_type' => 'required|in:class_roster,enrollment_summary,course_utilization',
            'semester' => 'required|string',
            'course_id' => 'nullable|exists:courses,id',
            'format' => 'required|in:pdf,excel,csv',
        ]);

        list($semesterLabel, $year) = explode(' ', $request->semester);

        $data = [];

        switch ($request->report_type) {
            case 'class_roster':
                $query = Enrollment::with(['student.user', 'course'])
                    ->whereHas('course', function ($q) use ($semesterLabel, $year) {
                        $q->where('semester', $semesterLabel)->where('year', $year);
                    });
                if ($request->course_id) {
                    $query->where('course_id', $request->course_id);
                }
                $enrollments = $query->get();
                $data = $enrollments->map(function ($e) {
                    return [
                        'student_id' => $e->student->student_id,
                        'name' => $e->student->first_name . ' ' . $e->student->last_name,
                        'email' => $e->student->user->email,
                        'course' => $e->course->course_code . ' - ' . $e->course->title,
                        'status' => $e->status,
                        'enrolled_date' => $e->enrollment_date,
                    ];
                });
                break;

            case 'enrollment_summary':
                $courses = Course::withCount(['enrollments' => function ($q) {
                    $q->where('status', 'Enrolled');
                }])
                    ->where('semester', $semesterLabel)
                    ->where('year', $year)
                    ->get();
                $data = $courses->map(function ($c) {
                    return [
                        'course_code' => $c->course_code,
                        'title' => $c->title,
                        'enrolled' => $c->enrollments_count,
                        'capacity' => $c->capacity,
                        'utilization' => $c->capacity > 0 ? round(($c->enrollments_count / $c->capacity) * 100) : 0,
                    ];
                });
                break;

            case 'course_utilization':
                $courses = Course::withCount('enrollments')
                    ->where('semester', $semesterLabel)
                    ->where('year', $year)
                    ->orderBy('enrollments_count', 'desc')
                    ->get();
                $data = $courses->map(function ($c) {
                    return [
                        'course_code' => $c->course_code,
                        'title' => $c->title,
                        'enrolled' => $c->enrollments_count,
                        'capacity' => $c->capacity,
                        'percent' => $c->capacity > 0 ? round(($c->enrollments_count / $c->capacity) * 100) : 0,
                    ];
                });
                break;
        }

        // For preview, return JSON
        if ($request->ajax()) {
            return response()->json(['html' => $this->renderPreviewTable($data, $request->report_type)]);
        }

        // For actual download, we would generate PDF/Excel/CSV here (not implemented yet)
        return redirect()->back()->with('info', 'Download feature coming soon.');
    }

    private function renderPreviewTable($data, $reportType)
    {
        if (empty($data)) {
            return '<p class="text-muted text-center">No data available for the selected criteria.</p>';
        }
        $html = '<table class="table table-sm table-bordered"><thead><tr>';
        $headers = array_keys((array)$data[0]);
        foreach ($headers as $h) {
            $html .= '<th>' . ucfirst(str_replace('_', ' ', $h)) . '</th>';
        }
        $html .= '</tr></thead><tbody>';
        foreach ($data as $row) {
            $html .= '<tr>';
            foreach ((array)$row as $cell) {
                $html .= '<td>' . e($cell) . '</td>';
            }
            $html .= '</tr>';
        }
        $html .= '</tbody></table>';
        return $html;
    }
}
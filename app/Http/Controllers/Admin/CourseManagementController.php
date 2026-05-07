<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Department;
use App\Models\Section;
use Illuminate\Http\Request;

class CourseManagementController extends Controller
{
    public function index()
    {

    $courses = Course::with('department')->paginate(9);
    return view('admin.courses.index', compact('courses'));
     
    }

    public function create()
    {
        $departments = Department::all();
        return view('admin.courses.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_code' => 'required|unique:courses',
            'title' => 'required',
            'credits' => 'required|integer',
            'capacity' => 'required|integer',
        ]);

        Course::create($request->all());
        return redirect()->route('admin.courses.index')->with('success', 'Course created successfully.');
    }

    public function show(Course $course)
    {
        return view('admin.courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        $departments = Department::all();
        return view('admin.courses.edit', compact('course', 'departments'));
    }

    public function update(Request $request, Course $course)
    {
        $course->update($request->all());
        return redirect()->route('admin.courses.index')->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('admin.courses.index')->with('success', 'Course deleted successfully.');
    }

    // Add this method for storing sections
    public function storeSection(Request $request, Course $course)
    {
        $request->validate([
            'section_code' => 'required',
            'schedule_days' => 'required',
            'schedule_time' => 'required',
            'room' => 'required',
            'instructor' => 'required',
            'capacity' => 'required|integer',
        ]);

        Section::create([
            'course_id' => $course->id,
            'section_code' => $request->section_code,
            'schedule_days' => $request->schedule_days,
            'schedule_time' => $request->schedule_time,
            'room' => $request->room,
            'instructor' => $request->instructor,
            'capacity' => $request->capacity,
            'enrolled_count' => 0,
            'status' => 'Open',
        ]);

        return redirect()->route('admin.courses.show', $course)->with('success', 'Section added successfully.');
    }
}
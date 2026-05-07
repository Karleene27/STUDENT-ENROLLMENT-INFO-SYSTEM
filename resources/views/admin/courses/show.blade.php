@extends('layouts.app')

@section('title', 'Course Details')
@section('content')
<div class="fade-in">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">{{ $course->course_code }} - {{ $course->title }}</h2>
            <p class="text-muted">Course details and sections</p>
        </div>
        <div>
            <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-outline-primary me-2">
                <i class="fas fa-edit me-2"></i> Edit Course
            </a>
            <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i> Back
            </a>
        </div>
    </div>
    
    <div class="row">
        <!-- Course Information -->
        <div class="col-md-5">
            <div class="stat-card">
                <h5>Course Information</h5>
                <table class="table table-borderless">
                    <tr><th width="120">Course Code</th><td>{{ $course->course_code }}</td></tr>
                    <tr><th>Title</th><td>{{ $course->title }}</td></tr>
                    <tr><th>Credits</th><td>{{ $course->credits }}</td></tr>
                    <tr><th>Department</th><td>{{ $course->department->dept_name ?? 'N/A' }}</td></tr>
                    <tr><th>Capacity</th><td>{{ $course->capacity }}</td></tr>
                    <tr><th>Status</th>
                        <td>
                            @if($course->status == 'Open')
                                <span class="badge bg-success">Open</span>
                            @elseif($course->status == 'Limited')
                                <span class="badge bg-warning">Limited</span>
                            @elseif($course->status == 'Full')
                                <span class="badge bg-danger">Full</span>
                            @else
                                <span class="badge bg-secondary">Closed</span>
                            @endif
                        </td>
                    </tr>
                    <tr><th>Semester</th><td>{{ $course->semester }} {{ $course->year }}</td></tr>
                    <tr><th>Description</th><td>{{ $course->description ?? 'No description' }}</td></tr>
                </table>
            </div>
        </div>
        
        <!-- Add Section Form -->
        <div class="col-md-7">
            <div class="stat-card">
                <h5>Add New Section</h5>
                <form method="POST" action="{{ route('admin.courses.sections.store', $course) }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Section Code</label>
                            <input type="text" name="section_code" class="form-control" placeholder="e.g., A, B, C" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Schedule Days</label>
                            <select name="schedule_days" class="form-select" required>
                                <option value="MWF">Monday, Wednesday, Friday (MWF)</option>
                                <option value="TTh">Tuesday, Thursday (TTh)</option>
                                <option value="MW">Monday, Wednesday (MW)</option>
                                <option value="TThS">Tuesday, Thursday, Saturday (TThS)</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Schedule Time</label>
                            <input type="text" name="schedule_time" class="form-control" placeholder="e.g., 8:00 AM - 10:00 AM" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Room</label>
                            <input type="text" name="room" class="form-control" placeholder="e.g., Hall 101" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Instructor</label>
                            <input type="text" name="instructor" class="form-control" placeholder="e.g., Prof. Adams" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Capacity</label>
                            <input type="number" name="capacity" class="form-control" value="30" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-gradient w-100">Add Section</button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Existing Sections -->
    <div class="mt-4">
        <div class="stat-card">
            <h5>Course Sections</h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Section</th>
                            <th>Schedule</th>
                            <th>Room</th>
                            <th>Instructor</th>
                            <th>Enrolled</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($course->sections as $section)
                        <tr>
                            <td>{{ $section->section_code }}</td>
                            <td>{{ $section->schedule_days }} {{ $section->schedule_time }}</td>
                            <td>{{ $section->room }}</td>
                            <td>{{ $section->instructor }}</td>
                            <td>{{ $section->enrolled_count }}/{{ $section->capacity }}</td>
                            <td>
                                @if($section->enrolled_count >= $section->capacity)
                                    <span class="badge bg-danger">Full</span>
                                @else
                                    <span class="badge bg-success">Open</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center text-muted">No sections added yet. Add one above.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
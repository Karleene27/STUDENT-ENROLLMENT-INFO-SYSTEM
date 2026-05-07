@extends('layouts.app')

@section('title', 'Edit Course')
@section('content')
<div class="fade-in">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Edit Course</h2>
            <p class="text-muted">Update course information</p>
        </div>
        <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i> Back to Courses
        </a>
    </div>
    
    <div class="stat-card">
        <form method="POST" action="{{ route('admin.courses.update', $course) }}">
            @csrf
            @method('PUT')
            
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Course Code</label>
                        <input type="text" name="course_code" class="form-control form-control-custom" 
                               value="{{ old('course_code', $course->course_code) }}" required readonly>
                        <small class="text-muted">Course code cannot be changed</small>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Credits</label>
                        <input type="number" name="credits" class="form-control form-control-custom" 
                               value="{{ old('credits', $course->credits) }}" required>
                    </div>
                </div>
                
                <div class="col-12">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Course Title</label>
                        <input type="text" name="title" class="form-control form-control-custom" 
                               value="{{ old('title', $course->title) }}" required>
                    </div>
                </div>
                
                <div class="col-12">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" rows="4" class="form-control form-control-custom">{{ old('description', $course->description) }}</textarea>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Department</label>
                        <select name="department_id" class="form-select form-control-custom">
                            @foreach($departments ?? [] as $dept)
                                <option value="{{ $dept->id }}" {{ ($course->department_id == $dept->id) ? 'selected' : '' }}>
                                    {{ $dept->dept_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Capacity</label>
                        <input type="number" name="capacity" class="form-control form-control-custom" 
                               value="{{ old('capacity', $course->capacity) }}">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Semester</label>
                        <select name="semester" class="form-select form-control-custom">
                            <option value="Spring" {{ $course->semester == 'Spring' ? 'selected' : '' }}>Spring</option>
                            <option value="Summer" {{ $course->semester == 'Summer' ? 'selected' : '' }}>Summer</option>
                            <option value="Fall" {{ $course->semester == 'Fall' ? 'selected' : '' }}>Fall</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Year</label>
                        <input type="number" name="year" class="form-control form-control-custom" 
                               value="{{ old('year', $course->year) }}">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Status</label>
                        <select name="status" class="form-select form-control-custom">
                            <option value="Open" {{ $course->status == 'Open' ? 'selected' : '' }}>Open</option>
                            <option value="Limited" {{ $course->status == 'Limited' ? 'selected' : '' }}>Limited</option>
                            <option value="Full" {{ $course->status == 'Full' ? 'selected' : '' }}>Full</option>
                            <option value="Closed" {{ $course->status == 'Closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-gradient px-4">
                    <i class="fas fa-save me-2"></i> Update Course
                </button>
                <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary px-4">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
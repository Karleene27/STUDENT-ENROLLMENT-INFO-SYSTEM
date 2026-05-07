@extends('layouts.app')

@section('title', 'Add New Course')
@section('content')
<div class="fade-in">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Add New Course</h2>
            <p class="text-muted">Create a new course offering</p>
        </div>
        <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i> Back to Courses
        </a>
    </div>
    
    <div class="stat-card">
        <form method="POST" action="{{ route('admin.courses.store') }}">
            @csrf
            
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Course Code <span class="text-danger">*</span></label>
                        <input type="text" name="course_code" class="form-control form-control-custom @error('course_code') is-invalid @enderror" 
                               value="{{ old('course_code') }}" placeholder="e.g., CS101" required>
                        @error('course_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Credits <span class="text-danger">*</span></label>
                        <input type="number" name="credits" class="form-control form-control-custom @error('credits') is-invalid @enderror" 
                               value="{{ old('credits', 3) }}" required>
                        @error('credits')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-12">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Course Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control form-control-custom @error('title') is-invalid @enderror" 
                               value="{{ old('title') }}" placeholder="e.g., Introduction to Computer Science" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-12">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" rows="4" class="form-control form-control-custom @error('description') is-invalid @enderror" 
                                  placeholder="Course description...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Department</label>
                        <select name="department_id" class="form-select form-control-custom @error('department_id') is-invalid @enderror">
                            <option value="">Select Department</option>
                            @foreach($departments ?? [] as $dept)
                                <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                                    {{ $dept->dept_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('department_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Capacity</label>
                        <input type="number" name="capacity" class="form-control form-control-custom @error('capacity') is-invalid @enderror" 
                               value="{{ old('capacity', 30) }}">
                        @error('capacity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Semester</label>
                        <select name="semester" class="form-select form-control-custom @error('semester') is-invalid @enderror">
                            <option value="Spring" {{ old('semester') == 'Spring' ? 'selected' : '' }}>Spring</option>
                            <option value="Summer" {{ old('semester') == 'Summer' ? 'selected' : '' }}>Summer</option>
                            <option value="Fall" {{ old('semester') == 'Fall' ? 'selected' : '' }}>Fall</option>
                        </select>
                        @error('semester')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Year</label>
                        <input type="number" name="year" class="form-control form-control-custom @error('year') is-invalid @enderror" 
                               value="{{ old('year', date('Y')) }}">
                        @error('year')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Status</label>
                        <select name="status" class="form-select form-control-custom @error('status') is-invalid @enderror">
                            <option value="Open" {{ old('status') == 'Open' ? 'selected' : '' }}>Open</option>
                            <option value="Limited" {{ old('status') == 'Limited' ? 'selected' : '' }}>Limited</option>
                            <option value="Full" {{ old('status') == 'Full' ? 'selected' : '' }}>Full</option>
                            <option value="Closed" {{ old('status') == 'Closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-gradient px-4">
                    <i class="fas fa-save me-2"></i> Create Course
                </button>
                <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary px-4">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
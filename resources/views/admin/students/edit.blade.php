@extends('layouts.app')

@section('title', 'Edit Student')
@section('content')
<div class="fade-in">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Edit Student</h2>
            <p class="text-muted">Update student information</p>
        </div>
        <a href="{{ route('admin.students.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i> Back
        </a>
    </div>
    
    <div class="stat-card">
        <form method="POST" action="{{ route('admin.students.update', $student) }}">
            @csrf
            @method('PUT')
            
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">First Name</label>
                        <input type="text" name="first_name" class="form-control form-control-custom" value="{{ $student->first_name }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Last Name</label>
                        <input type="text" name="last_name" class="form-control form-control-custom" value="{{ $student->last_name }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Student ID</label>
                        <input type="text" name="student_id" class="form-control form-control-custom" value="{{ $student->student_id }}" readonly>
                        <small class="text-muted">Student ID cannot be changed</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <input type="email" name="email" class="form-control form-control-custom" value="{{ $student->user->email }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Program</label>
                        <select name="program" class="form-select form-control-custom">
                            <option {{ $student->program == 'Computer Science' ? 'selected' : '' }}>Computer Science</option>
                            <option {{ $student->program == 'Information Technology' ? 'selected' : '' }}>Information Technology</option>
                            <option {{ $student->program == 'Engineering' ? 'selected' : '' }}>Engineering</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Year Level</label>
                        <select name="year_level" class="form-select form-control-custom">
                            <option {{ $student->year_level == 'Freshman' ? 'selected' : '' }}>Freshman</option>
                            <option {{ $student->year_level == 'Sophomore' ? 'selected' : '' }}>Sophomore</option>
                            <option {{ $student->year_level == 'Junior' ? 'selected' : '' }}>Junior</option>
                            <option {{ $student->year_level == 'Senior' ? 'selected' : '' }}>Senior</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Status</label>
                        <select name="status" class="form-select form-control-custom">
                            <option {{ $student->status == 'Active' ? 'selected' : '' }}>Active</option>
                            <option {{ $student->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option {{ $student->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-gradient px-4">
                    <i class="fas fa-save me-2"></i> Update Student
                </button>
                <a href="{{ route('admin.students.index') }}" class="btn btn-secondary px-4">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
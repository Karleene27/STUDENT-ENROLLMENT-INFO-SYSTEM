@extends('layouts.app')

@section('title', 'Add Student')
@section('content')
<div class="fade-in">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Add New Student</h2>
            <p class="text-muted">Create a new student account</p>
        </div>
        <a href="{{ route('admin.students.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i> Back
        </a>
    </div>
    
    <div class="stat-card">
        <form method="POST" action="{{ route('admin.students.store') }}">
            @csrf
            
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">First Name <span class="text-danger">*</span></label>
                        <input type="text" name="first_name" class="form-control form-control-custom" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Last Name <span class="text-danger">*</span></label>
                        <input type="text" name="last_name" class="form-control form-control-custom" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Student ID <span class="text-danger">*</span></label>
                        <input type="text" name="student_id" class="form-control form-control-custom" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control form-control-custom" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Program</label>
                        <select name="program" class="form-select form-control-custom">
                            <option>Computer Science</option>
                            <option>Information Technology</option>
                            <option>Engineering</option>
                            <option>Business Administration</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Year Level</label>
                        <select name="year_level" class="form-select form-control-custom">
                            <option>Freshman</option>
                            <option>Sophomore</option>
                            <option>Junior</option>
                            <option>Senior</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control form-control-custom" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control form-control-custom" required>
                    </div>
                </div>
            </div>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-gradient px-4">
                    <i class="fas fa-save me-2"></i> Create Student
                </button>
                <a href="{{ route('admin.students.index') }}" class="btn btn-secondary px-4">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
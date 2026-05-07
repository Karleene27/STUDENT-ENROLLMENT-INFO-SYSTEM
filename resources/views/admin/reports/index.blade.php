@extends('layouts.app')

@section('title', 'Reports')
@section('content')
<div class="fade-in">
    <h2 class="mb-4">Generate Reports</h2>
    
    <div class="stat-card">
        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label fw-bold">Report Type</label>
                <select class="form-select form-control-custom mb-3">
                    <option>Class Roster</option>
                    <option>Enrollment Summary</option>
                    <option>Grade Report</option>
                    <option>Course Utilization</option>
                </select>
                
                <label class="form-label fw-bold">Semester</label>
                <select class="form-select form-control-custom mb-3">
                    <option>Spring 2025</option>
                    <option>Fall 2024</option>
                </select>
                
                <label class="form-label fw-bold">Course</label>
                <select class="form-select form-control-custom mb-3">
                    <option>All Courses</option>
                    <option>CS101 - Intro to CS</option>
                    <option>CS202 - Data Structures</option>
                </select>
                
                <label class="form-label fw-bold">Format</label>
                <div class="d-flex gap-3 mb-4">
                    <div><input type="radio" name="format" checked> PDF</div>
                    <div><input type="radio" name="format"> Excel</div>
                    <div><input type="radio" name="format"> CSV</div>
                </div>
                
                <button class="btn btn-gradient w-100 py-2">
                    <i class="fas fa-chart-line me-2"></i> Generate Report
                </button>
            </div>
            <div class="col-md-6">
                <div class="bg-light rounded-3 p-4 text-center">
                    <i class="fas fa-file-alt fa-4x text-primary mb-3"></i>
                    <h6>Report Preview</h6>
                    <p class="text-muted small">Select report options and click Generate to preview</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
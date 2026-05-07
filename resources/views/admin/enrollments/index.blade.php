@extends('layouts.app')

@section('title', 'Enrollment Management')
@section('content')
<div class="fade-in">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Enrollment Management</h2>
            <p class="text-muted">Monitor all student enrollments</p>
        </div>
        <select class="form-select w-auto form-control-custom">
            <option>Spring 2025</option>
            <option>Fall 2024</option>
        </select>
    </div>
    
    <!-- Summary -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="stat-card text-center">
                <h2 class="text-primary mb-0">892</h2>
                <small>Total Enrolled</small>
                <div class="progress-bar-custom mt-2">
                    <div class="progress-fill" style="width: 74%"></div>
                </div>
                <small>74% of Capacity</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card text-center">
                <h2 class="text-warning mb-0">23</h2>
                <small>Waitlisted Students</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card text-center">
                <h2 class="text-success mb-0">308</h2>
                <small>Open Seats Available</small>
            </div>
        </div>
    </div>
    
    <!-- Course Enrollment Table -->
    <div class="stat-card">
        <h5 class="mb-3">Course Enrollment Status</h5>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Course Code</th>
                        <th>Course Title</th>
                        <th>Enrolled</th>
                        <th>Capacity</th>
                        <th>Utilization</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>CS101</td>
                        <td>Introduction to CS</td>
                        <td>28</td>
                        <td>30</td>
                        <td>
                            <div class="progress-bar-custom" style="width: 100px;">
                                <div class="progress-fill" style="width: 93%"></div>
                            </div>
                        </td>
                        <td><span class="badge bg-success">Open</span></td>
                        <td><button class="btn btn-sm btn-outline-primary">View Roster</button></td>
                    </tr>
                    <tr>
                        <td>CS202</td>
                        <td>Data Structures</td>
                        <td>25</td>
                        <td>25</td>
                        <td>
                            <div class="progress-bar-custom" style="width: 100px;">
                                <div class="progress-fill bg-danger" style="width: 100%"></div>
                            </div>
                        </td>
                        <td><span class="badge bg-danger">Full</span></td>
                        <td><button class="btn btn-sm btn-outline-primary">View Roster</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
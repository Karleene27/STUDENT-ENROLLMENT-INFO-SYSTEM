@extends('layouts.app')

@section('title', 'Admin Dashboard')
@section('content')
<div class="fade-in">
    <!-- Welcome Banner -->
    <div class="welcome-banner mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-0">Good afternoon, {{ Auth::user()->name }}! 👋</h2>
                <p class="mb-0 opacity-75 small">Here's your university performance snapshot</p>
            </div>
            <div class="bg-white bg-opacity-20 rounded-circle p-2">
                <i class="fas fa-chart-line fa-1x"></i>
            </div>
        </div>
    </div>
    
    <!-- Stats Cards - First Row -->
    <div class="row g-2 mb-3">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value">{{ $totalStudents ?? 0 }}</div>
                        <div class="stat-label">Total Students</div>
                    </div>
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value">{{ $totalEnrolled ?? 0 }}</div>
                        <div class="stat-label">Enrolled Students</div>
                    </div>
                    <div class="stat-icon bg-success bg-opacity-10 text-success">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value">{{ $pendingApplications ?? 0 }}</div>
                        <div class="stat-label">Pending Applications</div>
                    </div>
                    <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value">{{ $pendingPayments ?? 0 }}</div>
                        <div class="stat-label">Pending Payments</div>
                    </div>
                    <div class="stat-icon bg-info bg-opacity-10 text-info">
                        <i class="fas fa-credit-card"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Second Row - Pending Approvals -->
    <div class="row g-2 mb-3">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value">{{ $pendingStudents ?? 0 }}</div>
                        <div class="stat-label">Pending Approvals</div>
                    </div>
                    <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                        <i class="fas fa-user-clock"></i>
                    </div>
                </div>
                @if(($pendingStudents ?? 0) > 0)
                    <a href="{{ route('admin.students.pending') }}" class="small mt-1 d-inline-block">Click Here To Review</a>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Charts Row -->
    <div class="row g-2 mb-3">
        <div class="col-md-7">
            <div class="stat-card">
                <h5 class="mb-2"><i class="fas fa-chart-bar me-2 text-primary"></i> Enrollment by Department</h5>
                <div class="d-flex align-items-end justify-content-around" style="height: 200px;">
                    <div class="text-center">
                        <div class="bg-primary rounded-top" style="width: 60px; height: {{ max(($enrollmentByDept['CS'] ?? 0) / 2, 10) }}px;"></div>
                        <div class="mt-1 fw-bold small">CS</div>
                        <small class="small">{{ $enrollmentByDept['CS'] ?? 0 }}</small>
                    </div>
                    <div class="text-center">
                        <div class="bg-success rounded-top" style="width: 60px; height: {{ max(($enrollmentByDept['MATH'] ?? 0) / 2, 10) }}px;"></div>
                        <div class="mt-1 fw-bold small">MATH</div>
                        <small class="small">{{ $enrollmentByDept['MATH'] ?? 0 }}</small>
                    </div>
                    <div class="text-center">
                        <div class="bg-warning rounded-top" style="width: 60px; height: {{ max(($enrollmentByDept['ENG'] ?? 0) / 2, 10) }}px;"></div>
                        <div class="mt-1 fw-bold small">ENG</div>
                        <small class="small">{{ $enrollmentByDept['ENG'] ?? 0 }}</small>
                    </div>
                    <div class="text-center">
                        <div class="bg-info rounded-top" style="width: 60px; height: {{ max(($enrollmentByDept['SCI'] ?? 0) / 2, 10) }}px;"></div>
                        <div class="mt-1 fw-bold small">SCI</div>
                        <small class="small">{{ $enrollmentByDept['SCI'] ?? 0 }}</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="stat-card">
                <h5 class="mb-2"><i class="fas fa-trophy me-2 text-primary"></i> Top Courses</h5>
                @forelse($topCourses ?? [] as $course)
                <div class="mb-2">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="small">{{ $course->course_code }} - {{ $course->title }}</span>
                        <span class="small">{{ $course->enrollments_count }} students</span>
                    </div>
                    <div class="progress-bar-custom">
                        <div class="progress-fill" style="width: {{ min(($course->enrollments_count / 50) * 100, 100) }}%"></div>
                    </div>
                </div>
                @empty
                <p class="text-muted small">No courses available</p>
                @endforelse
            </div>
        </div>
    </div>
    
    <!-- Recent Activity -->
    <div class="stat-card">
        <h5 class="mb-2"><i class="fas fa-history me-2 text-primary"></i> Recent Activity</h5>
        <div class="table-responsive">
            <table class="table table-sm table-hover">
                <thead>
                    <tr>
                        <th class="small">Date</th>
                        <th class="small">Student</th>
                        <th class="small">Course</th>
                        <th class="small">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentActivities ?? [] as $activity)
                    <tr>
                        <td><small>{{ $activity->created_at->format('M d, h:i A') }}</small></td>
                        <td><small>{{ $activity->student->first_name ?? 'N/A' }} {{ $activity->student->last_name ?? '' }}</small></td>
                        <td><small>{{ $activity->course->title ?? 'N/A' }}</small></td>
                        <td>
                            @if($activity->status == 'Enrolled')
                                <span class="badge-enrolled">Enrolled</span>
                            @elseif($activity->status == 'Pending')
                                <span class="badge-pending">Pending</span>
                            @else
                                <span class="badge-dropped">{{ $activity->status }}</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center text-muted small">No recent activity</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
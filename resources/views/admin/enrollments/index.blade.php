@extends('layouts.app')

@section('title', 'Enrollment Management')
@section('content')
<div class="fade-in">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Enrollment Management</h2>
            <p class="text-muted">Monitor all student enrollments</p>
        </div>
        <form method="GET" action="{{ route('admin.enrollments.index') }}" class="d-flex">
            <select name="semester" class="form-select w-auto form-control-custom me-2" onchange="this.form.submit()">
                @foreach($semesters as $sem)
                    <option value="{{ $sem }}" {{ $selectedSemester == $sem ? 'selected' : '' }}>{{ $sem }}</option>
                @endforeach
            </select>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="stat-card text-center">
                <h2 class="text-primary mb-0">{{ $totalEnrolled }}</h2>
                <small>Total Enrolled</small>
                <div class="progress-bar-custom mt-2">
                    <div class="progress-fill" style="width: {{ $utilizationPercent }}%"></div>
                </div>
                <small>{{ $utilizationPercent }}% of Capacity</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card text-center">
                <h2 class="text-warning mb-0">{{ $waitlistedCount }}</h2>
                <small>Waitlisted Students</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card text-center">
                <h2 class="text-success mb-0">{{ $openSeats }}</h2>
                <small>Open Seats Available</small>
            </div>
        </div>
    </div>

    <!-- Course Enrollment Table -->
    <div class="stat-card">
        <h5 class="mb-3">Course Enrollment Status ({{ $selectedSemester }})</h5>
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
                    @forelse($courses as $course)
                    <tr>
                        <td>{{ $course->course_code }}</td>
                        <td>{{ $course->title }}</td>
                        <td>{{ $course->enrollments_count }}</td>
                        <td>{{ $course->capacity }}</td>
                        <td>
                            <div class="progress-bar-custom" style="width: 100px;">
                                <div class="progress-fill {{ $course->utilization >= 100 ? 'bg-danger' : ($course->utilization >= 80 ? 'bg-warning' : 'bg-success') }}" 
                                     style="width: {{ $course->utilization }}%"></div>
                            </div>
                            <small>{{ $course->utilization }}%</small>
                        </td>
                        <td>
                            @if($course->utilization >= 100)
                                <span class="badge bg-danger">Full</span>
                            @elseif($course->utilization >= 80)
                                <span class="badge bg-warning">Limited</span>
                            @else
                                <span class="badge bg-success">Open</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.courses.show', $course) }}" class="btn btn-sm btn-outline-primary">View Roster</a>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No courses found for {{ $selectedSemester }}.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-3">
            {{ $courses->onEachSide(1)->links('vendor.pagination.compact') }}
        </div>
    </div>
</div>
@endsection
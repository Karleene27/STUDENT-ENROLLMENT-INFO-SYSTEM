@extends('layouts.app')

@section('title', 'My Grades')
@section('content')
<div class="fade-in">
    <h2 class="mb-4">My Grades & Transcript</h2>
    
    @if($grades->count() > 0)
        <!-- Grade Summary Cards - Only show if there are grades -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="stat-card text-center">
                    <h3 class="text-primary mb-0">{{ number_format($semesterGpa ?? 0, 2) }}</h3>
                    <small class="text-muted">Semester GPA</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card text-center">
                    <h3 class="text-success mb-0">{{ number_format($cumulativeGpa ?? 0, 2) }}</h3>
                    <small class="text-muted">Cumulative GPA</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card text-center">
                    <h3 class="text-info mb-0"><i class="fas fa-trophy"></i> ✓</h3>
                    <small class="text-muted">Dean's List</small>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card text-center">
                    <h3 class="text-success mb-0"><i class="fas fa-check-circle"></i></h3>
                    <small class="text-muted">Good Standing</small>
                </div>
            </div>
        </div>
        
        <!-- Grades Table -->
        <div class="stat-card">
            <h5 class="mb-3">Your Grades</h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr><th>Course</th><th>Code</th><th>Credits</th><th>Grade</th><th>GPA Value</th></tr>
                    </thead>
                    <tbody>
                        @foreach($grades as $grade)
                        <tr>
                            <td>{{ $grade->course->title }}</td>
                            <td>{{ $grade->course->course_code }}</td>
                            <td>{{ $grade->course->credits }}</td>
                            <td><span class="badge bg-primary">{{ $grade->grade }}</span></td>
                            <td>{{ number_format($grade->grade_points ?? 0, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <!-- Empty state - No grades yet -->
        <div class="stat-card text-center py-5">
            <i class="fas fa-chart-line fa-4x text-muted mb-3"></i>
            <h5>No Grades Yet</h5>
            <p class="text-muted">You don't have any grades recorded yet. Once you complete courses, your grades will appear here.</p>
            <a href="{{ route('student.enroll.index') }}" class="btn btn-gradient mt-2">Browse Courses</a>
        </div>
    @endif
</div>
@endsection
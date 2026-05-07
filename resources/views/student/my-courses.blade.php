@extends('layouts.app')
@section('title', 'My Courses')
@section('content')
<div class="fade-in">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>My Courses</h2>
        <a href="{{ route('student.enroll.index') }}" class="btn btn-gradient">+ Enroll More</a>
    </div>
    <div class="row g-4">
        @forelse($enrollments as $enrollment)
        <div class="col-md-4">
            <div class="course-card">
                <div class="course-code">{{ $enrollment->course->course_code }}</div>
                <div class="course-title">{{ $enrollment->course->title }}</div>
                <div class="course-info"><i class="fas fa-user"></i> {{ $enrollment->section->instructor ?? 'TBA' }}</div>
                <div class="course-info"><i class="fas fa-clock"></i> {{ $enrollment->section->schedule_days ?? 'MWF' }} {{ $enrollment->section->schedule_time ?? '' }}</div>
                <div class="mt-3">
                    <button onclick="openDropModal({{ $enrollment->id }}, '{{ $enrollment->course->title }}')" class="btn btn-sm btn-danger">Drop Course</button>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12"><p class="text-muted">No courses enrolled.</p></div>
        @endforelse
    </div>
    <div class="d-flex justify-content-center mt-4">
        {{ $enrollments->links() }}
    </div>
</div>
<!-- Drop Modal (unchanged) -->
<div class="modal fade" id="dropModal" tabindex="-1">...</div>
<script>
function openDropModal(id, name) {
    document.getElementById('dropCourseName').textContent = name;
    document.getElementById('dropForm').action = '/student/enrollments/' + id + '/drop';
    new bootstrap.Modal(document.getElementById('dropModal')).show();
}
</script>
@endsection
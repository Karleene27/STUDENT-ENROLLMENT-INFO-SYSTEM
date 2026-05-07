@extends('layouts.app')

@section('title', 'Manage Courses')
@section('content')
<div class="fade-in">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Manage Courses</h2>
            <p class="text-muted">View, add, edit, or remove course offerings</p>
        </div>
        <a href="{{ route('admin.courses.create') }}" class="btn btn-gradient">
            <i class="fas fa-plus me-2"></i> Add New Course
        </a>
    </div>

    <!-- Search -->
    <div class="stat-card mb-4">
        <input type="text" id="searchInput" class="form-control form-control-custom" placeholder="🔍 Search by course code or title...">
    </div>

    <!-- Courses Grid -->
    <div class="row g-4" id="courseGrid">
        @forelse($courses ?? [] as $course)
        <div class="col-md-6 col-lg-4">
            <div class="course-card">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="course-code">{{ $course->course_code }}</span>
                    @if($course->status == 'Open')
                        <span class="badge bg-success">🟢 Open</span>
                    @elseif($course->status == 'Limited')
                        <span class="badge bg-warning">🟡 Limited</span>
                    @elseif($course->status == 'Full')
                        <span class="badge bg-danger">🔴 Full</span>
                    @else
                        <span class="badge bg-secondary">Closed</span>
                    @endif
                </div>

                <h5 class="mt-2">{{ $course->title }}</h5>
                <p class="text-muted small">{{ Str::limit($course->description ?? 'No description', 80) }}</p>

                <div class="course-info mt-2">
                    <i class="fas fa-star me-2"></i> {{ $course->credits }} credits
                </div>
                <div class="course-info">
                    <i class="fas fa-users me-2"></i> Capacity: {{ $course->capacity }}
                </div>
                <div class="course-info">
                    <i class="fas fa-chart-line me-2"></i> Enrolled: {{ $course->enrollments_count ?? 0 }}
                </div>

                <div class="mt-3">
                    <div class="d-flex justify-content-between small mb-1">
                        <span>Utilization</span>
                        <span>{{ $course->enrollments_count ?? 0 }}/{{ $course->capacity }}</span>
                    </div>
                    <div class="progress-bar-custom">
                        <div class="progress-fill" style="width: {{ ($course->enrollments_count ?? 0) / $course->capacity * 100 }}%"></div>
                    </div>
                </div>

                <div class="mt-3 d-flex gap-2">
                    <a href="{{ route('admin.courses.show', $course) }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-eye me-1"></i> View
                    </a>
                    <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    <button onclick="deleteCourse({{ $course->id }})" class="btn btn-sm btn-outline-danger">
                        <i class="fas fa-trash me-1"></i>
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="stat-card text-center py-5">
                <i class="fas fa-book fa-4x text-muted mb-3"></i>
                <h5>No Courses Found</h5>
                <p class="text-muted">Click "Add New Course" to create your first course.</p>
                <a href="{{ route('admin.courses.create') }}" class="btn btn-gradient mt-2">
                    <i class="fas fa-plus me-2"></i> Add New Course
                </a>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $courses->onEachSide(1)->links('vendor.pagination.compact') }}
    </div>

</div>

<script>
function deleteCourse(id) {
    if(confirm('Are you sure you want to delete this course? This action cannot be undone.')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>

@foreach($courses ?? [] as $course)
<form id="delete-form-{{ $course->id }}" action="{{ route('admin.courses.destroy', $course) }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endforeach
@endsection
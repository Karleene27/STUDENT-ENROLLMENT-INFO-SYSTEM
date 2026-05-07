@extends('layouts.app')

@section('title', 'Enroll in Courses')
@section('content')
<div class="fade-in">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Enroll in Courses</h2>
            <p class="text-muted">Spring 2025 • Enrollment ends April 15, 2025</p>
        </div>
        <div class="text-end">
            <span class="badge bg-primary p-2">
                <i class="fas fa-shopping-cart me-1"></i> Cart: <span id="cartCount">{{ count($cartItems ?? []) }}</span>
            </span>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="stat-card mb-4">
        <div class="row g-3">
            <div class="col-md-8">
                <input type="text" id="searchInput" class="form-control form-control-custom" placeholder="🔍 Search by course code, title, or instructor...">
            </div>
            <div class="col-md-4">
                <select id="departmentFilter" class="form-select form-control-custom">
                    <option value="">All Departments</option>
                    @foreach($departments ?? [] as $dept)
                    <option value="{{ $dept->id }}">{{ $dept->dept_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Course List -->
    <div class="row g-4" id="courseList">
        @forelse($courses ?? [] as $course)
        <div class="col-md-6 col-lg-4 course-card-item" data-course-id="{{ $course->id }}" data-department="{{ $course->department_id }}">
            <div class="course-card">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="course-code">{{ $course->course_code }}</span>
                    @if($course->status == 'Open')
                        <span class="badge bg-success">🟢 Open</span>
                    @elseif($course->status == 'Limited')
                        <span class="badge bg-warning">🟡 Limited</span>
                    @else
                        <span class="badge bg-danger">🔴 Full</span>
                    @endif
                </div>
                <h5 class="course-title">{{ $course->title }}</h5>
                <p class="text-muted small">{{ Str::limit($course->description ?? 'No description available.', 100) }}</p>
                <div class="course-info"><i class="fas fa-building"></i> {{ $course->department->dept_name ?? 'General' }}</div>
                <div class="course-info"><i class="fas fa-star"></i> {{ $course->credits }} credits</div>
                <div class="course-info"><i class="fas fa-users"></i> {{ $course->available_seats ?? $course->capacity }} seats available</div>
                <div class="mt-3">
                    <button onclick="viewSections({{ $course->id }}, '{{ $course->course_code }} - {{ addslashes($course->title) }}')" class="btn btn-gradient w-100">View Schedules</button>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="stat-card text-center py-5">
                <i class="fas fa-book fa-4x text-muted mb-3"></i>
                <h5>No Courses Available</h5>
                <p class="text-muted">Check back later for course offerings.</p>
            </div>
        </div>
        @endforelse
    </div>

    <!-- PAGINATION (centered, compact) -->
    <div class="d-flex justify-content-center mt-4">
{{ $courses->onEachSide(1)->links('vendor.pagination.compact') }}    </div>

    <!-- Cart Section -->
    <div class="mt-4">
        <div class="stat-card">
            <h5 class="mb-3"><i class="fas fa-shopping-cart me-2 text-primary"></i> My Enrollment Cart</h5>
            <div id="cartItems">
                @if(empty($cartItems))
                    <p class="text-muted text-center py-3">Your cart is empty. Browse courses above to add.</p>
                @else
                    @foreach($cartItems as $item)
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom" data-cart-index="{{ $item['index'] }}">
                        <div>
                            <div class="fw-medium">{{ $item['section']->course->course_code }} - {{ $item['section']->course->title }}</div>
                            <small class="text-muted">{{ $item['schedule'] }} • {{ $item['section']->instructor }} • Room {{ $item['section']->room }}</small>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold text-primary">₱{{ number_format($item['price'], 2) }}</div>
                            <button onclick="removeFromCart({{ $item['index'] }})" class="btn btn-sm btn-danger mt-1">Remove</button>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
            <div class="mt-3 pt-2 border-top d-flex justify-content-between align-items-center">
                <div>
                    <span class="fw-bold">Total Credits: <span id="totalCredits">{{ $totalCredits ?? 0 }}</span></span>
                    <span class="fw-bold ms-3">Total Price: <span id="totalPrice" class="text-primary">₱{{ number_format($totalPrice ?? 0, 2) }}</span></span>
                </div>
                <form id="enrollForm" action="{{ route('student.enroll.confirm') }}" method="POST">
                    @csrf
                    <button type="submit" id="confirmBtn" class="btn btn-gradient" {{ empty($cartItems) ? 'disabled' : '' }}>
                        <i class="fas fa-check me-2"></i> Confirm Enrollment
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Schedule Modal -->
<div class="modal fade" id="scheduleModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCourseTitle">Select Schedule</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="sectionsList">
                <!-- Sections loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
function viewSections(courseId, courseTitle) {
    document.getElementById('modalCourseTitle').innerHTML = courseTitle + ' - Select Schedule';
    fetch(`/student/enroll/course/${courseId}/sections`)
        .then(response => response.json())
        .then(data => {
            const sectionsList = document.getElementById('sectionsList');
            sectionsList.innerHTML = '';
            if (data.sections.length === 0) {
                sectionsList.innerHTML = '<p class="text-muted text-center py-4">No schedules available.</p>';
            } else {
                data.sections.forEach(section => {
                    const availableSeats = section.capacity - section.enrolled_count;
                    sectionsList.innerHTML += `
                        <div class="border rounded-3 p-3 mb-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-2">Section ${section.section_code}</h6>
                                    <p class="mb-1"><i class="fas fa-clock text-primary me-2"></i> ${section.schedule_time}</p>
                                    <p class="mb-1"><i class="fas fa-calendar text-primary me-2"></i> ${section.schedule_days}</p>
                                    <p class="mb-1"><i class="fas fa-location-dot text-primary me-2"></i> ${section.room}</p>
                                    <p class="mb-1"><i class="fas fa-user text-primary me-2"></i> ${section.instructor}</p>
                                    <p class="mb-0 ${availableSeats > 0 ? 'text-success' : 'text-danger'}">
                                        <i class="fas fa-users me-2"></i> ${availableSeats} / ${section.capacity} seats available
                                    </p>
                                </div>
                                ${availableSeats > 0 ? `<button onclick="addToCart(${section.id}, '${section.schedule_days} ${section.schedule_time}')" class="btn btn-gradient">Select</button>` : `<button class="btn btn-secondary" disabled>Full</button>`}
                            </div>
                        </div>
                    `;
                });
            }
            new bootstrap.Modal(document.getElementById('scheduleModal')).show();
        });
}

function addToCart(sectionId, schedule) {
    fetch('{{ route("student.enroll.addToCart") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ section_id: sectionId, schedule: schedule })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) location.reload();
        else showToast(data.message, 'error');
    });
}

function removeFromCart(index) {
    fetch(`/student/enroll/remove-from-cart/${index}`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    })
    .then(response => response.json())
    .then(data => { if (data.success) location.reload(); });
}

function showToast(message, type) {
    let container = document.getElementById('toast-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toast-container';
        container.style.position = 'fixed';
        container.style.bottom = '20px';
        container.style.right = '20px';
        container.style.zIndex = '9999';
        document.body.appendChild(container);
    }
    const toast = document.createElement('div');
    toast.className = `toast align-items-center text-white bg-${type === 'success' ? 'success' : 'danger'} border-0 show`;
    toast.innerHTML = `<div class="d-flex"><div class="toast-body">${message}</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div>`;
    container.appendChild(toast);
    setTimeout(() => { toast.classList.remove('show'); setTimeout(() => toast.remove(), 300); }, 3000);
}

// Search & filter
document.getElementById('searchInput')?.addEventListener('keyup', filterCourses);
document.getElementById('departmentFilter')?.addEventListener('change', filterCourses);
function filterCourses() {
    const searchTerm = document.getElementById('searchInput')?.value.toLowerCase() || '';
    const departmentId = document.getElementById('departmentFilter')?.value || '';
    const courses = document.querySelectorAll('.course-card-item');
    courses.forEach(course => {
        const text = course.innerText.toLowerCase();
        const matchesSearch = text.includes(searchTerm);
        const matchesDept = !departmentId || course.dataset.department == departmentId;
        course.style.display = (matchesSearch && matchesDept) ? '' : 'none';
    });
}
</script>
@endsection
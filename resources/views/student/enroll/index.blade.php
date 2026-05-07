@extends('layouts.app')

@section('title', 'Enroll in Courses')
@section('header', 'Enroll in Courses')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header Info -->
        <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-blue-800">Spring 2025 Enrollment Period</p>
                    <p class="text-xs text-blue-600">March 1 - April 15, 2025 • 5 days remaining</p>
                </div>
                <div class="text-right">
                    <p class="text-sm font-medium text-blue-800">Cart: <span id="cartCount">{{ count($cartItems ?? []) }}</span> course(s)</p>
                    <a href="#cart" class="text-xs text-blue-600 hover:underline">View Cart →</a>
                </div>
            </div>
        </div>
        
        <!-- Search and Filter Bar -->
        <div class="bg-white shadow-sm rounded-xl p-4 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-2">
                    <input type="text" id="searchInput" placeholder="Search by course code, title, or instructor..." 
                           class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div>
                    <select id="departmentFilter" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">All Departments</option>
                        @foreach($departments ?? [] as $dept)
                        <option value="{{ $dept->id }}">{{ $dept->dept_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        
        <!-- Course List -->
        <div id="courseList" class="space-y-4">
            @forelse($courses ?? [] as $course)
            <div class="bg-white shadow-sm rounded-xl overflow-hidden course-card" data-course-id="{{ $course->id }}" data-department="{{ $course->department_id }}">
                <div class="p-5">
                    <div class="flex flex-wrap justify-between items-start gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="text-xs font-medium text-indigo-600">{{ $course->course_code }}</span>
                                <span class="px-2 py-1 text-xs rounded-full 
                                    @if($course->status == 'Open') bg-green-100 text-green-700
                                    @elseif($course->status == 'Limited') bg-yellow-100 text-yellow-700
                                    @elseif($course->status == 'Full') bg-red-100 text-red-700
                                    @else bg-gray-100 text-gray-700
                                    @endif">
                                    {{ $course->status }}
                                </span>
                                <span class="text-xs text-gray-500">{{ $course->credits }} credits</span>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $course->title }}</h3>
                            <p class="text-sm text-gray-600 mt-1">{{ Str::limit($course->description, 150) }}</p>
                            <div class="mt-3 flex flex-wrap gap-4 text-sm text-gray-500">
                                <span>📚 {{ $course->department->dept_name ?? 'General' }}</span>
                                <span>🎓 {{ $course->available_seats ?? $course->capacity }} seats available</span>
                            </div>
                        </div>
                        <div>
                            <button onclick="viewSections({{ $course->id }}, '{{ $course->course_code }} - {{ $course->title }}')" 
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                                View Schedules
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white shadow-sm rounded-xl p-8 text-center">
                <p class="text-gray-500">No courses available for enrollment.</p>
            </div>
            @endforelse
        </div>
        
        <!-- Enrollment Cart -->
        <div id="cart" class="mt-8 bg-white shadow-sm rounded-xl overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">🛒 My Enrollment Cart</h3>
            </div>
            <div class="p-6">
                <div id="cartItems">
                    @if(empty($cartItems))
                    <p class="text-gray-500 text-center py-4">Your cart is empty. Browse courses above to add.</p>
                    @else
                    @foreach($cartItems as $index => $item)
                    <div class="flex justify-between items-center py-3 border-b border-gray-100 last:border-0" data-cart-index="{{ $index }}">
                        <div>
                            <p class="font-medium text-gray-800">{{ $item['section']->course->course_code }} - {{ $item['section']->course->title }}</p>
                            <p class="text-sm text-gray-500">{{ $item['schedule'] }} • {{ $item['section']->instructor }} • Room {{ $item['section']->room }}</p>
                        </div>
                        <button onclick="removeFromCart({{ $index }})" class="text-red-600 hover:text-red-800 text-sm">
                            Remove
                        </button>
                    </div>
                    @endforeach
                    @endif
                </div>
                
                <div class="mt-4 pt-4 border-t border-gray-200 flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-600">Total Credits: <span id="totalCredits">{{ $totalCredits ?? 0 }}</span></p>
                        <p id="scheduleStatus" class="text-xs text-green-600">✓ No schedule conflicts</p>
                    </div>
                    <form id="enrollForm" action="{{ route('student.enroll.confirm') }}" method="POST">
                        @csrf
                        <button type="submit" id="confirmBtn" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium transition" {{ empty($cartItems) ? 'disabled' : '' }}>
                            Confirm Enrollment
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Schedule Selection Modal -->
<div id="scheduleModal" class="fixed inset-0 z-50 hidden overflow-y-auto" role="dialog">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" onclick="closeScheduleModal()"></div>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modalCourseTitle">Select Schedule</h3>
                        <div id="sectionsList" class="mt-4 space-y-3">
                            <!-- Sections will be loaded here -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" onclick="closeScheduleModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let currentCourseId = null;
let currentCourseTitle = '';

function viewSections(courseId, courseTitle) {
    currentCourseId = courseId;
    currentCourseTitle = courseTitle;
    document.getElementById('modalCourseTitle').innerHTML = courseTitle + ' - Select Schedule';
    
    fetch(`/student/enroll/course/${courseId}/sections`)
        .then(response => response.json())
        .then(data => {
            const sectionsList = document.getElementById('sectionsList');
            sectionsList.innerHTML = '';
            
            if (data.sections.length === 0) {
                sectionsList.innerHTML = '<p class="text-gray-500 text-center py-4">No schedules available for this course.</p>';
            } else {
                data.sections.forEach(section => {
                    const sectionHtml = `
                        <div class="border rounded-lg p-4 hover:bg-gray-50 transition">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-medium text-gray-900">Section ${section.section_code}</p>
                                    <p class="text-sm text-gray-600 mt-1">🕐 ${section.schedule_time}</p>
                                    <p class="text-sm text-gray-600">📅 ${section.schedule_days}</p>
                                    <p class="text-sm text-gray-600">📍 ${section.room}</p>
                                    <p class="text-sm text-gray-600">👨‍🏫 ${section.instructor}</p>
                                    <p class="text-sm ${section.available_seats > 0 ? 'text-green-600' : 'text-red-600'} mt-2">
                                        ${section.available_seats} / ${section.capacity} seats available
                                    </p>
                                </div>
                                ${section.available_seats > 0 ? 
                                    `<button onclick="addToCart(${section.id}, '${section.schedule_days} ${section.schedule_time}')" 
                                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm transition">
                                        Select
                                    </button>` :
                                    `<button disabled class="bg-gray-300 text-gray-500 px-4 py-2 rounded-lg text-sm cursor-not-allowed">
                                        Full
                                    </button>`
                                }
                            </div>
                        </div>
                    `;
                    sectionsList.insertAdjacentHTML('beforeend', sectionHtml);
                });
            }
            document.getElementById('scheduleModal').classList.remove('hidden');
        });
}

function addToCart(sectionId, schedule) {
    fetch('{{ route("student.enroll.addToCart") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            section_id: sectionId,
            schedule: schedule
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message);
        }
    });
}

function removeFromCart(index) {
    fetch(`/student/enroll/remove-from-cart/${index}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

function closeScheduleModal() {
    document.getElementById('scheduleModal').classList.add('hidden');
}

// Search and filter
document.getElementById('searchInput').addEventListener('keyup', filterCourses);
document.getElementById('departmentFilter').addEventListener('change', filterCourses);

function filterCourses() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const departmentId = document.getElementById('departmentFilter').value;
    const courses = document.querySelectorAll('.course-card');
    
    courses.forEach(course => {
        const text = course.innerText.toLowerCase();
        const matchesSearch = text.includes(searchTerm);
        const matchesDept = !departmentId || course.dataset.department == departmentId;
        
        if (matchesSearch && matchesDept) {
            course.style.display = '';
        } else {
            course.style.display = 'none';
        }
    });
}
</script>
@endsection
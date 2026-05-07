@extends('layouts.app')

@section('title', 'Student Dashboard')
@section('content')
<div class="fade-in">
    <!-- Welcome Banner -->
    <div class="welcome-banner mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-2">Welcome back, {{ $student->first_name ?? 'Student' }}! 👋</h2>
                <p class="mb-0 opacity-75">{{ now()->format('l, F j, Y') }}</p>
                @if($activeEnrollments == 0)
                    <p class="mt-2 mb-0">
                        <i class="fas fa-info-circle me-1"></i> 
                        You are not enrolled in any courses yet. 
                        <a href="{{ route('student.enroll.index') }}" class="text-white text-decoration-underline">Enroll now →</a>
                    </p>
                @endif
            </div>
            <div class="bg-white bg-opacity-20 rounded-circle p-3">
                <i class="fas fa-graduation-cap fa-2x"></i>
            </div>
        </div>
    </div>

    <!-- First row: Credits (This Sem), Credits Earned, In Cart -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="stat-card" style="height: 140px;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value">{{ $totalCredits }}</div>
                        <div class="stat-label">Credits (This Sem)</div>
                    </div>
                    <div class="stat-icon bg-success bg-opacity-10 text-success">
                        <i class="fas fa-book"></i>
                    </div>
                </div>
                @if($totalCredits == 0)
                    <small class="text-muted mt-2 d-block">No courses enrolled</small>
                @endif
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card" style="height: 140px;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value">{{ $completedCredits }}/120</div>
                        <div class="stat-label">Credits Earned</div>
                    </div>
                    <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                        <i class="fas fa-star"></i>
                    </div>
                </div>
                <div class="progress-bar-custom mt-2">
                    <div class="progress-fill" style="width: {{ ($completedCredits / 120) * 100 }}%"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card" style="height: 140px;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value">{{ $cartCount }}</div>
                        <div class="stat-label">In Cart</div>
                    </div>
                    <div class="stat-icon bg-info bg-opacity-10 text-info">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                </div>
                @if($cartCount > 0)
                    <div class="mt-2">
                        <a href="{{ route('student.enroll.index') }}" class="small">Complete enrollment →</a>
                    </div>
                @else
                    <small class="text-muted mt-2 d-block">No items in cart</small>
                @endif
            </div>
        </div>
    </div>

    <!-- Second row: Pending Payments & Paid Payments -->
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="stat-card" style="height: 140px;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value">₱{{ number_format($pendingPaymentsTotal ?? 0, 2) }}</div>
                        <div class="stat-label">Pending Payments</div>
                    </div>
                    <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
                <a href="{{ route('student.payments.index') }}" class="small mt-2 d-inline-block">View details →</a>
            </div>
        </div>
        <div class="col-md-6">
            <div class="stat-card" style="height: 140px;">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="stat-value">₱{{ number_format($paidPaymentsTotal ?? 0, 2) }}</div>
                        <div class="stat-label">Paid Payments</div>
                    </div>
                    <div class="stat-icon bg-success bg-opacity-10 text-success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
                <a href="{{ route('student.payments.index') }}" class="small mt-2 d-inline-block">View history →</a>
            </div>
        </div>
    </div>

    <!-- Enrollment Reminder -->
    @if($cartCount > 0)
        <div class="alert alert-warning alert-custom mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Enrollment Reminder!</strong> You have {{ $cartCount }} course(s) in your cart.
                </div>
                <a href="{{ route('student.enroll.index') }}" class="btn btn-sm btn-gradient">Complete Enrollment →</a>
            </div>
        </div>
    @endif

    <!-- Two Column Layout (Upcoming Deadlines & Recommended Courses) -->
    <div class="row g-4">
        <div class="col-md-6">
            <div class="stat-card">
                <h5 class="mb-3"><i class="fas fa-calendar-alt me-2 text-primary"></i> Upcoming Deadlines</h5>
                @if(count($upcomingDeadlines) > 0)
                    @foreach($upcomingDeadlines as $deadline)
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                        <div>
                            <div class="fw-medium">{{ $deadline['task'] }}</div>
                            <small class="text-muted">{{ $deadline['date'] }}</small>
                        </div>
                        <span class="badge bg-danger">{{ $deadline['days_left'] }} days left</span>
                    </div>
                    @endforeach
                @else
                    <p class="text-muted text-center py-3">No upcoming deadlines.</p>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="stat-card">
                <h5 class="mb-3"><i class="fas fa-lightbulb me-2 text-warning"></i> Recommended for You</h5>
                @if($recommendedCourses->count() > 0)
                    @foreach($recommendedCourses as $course)
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                        <div>
                            <div class="fw-medium">{{ $course->course_code }} - {{ $course->title }}</div>
                            <small class="text-muted">{{ $course->credits }} credits</small>
                        </div>
                        <a href="{{ route('student.enroll.index') }}" class="btn btn-sm btn-outline-gradient">Add</a>
                    </div>
                    @endforeach
                @else
                    <p class="text-muted text-center py-3">No recommendations available.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Current Courses -->
    <div class="mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5><i class="fas fa-book-open me-2 text-primary"></i> My Current Courses</h5>
            @if($activeEnrollments > 0)
                <a href="{{ route('student.my-courses') }}" class="text-decoration-none">View All →</a>
            @endif
        </div>

        @if($activeEnrollments > 0)
            <div class="row g-4">
                @foreach($currentCourses as $course)
                <div class="col-md-4">
                    <div class="course-card">
                        <div class="course-code">{{ $course->course_code }}</div>
                        <div class="course-title">{{ $course->title }}</div>
                        <div class="course-info"><i class="fas fa-user"></i> {{ $course->instructor ?? 'TBA' }}</div>
                        <div class="course-info"><i class="fas fa-clock"></i> {{ $course->schedule ?? 'Schedule TBA' }}</div>
                        <div class="mt-3">
                            <div class="d-flex justify-content-between small mb-1">
                                <span>Progress</span>
                                <span>0%</span>
                            </div>
                            <div class="progress-bar-custom">
                                <div class="progress-fill" style="width: 0%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="stat-card text-center py-5">
                <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                <p class="text-muted">You are not enrolled in any courses yet.</p>
                <a href="{{ route('student.enroll.index') }}" class="btn btn-gradient">Browse Courses</a>
            </div>
        @endif
    </div>
</div>
@endsection
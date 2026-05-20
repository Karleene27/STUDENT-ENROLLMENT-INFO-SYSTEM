<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SEIS - @yield('title', 'Student Enrollment Information System')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="http://student-enrollment-info-system-2.onrender.com/css/style.css" rel="stylesheet">
    
    @stack('styles')
    <style>
        /* Tailwind directives will go here */
/* ========================================
   STUDENT ENROLLMENT INFORMATION SYSTEM
   MODERN PROFESSIONAL CSS
   ======================================== */

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    background: #f1f5f9;
    color: #1e293b;
    line-height: 1.5;
}

/* ========================================
   NAVBAR
   ======================================== */
.navbar {
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    padding: 1rem 2rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    position: sticky;
    top: 0;
    z-index: 1000;
}

.navbar-brand {
    font-size: 1.5rem;
    font-weight: 700;
    color: white !important;
}

.navbar-brand i {
    margin-right: 0.5rem;
}

.nav-link {
    color: rgba(255, 255, 255, 0.9) !important;
    font-weight: 500;
    transition: all 0.3s;
}

.nav-link:hover {
    color: white !important;
    transform: translateY(-2px);
}

.dropdown-menu {
    border-radius: 0.75rem;
    border: none;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    margin-top: 0.5rem;
}

.dropdown-item {
    padding: 0.5rem 1rem;
    transition: all 0.3s;
}

.dropdown-item:hover {
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    color: white;
}

/* ========================================
   SIDEBAR
   ======================================== */
.sidebar {
    background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
    min-height: calc(100vh - 70px);
    padding: 1.5rem;
    position: sticky;
    top: 70px;
}

.sidebar .nav-link {
    color: rgba(255, 255, 255, 0.7);
    padding: 0.75rem 1rem;
    margin: 0.25rem 0;
    border-radius: 0.75rem;
    transition: all 0.3s;
    font-weight: 500;
}

.sidebar .nav-link:hover {
    background: rgba(255, 255, 255, 0.1);
    color: white;
    transform: translateX(5px);
}

.sidebar .nav-link.active {
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    color: white;
}

.sidebar .nav-link i {
    margin-right: 0.75rem;
    width: 20px;
}

/* ========================================
   CARDS & STATS
   ======================================== */
.stat-card {
    background: white;
    border-radius: 1rem;
    padding: 1.5rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    transition: all 0.3s;
    border: 1px solid #e2e8f0;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.stat-value {
    font-size: 2rem;
    font-weight: 700;
    color: #1e293b;
}

.stat-label {
    color: #64748b;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

/* ========================================
   BUTTONS
   ======================================== */
.btn-gradient {
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    color: white;
    border: none;
    padding: 0.5rem 1.5rem;
    border-radius: 0.75rem;
    font-weight: 500;
    transition: all 0.3s;
}

.btn-gradient:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.4);
    color: white;
}

.btn-outline-gradient {
    background: transparent;
    border: 2px solid #6366f1;
    color: #6366f1;
    padding: 0.5rem 1.5rem;
    border-radius: 0.75rem;
    font-weight: 500;
    transition: all 0.3s;
}

.btn-outline-gradient:hover {
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    color: white;
    transform: translateY(-2px);
}

/* ========================================
   TABLES
   ======================================== */
.table-custom {
    background: white;
    border-radius: 1rem;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.table-custom thead {
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    color: white;
}

.table-custom th {
    padding: 1rem;
    font-weight: 600;
    border: none;
}

.table-custom td {
    padding: 1rem;
    vertical-align: middle;
    border-bottom: 1px solid #e2e8f0;
}

.table-custom tr:hover {
    background: #f8fafc;
}

/* ========================================
   BADGES
   ======================================== */
.badge-enrolled {
    background: #10b981;
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 2rem;
    font-size: 0.75rem;
    font-weight: 500;
}

.badge-pending {
    background: #f59e0b;
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 2rem;
    font-size: 0.75rem;
    font-weight: 500;
}

.badge-dropped {
    background: #ef4444;
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 2rem;
    font-size: 0.75rem;
    font-weight: 500;
}

.badge-completed {
    background: #3b82f6;
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 2rem;
    font-size: 0.75rem;
    font-weight: 500;
}

/* ========================================
   MODALS
   ======================================== */
.modal-content {
    border-radius: 1.5rem;
    border: none;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}

.modal-header {
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    color: white;
    border-radius: 1.5rem 1.5rem 0 0;
    padding: 1.25rem 1.5rem;
}

.modal-title {
    font-weight: 600;
}

.btn-close-white {
    filter: brightness(0) invert(1);
}

/* ========================================
   FORMS
   ======================================== */
.form-control-custom {
    border: 1px solid #e2e8f0;
    border-radius: 0.75rem;
    padding: 0.75rem 1rem;
    transition: all 0.3s;
}

.form-control-custom:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    outline: none;
}

/* ========================================
   ALERTS
   ======================================== */
.alert-custom {
    border-radius: 0.75rem;
    border: none;
    padding: 1rem 1.25rem;
}

.alert-success {
    background: #ecfdf5;
    color: #065f46;
    border-left: 4px solid #10b981;
}

.alert-danger {
    background: #fef2f2;
    color: #991b1b;
    border-left: 4px solid #ef4444;
}

.alert-warning {
    background: #fffbeb;
    color: #92400e;
    border-left: 4px solid #f59e0b;
}

/* ========================================
   ANIMATIONS
   ======================================== */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-in {
    animation: fadeIn 0.5s ease-out;
}

/* ========================================
   RESPONSIVE
   ======================================== */
@media (max-width: 768px) {
    .sidebar {
        position: static;
        min-height: auto;
    }
    
    .stat-card {
        margin-bottom: 1rem;
    }
    
    .stat-value {
        font-size: 1.5rem;
    }
}

/* ========================================
   DASHBOARD SPECIFIC
   ======================================== */
.welcome-banner {
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    border-radius: 1.5rem;
    padding: 2rem;
    color: white;
    margin-bottom: 2rem;
}

.course-card {
    background: white;
    border-radius: 1rem;
    padding: 1.25rem;
    margin-bottom: 1rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    transition: all 0.3s;
    border: 1px solid #e2e8f0;
}

.course-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
}

.course-code {
    font-size: 0.75rem;
    font-weight: 600;
    color: #6366f1;
    text-transform: uppercase;
}

.course-title {
    font-weight: 600;
    margin: 0.5rem 0;
}

.course-info {
    font-size: 0.875rem;
    color: #64748b;
    margin-bottom: 0.25rem;
}

.course-info i {
    width: 20px;
    margin-right: 0.5rem;
}

.progress-bar-custom {
    height: 6px;
    background: #e2e8f0;
    border-radius: 3px;
    overflow: hidden;
    margin-top: 0.75rem;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #6366f1 0%, #8b5cf6 100%);
    border-radius: 3px;
    transition: width 0.3s;
}


/* About Page Styles */
.about-hero {
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    color: white;
    padding: 4rem 0;
    text-align: center;
}

.team-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    transition: all 0.3s;
    text-align: center;
    padding: 1.5rem;
}

.team-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
}

.team-avatar {
    width: 120px;
    height: 120px;
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    color: white;
    font-size: 3rem;
}

/* Contact Page Styles */
.contact-info-card {
    background: white;
    border-radius: 20px;
    padding: 1.5rem;
    text-align: center;
    transition: all 0.3s;
    height: 100%;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
}

.contact-info-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.contact-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    color: white;
    font-size: 1.5rem;
}

.contact-form {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);

}
/* Force pagination to be small */
.pagination {
    --bs-pagination-padding-x: 0.5rem;
    --bs-pagination-padding-y: 0.25rem;
    --bs-pagination-font-size: 0.75rem;
    gap: 0.25rem;
    flex-wrap: wrap;
}

.pagination .page-link {
    padding: var(--bs-pagination-padding-y) var(--bs-pagination-padding-x);
    font-size: var(--bs-pagination-font-size);
}

.pagination .page-item .page-link {
    border-radius: 0.25rem;
}

.pagination .page-link {
    padding: 0.2rem 0.5rem !important;
    font-size: 0.7rem !important;
}
.pagination {
    gap: 0.2rem !important;
}

</style>
</head>
<body>
    <div id="app">
        <!-- Top Navigation -->
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <i class="fas fa-graduation-cap"></i> SEIS
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">
                                    <i class="fas fa-sign-in-alt me-1"></i> Login
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">
                                    <i class="fas fa-user-plus me-1"></i> Enroll Now
                                </a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        @if(Auth::user()->role === 'admin')
                                            <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                                            </a>
                                        @else
                                            <a class="dropdown-item" href="{{ route('student.profile') }}">
                                                <i class="fas fa-id-card me-2"></i> My Profile
                                            </a>
                                        @endif
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="container-fluid">
            <div class="row">
                @auth
                    <!-- Sidebar -->
                    <div class="col-md-3 col-lg-2 px-0">
                        <div class="sidebar">
                            <div class="text-center mb-4">
                                <div class="bg-white bg-opacity-10 rounded-circle mx-auto d-flex align-items-center justify-content-center mb-2" style="width: 60px; height: 60px;">
                                    <i class="fas fa-user-graduate fa-2x text-white"></i>
                                </div>
                                <h6 class="text-white mb-0">{{ Auth::user()->name }}</h6>
                                <small class="text-white-50">
                                    @if(Auth::user()->role === 'admin')
                                        <i class="fas fa-shield-alt me-1"></i> Administrator
                                    @else
                                        <i class="fas fa-user me-1"></i> Student
                                    @endif
                                </small>
                            </div>
                            <hr class="border-light">
                            
                            @if(Auth::user()->role === 'admin')
                                <div class="nav flex-column">
                                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                                       href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-chart-line"></i> Dashboard
                                    </a>
                                    <a class="nav-link {{ request()->routeIs('admin.students.*') ? 'active' : '' }}" 
                                       href="{{ route('admin.students.index') }}">
                                        <i class="fas fa-users"></i> Students
                                    </a>
                                    <a class="nav-link {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}" 
                                       href="{{ route('admin.courses.index') }}">
                                        <i class="fas fa-book"></i> Courses
                                    </a>
                                    <a class="nav-link {{ request()->routeIs('admin.enrollments.*') ? 'active' : '' }}" 
                                       href="{{ route('admin.enrollments.index') }}">
                                        <i class="fas fa-clipboard-list"></i> Enrollments
                                    </a>
                                    <a class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" 
                                       href="{{ route('admin.reports.index') }}">
                                        <i class="fas fa-chart-bar"></i> Reports
                                    </a>
                                </div>
                            @else
                                <div class="nav flex-column">
                                    <a class="nav-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}" 
                                       href="{{ route('student.dashboard') }}">
                                        <i class="fas fa-tachometer-alt"></i> Dashboard
                                    </a>
                                    <a class="nav-link {{ request()->routeIs('student.my-courses') ? 'active' : '' }}" 
                                       href="{{ route('student.my-courses') }}">
                                        <i class="fas fa-book-open"></i> My Courses
                                    </a>
                                    <a class="nav-link {{ request()->routeIs('student.enroll.*') ? 'active' : '' }}" 
                                       href="{{ route('student.enroll.index') }}">
                                        <i class="fas fa-cart-plus"></i> Enroll
                                    </a>
                                    <!-- Payments link (replaces Grades) -->
                                    <a class="nav-link {{ request()->routeIs('student.payments.index') ? 'active' : '' }}" 
                                       href="{{ route('student.payments.index') }}">
                                        <i class="fas fa-credit-card"></i> Payments
                                    </a>
                                    <a class="nav-link {{ request()->routeIs('student.profile') ? 'active' : '' }}" 
                                       href="{{ route('student.profile') }}">
                                        <i class="fas fa-user-circle"></i> Profile
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Content Area -->
                    <div class="col-md-9 col-lg-10 p-4">
                        @if(session('success'))
                            <div class="alert alert-custom alert-success alert-dismissible fade show mb-4" role="alert">
                                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        
                        @if(session('error'))
                            <div class="alert alert-custom alert-danger alert-dismissible fade show mb-4" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        
                        @yield('content')
                    </div>
                @else
                    <div class="col-12 p-0">
                        @yield('content')
                    </div>
                @endauth
            </div>
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    setTimeout(function() {
                        bsAlert.close();
                    }, 5000);
                });
            }, 100);
        });
    </script>
    
    @stack('scripts')
</body>
</html>
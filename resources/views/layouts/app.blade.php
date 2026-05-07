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
    
    @stack('styles')
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
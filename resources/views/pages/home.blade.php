@extends('layouts.landing')

@section('content')
<style>
    /* Hero Section with Gradient Background */
    .hero {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.05), rgba(139, 92, 246, 0.05));
        min-height: 80vh;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
    }
    
    .hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(99, 102, 241, 0.1), transparent);
        border-radius: 50%;
    }
    
    .hero-title {
        font-size: 3rem;
        font-weight: 800;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        margin-bottom: 1.5rem;
    }
    
    .hero-subtitle {
        font-size: 1.1rem;
        color: #64748b;
        margin-bottom: 2rem;
        line-height: 1.6;
    }
    
    .btn-login {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: white;
        border: none;
        padding: 10px 28px;
        border-radius: 30px;
        font-weight: 500;
        transition: all 0.3s;
    }
    
    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(99, 102, 241, 0.4);
        color: white;
    }
    
    .btn-register {
        border: 2px solid #6366f1;
        background: transparent;
        color: #6366f1;
        padding: 10px 28px;
        border-radius: 30px;
        font-weight: 500;
        transition: all 0.3s;
    }
    
    .btn-register:hover {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: white;
        border-color: transparent;
        transform: translateY(-2px);
    }
    
    /* Features Section */
    .features-section {
        background: white;
    }
    
    .section-title {
        font-size: 2.2rem;
        font-weight: 700;
        text-align: center;
        margin-bottom: 1rem;
    }
    
    .section-subtitle {
        text-align: center;
        color: #64748b;
        margin-bottom: 3rem;
    }
    
    .feature-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        height: 100%;
    }
    
    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }
    
    .feature-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        color: white;
        font-size: 1.8rem;
    }
    
    .feature-title {
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }
    
    /* Stats Section */
    .stats-section {
        background: white;
    }
    
    /* CTA Section */
    .cta-section {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        padding: 4rem 0;
        margin-bottom: 0;
    }
    
    .cta-section h2, .cta-section p {
        color: white;
    }
    
    .cta-section .btn-light {
        background: white;
        color: #6366f1;
        border: none;
        padding: 12px 30px;
        border-radius: 30px;
        font-weight: 600;
        transition: all 0.3s;
    }
    
    .cta-section .btn-light:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }
    
    /* Hero image gradient box */
    .hero-image-box {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border-radius: 20px;
        padding: 3rem;
        text-align: center;
    }
</style>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <h1 class="hero-title">Welcome to Student Enrollment Information System</h1>
                <p class="hero-subtitle">
                    Streamline your academic journey with our modern enrollment platform. 
                    Browse courses, manage schedules, and track your academic progress all in one place.
                </p>
                <div class="d-flex gap-3">
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-login px-4 py-2">Enroll Now</a>
                        <a href="{{ route('login') }}" class="btn btn-register px-4 py-2">Login</a>
                    @else
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-login px-4 py-2">Go to Dashboard</a>
                        @else
                            <a href="{{ route('student.dashboard') }}" class="btn btn-login px-4 py-2">Go to Dashboard</a>
                        @endif
                    @endguest
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="hero-image text-center">
                    <div class="hero-image-box">
                        <i class="fas fa-graduation-cap fa-5x text-white mb-3"></i>
                        <h3 class="text-white">SEIS</h3>
                        <p class="text-white-50">Student Enrollment Information System</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5 features-section">
    <div class="container">
        <h2 class="section-title" data-aos="fade-up">Why Choose SEIS?</h2>
        <p class="section-subtitle" data-aos="fade-up">Powerful features to enhance your academic experience</p>
        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h3 class="feature-title">Easy Enrollment</h3>
                    <p>Browse available courses and enroll with just a few clicks. Choose from multiple schedule options.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="feature-title">Track Your Progress</h3>
                    <p>Monitor your academic performance with real-time GPA updates and grade tracking.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-bell"></i>
                    </div>
                    <h3 class="feature-title">Real-time Notifications</h3>
                    <p>Stay updated with enrollment deadlines, schedule changes, and important announcements.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-5 stats-section">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-md-3" data-aos="zoom-in">
                <h2 class="text-primary" style="font-size: 2.5rem;">10K+</h2>
                <p class="text-muted">Active Students</p>
            </div>
            <div class="col-md-3" data-aos="zoom-in" data-aos-delay="100">
                <h2 class="text-primary" style="font-size: 2.5rem;">500+</h2>
                <p class="text-muted">Courses Available</p>
            </div>
            <div class="col-md-3" data-aos="zoom-in" data-aos-delay="200">
                <h2 class="text-primary" style="font-size: 2.5rem;">50+</h2>
                <p class="text-muted">Departments</p>
            </div>
            <div class="col-md-3" data-aos="zoom-in" data-aos-delay="300">
                <h2 class="text-primary" style="font-size: 2.5rem;">24/7</h2>
                <p class="text-muted">Support Available</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section" style="margin-bottom: 0;">
    <div class="container text-center">
        <h2 class="mb-3" data-aos="fade-up">Ready to Get Started?</h2>
        <p class="mb-4" data-aos="fade-up">Join thousands of students who have simplified their enrollment process.</p>
        @guest
            <a href="{{ route('register') }}" class="btn btn-light px-4 py-2" data-aos="fade-up">Enroll Now</a>
        @else
            <a href="{{ route('student.dashboard') }}" class="btn btn-light px-4 py-2" data-aos="fade-up">Go to Dashboard</a>
        @endguest
    </div>
</section>
@endsection
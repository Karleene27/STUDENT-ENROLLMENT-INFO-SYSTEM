@extends('layouts.landing')

@section('content')
<div class="about-hero">
    <div class="container">
        <h1 data-aos="fade-up">About Us</h1>
        <p data-aos="fade-up" class="mb-0">Learn more about our mission and vision</p>
    </div>
</div>

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6" data-aos="fade-right">
                <h2 class="mb-3">Our Mission</h2>
                <p class="text-muted">To provide a seamless, efficient, and user-friendly enrollment experience for students and administrators alike.</p>
                <h2 class="mb-3 mt-4">Our Vision</h2>
                <p class="text-muted">To become the leading enrollment management system in educational institutions, transforming how academic records are managed.</p>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="bg-light rounded-4 p-4">
                    <h4 class="mb-3">Why We Built SEIS</h4>
                    <p>Traditional enrollment processes are time-consuming and error-prone. SEIS was created to:</p>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Reduce manual paperwork</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Eliminate scheduling conflicts</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Provide real-time course availability</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Empower students with self-service enrollment</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-4" data-aos="fade-up">Our Team</h2>
        <div class="row g-4">
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
                <div class="team-card">
                    <div class="team-avatar">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <h5 class="mb-1">Levi Jasper Alicaya</h5>
                    <p class="text-muted small">Lead Developer</p>
                </div>
            </div>
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
                <div class="team-card">
                    <div class="team-avatar">
                        <i c=
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
                <div class="team-card">
                    <div class="team-avatar">
                        <i class="fas fa-code"></i>
                    </div>
                    <h5 class="mb-1">Levi Jasper Alicaya</h5>
                    <p class="text-muted small">UI/UX Designer</p>
                </div>
            </div>
            <div class="col-md-3" data-aos="fade-up" data-aos-delay="400">
                <div class="team-card">
                    <div class="team-avatar">
                        <i class="fas fa-database"></i>
                    </div>
                    <h5 class="mb-1">Levi Jasper Alicaya</h5>
                    <p class="text-muted small">Database Architect</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
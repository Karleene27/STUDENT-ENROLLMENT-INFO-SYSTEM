@extends('layouts.landing')

@section('content')
<style>
    .contact-hero {
        background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        color: white;
        padding: 4rem 0;
        text-align: center;
        margin-top: -70px;
        padding-top: calc(4rem + 70px);
    }
    
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
    
    .form-control-custom {
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        transition: all 0.3s;
        width: 100%;
    }
    
    .form-control-custom:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        outline: none;
    }
</style>

<div class="contact-hero">
    <div class="container">
        <h1 data-aos="fade-up">Contact Us</h1>
        <p data-aos="fade-up" class="mb-0">We'd love to hear from you</p>
    </div>
</div>

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="contact-info-card">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h5>Visit Us</h5>
                    <p class="text-muted">123 University Avenue,<br>City, State 12345</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="contact-info-card">
                    <div class="contact-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <h5>Call Us</h5>
                    <p class="text-muted">+63 123 456 7890<br>+63 123 456 7891</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="contact-info-card">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h5>Email Us</h5>
                    <p class="text-muted">info@seis.com<br>support@seis.com</p>
                </div>
            </div>
        </div>
        
        <div class="row mt-5">
            <div class="col-lg-8 mx-auto" data-aos="fade-up">
                <div class="contact-form">
                    <h3 class="mb-4 text-center">Send us a message</h3>
                    
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('contact.submit') }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="text" name="name" class="form-control-custom" placeholder="Your Name" required>
                            </div>
                            <div class="col-md-6">
                                <input type="email" name="email" class="form-control-custom" placeholder="Your Email" required>
                            </div>
                            <div class="col-12">
                                <input type="text" name="subject" class="form-control-custom" placeholder="Subject">
                            </div>
                            <div class="col-12">
                                <textarea name="message" rows="5" class="form-control-custom" placeholder="Your Message" required></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-login w-100 py-2">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12" data-aos="fade-up">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1930.123456789!2d121.123456!3d14.123456!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTTCsDA3JzI0LjQiTiAxMjHCsDA3JzI0LjQiRQ!5e0!3m2!1sen!2sph!4v1234567890" 
                    width="100%" 
                    height="300" 
                    style="border:0; border-radius: 15px;" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
            </div>
        </div>
    </div>
</section>
@endsection
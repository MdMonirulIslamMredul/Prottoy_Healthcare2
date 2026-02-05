@extends('frontend.layouts.app')

@section('title', 'Home')
@section('meta_description', 'Prottoy Healthcare - Leading healthcare management system in Bangladesh providing comprehensive healthcare services')

@section('styles')
<style>
    /* Hero Section */
    .hero-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 100px 0;
        position: relative;
        overflow: hidden;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.1)" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,112C672,96,768,96,864,112C960,128,1056,160,1152,160C1248,160,1344,128,1392,112L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');
        background-size: cover;
        background-position: bottom;
    }

    .hero-content {
        position: relative;
        z-index: 1;
    }

    .hero-title {
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 1.5rem;
        line-height: 1.2;
    }

    .hero-subtitle {
        font-size: 1.3rem;
        margin-bottom: 2rem;
        opacity: 0.95;
    }

    .hero-buttons .btn {
        padding: 0.875rem 2rem;
        font-weight: 600;
        border-radius: 50px;
        margin: 0.5rem;
        transition: all 0.3s ease;
    }

    .btn-hero-primary {
        background: white;
        color: #667eea;
    }

    .btn-hero-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }

    .btn-hero-outline {
        border: 2px solid white;
        color: white;
    }

    .btn-hero-outline:hover {
        background: white;
        color: #667eea;
    }

    /* Features Section */
    .features-section {
        padding: 80px 0;
        background: #f8f9fa;
    }

    .feature-card {
        background: white;
        padding: 2.5rem;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        height: 100%;
        border: none;
    }

    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .feature-icon {
        width: 70px;
        height: 70px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin-bottom: 1.5rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .feature-title {
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    /* Stats Section */
    .stats-section {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: white;
        padding: 60px 0;
    }

    .stat-item {
        text-align: center;
        padding: 2rem;
    }

    .stat-number {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        font-size: 1.1rem;
        opacity: 0.9;
    }

    /* Services Section */
    .services-section {
        padding: 80px 0;
    }

    .service-card {
        position: relative;
        overflow: hidden;
        border-radius: 15px;
        height: 350px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .service-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(180deg, transparent 0%, rgba(0, 0, 0, 0.8) 100%);
        z-index: 1;
    }

    .service-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: all 0.3s ease;
    }

    .service-card:hover img {
        transform: scale(1.1);
    }

    .service-content {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 2rem;
        z-index: 2;
        color: white;
    }

    .service-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    /* CTA Section */
    .cta-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 80px 0;
        text-align: center;
    }

    .cta-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
    }

    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.5rem;
        }

        .hero-subtitle {
            font-size: 1.1rem;
        }

        .stat-number {
            font-size: 2rem;
        }
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 hero-content">
                <h1 class="hero-title fade-in-up">Welcome to Prottoy Healthcare</h1>
                <p class="hero-subtitle fade-in-up">Your trusted partner in comprehensive healthcare management across Bangladesh</p>
                <div class="hero-buttons fade-in-up">
                    <a href="{{ route('frontend.about') }}" class="btn btn-hero-primary btn-lg">
                        <i class="bi bi-info-circle me-2"></i>Learn More
                    </a>
                    <a href="{{ route('frontend.customer-service') }}" class="btn btn-hero-outline btn-lg">
                        <i class="bi bi-telephone me-2"></i>Contact Us
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center mt-5 mt-lg-0">
                <i class="bi bi-hospital" style="font-size: 15rem; opacity: 0.2;"></i>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Why Choose Us</h2>
            <p class="section-subtitle">Delivering excellence in healthcare management</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h3 class="feature-title">Reliable Service</h3>
                    <p class="text-muted">Comprehensive healthcare coverage with trusted service providers across the nation.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <h3 class="feature-title">Expert Team</h3>
                    <p class="text-muted">Experienced healthcare professionals dedicated to providing quality care and support.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <h3 class="feature-title">24/7 Support</h3>
                    <p class="text-muted">Round-the-clock customer service to assist you with all your healthcare needs.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-geo-alt"></i>
                    </div>
                    <h3 class="feature-title">Wide Coverage</h3>
                    <p class="text-muted">Service network spanning across all divisions and districts of Bangladesh.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-file-earmark-check"></i>
                    </div>
                    <h3 class="feature-title">Easy Claims</h3>
                    <p class="text-muted">Streamlined claim process with fast approval and hassle-free documentation.</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-award"></i>
                    </div>
                    <h3 class="feature-title">Quality Assured</h3>
                    <p class="text-muted">Committed to maintaining the highest standards of healthcare service delivery.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <div class="stat-number">8</div>
                    <div class="stat-label">Divisions</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <div class="stat-number">64+</div>
                    <div class="stat-label">Districts Covered</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <div class="stat-number">500+</div>
                    <div class="stat-label">Upazilas Served</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <div class="stat-number">10K+</div>
                    <div class="stat-label">Happy Customers</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="services-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Our Services</h2>
            <p class="section-subtitle">Comprehensive healthcare solutions for everyone</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="service-card">
                    <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=500" alt="Customer Service">
                    <div class="service-content">
                        <h3 class="service-title">Customer Service</h3>
                        <p>Dedicated support for all your healthcare queries</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="service-card">
                    <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=500" alt="Claims Processing">
                    <div class="service-content">
                        <h3 class="service-title">Claims Processing</h3>
                        <p>Fast and efficient claim approval process</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="service-card">
                    <img src="https://images.unsplash.com/photo-1532938911079-1b06ac7ceec7?w=500" alt="Healthcare Network">
                    <div class="service-content">
                        <h3 class="service-title">Healthcare Network</h3>
                        <p>Extensive network of trusted healthcare providers</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <h2 class="cta-title">Ready to Get Started?</h2>
        <p class="mb-4" style="font-size: 1.2rem;">Join thousands of satisfied customers and experience quality healthcare</p>
        <a href="{{ route('login') }}" class="btn btn-hero-primary btn-lg">
            <i class="bi bi-box-arrow-in-right me-2"></i>Access Portal
        </a>
    </div>
</section>
@endsection

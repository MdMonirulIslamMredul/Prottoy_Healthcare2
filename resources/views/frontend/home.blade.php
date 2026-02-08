@extends('frontend.layouts.app')

@section('title', 'Home')
@section('meta_description', 'Prottoy Healthcare - Leading healthcare management system in Bangladesh providing comprehensive healthcare services')

@section('styles')
<style>
    /* Hero Carousel Section */
    .hero-carousel {
        position: relative;
        height: 100vh;
        min-height: 600px;
    }

    .hero-carousel .carousel-item {
        height: 100vh;
        min-height: 600px;
        background-size: cover;
        background-position: center;
        position: relative;
    }

    .hero-carousel .carousel-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(151, 154, 167, 0.317) 0%, rgba(105, 105, 110, 0.494) 100%);
        z-index: 1;
    }

    .hero-carousel .carousel-content {
        position: relative;
        z-index: 2;
        height: 100%;
        display: flex;
        align-items: center;
        color: white;
    }

    .hero-carousel .carousel-title {
        font-size: 4rem;
        font-weight: 800;
        margin-bottom: 1.5rem;
        line-height: 1.2;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    }

    .hero-carousel .carousel-subtitle {
        font-size: 1.5rem;
        margin-bottom: 2rem;
        opacity: 0.95;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
    }

    .hero-carousel .carousel-control-prev,
    .hero-carousel .carousel-control-next {
        z-index: 3;
        width: 5%;
    }

    .hero-carousel .carousel-indicators {
        z-index: 3;
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
        border: none;
    }

    .btn-hero-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        background: #f8f9fa;
        color: #667eea;
    }

    .btn-hero-outline {
        border: 2px solid white;
        color: white;
        background: transparent;
    }

    .btn-hero-outline:hover {
        background: white;
        color: #667eea;
    }

    /* News & Events Section */
    .news-events-section {
        padding: 80px 0;
        background: #f8f9fa;
    }

    .news-card {
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .news-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15) !important;
    }

    .news-card .card-title {
        font-weight: 700;
        color: #333;
        font-size: 1.1rem;
        line-height: 1.4;
    }

    .notice-sidebar-item {
        padding: 1rem;
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.3s ease;
    }

    .notice-sidebar-item:hover {
        background: #f8f9fa;
        cursor: pointer;
    }

    .notice-sidebar-item h6 {
        font-weight: 600;
        color: #333;
        font-size: 0.9rem;
    }

    .notice-badge {
        padding: 0.25rem 0.6rem;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 600;
    }

    .notice-item {
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
    }

    .notice-item:hover {
        border-left-color: #667eea;
        transform: translateX(5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .notice-title {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
    }

    .notice-date {
        font-size: 0.875rem;
        color: #6c757d;
    }

    /* Testimonials Section */
    .testimonials-section {
        padding: 80px 0;
        background: white;
    }

    .testimonial-card {
        background: white;
        padding: 3rem;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        text-align: center;
        margin: 0 15px;
    }

    .testimonial-photo {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        margin: 0 auto 1.5rem;
        border: 5px solid #f8f9fa;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .testimonial-text {
        font-size: 1.1rem;
        font-style: italic;
        color: #555;
        margin-bottom: 1.5rem;
        line-height: 1.8;
    }

    .testimonial-name {
        font-weight: 700;
        font-size: 1.2rem;
        color: #333;
        margin-bottom: 0.25rem;
    }

    .testimonial-designation {
        color: #6c757d;
        font-size: 0.95rem;
    }

    .testimonial-stars {
        margin-bottom: 1rem;
        font-size: 1.2rem;
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

    /* Section Title Styles */
    .section-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: #333;
    }

    .section-subtitle {
        font-size: 1.2rem;
        color: #6c757d;
        margin-bottom: 0;
    }

    /* Responsive Styles */
    @media (max-width: 992px) {
        .hero-carousel .carousel-title {
            font-size: 3rem;
        }

        .hero-carousel .carousel-subtitle {
            font-size: 1.2rem;
        }
    }

    @media (max-width: 768px) {
        .hero-carousel {
            height: 70vh;
            min-height: 500px;
        }

        .hero-carousel .carousel-item {
            height: 70vh;
            min-height: 500px;
        }

        .hero-carousel .carousel-title {
            font-size: 2.2rem;
        }

        .hero-carousel .carousel-subtitle {
            font-size: 1rem;
        }

        .stat-number {
            font-size: 2rem;
        }

        .section-title {
            font-size: 2rem;
        }

        .testimonial-card {
            padding: 2rem;
        }
    }

    @media (max-width: 576px) {
        .hero-carousel .carousel-title {
            font-size: 1.8rem;
        }

        .hero-buttons .btn {
            padding: 0.75rem 1.5rem;
            font-size: 0.9rem;
        }
    }
</style>
@endsection

@section('content')
<!-- Hero Carousel Section -->
<section id="heroCarousel" class="hero-carousel carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
    @php
        $sliders = \App\Models\Slider::active()->ordered()->get();
    @endphp

    @if($sliders->count() > 1)
    <div class="carousel-indicators">
        @foreach($sliders as $index => $slider)
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $index }}"
                    class="{{ $index == 0 ? 'active' : '' }}"
                    aria-current="{{ $index == 0 ? 'true' : 'false' }}"
                    aria-label="Slide {{ $index + 1 }}"></button>
        @endforeach
    </div>
    @endif

    <div class="carousel-inner">
        @forelse($sliders as $index => $slider)
        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}" style="background-image: url('{{ asset('storage/' . $slider->image) }}');">
            <div class="carousel-content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8">
                            <h1 class="carousel-title {{ $index == 0 ? 'animate__animated animate__fadeInUp' : '' }}">
                                {{ $slider->title }}
                            </h1>
                            @if($slider->subtitle)
                            <p class="carousel-subtitle {{ $index == 0 ? 'animate__animated animate__fadeInUp animate__delay-1s' : '' }}">
                                {{ $slider->subtitle }}
                            </p>
                            @endif
                            @if($slider->button_text && $slider->button_link)
                            <div class="hero-buttons {{ $index == 0 ? 'animate__animated animate__fadeInUp animate__delay-2s' : '' }}">
                                <a href="{{ $slider->button_link }}" class="btn btn-hero-primary btn-lg">
                                    <i class="bi bi-arrow-right-circle me-2"></i>{{ $slider->button_text }}
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <!-- Fallback slide if no sliders in database -->
        <div class="carousel-item active" style="background-image: url('https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=1920');">
            <div class="carousel-content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8">
                            <h1 class="carousel-title">Welcome to Prottoy Healthcare</h1>
                            <p class="carousel-subtitle">Your trusted partner in comprehensive healthcare management across Bangladesh</p>
                            <div class="hero-buttons">
                                <a href="{{ route('frontend.about') }}" class="btn btn-hero-primary btn-lg">
                                    <i class="bi bi-info-circle me-2"></i>Learn More
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforelse
    </div>

    @if($sliders->count() > 1)
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
    @endif
</section>

<!-- News & Events Section -->
<section class="news-events-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">News & Updates</h2>
            <p class="section-subtitle">Stay informed with our latest news, events, and announcements</p>
        </div>

        @php
            $newsEvents = \App\Models\NewsEvent::active()->recent(3)->get();
            $notices = \App\Models\Notice::active()->recent(5)->get();
        @endphp

        <div class="row g-4">
            <!-- News & Events Slider (3 cards) -->
            <div class="col-lg-9">
                @if($newsEvents->count() > 0)
                    <!-- News & Events Carousel -->
                    <div id="newsEventsCarousel" class="carousel slide mb-4" data-bs-ride="carousel" data-bs-interval="5000">
                        @if($newsEvents->count() > 1)
                        <div class="carousel-indicators">
                            @foreach($newsEvents as $index => $newsEvent)
                                <button type="button" data-bs-target="#newsEventsCarousel" data-bs-slide-to="{{ $index }}"
                                        class="{{ $index == 0 ? 'active' : '' }}"
                                        aria-current="{{ $index == 0 ? 'true' : 'false' }}"
                                        aria-label="News {{ $index + 1 }}"></button>
                            @endforeach
                        </div>
                        @endif

                        <div class="carousel-inner">
                            @foreach($newsEvents as $index => $newsEvent)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                <div class="row justify-content-center">
                                    <div class="col-lg-10">
                                        <div class="card shadow-sm news-card" onclick="window.location.href='{{ route('frontend.news-event.show', $newsEvent->id) }}'">
                                            @if($newsEvent->image)
                                                <div class="news-card-image">
                                                    <img src="{{ asset('storage/' . $newsEvent->image) }}"
                                                         alt="{{ $newsEvent->title }}"
                                                         class="card-img-top"
                                                         style="height: 300px; object-fit: cover;">
                                                </div>
                                            @else
                                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 300px;">
                                                    <i class="bi bi-newspaper text-muted" style="font-size: 4rem;"></i>
                                                </div>
                                            @endif
                                            <div class="card-body">
                                                <h5 class="card-title" style="font-size: 1.5rem;">{{ $newsEvent->title }}</h5>
                                                <p class="card-text text-muted" style="font-size: 1.05rem;">
                                                    {{ Str::limit(strip_tags($newsEvent->content), 200) }}
                                                </p>
                                                <div class="d-flex justify-content-between align-items-center mt-3">
                                                    <small class="text-muted">
                                                        <i class="bi bi-calendar3 me-1"></i>
                                                        {{ $newsEvent->published_at->format('F d, Y') }}
                                                    </small>
                                                    <a href="{{ route('frontend.news-event.show', $newsEvent->id) }}"
                                                       class="btn btn-primary" onclick="event.stopPropagation();">
                                                        Read More <i class="bi bi-arrow-right ms-1"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        @if($newsEvents->count() > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#newsEventsCarousel" data-bs-slide="prev" style="width: 5%;">
                            <span class="carousel-control-prev-icon bg-primary rounded-circle p-3" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#newsEventsCarousel" data-bs-slide="next" style="width: 5%;">
                            <span class="carousel-control-next-icon bg-primary rounded-circle p-3" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                        @endif
                    </div>

                    <div class="text-center">
                        <a href="{{ route('frontend.news-events') }}" class="btn btn-primary btn-lg">
                            <i class="bi bi-newspaper me-2"></i>See All News & Events
                        </a>
                    </div>
                @else
                    <div class="card shadow-sm">
                        <div class="card-body text-center py-5">
                            <i class="bi bi-newspaper text-muted" style="font-size: 4rem;"></i>
                            <p class="text-muted mt-3 mb-0">No news or events available at the moment.</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Notices Sidebar (1 card) -->
            <div class="col-lg-3">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-megaphone me-2"></i>Notices
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        @if($notices->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach($notices->take(4) as $notice)
                                    <div class="list-group-item notice-sidebar-item" onclick="window.location.href='{{ route('frontend.notice.show', $notice->id) }}'">
                                        <span class="notice-badge badge mb-2
                                            @if($notice->type == 'emergency') bg-danger
                                            @elseif($notice->type == 'announcement') bg-primary
                                            @elseif($notice->type == 'event') bg-success
                                            @else bg-secondary
                                            @endif">
                                            {{ ucfirst($notice->type) }}
                                        </span>
                                        <h6 class="mb-1">{{ Str::limit($notice->title, 50) }}</h6>
                                        <small class="text-muted d-block">
                                            <i class="bi bi-calendar3 me-1"></i>
                                            {{ $notice->published_at->format('M d, Y') }}
                                        </small>
                                    </div>
                                @endforeach
                            </div>
                            <div class="card-footer bg-white text-center border-top">
                                <a href="{{ route('frontend.notices') }}" class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-list-ul me-1"></i>See All Notices
                                </a>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-megaphone text-muted" style="font-size: 2.5rem;"></i>
                                <p class="text-muted small mt-2 mb-0">No notices available</p>
                            </div>
                        @endif
                    </div>
                </div>
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

        @php
            $services = \App\Models\Service::active()->ordered()->get();
        @endphp

        <div class="row g-4">
            @forelse($services as $service)
            <div class="col-lg-4 col-md-6">
                <div class="service-card">
                    @if($service->image)
                        <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->title }}">
                    @else
                        <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=500" alt="{{ $service->title }}">
                    @endif
                    <div class="service-content">
                        <h3 class="service-title">{{ $service->title }}</h3>
                        <p>{{ $service->description }}</p>
                    </div>
                </div>
            </div>
            @empty
            <!-- Fallback content if no services in database -->
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
            @endforelse
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">What Our Customers Say</h2>
            <p class="section-subtitle">Real experiences from satisfied customers</p>
        </div>

        @php
            $testimonials = \App\Models\Testimonial::active()->latest()->get();
        @endphp

        @if($testimonials->count() > 0)
            <div id="testimonialsCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
                <div class="carousel-inner">
                    @foreach($testimonials as $index => $testimonial)
                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                            <div class="row justify-content-center">
                                <div class="col-lg-8">
                                    <div class="testimonial-card">
                                        @if($testimonial->customer_photo)
                                            <img src="{{ asset('storage/' . $testimonial->customer_photo) }}" alt="{{ $testimonial->customer_name }}" class="testimonial-photo">
                                        @else
                                            <div class="testimonial-photo d-flex align-items-center justify-content-center" style="background: #f8f9fa;">
                                                <i class="bi bi-person-circle" style="font-size: 5rem; color: #6c757d;"></i>
                                            </div>
                                        @endif

                                        <div class="testimonial-stars">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $testimonial->rating)
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                @else
                                                    <i class="bi bi-star text-warning"></i>
                                                @endif
                                            @endfor
                                        </div>

                                        <p class="testimonial-text">"{{ $testimonial->testimonial }}"</p>

                                        <h4 class="testimonial-name">{{ $testimonial->customer_name }}</h4>
                                        @if($testimonial->customer_designation)
                                            <p class="testimonial-designation">{{ $testimonial->customer_designation }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($testimonials->count() > 1)
                    <button class="carousel-control-prev" type="button" data-bs-target="#testimonialsCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#testimonialsCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>

                    <div class="carousel-indicators position-relative mt-4">
                        @foreach($testimonials as $index => $testimonial)
                            <button type="button" data-bs-target="#testimonialsCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}" aria-current="{{ $index == 0 ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}"></button>
                        @endforeach
                    </div>
                @endif
            </div>
        @else
            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle me-2"></i>
                No testimonials available at the moment.
            </div>
        @endif
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

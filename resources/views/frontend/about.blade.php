@extends('frontend.layouts.app')

@section('title', 'About Us')
@section('meta_description', 'Learn about Prottoy Healthcare - Our Mission, Vision, and Leadership Team')

@section('styles')
<style>
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 80px 0 60px;
        text-align: center;
    }

    .page-header h1 {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 1rem;
    }

    .page-header p {
        font-size: 1.2rem;
        opacity: 0.95;
    }

    .about-section {
        padding: 80px 0;
    }

    .mission-vision-section {
        background: #f8f9fa;
        padding: 80px 0;
    }

    .mv-card {
        background: white;
        padding: 3rem;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        height: 100%;
        transition: all 0.3s ease;
    }

    .mv-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .mv-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        margin-bottom: 1.5rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .mv-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        color: #2c3e50;
    }

    .mv-text {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #555;
    }

    .leadership-section {
        padding: 80px 0;
    }

    .leader-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        margin-bottom: 2rem;
    }

    .leader-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .leader-image {
        width: 100%;
        height: 350px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 8rem;
        color: white;
        position: relative;
    }

    .leader-content {
        padding: 2.5rem;
    }

    .leader-name {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: #2c3e50;
    }

    .leader-title {
        font-size: 1.2rem;
        color: #667eea;
        font-weight: 600;
        margin-bottom: 1.5rem;
    }

    .leader-bio {
        font-size: 1rem;
        line-height: 1.8;
        color: #555;
        margin-bottom: 1rem;
    }

    .timeline {
        position: relative;
        padding: 2rem 0;
    }

    .timeline-item {
        position: relative;
        padding-left: 3rem;
        margin-bottom: 2rem;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 15px;
        height: 15px;
        background: #667eea;
        border-radius: 50%;
        border: 3px solid #f8f9fa;
    }

    .timeline-item::after {
        content: '';
        position: absolute;
        left: 7px;
        top: 15px;
        width: 2px;
        height: calc(100% + 2rem);
        background: #dee2e6;
    }

    .timeline-item:last-child::after {
        display: none;
    }

    .timeline-year {
        font-size: 1.1rem;
        font-weight: 700;
        color: #667eea;
        margin-bottom: 0.5rem;
    }

    .timeline-text {
        color: #555;
        line-height: 1.6;
    }

    .values-section {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: white;
        padding: 80px 0;
    }

    .value-item {
        text-align: center;
        padding: 2rem;
    }

    .value-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        margin: 0 auto 1.5rem;
    }

    .value-title {
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 0.75rem;
    }

    @media (max-width: 768px) {
        .page-header h1 {
            font-size: 2rem;
        }

        .leader-image {
            height: 250px;
            font-size: 5rem;
        }
    }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="container">
        <h1 class="fade-in-up">About Us</h1>
        <p class="fade-in-up">Leading the way in healthcare management excellence</p>
    </div>
</div>

<!-- About Us Section -->
@php
    $aboutUs = \App\Models\AboutContent::active()->ofType('about')->first();
@endphp

@if($aboutUs)
<section class="about-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">{{ $aboutUs->title }}</h2>
            <p class="section-subtitle">Discover our story and commitment to healthcare excellence</p>
        </div>

        <div class="row align-items-center">
            @if($aboutUs->image)
            <div class="col-lg-5 mb-4 mb-lg-0">
                <img src="{{ asset('storage/' . $aboutUs->image) }}" alt="{{ $aboutUs->title }}" class="img-fluid rounded shadow">
            </div>
            <div class="col-lg-7">
            @else
            <div class="col-lg-12">
            @endif
                <div class="lead" style="color: #555; line-height: 1.8;">
                    {!! nl2br(e($aboutUs->content)) !!}
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Mission & Vision Section -->
<section class="mission-vision-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Our Mission & Vision</h2>
            <p class="section-subtitle">Guiding principles that drive our commitment to excellence</p>
        </div>

        @php
            $mission = \App\Models\AboutContent::active()->ofType('mission')->first();
            $vision = \App\Models\AboutContent::active()->ofType('vision')->first();
        @endphp

        <div class="row g-4">
            <div class="col-lg-6">
                <div class="mv-card">
                    @if($mission && $mission->image)
                        <img src="{{ asset('storage/' . $mission->image) }}" alt="Mission" class="img-fluid rounded mb-3">
                    @endif
                    <div class="mv-icon">
                        <i class="bi bi-bullseye"></i>
                    </div>
                    <h3 class="mv-title">{{ $mission ? $mission->title : 'Our Mission' }}</h3>
                    <p class="mv-text">
                        @if($mission)
                            {{ $mission->content }}
                        @else
                            To provide accessible, affordable, and quality healthcare services to every citizen of Bangladesh.
                            We strive to create a comprehensive healthcare ecosystem that ensures timely medical assistance,
                            seamless claims processing, and continuous support for all our members. Our mission is to bridge
                            the gap between healthcare providers and patients, making quality healthcare a reality for everyone.
                        @endif
                    </p>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="mv-card">
                    @if($vision && $vision->image)
                        <img src="{{ asset('storage/' . $vision->image) }}" alt="Vision" class="img-fluid rounded mb-3">
                    @endif
                    <div class="mv-icon">
                        <i class="bi bi-eye"></i>
                    </div>
                    <h3 class="mv-title">{{ $vision ? $vision->title : 'Our Vision' }}</h3>
                    <p class="mv-text">
                        @if($vision)
                            {{ $vision->content }}
                        @else
                            To become the most trusted and preferred healthcare management organization in Bangladesh by 2030.
                            We envision a future where every individual has access to world-class healthcare services regardless
                            of their location or economic status. Through innovation, technology, and unwavering commitment,
                            we aim to set new standards in healthcare delivery and customer satisfaction across the nation.
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Leadership Section -->
@php
    $leaders = \App\Models\Leadership::active()->ordered()->get();
@endphp

@if($leaders->count() > 0)
<section class="leadership-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Our Leadership</h2>
            <p class="section-subtitle">Meet the visionaries behind Prottoy Healthcare</p>
        </div>

        @foreach($leaders as $leader)
        <div class="leader-card">
            <div class="row g-0">
                <div class="col-lg-4">
                    <div class="leader-image">
                        @if($leader->photo)
                            <img src="{{ asset('storage/' . $leader->photo) }}" alt="{{ $leader->name }}"
                                 style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <i class="bi bi-person-circle"></i>
                        @endif
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="leader-content">
                        <h3 class="leader-name">{{ $leader->name }}</h3>
                        <p class="leader-title">{{ $leader->designation }}</p>

                        @if($leader->bio)
                        <div class="leader-bio">
                            {!! $leader->bio !!}
                        </div>
                        @endif

                        @if($leader->email || $leader->phone)
                        <div class="mt-4">
                            @if($leader->email)
                                <p class="mb-2">
                                    <i class="bi bi-envelope me-2 text-primary"></i>
                                    <a href="mailto:{{ $leader->email }}" class="text-decoration-none">{{ $leader->email }}</a>
                                </p>
                            @endif
                            @if($leader->phone)
                                <p class="mb-2">
                                    <i class="bi bi-telephone me-2 text-primary"></i>
                                    <a href="tel:{{ $leader->phone }}" class="text-decoration-none">{{ $leader->phone }}</a>
                                </p>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif

<!-- Values Section -->
<section class="values-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title text-white">Our Core Values</h2>
            <p class="section-subtitle text-white-50">The principles that guide everything we do</p>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="value-item">
                    <div class="value-icon">
                        <i class="bi bi-heart-pulse"></i>
                    </div>
                    <h4 class="value-title">Compassion</h4>
                    <p>Caring for every individual with empathy and understanding</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="value-item">
                    <div class="value-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h4 class="value-title">Integrity</h4>
                    <p>Upholding the highest standards of honesty and ethics</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="value-item">
                    <div class="value-icon">
                        <i class="bi bi-lightning"></i>
                    </div>
                    <h4 class="value-title">Innovation</h4>
                    <p>Embracing new technologies and methods for better service</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="value-item">
                    <div class="value-icon">
                        <i class="bi bi-award"></i>
                    </div>
                    <h4 class="value-title">Excellence</h4>
                    <p>Striving for the best in everything we do</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

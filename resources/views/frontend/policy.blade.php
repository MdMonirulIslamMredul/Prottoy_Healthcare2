@extends('frontend.layouts.app')

@section('title', 'Policy & Legal')
@section('meta_description', 'Access Prottoy Healthcare policies, legal documents, memorandum, and official notices')

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

    .policy-section {
        padding: 80px 0;
    }

    .document-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        padding: 2.5rem;
        margin-bottom: 2rem;
        transition: all 0.3s ease;
        border-left: 5px solid #667eea;
    }

    .document-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .document-header {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid #f8f9fa;
    }

    .document-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        color: white;
        margin-right: 1.5rem;
    }

    .document-title {
        font-size: 1.6rem;
        font-weight: 700;
        color: #2c3e50;
        margin: 0;
    }

    .document-meta {
        font-size: 0.9rem;
        color: #6c757d;
        margin-top: 0.5rem;
    }

    .document-content {
        color: #555;
        line-height: 1.8;
    }

    .document-content h5 {
        color: #2c3e50;
        font-weight: 700;
        margin-top: 1.5rem;
        margin-bottom: 1rem;
    }

    .document-content ul {
        list-style: none;
        padding-left: 0;
    }

    .document-content li {
        padding: 0.5rem 0;
        padding-left: 2rem;
        position: relative;
    }

    .document-content li::before {
        content: '▪';
        position: absolute;
        left: 0;
        color: #667eea;
        font-weight: 700;
        font-size: 1.2rem;
    }

    .download-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
    }

    .download-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .notices-section {
        background: #f8f9fa;
        padding: 80px 0;
    }

    .notice-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border-left: 4px solid #667eea;
    }

    .notice-card:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.12);
    }

    .notice-badge {
        display: inline-block;
        padding: 0.375rem 0.75rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
    }

    .notice-badge.important {
        background: #fff3cd;
        color: #856404;
    }

    .notice-badge.general {
        background: #d1ecf1;
        color: #0c5460;
    }

    .notice-badge.urgent {
        background: #f8d7da;
        color: #721c24;
    }

    .notice-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }

    .notice-date {
        font-size: 0.9rem;
        color: #6c757d;
        margin-bottom: 0.75rem;
    }

    .notice-excerpt {
        color: #555;
        line-height: 1.6;
    }

    .compliance-section {
        padding: 80px 0;
    }

    .compliance-card {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        height: 100%;
        transition: all 0.3s ease;
        text-align: center;
    }

    .compliance-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .compliance-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        color: white;
        margin: 0 auto 1.5rem;
    }

    .compliance-title {
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: #2c3e50;
    }

    @media (max-width: 768px) {
        .page-header h1 {
            font-size: 2rem;
        }

        .document-header {
            flex-direction: column;
            text-align: center;
        }

        .document-icon {
            margin-right: 0;
            margin-bottom: 1rem;
        }
    }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="container">
        <h1 class="fade-in-up">Policy & Legal</h1>
        <p class="fade-in-up">Official documents, policies, and regulatory compliance information</p>
    </div>
</div>

<!-- Policy Documents Section -->
<section class="policy-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Policy Documents</h2>
            <p class="section-subtitle">Access our official policies and legal documents</p>
        </div>

        @php
            $policies = \App\Models\Policy::active()->ordered()->get();
        @endphp

        @forelse($policies as $policy)
            <!-- {{ $policy->title }} -->
            <div class="document-card" style="border-left-color: {{ $policy->color ?? '#667eea' }};">
                <div class="document-header">
                    <div class="document-icon" style="background: linear-gradient(135deg, {{ $policy->color ?? '#667eea' }} 0%, {{ $policy->color ?? '#764ba2' }} 100%);">
                        <i class="{{ $policy->icon ?? 'bi-file-earmark-text' }}"></i>
                    </div>
                    <div>
                        <h3 class="document-title">{{ $policy->title }}</h3>
                        <div class="document-meta">
                            <i class="bi bi-calendar3 me-2"></i>Last Updated: {{ $policy->updated_at->format('F Y') }}
                            @if($policy->category)
                                <span class="mx-2">|</span>
                                <i class="bi bi-tag me-2"></i>{{ ucfirst($policy->category) }}
                            @endif
                        </div>
                    </div>
                </div>
                <div class="document-content">
                    @if($policy->description)
                        <p class="lead">{{ $policy->description }}</p>
                    @endif

                    {!! $policy->content !!}
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <div style="font-size: 4rem; color: #dee2e6;">
                    <i class="bi bi-file-earmark-x"></i>
                </div>
                <h4 class="mt-3 text-muted">No Policy Documents Available</h4>
                <p class="text-muted">Policy documents will be published here soon.</p>
            </div>
        @endforelse
    </div>
</section>

<!-- Compliance Section -->
<section class="compliance-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Regulatory Compliance</h2>
            <p class="section-subtitle">Our commitment to legal and ethical standards</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="compliance-card">
                    <div class="compliance-icon">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <h4 class="compliance-title">Licensed & Registered</h4>
                    <p class="text-muted">Fully licensed healthcare organization registered with relevant authorities</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="compliance-card">
                    <div class="compliance-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h4 class="compliance-title">Data Protection</h4>
                    <p class="text-muted">Compliant with Bangladesh data protection and privacy laws</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="compliance-card">
                    <div class="compliance-icon">
                        <i class="bi bi-file-earmark-check"></i>
                    </div>
                    <h4 class="compliance-title">Quality Standards</h4>
                    <p class="text-muted">Adheres to national healthcare quality and safety standards</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="compliance-card">
                    <div class="compliance-icon">
                        <i class="bi bi-award"></i>
                    </div>
                    <h4 class="compliance-title">Certified Operations</h4>
                    <p class="text-muted">Certified by healthcare regulatory bodies and industry associations</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

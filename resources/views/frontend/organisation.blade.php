@extends('frontend.layouts.app')

@section('title', 'Organisation & Leadership')
@section('meta_description', 'Learn about Prottoy Healthcare organizational structure, leadership team, and their roles & responsibilities')

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

    .org-section {
        padding: 80px 0;
    }

    .org-chart {
        background: #f8f9fa;
        padding: 80px 0;
    }

    .org-level {
        margin-bottom: 3rem;
        text-align: center;
    }

    .org-box {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        margin: 0 auto 1.5rem;
        max-width: 350px;
        position: relative;
        transition: all 0.3s ease;
    }

    .org-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .org-box.level-1 {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .org-box.level-2 {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }

    .org-box.level-3 {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
    }

    .org-box.level-4 {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        color: white;
    }

    .org-box.level-5 {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        color: white;
    }

    .org-icon {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin: 0 auto 1rem;
    }

    .org-title {
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .org-subtitle {
        font-size: 0.9rem;
        opacity: 0.9;
    }

    .connector {
        width: 2px;
        height: 30px;
        background: #dee2e6;
        margin: 0 auto;
    }

    .role-section {
        padding: 80px 0;
    }

    .role-card {
        background: white;
        border-radius: 15px;
        padding: 2.5rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
        transition: all 0.3s ease;
    }

    .role-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .role-header {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid #f8f9fa;
    }

    .role-icon {
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

    .role-name {
        font-size: 1.6rem;
        font-weight: 700;
        color: #2c3e50;
        margin: 0;
    }

    .responsibility-list {
        list-style: none;
        padding: 0;
    }

    .responsibility-list li {
        padding: 0.75rem 0;
        padding-left: 2rem;
        position: relative;
        color: #555;
        line-height: 1.6;
    }

    .responsibility-list li::before {
        content: '✓';
        position: absolute;
        left: 0;
        color: #667eea;
        font-weight: 700;
        font-size: 1.2rem;
    }

    .stats-badge {
        display: inline-block;
        background: #f8f9fa;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        margin: 0.25rem;
        font-size: 0.9rem;
        color: #667eea;
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .page-header h1 {
            font-size: 2rem;
        }

        .org-box {
            max-width: 100%;
        }

        .role-header {
            flex-direction: column;
            text-align: center;
        }

        .role-icon {
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
        <h1 class="fade-in-up">Organisation & Leadership</h1>
        <p class="fade-in-up">Our structured approach to excellence in healthcare management</p>
    </div>
</div>

<!-- Organizational Chart Section -->
<section class="org-chart">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Organizational Structure</h2>
            <p class="section-subtitle">Hierarchical framework ensuring efficient service delivery</p>
        </div>

        @php
            $orgRoles = \App\Models\OrganizationalRole::active()->ordered()->get();
        @endphp

        @foreach($orgRoles as $role)
            <!-- {{ $role->title }} -->
            <div class="org-level">
                <div class="org-box level-{{ $role->level }}" style="background: linear-gradient(135deg, {{ $role->color_start }} 0%, {{ $role->color_end }} 100%);">
                    <div class="org-icon">
                        <i class="{{ $role->icon }}"></i>
                    </div>
                    <div class="org-title">{{ $role->title }}</div>
                    @if($role->subtitle)
                        <div class="org-subtitle">{{ $role->subtitle }}</div>
                    @endif
                </div>
                @if(!$loop->last)
                    <div class="connector"></div>
                @endif
            </div>
        @endforeach

        <div class="text-center mt-5">
            <p class="text-muted"><i class="bi bi-info-circle me-2"></i>Each level ensures accountability and efficient service delivery across Bangladesh</p>
        </div>
    </div>
</section>

<!-- Roles & Responsibilities Section -->
<section class="role-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Roles & Responsibilities</h2>
            <p class="section-subtitle">Detailed overview of each position's duties and authority</p>
        </div>

        @foreach($orgRoles as $role)
            <!-- {{ $role->title }} -->
            <div class="role-card">
                <div class="role-header">
                    <div class="role-icon" style="background: linear-gradient(135deg, {{ $role->color_start }} 0%, {{ $role->color_end }} 100%);">
                        <i class="{{ $role->icon }}"></i>
                    </div>
                    <div>
                        <h3 class="role-name">{{ $role->title }}</h3>
                        @if($role->stats && count($role->stats) > 0)
                            <div class="mt-2">
                                @foreach($role->stats as $stat)
                                    <span class="stats-badge">{{ $stat }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                <h5 class="mb-3">Key Responsibilities:</h5>
                <ul class="responsibility-list">
                    @foreach($role->responsibilities as $responsibility)
                        <li>{{ $responsibility }}</li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>
</section>

<!-- Coverage Stats Section -->
<section class="stats-section" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: white; padding: 60px 0;">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="text-white mb-3">Our National Coverage</h2>
        </div>
        <div class="row text-center">
            <div class="col-lg-3 col-md-6 mb-4">
                <div style="font-size: 2.5rem; font-weight: 800;">8</div>
                <div style="font-size: 1.1rem; opacity: 0.9;">Divisions</div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div style="font-size: 2.5rem; font-weight: 800;">64</div>
                <div style="font-size: 1.1rem; opacity: 0.9;">Districts</div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div style="font-size: 2.5rem; font-weight: 800;">500+</div>
                <div style="font-size: 1.1rem; opacity: 0.9;">Upazilas</div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div style="font-size: 2.5rem; font-weight: 800;">100%</div>
                <div style="font-size: 1.1rem; opacity: 0.9;">National Coverage</div>
            </div>
        </div>
    </div>
</section>
@endsection

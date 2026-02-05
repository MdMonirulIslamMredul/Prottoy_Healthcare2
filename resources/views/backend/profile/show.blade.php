@extends('backend.layouts.app')

@section('page-title', 'My Profile')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Profile Card -->
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-person-circle me-2"></i>Profile Information</h5>
                    <a href="{{ route('profile.edit') }}" class="btn btn-light btn-sm">
                        <i class="bi bi-pencil me-1"></i>Edit Profile
                    </a>
                </div>
                <div class="card-body">
                    <!-- Profile Avatar -->
                    <div class="text-center mb-4">
                        <div class="profile-avatar-large mx-auto mb-3">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <h4 class="mb-1">{{ $user->name }}</h4>
                        <span class="badge bg-{{
                            $user->role === 'super_admin' ? 'danger' :
                            ($user->role === 'divisional_chief' ? 'primary' :
                            ($user->role === 'district_manager' ? 'success' :
                            ($user->role === 'upazila_supervisor' ? 'info' :
                            ($user->role === 'pho' ? 'warning' : 'secondary'))))
                        }} fs-6">
                            {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                        </span>
                    </div>

                    <hr>

                    <!-- Profile Details -->
                    <div class="row g-3">
                        <!-- Email -->
                        <div class="col-md-6">
                            <div class="profile-info-item">
                                <label class="text-muted mb-1">
                                    <i class="bi bi-envelope me-2"></i>Email Address
                                </label>
                                <p class="fw-semibold mb-0">{{ $user->email }}</p>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="col-md-6">
                            <div class="profile-info-item">
                                <label class="text-muted mb-1">
                                    <i class="bi bi-telephone me-2"></i>Phone Number
                                </label>
                                <p class="fw-semibold mb-0">{{ $user->phone ?? 'Not provided' }}</p>
                            </div>
                        </div>

                        <!-- Division -->
                        @if($user->division)
                        <div class="col-md-6">
                            <div class="profile-info-item">
                                <label class="text-muted mb-1">
                                    <i class="bi bi-geo-alt me-2"></i>Division
                                </label>
                                <p class="fw-semibold mb-0">{{ $user->division->name }}</p>
                            </div>
                        </div>
                        @endif

                        <!-- District -->
                        @if($user->district)
                        <div class="col-md-6">
                            <div class="profile-info-item">
                                <label class="text-muted mb-1">
                                    <i class="bi bi-geo me-2"></i>District
                                </label>
                                <p class="fw-semibold mb-0">{{ $user->district->name }}</p>
                            </div>
                        </div>
                        @endif

                        <!-- Upazila -->
                        @if($user->upzila)
                        <div class="col-md-6">
                            <div class="profile-info-item">
                                <label class="text-muted mb-1">
                                    <i class="bi bi-pin-map me-2"></i>Upazila
                                </label>
                                <p class="fw-semibold mb-0">{{ $user->upzila->name }}</p>
                            </div>
                        </div>
                        @endif

                        <!-- Address -->
                        <div class="col-12">
                            <div class="profile-info-item">
                                <label class="text-muted mb-1">
                                    <i class="bi bi-house me-2"></i>Address
                                </label>
                                <p class="fw-semibold mb-0">{{ $user->address ?? 'Not provided' }}</p>
                            </div>
                        </div>

                        <!-- Supervisor (if PHO) -->
                        @if($user->role === 'pho' && $user->upazilaSupervisor)
                        <div class="col-md-6">
                            <div class="profile-info-item">
                                <label class="text-muted mb-1">
                                    <i class="bi bi-person-badge me-2"></i>Upazila Supervisor
                                </label>
                                <p class="fw-semibold mb-0">{{ $user->upazilaSupervisor->name }}</p>
                            </div>
                        </div>
                        @endif

                        <!-- PHO (if Customer) -->
                        @if($user->role === 'customer' && $user->pho)
                        <div class="col-md-6">
                            <div class="profile-info-item">
                                <label class="text-muted mb-1">
                                    <i class="bi bi-person-badge me-2"></i>Primary Health Officer
                                </label>
                                <p class="fw-semibold mb-0">{{ $user->pho->name }}</p>
                            </div>
                        </div>
                        @endif

                        <!-- Member Since -->
                        <div class="col-md-6">
                            <div class="profile-info-item">
                                <label class="text-muted mb-1">
                                    <i class="bi bi-calendar-check me-2"></i>Member Since
                                </label>
                                <p class="fw-semibold mb-0">{{ $user->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>

                        <!-- Last Updated -->
                        <div class="col-md-6">
                            <div class="profile-info-item">
                                <label class="text-muted mb-1">
                                    <i class="bi bi-clock-history me-2"></i>Last Updated
                                </label>
                                <p class="fw-semibold mb-0">{{ $user->updated_at->format('M d, Y h:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .profile-avatar-large {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 60px;
    }

    .profile-info-item {
        padding: 15px;
        background: #f8f9fa;
        border-radius: 8px;
        border-left: 4px solid #0d6efd;
    }

    .profile-info-item label {
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .profile-info-item p {
        font-size: 15px;
        color: #333;
    }

    .card {
        border: none;
        border-radius: 10px;
    }

    .card-header {
        border-radius: 10px 10px 0 0 !important;
        padding: 15px 20px;
    }
</style>
@endsection

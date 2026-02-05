@extends('backend.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h2>Customer Dashboard</h2>
            <p class="text-muted">Welcome, {{ $customer->name }}</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Personal Information -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-person-circle text-primary me-2"></i>Personal Information
                    </h5>
                    <hr>
                    <div class="mb-3">
                        <strong>Name:</strong><br>
                        <span class="fs-5">{{ $customer->name }}</span>
                    </div>
                    <div class="mb-3">
                        <strong>Email:</strong><br>
                        {{ $customer->email }}
                    </div>
                    <div class="mb-3">
                        <strong>Role:</strong><br>
                        <span class="badge bg-success">Customer</span>
                    </div>
                    <div class="mb-3">
                        <strong>Member Since:</strong><br>
                        {{ $customer->created_at->format('d M Y') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Location & PHO Information -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-geo-alt-fill text-success me-2"></i>Location & PHO Details
                    </h5>
                    <hr>
                    <div class="mb-3">
                        <strong>Division:</strong><br>
                        {{ $customer->division->name ?? 'N/A' }}
                    </div>
                    <div class="mb-3">
                        <strong>District:</strong><br>
                        {{ $customer->district->name ?? 'N/A' }}
                    </div>
                    <div class="mb-3">
                        <strong>Upazila:</strong><br>
                        {{ $customer->upzila->name ?? 'N/A' }}
                    </div>
                    <div class="mb-3">
                        <strong>Assigned PHO:</strong><br>
                        <span class="fs-5">{{ $customer->pho->name ?? 'N/A' }}</span><br>
                        <small class="text-muted">{{ $customer->pho->email ?? '' }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Welcome Message -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm bg-primary bg-opacity-10">
                <div class="card-body text-center py-5">
                    <i class="bi bi-heart-pulse-fill text-primary fs-1 mb-3 d-block"></i>
                    <h3 class="text-primary mb-3">Welcome to Prottoy Healthcare System</h3>
                    <p class="lead mb-0">
                        Your health and wellness is our priority. You are registered under <strong>{{ $customer->pho->name ?? 'your PHO' }}</strong>.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

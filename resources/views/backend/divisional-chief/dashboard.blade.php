@extends('backend.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h2>Divisional Chief Dashboard</h2>
            <p class="text-muted">Welcome, {{ $divisionalChief->name }}</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-3">
            <a href="{{ route('divisionalchief.district-managers.index') }}" class="text-decoration-none">
                <div class="card shadow-sm h-100 hover-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                                    <i class="bi bi-building text-primary fs-4"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1 text-muted">District Managers</h6>
                                <h3 class="mb-0 text-dark">{{ $districtManagersCount }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-lg-3">
            <a href="{{ route('divisionalchief.upazila-supervisors.index') }}" class="text-decoration-none">
                <div class="card shadow-sm h-100 hover-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle bg-success bg-opacity-10 p-3">
                                    <i class="bi bi-pin-map-fill text-success fs-4"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1 text-muted">Upazila Supervisors</h6>
                                <h3 class="mb-0 text-dark">{{ $upazilaSupervisorsCount }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-lg-3">
            <a href="{{ route('divisionalchief.phos.index') }}" class="text-decoration-none">
                <div class="card shadow-sm h-100 hover-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle bg-info bg-opacity-10 p-3">
                                    <i class="bi bi-person-vcard text-info fs-4"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1 text-muted">PHOs</h6>
                                <h3 class="mb-0 text-dark">{{ $phosCount }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-lg-3">
            <a href="{{ route('divisionalchief.customers.index') }}" class="text-decoration-none">
                <div class="card shadow-sm h-100 hover-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                                    <i class="bi bi-people-fill text-warning fs-4"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1 text-muted">Customers</h6>
                                <h3 class="mb-0 text-dark">{{ $customersCount }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Hierarchy Card -->
    <div class="row g-4 mb-4">
        <div class="col-12">
            <a href="{{ route('divisionalchief.hierarchy') }}" class="text-decoration-none">
                <div class="card shadow-sm hover-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle bg-purple bg-opacity-10 p-3">
                                    <i class="bi bi-diagram-3 text-purple fs-4"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mb-1 text-dark">View User Hierarchy</h5>
                                <p class="mb-0 text-muted">See the complete organizational structure and reporting hierarchy</p>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="bi bi-arrow-right text-muted fs-3"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Location Information -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-geo-alt-fill text-primary me-2"></i>Your Division
                    </h5>
                    <hr>
                    <div class="mb-3">
                        <strong>Division:</strong><br>
                        <span class="fs-5">{{ $divisionalChief->division->name ?? 'N/A' }}</span>
                    </div>
                    <div class="mb-3">
                        <strong>Role:</strong><br>
                        <span class="badge bg-primary">Divisional Chief</span>
                    </div>
                    <div class="mb-3">
                        <strong>Email:</strong><br>
                        {{ $divisionalChief->email }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-info-circle text-info me-2"></i>Quick Info
                    </h5>
                    <hr>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            You manage the entire <strong>{{ $divisionalChief->division->name ?? 'N/A' }}</strong> division
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            Total of <strong>{{ $districtManagersCount }}</strong> District Managers under your supervision
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            <strong>{{ $upazilaSupervisorsCount }}</strong> Upazila Supervisors in your division
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            <strong>{{ $phosCount }}</strong> PHOs serving customers
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hover-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    cursor: pointer;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.bg-purple {
    background-color: #6f42c1;
}

.text-purple {
    color: #6f42c1;
}
</style>
@endsection

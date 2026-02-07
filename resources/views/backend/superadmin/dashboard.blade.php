@extends('backend.layouts.app')

@section('title', 'Super Admin Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Welcome Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h4 class="mb-2">Welcome back, {{ Auth::user()->name ?? 'Super Admin' }} </h4>
                    <p class="text-muted mb-0">Here's what's happening with your Prottoy Healthcare system today.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-12 col-sm-6 col-lg-4 col-xl-2">
            <a href="{{ route('superadmin.divisional-chiefs.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-muted mb-1 small">Divisional Chiefs</p>
                                <h3 class="mb-0">{{ $divisionalChiefsCount }}</h3>
                            </div>
                            <div class="stat-icon bg-primary">
                                <i class="bi bi-person-badge-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-12 col-sm-6 col-lg-4 col-xl-2">
            <a href="{{ route('superadmin.district-managers.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-muted mb-1 small">District Managers</p>
                                <h3 class="mb-0">{{ $districtManagersCount }}</h3>
                            </div>
                            <div class="stat-icon bg-success">
                                <i class="bi bi-geo-alt-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-12 col-sm-6 col-lg-4 col-xl-2">
            <a href="{{ route('superadmin.upazila-supervisors.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-muted mb-1 small">Upazila Supervisors</p>
                                <h3 class="mb-0">{{ $upazilaSupervisorsCount }}</h3>
                            </div>
                            <div class="stat-icon bg-info">
                                <i class="bi bi-pin-map-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-12 col-sm-6 col-lg-4 col-xl-2">
            <a href="{{ route('superadmin.phos.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-muted mb-1 small">PHOs</p>
                                <h3 class="mb-0">{{ $phosCount }}</h3>
                            </div>
                            <div class="stat-icon bg-warning">
                                <i class="bi bi-person-vcard"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-12 col-sm-6 col-lg-4 col-xl-2">
            <a href="{{ route('superadmin.customers.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-muted mb-1 small">Customers</p>
                                <h3 class="mb-0">{{ $customersCount }}</h3>
                            </div>
                            <div class="stat-icon bg-secondary">
                                <i class="bi bi-people-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-12 col-sm-6 col-lg-4 col-xl-2">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">Total Users</p>
                            <h3 class="mb-0">{{ $totalUsers }}</h3>
                        </div>
                        <div class="stat-icon bg-dark">
                            <i class="bi bi-people"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Package Sales Statistics -->
    <div class="row g-4 mb-4">
        <div class="col-12 col-sm-6 col-lg-3">
            <a href="{{ route('superadmin.package-sales') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-muted mb-1 small">Packages Sold</p>
                                <h3 class="mb-0">{{ $totalPackagesSold }}</h3>
                            </div>
                            <div class="stat-icon bg-primary">
                                <i class="bi bi-box-seam"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <a href="{{ route('superadmin.package-sales') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-muted mb-1 small">Sales Amount</p>
                                <h3 class="mb-0">৳{{ number_format($totalSalesAmount, 0) }}</h3>
                            </div>
                            <div class="stat-icon bg-info">
                                <i class="bi bi-currency-exchange"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <a href="{{ route('superadmin.package-sales') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-muted mb-1 small">Paid Amount</p>
                                <h3 class="mb-0">৳{{ number_format($totalPaidAmount, 0) }}</h3>
                            </div>
                            <div class="stat-icon bg-success">
                                <i class="bi bi-check-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <a href="{{ route('superadmin.package-sales') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-muted mb-1 small">Due Amount</p>
                                <h3 class="mb-0">৳{{ number_format($totalDueAmount, 0) }}</h3>
                            </div>
                            <div class="stat-icon bg-warning">
                                <i class="bi bi-exclamation-triangle"></i>
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
            <a href="{{ route('superadmin.hierarchy') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm hover-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle bg-purple bg-opacity-10 p-3">
                                    <i class="bi bi-diagram-3 text-purple fs-4"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mb-1 text-dark">View Complete User Hierarchy</h5>
                                <p class="mb-0 text-muted">See the complete organizational structure of the entire Prottoy Healthcare system</p>
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



    <!-- Recent Users Table -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Recent Users</h5>
                        <button class="btn btn-sm btn-primary">
                            <i class="bi bi-plus-circle me-1"></i>Add User
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($recentUsers->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="px-4">ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Created At</th>
                                        <th class="text-end pe-4">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentUsers as $user)
                                        <tr>
                                            <td class="px-4">#{{ $user->id }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm me-2">
                                                        <i class="bi bi-person-circle fs-4 text-muted"></i>
                                                    </div>
                                                    <span>{{ $user->name ?? 'N/A' }}</span>
                                                </div>
                                            </td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @if($user->role === 'super_admin')
                                                    <span class="badge bg-primary">
                                                        <i class="bi bi-shield-fill-check me-1"></i>Super Admin
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">
                                                        {{ ucfirst(str_replace('_', ' ', $user->role ?? 'User')) }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    <i class="bi bi-clock me-1"></i>
                                                    {{ $user->created_at->format('M d, Y') }}
                                                </small>
                                            </td>
                                            <td class="text-end pe-4">
                                                <button class="btn btn-sm btn-light" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-sm btn-light" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-light text-danger" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-inbox fs-1 text-muted"></i>
                            <p class="text-muted mt-2">No users found</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
        opacity: 0.9;
    }

    .avatar-sm {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .table th {
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #666;
    }

    .table td {
        vertical-align: middle;
        font-size: 14px;
    }

    .card {
        transition: transform 0.2s ease;
    }

    .card:hover {
        transform: translateY(-2px);
    }

    .btn-light:hover {
        background: #e9ecef;
    }

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
@endpush

@extends('backend.layouts.app')

@section('content')
    <style>
        .hover-lift {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
            cursor: pointer;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }
    </style>

    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-12">
                <h2>Customer Dashboard</h2>
                <p class="text-muted">Welcome, {{ $customer->name }}</p>
            </div>
        </div>

        {{-- @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif --}}

        <!-- Package Statistics -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <a href="{{ route('customer.packages.index') }}" class="text-decoration-none">
                    <div class="card shadow-sm bg-primary bg-opacity-10 border-primary hover-lift">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-1">Total Packages</p>
                                    <h3 class="mb-0 text-primary">{{ $totalPackages }}</h3>
                                </div>
                                <i class="bi bi-box-seam text-primary fs-1"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <a href="{{ route('customer.packages.index') }}" class="text-decoration-none">
                    <div class="card shadow-sm bg-info bg-opacity-10 border-info hover-lift">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-1">Total Value</p>
                                    <h3 class="mb-0 text-info">৳{{ number_format($totalSpent, 0) }}</h3>
                                </div>
                                <i class="bi bi-currency-exchange text-info fs-1"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <a href="{{ route('customer.packages.index') }}" class="text-decoration-none">
                    <div class="card shadow-sm bg-success bg-opacity-10 border-success hover-lift">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-1">Amount Paid</p>
                                    <h3 class="mb-0 text-success">৳{{ number_format($totalPaid, 0) }}</h3>
                                </div>
                                <i class="bi bi-check-circle text-success fs-1"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <a href="{{ route('customer.packages.index') }}" class="text-decoration-none">
                    <div class="card shadow-sm bg-warning bg-opacity-10 border-warning hover-lift">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-1">Amount Due</p>
                                    <h3 class="mb-0 text-warning">৳{{ number_format($totalDue, 0) }}</h3>
                                </div>
                                <i class="bi bi-exclamation-triangle text-warning fs-1"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

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
                            <small class="text-muted d-block">{{ $customer->pho->phone ?? '' }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Packages -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-box-seam text-primary me-2"></i>Recent Healthcare Packages
                        </h5>
                        <a href="{{ route('customer.packages.index') }}" class="btn btn-sm btn-outline-primary">
                            View All <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                    <div class="card-body">
                        @if ($recentPackages->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Package Name</th>
                                            <th>Purchase Date</th>
                                            <th>Total Price</th>
                                            <th>Paid</th>
                                            <th>Due</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($recentPackages as $purchase)
                                            <tr>
                                                <td>
                                                    <strong>{{ $purchase->package->name }}</strong><br>
                                                    <small class="text-muted">{!! Str::limit($purchase->package->details, 40) !!}</small>
                                                </td>
                                                <td>{{ $purchase->purchase_date->format('d M, Y') }}</td>
                                                <td class="fw-bold">৳{{ number_format($purchase->total_price, 2) }}</td>
                                                <td class="text-success">৳{{ number_format($purchase->paid_amount, 2) }}
                                                </td>
                                                <td class="text-danger">৳{{ number_format($purchase->due_amount, 2) }}</td>
                                                <td>
                                                    @if ($purchase->payment_status == 'paid')
                                                        <span class="badge bg-success">Paid</span>
                                                    @elseif($purchase->payment_status == 'partial')
                                                        <span class="badge bg-warning">Partial</span>
                                                    @else
                                                        <span class="badge bg-danger">Pending</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('customer.packages.show', $purchase->id) }}"
                                                        class="btn btn-sm btn-outline-info">
                                                        <i class="bi bi-eye"></i> View
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-box-seam text-muted" style="font-size: 3rem;"></i>
                                <p class="text-muted mt-3 mb-0">No packages purchased yet</p>
                                <p class="text-muted">Contact your PHO to purchase healthcare packages</p>
                            </div>
                        @endif
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
                            Your health and wellness is our priority. You are registered under
                            <strong>{{ $customer->pho->name ?? 'your PHO' }}</strong>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

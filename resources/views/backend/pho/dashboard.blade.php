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
                <h2>PHO Dashboard</h2>
                <p class="text-muted">Welcome, {{ $pho->name }}</p>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Package Sales Statistics -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <a href="{{ route('pho.packages.index') }}" class="text-decoration-none">
                    <div class="card shadow-sm bg-primary bg-opacity-10 border-primary hover-lift">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-1">Packages Sold</p>
                                    <h3 class="mb-0 text-primary">{{ $packagesSoldCount }}</h3>
                                </div>
                                <i class="bi bi-box-seam text-primary fs-1"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <a href="{{ route('pho.packages.index') }}" class="text-decoration-none">
                    <div class="card shadow-sm bg-info bg-opacity-10 border-info hover-lift">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-1">Total Sales</p>
                                    <h3 class="mb-0 text-info">৳{{ number_format($totalSalesAmount, 0) }}</h3>
                                </div>
                                <i class="bi bi-currency-exchange text-info fs-1"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <a href="{{ route('pho.packages.index') }}" class="text-decoration-none">
                    <div class="card shadow-sm bg-success bg-opacity-10 border-success hover-lift">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-1">Amount Collected</p>
                                    <h3 class="mb-0 text-success">৳{{ number_format($totalPaidAmount, 0) }}</h3>
                                </div>
                                <i class="bi bi-check-circle text-success fs-1"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <a href="{{ route('pho.packages.index') }}" class="text-decoration-none">
                    <div class="card shadow-sm bg-warning bg-opacity-10 border-warning hover-lift">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted mb-1">Amount Due</p>
                                    <h3 class="mb-0 text-warning">৳{{ number_format($totalDueAmount, 0) }}</h3>
                                </div>
                                <i class="bi bi-exclamation-triangle text-warning fs-1"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Statistics Card -->
        <div class="row g-4 mb-4">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                                    <i class="bi bi-people-fill text-primary fs-4"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1 text-muted">My Customers</h6>
                                <h3 class="mb-0">{{ $customersCount }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-8">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="bi bi-geo-alt-fill text-primary me-2"></i>Your Location
                        </h5>
                        <div class="row">
                            <div class="col-md-4">
                                <strong>Division:</strong><br>
                                {{ $pho->division->name ?? 'N/A' }}
                            </div>
                            <div class="col-md-4">
                                <strong>District:</strong><br>
                                {{ $pho->district->name ?? 'N/A' }}
                            </div>
                            <div class="col-md-4">
                                <strong>Upazila:</strong><br>
                                {{ $pho->upzila->name ?? 'N/A' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Package Sales -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-box-seam text-primary me-2"></i>Recent Package Sales
                        </h5>
                        <a href="{{ route('pho.packages.index') }}" class="btn btn-sm btn-outline-primary">
                            View All <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                    <div class="card-body">
                        @if ($recentPackageSales->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Customer</th>
                                            <th>Package</th>
                                            <th>Purchase Date</th>
                                            <th>Total Price</th>
                                            <th>Paid</th>
                                            <th>Due</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($recentPackageSales as $sale)
                                            <tr>
                                                <td>{{ $sale->customer->name }}</td>
                                                <td>
                                                    <strong>{{ $sale->package->name }}</strong><br>
                                                    {{-- <small class="text-muted">{!! Str::limit($sale->package->details, 30) !!}</small> --}}
                                                </td>
                                                <td>{{ $sale->purchase_date->format('d M, Y') }}</td>
                                                <td class="fw-bold">৳{{ number_format($sale->total_price, 2) }}</td>
                                                <td class="text-success">৳{{ number_format($sale->paid_amount, 2) }}</td>
                                                <td class="text-danger">৳{{ number_format($sale->due_amount, 2) }}</td>
                                                <td>
                                                    @if ($sale->payment_status == 'paid')
                                                        <span class="badge bg-success">Paid</span>
                                                    @elseif($sale->payment_status == 'partial')
                                                        <span class="badge bg-warning">Partial</span>
                                                    @else
                                                        <span class="badge bg-danger">Pending</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('pho.packages.show', $sale->id) }}"
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
                                <p class="text-muted mt-3 mb-0">No package sales yet</p>
                                <p class="text-muted">Start selling packages to your customers</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Customers List -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="bi bi-people-fill text-info me-2"></i>My Customers
                        </h5>
                        <hr>

                        @if ($customers->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>SL</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Created At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customers as $index => $customer)
                                            <tr>
                                                <td>{{ $customers->firstItem() + $index }}</td>
                                                <td>{{ $customer->name }}</td>
                                                <td>{{ $customer->email }}</td>
                                                <td>{{ $customer->created_at->format('d M Y, h:i A') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            @if ($customers->hasPages())
                                <div class="mt-3">
                                    {{ $customers->links() }}
                                </div>
                            @endif
                        @else
                            <div class="text-center text-muted py-5">
                                <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                                <p>No customers created yet</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

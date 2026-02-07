@extends('backend.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h2>Upazila Supervisor Dashboard</h2>
            <p class="text-muted">Welcome, {{ $upazilaSupervisor->name }}</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Package Sales Statistics -->
    <div class="row g-4 mb-4">
        <div class="col-lg-3 col-md-6">
            <a href="{{ route('upazilasupervisor.package-sales') }}" class="text-decoration-none">
                <div class="card shadow-sm h-100 hover-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                                    <i class="bi bi-box-seam text-primary fs-4"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1 text-muted">Total Packages Sold</h6>
                                <h3 class="mb-0">{{ $totalPackagesSold }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6">
            <a href="{{ route('upazilasupervisor.package-sales') }}" class="text-decoration-none">
                <div class="card shadow-sm h-100 hover-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle bg-info bg-opacity-10 p-3">
                                    <i class="bi bi-currency-exchange text-info fs-4"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1 text-muted">Total Sales Amount</h6>
                                <h3 class="mb-0">৳{{ number_format($totalSalesAmount, 0) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6">
            <a href="{{ route('upazilasupervisor.package-sales') }}" class="text-decoration-none">
                <div class="card shadow-sm h-100 hover-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle bg-success bg-opacity-10 p-3">
                                    <i class="bi bi-check-circle text-success fs-4"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1 text-muted">Total Paid Amount</h6>
                                <h3 class="mb-0">৳{{ number_format($totalPaidAmount, 0) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-6">
            <a href="{{ route('upazilasupervisor.package-sales') }}" class="text-decoration-none">
                <div class="card shadow-sm h-100 hover-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                                    <i class="bi bi-exclamation-triangle text-warning fs-4"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1 text-muted">Total Due Amount</h6>
                                <h3 class="mb-0">৳{{ number_format($totalDueAmount, 0) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <a href="{{ route('upazilasupervisor.phos.index') }}" class="text-decoration-none">
                <div class="card shadow-sm h-100 hover-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                                    <i class="bi bi-person-vcard text-primary fs-4"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1 text-muted">Total PHOs</h6>
                                <h3 class="mb-0">{{ $phosCount }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6">
            <a href="{{ route('upazilasupervisor.customers.index') }}" class="text-decoration-none">
                <div class="card shadow-sm h-100 hover-card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="rounded-circle bg-success bg-opacity-10 p-3">
                                    <i class="bi bi-people-fill text-success fs-4"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1 text-muted">Total Customers</h6>
                                <h3 class="mb-0">{{ $customersCount }}</h3>
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
            <a href="{{ route('upazilasupervisor.hierarchy') }}" class="text-decoration-none">
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
                                <p class="mb-0 text-muted">See the complete organizational structure from your upazila level</p>
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

    <!-- Recent Package Purchases -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="bi bi-box-seam text-primary me-2"></i>Recent Package Sales by PHOs
                    </h5>
                </div>
                <div class="card-body">
                    @if($recentPackagePurchases->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>SL</th>
                                        <th>PHO</th>
                                        <th>Customer</th>
                                        <th>Package</th>
                                        <th>Purchase Date</th>
                                        <th>Total Amount</th>
                                        <th>Paid</th>
                                        <th>Due</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentPackagePurchases as $index => $purchase)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <strong>{{ $purchase->pho->name }}</strong><br>
                                                <small class="text-muted">{{ $purchase->pho->email }}</small>
                                            </td>
                                            <td>
                                                <strong>{{ $purchase->customer->name }}</strong><br>
                                                <small class="text-muted">{{ $purchase->customer->email }}</small>
                                            </td>
                                            <td>
                                                <strong>{{ $purchase->package->name }}</strong><br>
                                                <small class="text-muted">{{ Str::limit($purchase->package->details, 40) }}</small>
                                            </td>
                                            <td>{{ $purchase->purchase_date->format('d M, Y') }}</td>
                                            <td class="fw-bold">৳{{ number_format($purchase->total_price, 2) }}</td>
                                            <td class="text-success">৳{{ number_format($purchase->paid_amount, 2) }}</td>
                                            <td class="text-danger">৳{{ number_format($purchase->due_amount, 2) }}</td>
                                            <td>
                                                @if($purchase->payment_status == 'paid')
                                                    <span class="badge bg-success">Paid</span>
                                                @elseif($purchase->payment_status == 'partial')
                                                    <span class="badge bg-warning">Partial</span>
                                                @else
                                                    <span class="badge bg-danger">Pending</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-box-seam text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-3 mb-0">No package sales yet</p>
                            <p class="text-muted">PHOs under your supervision haven't sold any packages yet</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Location Information -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-geo-alt-fill text-primary me-2"></i>Your Location
                    </h5>
                    <hr>
                    <div class="mb-3">
                        <strong>Division:</strong><br>
                        <span class="fs-5">{{ $upazilaSupervisor->division->name ?? 'N/A' }}</span>
                    </div>
                    <div class="mb-3">
                        <strong>District:</strong><br>
                        <span class="fs-5">{{ $upazilaSupervisor->district->name ?? 'N/A' }}</span>
                    </div>
                    <div class="mb-3">
                        <strong>Upazila:</strong><br>
                        <span class="fs-5">{{ $upazilaSupervisor->upzila->name ?? 'N/A' }}</span>
                    </div>
                    <div class="mb-3">
                        <strong>Role:</strong><br>
                        <span class="badge bg-primary">Upazila Supervisor</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- PHOs List -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-person-vcard text-info me-2"></i>Your PHOs
                    </h5>
                    <hr>
                    @if($phos->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($phos as $pho)
                                <div class="list-group-item px-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">{{ $pho->name }}</h6>
                                            <small class="text-muted">{{ $pho->email }}</small>
                                        </div>
                                        <span class="badge bg-info">{{ $pho->customers->count() }} Customers</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            No PHOs created yet
                        </div>
                    @endif
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

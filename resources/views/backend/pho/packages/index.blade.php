@extends('backend.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Package Management</h2>
        <a href="{{ route('pho.packages.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Purchase Package for Customer
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Available Packages -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">Available Packages</h5>
        </div>
        <div class="card-body">
            <div class="row">
                @forelse($packages as $package)
                    <div class="col-md-4 mb-3">
                        <div class="card h-100 border-info">
                            <div class="card-body">
                                <h5 class="card-title">{{ $package->name }}</h5>
                                <p class="card-text text-muted">{{ Str::limit($package->details, 100) }}</p>
                                <p class="fs-4 text-success fw-bold">৳{{ number_format($package->price, 2) }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center text-muted">No packages available</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Purchase History -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Purchase History</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>SL</th>
                            <th>Customer</th>
                            <th>Package</th>
                            <th>Total Price</th>
                            <th>Paid</th>
                            <th>Due</th>
                            <th>Status</th>
                            <th>Purchase Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($purchases as $index => $purchase)
                            <tr>
                                <td>{{ $purchases->firstItem() + $index }}</td>
                                <td>{{ $purchase->customer->name }}</td>
                                <td>{{ $purchase->package->name }}</td>
                                <td>৳{{ number_format($purchase->total_price, 2) }}</td>
                                <td>৳{{ number_format($purchase->paid_amount, 2) }}</td>
                                <td>৳{{ number_format($purchase->due_amount, 2) }}</td>
                                <td>
                                    @if($purchase->payment_status == 'paid')
                                        <span class="badge bg-success">Paid</span>
                                    @elseif($purchase->payment_status == 'partial')
                                        <span class="badge bg-warning">Partial</span>
                                    @else
                                        <span class="badge bg-danger">Pending</span>
                                    @endif
                                </td>
                                <td>{{ $purchase->purchase_date->format('d M, Y') }}</td>
                                <td>
                                    <a href="{{ route('pho.packages.show', $purchase->id) }}"
                                       class="btn btn-sm btn-outline-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @if($purchase->payment_status != 'paid')
                                        <a href="{{ route('pho.packages.add-payment', $purchase->id) }}"
                                           class="btn btn-sm btn-outline-success">
                                            <i class="bi bi-cash-stack"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">No purchases found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-3">
                {{ $purchases->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

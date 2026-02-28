@extends('backend.layouts.app')

@section('title', 'My Packages')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4">My Healthcare Packages</h2>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Summary Cards -->
                @php
                    $totalPurchases = $purchases->count();
                    $totalSpent = $purchases->sum('total_price');
                    $totalPaid = $purchases->sum('paid_amount');
                    $totalDue = $purchases->sum('due_amount');
                @endphp

                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-2">Total Packages</h6>
                                <h2 class="card-title">{{ $totalPurchases }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-2">Total Value</h6>
                                <h2 class="card-title">৳{{ number_format($totalSpent, 2) }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-2">Amount Paid</h6>
                                <h2 class="card-title">৳{{ number_format($totalPaid, 2) }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <h6 class="card-subtitle mb-2">Amount Due</h6>
                                <h2 class="card-title">৳{{ number_format($totalDue, 2) }}</h2>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Packages List -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Purchase History</h5>

                        @forelse($purchases as $purchase)
                            <div
                                class="card mb-3 border-start border-5 @if ($purchase->payment_status == 'paid') border-success @elseif($purchase->payment_status == 'partial') border-warning @else border-danger @endif">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <h5 class="card-title">{{ $purchase->package->name }}</h5>
                                            <p class="card-text text-muted mb-2">{!! Str::limit(strip_tags($purchase->package->details), 100) !!}</p>
                                            <p class="mb-1">
                                                <small class="text-muted">
                                                    <i class="bi bi-calendar3 me-1"></i>
                                                    Purchased on {{ $purchase->purchase_date->format('d M, Y') }}
                                                </small>
                                            </p>
                                            <p class="mb-0">
                                                <small class="text-muted">
                                                    <i class="bi bi-person-badge me-1"></i>
                                                    Sold by: {{ $purchase->pho->name }}
                                                </small>
                                            </p>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-2">
                                                <small class="text-muted">Total Price:</small>
                                                <p class="mb-0 fw-bold">৳{{ number_format($purchase->total_price, 2) }}</p>
                                            </div>
                                            <div class="mb-2">
                                                <small class="text-muted">Paid:</small>
                                                <p class="mb-0 text-success">৳{{ number_format($purchase->paid_amount, 2) }}
                                                </p>
                                            </div>
                                            <div class="mb-2">
                                                <small class="text-muted">Due:</small>
                                                <p class="mb-0 text-danger">৳{{ number_format($purchase->due_amount, 2) }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-end">
                                            <div class="mb-2">
                                                @if ($purchase->payment_status == 'paid')
                                                    <span class="badge bg-success">Paid</span>
                                                @elseif($purchase->payment_status == 'partial')
                                                    <span class="badge bg-warning">Partial</span>
                                                @else
                                                    <span class="badge bg-danger">Pending</span>
                                                @endif
                                            </div>
                                            <a href="{{ route('customer.packages.show', $purchase->id) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <i class="bi bi-box-seam" style="font-size: 3rem; color: #ccc;"></i>
                                <p class="text-muted mt-3">No packages purchased yet</p>
                                <p class="text-muted">Contact your PHO to purchase healthcare packages</p>
                            </div>
                        @endforelse

                        @if ($purchases->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $purchases->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

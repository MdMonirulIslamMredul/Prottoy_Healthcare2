@extends('backend.layouts.app')

@section('title', 'Package Details')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('customer.packages.index') }}">My Packages</a></li>
                        <li class="breadcrumb-item active">Package Details</li>
                    </ol>
                </nav>

                <h2 class="mb-4">Package Details</h2>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="row">
                    <!-- Package Information -->
                    <div class="col-md-6 mb-4">
                        <div class="card shadow">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Package Information</h5>
                            </div>
                            <div class="card-body">
                                <h4 class="card-title mb-3">{{ $purchase->package->name }}</h4>
                                <div class="mb-3">
                                    <label class="fw-bold">Description:</label>
                                    <p class="text-muted">{!! $purchase->package->details !!}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="fw-bold">Purchase Date:</label>
                                    <p>{{ $purchase->purchase_date->format('d M, Y') }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="fw-bold">Purchased From:</label>
                                    <p>
                                        <i class="bi bi-person-badge me-2"></i>
                                        {{ $purchase->pho->name }}<br>
                                        <small class="text-muted">{{ $purchase->pho->email }}</small>
                                    </p>

                                    <p>
                                        <i class="bi bi-telephone me-2"></i>
                                        {{ $purchase->pho->phone ?? 'N/A' }}
                                    </p>

                                </div>
                                @if ($purchase->notes)
                                    <div class="mb-3">
                                        <label class="fw-bold">Notes:</label>
                                        <p class="text-muted">{{ $purchase->notes }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Payment Summary -->
                    <div class="col-md-6 mb-4">
                        <div class="card shadow">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0">Payment Summary</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-4">
                                    <label class="text-muted">Total Package Price</label>
                                    <h3 class="mb-0">৳{{ number_format($purchase->total_price, 2) }}</h3>
                                </div>
                                <div class="mb-4">
                                    <label class="text-muted">Amount Paid</label>
                                    <h3 class="text-success mb-0">৳{{ number_format($purchase->paid_amount, 2) }}</h3>
                                </div>
                                <div class="mb-4">
                                    <label class="text-muted">Amount Due</label>
                                    <h3
                                        class="@if ($purchase->due_amount > 0) text-danger @else text-success @endif mb-0">
                                        ৳{{ number_format($purchase->due_amount, 2) }}
                                    </h3>
                                </div>
                                <div class="mb-0">
                                    <label class="text-muted">Payment Status</label>
                                    <div>
                                        @if ($purchase->payment_status == 'paid')
                                            <span class="badge bg-success fs-6">Fully Paid</span>
                                        @elseif($purchase->payment_status == 'partial')
                                            <span class="badge bg-warning fs-6">Partially Paid</span>
                                        @else
                                            <span class="badge bg-danger fs-6">Payment Pending</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment History -->
                <div class="card shadow">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Payment History</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Payment Date</th>
                                        <th>Amount</th>
                                        <th>Payment Method</th>
                                        <th>Received By</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($purchase->payments as $index => $payment)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $payment->payment_date->format('d M, Y') }}</td>
                                            <td class="fw-bold text-success">৳{{ number_format($payment->amount, 2) }}</td>
                                            <td>{{ $payment->payment_method ?? 'N/A' }}</td>
                                            <td>{{ $payment->receivedBy->name }}</td>
                                            <td>{{ $payment->notes ?? '-' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">
                                                No payment records available
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                @if ($purchase->payments->count() > 0)
                                    <tfoot class="table-light">
                                        <tr>
                                            <th colspan="2" class="text-end">Total Paid:</th>
                                            <th colspan="4" class="text-success">
                                                ৳{{ number_format($purchase->paid_amount, 2) }}</th>
                                        </tr>
                                    </tfoot>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('customer.packages.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Back to My Packages
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

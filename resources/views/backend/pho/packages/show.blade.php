@extends('backend.layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="mb-4">
            <h2>Package Purchase Details</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('pho.packages.index') }}">Packages</a></li>
                    <li class="breadcrumb-item active">Details</li>
                </ol>
            </nav>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <!-- Purchase Information -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Purchase Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="fw-bold">Customer:</label>
                            <p>{{ $purchase->customer->name }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold">Package:</label>
                            <p>{{ $purchase->package->name }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold">Package Details:</label>
                            <p class="text-muted">{!! $purchase->package->details !!}</p>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold">Purchase Date:</label>
                            <p>{{ $purchase->purchase_date->format('d M, Y') }}</p>
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
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Payment Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="fw-bold">Total Price:</label>
                            <p class="fs-4">৳{{ number_format($purchase->total_price, 2) }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold">Paid Amount:</label>
                            <p class="fs-4 text-success">৳{{ number_format($purchase->paid_amount, 2) }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold">Due Amount:</label>
                            <p class="fs-4 text-danger">৳{{ number_format($purchase->due_amount, 2) }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold">Payment Status:</label>
                            <p>
                                @if ($purchase->payment_status == 'paid')
                                    <span class="badge bg-success fs-6">Paid</span>
                                @elseif($purchase->payment_status == 'partial')
                                    <span class="badge bg-warning fs-6">Partial</span>
                                @else
                                    <span class="badge bg-danger fs-6">Pending</span>
                                @endif
                            </p>
                        </div>

                        @if ($purchase->payment_status != 'paid')
                            <div class="mt-4">
                                <a href="{{ route('pho.packages.add-payment', $purchase->id) }}"
                                    class="btn btn-success w-100">
                                    <i class="bi bi-cash-stack me-2"></i>Add Payment
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment History -->
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Payment History</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>SL</th>
                                <th>Date</th>
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
                                    <td>৳{{ number_format($payment->amount, 2) }}</td>
                                    <td>{{ $payment->payment_method ?? 'N/A' }}</td>
                                    <td>{{ $payment->receivedBy->name }}</td>
                                    <td>{{ $payment->notes ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">No payments recorded yet</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('pho.packages.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
@endsection

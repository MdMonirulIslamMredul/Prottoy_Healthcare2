@extends('backend.layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Purchase History — {{ $customer->name }}</h2>
            <a href="{{ route('pho.customers.index') }}" class="btn btn-secondary">Back to Customers</a>
        </div>

        <div class="row mb-3">
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 class="text-muted">Total Purchases</h6>
                        <p class="fs-4">{{ $totalPurchases ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 class="text-muted">Paid</h6>
                        <p class="fs-4 text-success">{{ $statusCounts['paid'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 class="text-muted">Partial</h6>
                        <p class="fs-4 text-warning">{{ $statusCounts['partial'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 class="text-muted">Pending</h6>
                        <p class="fs-4 text-danger">{{ $statusCounts['pending'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 class="text-muted">Total Spent</h6>
                        <p class="fs-4">৳{{ number_format($totalSpent ?? 0, 2) }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 class="text-muted">Total Paid</h6>
                        <p class="fs-4 text-success">৳{{ number_format($totalPaid ?? 0, 2) }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6 class="text-muted">Total Due</h6>
                        <p class="fs-4 text-danger">৳{{ number_format($totalDue ?? 0, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Purchases</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>SL</th>
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
                                    <td>{{ $purchase->package->name ?? 'N/A' }}</td>
                                    <td>৳{{ number_format($purchase->total_price, 2) }}</td>
                                    <td>৳{{ number_format($purchase->paid_amount, 2) }}</td>
                                    <td>৳{{ number_format($purchase->due_amount, 2) }}</td>
                                    <td>
                                        @if ($purchase->payment_status == 'paid')
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
                                        @if ($purchase->payment_status != 'paid')
                                            <a href="{{ route('pho.packages.add-payment', $purchase->id) }}"
                                                class="btn btn-sm btn-outline-success">
                                                <i class="bi bi-cash-stack"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                <tr class="table-secondary">
                                    <td colspan="8">
                                        <strong>Payments:</strong>
                                        @if ($purchase->payments->count() > 0)
                                            <ul class="mb-0">
                                                @foreach ($purchase->payments as $payment)
                                                    <li>৳{{ number_format($payment->amount, 2) }} —
                                                        {{ $payment->payment_date->format('d M, Y') }}
                                                        ({{ $payment->payment_method ?? '---' }})</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <span class="text-muted">No payments recorded.</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">No purchases found for this
                                        customer</td>
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

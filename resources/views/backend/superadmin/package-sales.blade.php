@extends('backend.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h2>Package Sales Overview</h2>
            <p class="text-muted">View all package sales across the entire system</p>
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
        <div class="col-lg-3 col-md-6">
            <div class="card shadow-sm h-100 bg-primary bg-opacity-10 border-primary">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                                <i class="bi bi-box-seam text-primary fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1 text-muted">Total Packages Sold</h6>
                            <h3 class="mb-0 text-primary">{{ $totalPackagesSold }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card shadow-sm h-100 bg-info bg-opacity-10 border-info">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-info bg-opacity-10 p-3">
                                <i class="bi bi-currency-exchange text-info fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1 text-muted">Total Sales Amount</h6>
                            <h3 class="mb-0 text-info">৳{{ number_format($totalSalesAmount, 0) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card shadow-sm h-100 bg-success bg-opacity-10 border-success">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-success bg-opacity-10 p-3">
                                <i class="bi bi-check-circle text-success fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1 text-muted">Total Paid Amount</h6>
                            <h3 class="mb-0 text-success">৳{{ number_format($totalPaidAmount, 0) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card shadow-sm h-100 bg-warning bg-opacity-10 border-warning">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                                <i class="bi bi-exclamation-triangle text-warning fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1 text-muted">Total Due Amount</h6>
                            <h3 class="mb-0 text-warning">৳{{ number_format($totalDueAmount, 0) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('superadmin.package-sales') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="pho_id" class="form-label">Filter by PHO</label>
                    <select name="pho_id" id="pho_id" class="form-select">
                        <option value="">All PHOs</option>
                        @foreach($phos as $pho)
                            <option value="{{ $pho->id }}" {{ request('pho_id') == $pho->id ? 'selected' : '' }}>
                                {{ $pho->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="package_id" class="form-label">Filter by Package</label>
                    <select name="package_id" id="package_id" class="form-select">
                        <option value="">All Packages</option>
                        @foreach($packages as $package)
                            <option value="{{ $package->id }}" {{ request('package_id') == $package->id ? 'selected' : '' }}>
                                {{ $package->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="payment_status" class="form-label">Payment Status</label>
                    <select name="payment_status" id="payment_status" class="form-select">
                        <option value="">All Status</option>
                        <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="partial" {{ request('payment_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                        <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                    <a href="{{ route('superadmin.package-sales') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Clear
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Package Sales Table -->
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="bi bi-box-seam text-primary me-2"></i>Package Sales Details
            </h5>
        </div>
        <div class="card-body">
            @if($packagePurchases->count() > 0)
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
                                <th>Payments</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($packagePurchases as $index => $purchase)
                                <tr>
                                    <td>{{ $packagePurchases->firstItem() + $index }}</td>
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
                                        <small class="text-muted">{{ Str::limit($purchase->package->details, 50) }}</small>
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
                                    <td>
                                        <button type="button"
                                                class="btn btn-sm btn-outline-info"
                                                data-bs-toggle="modal"
                                                data-bs-target="#paymentsModal{{ $purchase->id }}">
                                            <i class="bi bi-cash-stack"></i> View ({{ $purchase->payments->count() }})
                                        </button>

                                        <!-- Payment Details Modal -->
                                        <div class="modal fade" id="paymentsModal{{ $purchase->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Payment History - {{ $purchase->package->name }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        @if($purchase->payments->count() > 0)
                                                            <table class="table table-sm">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Date</th>
                                                                        <th>Amount</th>
                                                                        <th>Method</th>
                                                                        <th>Received By</th>
                                                                        <th>Notes</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($purchase->payments as $idx => $payment)
                                                                        <tr>
                                                                            <td>{{ $idx + 1 }}</td>
                                                                            <td>{{ $payment->payment_date->format('d M, Y') }}</td>
                                                                            <td class="text-success fw-bold">৳{{ number_format($payment->amount, 2) }}</td>
                                                                            <td>{{ $payment->payment_method ?? 'N/A' }}</td>
                                                                            <td>{{ $payment->receivedBy->name }}</td>
                                                                            <td>{{ $payment->notes ?? '-' }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                                <tfoot class="table-light">
                                                                    <tr>
                                                                        <th colspan="2">Total Paid:</th>
                                                                        <th colspan="4" class="text-success">৳{{ number_format($purchase->paid_amount, 2) }}</th>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        @else
                                                            <p class="text-muted text-center">No payments recorded yet</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-3">
                    {{ $packagePurchases->withQueryString()->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-box-seam text-muted" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-3 mb-0">No package sales found</p>
                    <p class="text-muted">Try adjusting your filters</p>
                </div>
            @endif
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('superadmin.dashboard') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Dashboard
        </a>
    </div>
</div>
@endsection

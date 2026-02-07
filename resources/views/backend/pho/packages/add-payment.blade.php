@extends('backend.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <h2>Add Payment</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('pho.packages.index') }}">Packages</a></li>
                <li class="breadcrumb-item"><a href="{{ route('pho.packages.show', $purchase->id) }}">Details</a></li>
                <li class="breadcrumb-item active">Add Payment</li>
            </ol>
        </nav>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Payment Form -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Payment Details</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('pho.packages.store-payment', $purchase->id) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="amount" class="form-label">Payment Amount (৳) <span class="text-danger">*</span></label>
                            <input type="number"
                                   class="form-control @error('amount') is-invalid @enderror"
                                   id="amount"
                                   name="amount"
                                   step="0.01"
                                   min="0.01"
                                   max="{{ $purchase->due_amount }}"
                                   value="{{ old('amount') }}"
                                   required>
                            <small class="text-muted">Maximum: ৳{{ number_format($purchase->due_amount, 2) }}</small>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="payment_date" class="form-label">Payment Date <span class="text-danger">*</span></label>
                            <input type="date"
                                   class="form-control @error('payment_date') is-invalid @enderror"
                                   id="payment_date"
                                   name="payment_date"
                                   value="{{ old('payment_date', date('Y-m-d')) }}"
                                   required>
                            @error('payment_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Payment Method</label>
                            <select class="form-select" id="payment_method" name="payment_method">
                                <option value="">-- Select Method --</option>
                                <option value="Cash">Cash</option>
                                <option value="bKash">bKash</option>
                                <option value="Nagad">Nagad</option>
                                <option value="Rocket">Rocket</option>
                                <option value="Bank Transfer">Bank Transfer</option>
                                <option value="Card">Card</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('pho.packages.show', $purchase->id) }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-success">Add Payment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Purchase Summary -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Purchase Summary</h5>
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
                        <label class="fw-bold">Total Price:</label>
                        <p class="fs-4">৳{{ number_format($purchase->total_price, 2) }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Already Paid:</label>
                        <p class="fs-4 text-success">৳{{ number_format($purchase->paid_amount, 2) }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Remaining Due:</label>
                        <p class="fs-4 text-danger">৳{{ number_format($purchase->due_amount, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

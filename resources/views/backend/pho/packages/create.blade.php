@extends('backend.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <h2>Purchase Package for Customer</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('pho.packages.index') }}">Packages</a></li>
                <li class="breadcrumb-item active">Purchase</li>
            </ol>
        </nav>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('pho.packages.store') }}" method="POST" id="purchaseForm">
                @csrf

                <div class="mb-3">
                    <label for="customer_id" class="form-label">Select Customer <span class="text-danger">*</span></label>
                    <select class="form-select @error('customer_id') is-invalid @enderror"
                            id="customer_id"
                            name="customer_id"
                            required>
                        <option value="">-- Select Customer --</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }} ({{ $customer->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('customer_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="package_id" class="form-label">Select Package <span class="text-danger">*</span></label>
                    <select class="form-select @error('package_id') is-invalid @enderror"
                            id="package_id"
                            name="package_id"
                            required>
                        <option value="">-- Select Package --</option>
                        @foreach($packages as $package)
                            <option value="{{ $package->id }}"
                                    data-price="{{ $package->price }}"
                                    {{ old('package_id') == $package->id ? 'selected' : '' }}>
                                {{ $package->name }} - ৳{{ number_format($package->price, 2) }}
                            </option>
                        @endforeach
                    </select>
                    @error('package_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Package Price:</label>
                    <p class="fs-4 text-success fw-bold" id="packagePrice">৳0.00</p>
                </div>

                <div class="mb-3">
                    <label for="purchase_date" class="form-label">Purchase Date <span class="text-danger">*</span></label>
                    <input type="date"
                           class="form-control @error('purchase_date') is-invalid @enderror"
                           id="purchase_date"
                           name="purchase_date"
                           value="{{ old('purchase_date', date('Y-m-d')) }}"
                           required>
                    @error('purchase_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="paid_amount" class="form-label">Initial Payment Amount (৳) <span class="text-danger">*</span></label>
                    <input type="number"
                           class="form-control @error('paid_amount') is-invalid @enderror"
                           id="paid_amount"
                           name="paid_amount"
                           step="0.01"
                           min="0"
                           value="{{ old('paid_amount', 0) }}"
                           required>
                    <small class="text-muted">Enter 0 for no initial payment (full payment later)</small>
                    @error('paid_amount')
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
                    <a href="{{ route('pho.packages.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Purchase Package</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('package_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const price = selectedOption.getAttribute('data-price');
    document.getElementById('packagePrice').textContent = '৳' + parseFloat(price || 0).toFixed(2);
    document.getElementById('paid_amount').setAttribute('max', price || 0);
});
</script>
@endsection

@extends('backend.layouts.app')

@section('title', 'Add New Customer')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Add New Customer</h2>
            <a href="{{ route('upazilasupervisor.customers.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to List
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('upazilasupervisor.customers.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    id="phone" name="phone" value="{{ old('phone') }}" required
                                    pattern="^01[3-9][0-9]{8}$" inputmode="tel" placeholder="e.g. 01712345678">
                                <div class="form-text text-muted">Accepts local 01XXXXXXXXX format only.</div>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3"
                                    placeholder="Enter full address">{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pho_id" class="form-label">Select PHO <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('pho_id') is-invalid @enderror" id="pho_id"
                                    name="pho_id" required>
                                    <option value="">-- Select PHO --</option>
                                    @foreach ($phos as $pho)
                                        <option value="{{ $pho->id }}" data-upzila-id="{{ $pho->upzila_id }}"
                                            {{ old('pho_id') == $pho->id ? 'selected' : '' }}>
                                            {{ $pho->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('pho_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="union_id" class="form-label">Union <span
                                        class="text-muted">(Optional)</span></label>
                                <select class="form-select @error('union_id') is-invalid @enderror" id="union_id"
                                    name="union_id">
                                    <option value="">Select Union (Optional)</option>
                                    @if ($upazilaSupervisor->upzila)
                                        @foreach ($upazilaSupervisor->upzila->unions as $union)
                                            <option value="{{ $union->id }}"
                                                {{ old('union_id') == $union->id ? 'selected' : '' }}>
                                                {{ $union->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('union_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Location (Inherited from Upazila Supervisor)</label>
                                <input type="text" class="form-control"
                                    value="{{ $upazilaSupervisor->upzila->name ?? 'N/A' }}, {{ $upazilaSupervisor->district->name ?? 'N/A' }}, {{ $upazilaSupervisor->division->name ?? 'N/A' }}"
                                    readonly>
                                <small class="text-muted">Customer will be automatically assigned to your upazila</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password <span
                                        class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" required>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('upazilasupervisor.customers.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Create Customer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const phoneInput = document.getElementById('phone');
            const phoneRegex = /^01[3-9][0-9]{8}$/;
            if (form && phoneInput) {
                form.addEventListener('submit', function(e) {
                    const val = phoneInput.value.trim();
                    if (val && !phoneRegex.test(val)) {
                        e.preventDefault();
                        phoneInput.classList.add('is-invalid');
                        let fb = phoneInput.parentElement.querySelector('.invalid-feedback');
                        if (!fb) {
                            fb = document.createElement('div');
                            fb.className = 'invalid-feedback';
                            phoneInput.parentElement.appendChild(fb);
                        }
                        fb.textContent =
                            'Please enter a valid Bangladeshi phone number in 01XXXXXXXXX format (e.g. 01712345678).';
                        phoneInput.focus();
                    }
                });
                phoneInput.addEventListener('input', function() {
                    if (phoneInput.classList.contains('is-invalid')) phoneInput.classList.remove(
                        'is-invalid');
                });
            }
        });
    </script>
@endpush

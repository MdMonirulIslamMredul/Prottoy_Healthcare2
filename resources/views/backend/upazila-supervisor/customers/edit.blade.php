@extends('backend.layouts.app')

@section('title', 'Edit Customer')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Edit Customer</h2>
            <a href="{{ route('upazilasupervisor.customers.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to List
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('upazilasupervisor.customers.update', $customer->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $customer->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email', $customer->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    id="phone" name="phone" value="{{ old('phone', $customer->phone) }}" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3"
                                    placeholder="Enter full address">{{ old('address', $customer->address) }}</textarea>
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
                                        <option value="{{ $pho->id }}"
                                            {{ old('pho_id', $customer->pho_id) == $pho->id ? 'selected' : '' }}>
                                            {{ $pho->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('pho_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Location (Cannot be changed)</label>
                                <input type="text" class="form-control"
                                    value="{{ $customer->union->name ?? 'N/A' }},{{ $customer->upzila->name ?? 'N/A' }}, {{ $customer->district->name ?? 'N/A' }}, {{ $customer->division->name ?? 'N/A' }}"
                                    readonly>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i>
                                Leave password fields blank if you don't want to change the password.
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">New Password (Optional)</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('upazilasupervisor.customers.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-save"></i> Update Customer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@extends('backend.layouts.app')

@section('title', 'Edit PHO')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Edit PHO</h2>
            <a href="{{ route('upazilasupervisor.phos.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to List
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('upazilasupervisor.phos.update', $pho->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $pho->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email', $pho->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    id="phone" name="phone" value="{{ old('phone', $pho->phone) }}"
                                    pattern="^01[3-9][0-9]{8}$" inputmode="tel" placeholder="e.g. 01712345678">
                                <div class="form-text text-muted">Accepts local 01XXXXXXXXX format only.</div>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Location (Cannot be changed)</label>
                                <input type="text" class="form-control"
                                    value="{{ $pho->upzila->name ?? 'N/A' }}, {{ $pho->district->name ?? 'N/A' }}, {{ $pho->division->name ?? 'N/A' }}"
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
                        <a href="{{ route('upazilasupervisor.phos.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-save"></i> Update PHO
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

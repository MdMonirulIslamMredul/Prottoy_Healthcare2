@extends('backend.layouts.app')

@section('page-title', 'Edit Profile')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Back Button -->
            <div class="mb-3">
                <a href="{{ route('profile.show') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i>Back to Profile
                </a>
            </div>

            <!-- Edit Profile Card -->
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Profile</h5>
                </div>
                <div class="card-body">
                    <!-- Profile Avatar -->
                    <div class="text-center mb-4">
                        <div class="profile-avatar-large mx-auto mb-3">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <h5 class="mb-1">{{ $user->name }}</h5>
                        <span class="badge bg-{{
                            $user->role === 'super_admin' ? 'danger' :
                            ($user->role === 'divisional_chief' ? 'primary' :
                            ($user->role === 'district_manager' ? 'success' :
                            ($user->role === 'upazila_supervisor' ? 'info' :
                            ($user->role === 'pho' ? 'warning' : 'secondary'))))
                        }}">
                            {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                        </span>
                    </div>

                    <hr>

                    <!-- Edit Form -->
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Personal Information Section -->
                        <div class="mb-4">
                            <h6 class="text-primary mb-3"><i class="bi bi-person me-2"></i>Personal Information</h6>

                            <!-- Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label">
                                    Full Name <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    id="name"
                                    name="name"
                                    value="{{ old('name', $user->name) }}"
                                    required
                                >
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    Email Address <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    id="email"
                                    name="email"
                                    value="{{ old('email', $user->email) }}"
                                    required
                                >
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div class="mb-3">
                                <label for="phone" class="form-label">
                                    Phone Number
                                </label>
                                <input
                                    type="text"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    id="phone"
                                    name="phone"
                                    value="{{ old('phone', $user->phone) }}"
                                    placeholder="Enter your phone number"
                                >
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div class="mb-3">
                                <label for="address" class="form-label">
                                    Address
                                </label>
                                <textarea
                                    class="form-control @error('address') is-invalid @enderror"
                                    id="address"
                                    name="address"
                                    rows="3"
                                    placeholder="Enter your full address"
                                >{{ old('address', $user->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Provide your complete address including street, city, and postal code</small>
                            </div>
                        </div>

                        <!-- Location Information (Read-only) -->
                        @if($user->division || $user->district || $user->upzila)
                        <div class="mb-4">
                            <h6 class="text-primary mb-3"><i class="bi bi-geo-alt me-2"></i>Location Information</h6>
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i>
                                <small>Location information (Division, District, Upazila) cannot be changed. Contact your administrator if changes are needed.</small>
                            </div>

                            <div class="row">
                                @if($user->division)
                                <div class="col-md-4">
                                    <div class="info-box">
                                        <label class="text-muted mb-1">Division</label>
                                        <p class="fw-semibold mb-0">{{ $user->division->name }}</p>
                                    </div>
                                </div>
                                @endif

                                @if($user->district)
                                <div class="col-md-4">
                                    <div class="info-box">
                                        <label class="text-muted mb-1">District</label>
                                        <p class="fw-semibold mb-0">{{ $user->district->name }}</p>
                                    </div>
                                </div>
                                @endif

                                @if($user->upzila)
                                <div class="col-md-4">
                                    <div class="info-box">
                                        <label class="text-muted mb-1">Upazila</label>
                                        <p class="fw-semibold mb-0">{{ $user->upzila->name }}</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif

                        <!-- Password Section -->
                        <div class="mb-4">
                            <h6 class="text-primary mb-3"><i class="bi bi-lock me-2"></i>Change Password (Optional)</h6>
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                <small>Leave password fields blank if you don't want to change your password.</small>
                            </div>

                            <!-- New Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">
                                    New Password
                                </label>
                                <input
                                    type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    id="password"
                                    name="password"
                                    placeholder="Enter new password (minimum 8 characters)"
                                >
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">
                                    Confirm New Password
                                </label>
                                <input
                                    type="password"
                                    class="form-control"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    placeholder="Confirm your new password"
                                >
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('profile.show') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-1"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-1"></i>Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .profile-avatar-large {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 50px;
    }

    .info-box {
        padding: 12px;
        background: #f8f9fa;
        border-radius: 6px;
        border-left: 3px solid #0d6efd;
        margin-bottom: 10px;
    }

    .info-box label {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .card {
        border: none;
        border-radius: 10px;
    }

    .card-header {
        border-radius: 10px 10px 0 0 !important;
        padding: 15px 20px;
    }

    .form-label {
        font-weight: 600;
        color: #495057;
    }

    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }
</style>
@endsection

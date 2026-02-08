@extends('backend.layouts.app')

@section('title', 'Contact Information')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Contact Information</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Website Settings</li>
                        <li class="breadcrumb-item active">Contact Information</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-telephone-fill me-2"></i>Edit Contact Information
                    </h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('superadmin.website.contact-info.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('address') is-invalid @enderror"
                                      id="address"
                                      name="address"
                                      rows="2"
                                      required>{{ old('address', $contactInfo->address ?? '') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       id="phone"
                                       name="phone"
                                       value="{{ old('phone', $contactInfo->phone ?? '') }}"
                                       required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       id="email"
                                       name="email"
                                       value="{{ old('email', $contactInfo->email ?? '') }}"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="working_hours" class="form-label">Working Hours</label>
                            <input type="text"
                                   class="form-control @error('working_hours') is-invalid @enderror"
                                   id="working_hours"
                                   name="working_hours"
                                   value="{{ old('working_hours', $contactInfo->working_hours ?? '') }}"
                                   placeholder="e.g., Saturday - Thursday: 9:00 AM - 5:00 PM">
                            @error('working_hours')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <h5 class="mb-3"><i class="bi bi-share me-2"></i>Social Media Links</h5>

                        <div class="mb-3">
                            <label for="facebook" class="form-label">
                                <i class="bi bi-facebook text-primary me-1"></i>Facebook URL
                            </label>
                            <input type="url"
                                   class="form-control @error('facebook') is-invalid @enderror"
                                   id="facebook"
                                   name="facebook"
                                   value="{{ old('facebook', $contactInfo->facebook ?? '') }}"
                                   placeholder="https://facebook.com/yourpage">
                            @error('facebook')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="twitter" class="form-label">
                                <i class="bi bi-twitter text-info me-1"></i>Twitter URL
                            </label>
                            <input type="url"
                                   class="form-control @error('twitter') is-invalid @enderror"
                                   id="twitter"
                                   name="twitter"
                                   value="{{ old('twitter', $contactInfo->twitter ?? '') }}"
                                   placeholder="https://twitter.com/yourprofile">
                            @error('twitter')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="linkedin" class="form-label">
                                <i class="bi bi-linkedin text-primary me-1"></i>LinkedIn URL
                            </label>
                            <input type="url"
                                   class="form-control @error('linkedin') is-invalid @enderror"
                                   id="linkedin"
                                   name="linkedin"
                                   value="{{ old('linkedin', $contactInfo->linkedin ?? '') }}"
                                   placeholder="https://linkedin.com/company/yourcompany">
                            @error('linkedin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="instagram" class="form-label">
                                <i class="bi bi-instagram text-danger me-1"></i>Instagram URL
                            </label>
                            <input type="url"
                                   class="form-control @error('instagram') is-invalid @enderror"
                                   id="instagram"
                                   name="instagram"
                                   value="{{ old('instagram', $contactInfo->instagram ?? '') }}"
                                   placeholder="https://instagram.com/yourprofile">
                            @error('instagram')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input"
                                       type="checkbox"
                                       id="is_active"
                                       name="is_active"
                                       value="1"
                                       {{ old('is_active', $contactInfo->is_active ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active (Display in frontend)
                                </label>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-1"></i>Update Contact Information
                            </button>
                            <a href="{{ route('superadmin.dashboard') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-1"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-info-circle me-2"></i>Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h6 class="alert-heading">About Contact Information</h6>
                        <p class="mb-2">This information will be displayed in the website footer and contact pages.</p>
                        <ul class="mb-0 ps-3">
                            <li>Address, Phone, and Email are required</li>
                            <li>Social media links are optional</li>
                            <li>Working hours help visitors know when to contact</li>
                            <li>Only active contact info will be displayed</li>
                        </ul>
                    </div>

                    @if($contactInfo)
                        <div class="alert alert-success">
                            <h6 class="alert-heading"><i class="bi bi-check-circle me-1"></i>Current Status</h6>
                            <p class="mb-0">
                                <strong>Status:</strong>
                                @if($contactInfo->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </p>
                            <p class="mb-0 mt-2">
                                <small class="text-muted">Last updated: {{ $contactInfo->updated_at->diffForHumans() }}</small>
                            </p>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <h6 class="alert-heading"><i class="bi bi-exclamation-triangle me-1"></i>No Contact Info</h6>
                            <p class="mb-0">No contact information has been set up yet. Please fill out the form to add contact details.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('backend.layouts.app')

@section('title', 'Add Testimonial')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <h2>Add New Testimonial</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('superadmin.testimonials.index') }}">Testimonials</a></li>
                <li class="breadcrumb-item active">Add New</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('superadmin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="customer_name" class="form-label">Customer Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('customer_name') is-invalid @enderror"
                                   id="customer_name" name="customer_name" value="{{ old('customer_name') }}"
                                   placeholder="Enter customer name" required>
                            @error('customer_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="customer_designation" class="form-label">Designation/Title</label>
                            <input type="text" class="form-control @error('customer_designation') is-invalid @enderror"
                                   id="customer_designation" name="customer_designation" value="{{ old('customer_designation') }}"
                                   placeholder="e.g., CEO, Business Owner, Customer">
                            @error('customer_designation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="customer_photo" class="form-label">Customer Photo</label>
                            <input type="file" class="form-control @error('customer_photo') is-invalid @enderror"
                                   id="customer_photo" name="customer_photo" accept="image/*">
                            @error('customer_photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Optional. Recommended size: 200x200px. Max 2MB</small>
                        </div>

                        <div class="mb-3">
                            <label for="testimonial" class="form-label">Testimonial Text <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('testimonial') is-invalid @enderror"
                                      id="testimonial" name="testimonial" rows="5"
                                      placeholder="Enter the customer's testimonial..." required>{{ old('testimonial') }}</textarea>
                            @error('testimonial')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Keep it concise and impactful (100-200 words recommended)</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="rating" class="form-label">Rating <span class="text-danger">*</span></label>
                                <select class="form-select @error('rating') is-invalid @enderror" id="rating" name="rating" required>
                                    <option value="">Select rating</option>
                                    <option value="5" {{ old('rating') == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5 stars)</option>
                                    <option value="4" {{ old('rating') == 4 ? 'selected' : '' }}>⭐⭐⭐⭐ (4 stars)</option>
                                    <option value="3" {{ old('rating') == 3 ? 'selected' : '' }}>⭐⭐⭐ (3 stars)</option>
                                    <option value="2" {{ old('rating') == 2 ? 'selected' : '' }}>⭐⭐ (2 stars)</option>
                                    <option value="1" {{ old('rating') == 1 ? 'selected' : '' }}>⭐ (1 star)</option>
                                </select>
                                @error('rating')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label d-block">Status</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" id="is_active"
                                           name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Active (Visible on website)
                                    </label>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('superadmin.testimonials.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Create Testimonial
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Testimonial Guidelines</h5>
                </div>
                <div class="card-body">
                    <h6>Photo Guidelines:</h6>
                    <ul class="small">
                        <li>Square format recommended (200x200px)</li>
                        <li>Clear, professional headshot</li>
                        <li>Good lighting and focus</li>
                        <li>Neutral or relevant background</li>
                        <li>If no photo: Initial will be displayed</li>
                    </ul>

                    <hr>

                    <h6>Content Best Practices:</h6>
                    <ul class="small">
                        <li>Use authentic, genuine testimonials</li>
                        <li>Focus on specific benefits</li>
                        <li>Keep it concise (100-200 words)</li>
                        <li>Include measurable results if possible</li>
                        <li>Add designation for credibility</li>
                    </ul>

                    <hr>

                    <h6>Rating System:</h6>
                    <ul class="small">
                        <li>5 stars: Exceptional experience</li>
                        <li>4 stars: Very satisfied</li>
                        <li>3 stars: Satisfied</li>
                        <li>2 stars: Below expectations</li>
                        <li>1 star: Poor experience</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

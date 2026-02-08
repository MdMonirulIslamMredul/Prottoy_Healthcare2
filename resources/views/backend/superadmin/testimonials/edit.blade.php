@extends('backend.layouts.app')

@section('title', 'Edit Testimonial')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <h2>Edit Testimonial</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('superadmin.testimonials.index') }}">Testimonials</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('superadmin.testimonials.update', $testimonial) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="customer_name" class="form-label">Customer Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('customer_name') is-invalid @enderror"
                                   id="customer_name" name="customer_name" value="{{ old('customer_name', $testimonial->customer_name) }}"
                                   placeholder="Enter customer name" required>
                            @error('customer_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="customer_designation" class="form-label">Designation/Title</label>
                            <input type="text" class="form-control @error('customer_designation') is-invalid @enderror"
                                   id="customer_designation" name="customer_designation" value="{{ old('customer_designation', $testimonial->customer_designation) }}"
                                   placeholder="e.g., CEO, Business Owner, Customer">
                            @error('customer_designation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="customer_photo" class="form-label">Customer Photo</label>

                            @if($testimonial->customer_photo)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $testimonial->customer_photo) }}"
                                         alt="Current photo"
                                         class="img-thumbnail rounded-circle"
                                         style="width: 100px; height: 100px; object-fit: cover;">
                                    <p class="text-muted small mb-0 mt-1">Current photo</p>
                                </div>
                            @endif

                            <input type="file" class="form-control @error('customer_photo') is-invalid @enderror"
                                   id="customer_photo" name="customer_photo" accept="image/*">
                            @error('customer_photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Leave empty to keep current photo. Recommended size: 200x200px. Max 2MB
                            </small>
                        </div>

                        <div class="mb-3">
                            <label for="testimonial" class="form-label">Testimonial Text <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('testimonial') is-invalid @enderror"
                                      id="testimonial" name="testimonial" rows="5"
                                      placeholder="Enter the customer's testimonial..." required>{{ old('testimonial', $testimonial->testimonial) }}</textarea>
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
                                    <option value="5" {{ old('rating', $testimonial->rating) == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5 stars)</option>
                                    <option value="4" {{ old('rating', $testimonial->rating) == 4 ? 'selected' : '' }}>⭐⭐⭐⭐ (4 stars)</option>
                                    <option value="3" {{ old('rating', $testimonial->rating) == 3 ? 'selected' : '' }}>⭐⭐⭐ (3 stars)</option>
                                    <option value="2" {{ old('rating', $testimonial->rating) == 2 ? 'selected' : '' }}>⭐⭐ (2 stars)</option>
                                    <option value="1" {{ old('rating', $testimonial->rating) == 1 ? 'selected' : '' }}>⭐ (1 star)</option>
                                </select>
                                @error('rating')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label d-block">Status</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" id="is_active"
                                           name="is_active" value="1" {{ old('is_active', $testimonial->is_active) ? 'checked' : '' }}>
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
                                <i class="bi bi-check-circle me-2"></i>Update Testimonial
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

                    <h6>Current Rating:</h6>
                    <div class="text-center mt-2">
                        <div style="font-size: 2rem;">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $testimonial->rating)
                                    <i class="bi bi-star-fill text-warning"></i>
                                @else
                                    <i class="bi bi-star text-warning"></i>
                                @endif
                            @endfor
                        </div>
                        <p class="mb-0">{{ $testimonial->rating }} out of 5</p>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mt-3">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0"><i class="bi bi-trash me-2"></i>Danger Zone</h5>
                </div>
                <div class="card-body">
                    <p class="small mb-2">Permanently delete this testimonial. This action cannot be undone.</p>
                    <form action="{{ route('superadmin.testimonials.destroy', $testimonial) }}" method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this testimonial?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="bi bi-trash me-1"></i>Delete Testimonial
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

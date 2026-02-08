@extends('backend.layouts.app')

@section('title', 'Add Service')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <h2>Add New Service</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('superadmin.website.services.index') }}">Services</a></li>
                <li class="breadcrumb-item active">Add New</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('superadmin.website.services.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label">Service Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   id="title" name="title" value="{{ old('title') }}"
                                   placeholder="Enter service title" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="4"
                                      placeholder="Enter service description" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="icon" class="form-label">Bootstrap Icon <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('icon') is-invalid @enderror"
                                   id="icon" name="icon" value="{{ old('icon') }}"
                                   placeholder="e.g., headset, hospital, file-check" required>
                            @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Enter Bootstrap Icons name (without 'bi-' prefix).
                                <a href="https://icons.getbootstrap.com/" target="_blank">Browse icons</a>
                            </small>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Service Image (Optional)</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                                   id="image" name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Recommended size: 500x400px. Max 2MB</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="order" class="form-label">Display Order</label>
                                <input type="number" class="form-control @error('order') is-invalid @enderror"
                                       id="order" name="order" value="{{ old('order', 0) }}" min="0">
                                @error('order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Lower numbers appear first</small>
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
                            <a href="{{ route('superadmin.website.services.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Create Service
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Service Guidelines</h5>
                </div>
                <div class="card-body">
                    <h6>Content Tips:</h6>
                    <ul class="small">
                        <li>Use clear, concise titles (3-5 words)</li>
                        <li>Keep descriptions brief but informative</li>
                        <li>Focus on benefits to customers</li>
                        <li>Use action-oriented language</li>
                    </ul>

                    <hr>

                    <h6>Icon Selection:</h6>
                    <ul class="small">
                        <li>Choose icons that match service type</li>
                        <li>Use consistent icon style</li>
                        <li>Popular: headset, hospital, shield-check</li>
                        <li>Visit <a href="https://icons.getbootstrap.com/" target="_blank">Bootstrap Icons</a></li>
                    </ul>

                    <hr>

                    <h6>Image Guidelines:</h6>
                    <ul class="small">
                        <li>Optional but recommended</li>
                        <li>Use high-quality, relevant images</li>
                        <li>Maintain consistent aspect ratio</li>
                        <li>Recommended: 500x400px</li>
                    </ul>

                    <hr>

                    <h6>Icon Preview:</h6>
                    <div class="d-flex flex-wrap gap-2 mt-2">
                        <i class="bi bi-headset fs-4"></i>
                        <i class="bi bi-hospital fs-4"></i>
                        <i class="bi bi-file-check fs-4"></i>
                        <i class="bi bi-shield-check fs-4"></i>
                        <i class="bi bi-clock fs-4"></i>
                        <i class="bi bi-people fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

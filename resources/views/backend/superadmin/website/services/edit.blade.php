@extends('backend.layouts.app')

@section('title', 'Edit Service')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <h2>Edit Service</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('superadmin.website.services.index') }}">Services</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('superadmin.website.services.update', $service) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="title" class="form-label">Service Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   id="title" name="title" value="{{ old('title', $service->title) }}"
                                   placeholder="Enter service title" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="4"
                                      placeholder="Enter service description" required>{{ old('description', $service->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="icon" class="form-label">Bootstrap Icon <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-{{ old('icon', $service->icon) }}"></i>
                                </span>
                                <input type="text" class="form-control @error('icon') is-invalid @enderror"
                                       id="icon" name="icon" value="{{ old('icon', $service->icon) }}"
                                       placeholder="e.g., headset, hospital, file-check" required>
                                @error('icon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="form-text text-muted">
                                Enter Bootstrap Icons name (without 'bi-' prefix).
                                <a href="https://icons.getbootstrap.com/" target="_blank">Browse icons</a>
                            </small>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Service Image (Optional)</label>

                            @if($service->image)
                                <div class="mb-2">
                                    <img src="{{ $service->image }}" alt="Current service image"
                                         class="img-thumbnail" style="max-height: 200px;">
                                    <p class="text-muted small mb-0 mt-1">Current image</p>
                                </div>
                            @endif

                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                                   id="image" name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Leave empty to keep current image. Recommended size: 500x400px. Max 2MB
                            </small>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="order" class="form-label">Display Order</label>
                                <input type="number" class="form-control @error('order') is-invalid @enderror"
                                       id="order" name="order" value="{{ old('order', $service->order) }}" min="0">
                                @error('order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Lower numbers appear first</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label d-block">Status</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" id="is_active"
                                           name="is_active" value="1" {{ old('is_active', $service->is_active) ? 'checked' : '' }}>
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
                                <i class="bi bi-check-circle me-2"></i>Update Service
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

                    <h6>Current Icon Preview:</h6>
                    <div class="text-center mt-3">
                        <i class="bi bi-{{ $service->icon }}" style="font-size: 3rem; color: #667eea;"></i>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mt-3">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0"><i class="bi bi-trash me-2"></i>Danger Zone</h5>
                </div>
                <div class="card-body">
                    <p class="small mb-2">Permanently delete this service. This action cannot be undone.</p>
                    <form action="{{ route('superadmin.website.services.destroy', $service) }}" method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this service?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="bi bi-trash me-1"></i>Delete Service
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

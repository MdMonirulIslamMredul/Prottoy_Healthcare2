@extends('backend.layouts.app')

@section('title', 'Add Gallery Image')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="bi bi-image me-2"></i>Add Gallery Image</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('superadmin.website.gallery.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   id="title" name="title" value="{{ old('title') }}" required
                                   placeholder="e.g., Annual Healthcare Summit 2024">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                            <select class="form-select @error('category') is-invalid @enderror"
                                    id="category" name="category" required>
                                <option value="">Select Category</option>
                                <option value="events" {{ old('category') == 'events' ? 'selected' : '' }}>Events</option>
                                <option value="facilities" {{ old('category') == 'facilities' ? 'selected' : '' }}>Facilities</option>
                                <option value="community" {{ old('category') == 'community' ? 'selected' : '' }}>Community</option>
                                <option value="awards" {{ old('category') == 'awards' ? 'selected' : '' }}>Awards</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            <div class="form-text">Optional: Brief description of the image</div>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Image <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                                   id="image" name="image" accept="image/jpeg,image/png,image/jpg" required>
                            <div class="form-text">Recommended: 1200x800px landscape, Max 2MB, JPG/PNG</div>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="order" class="form-label">Display Order</label>
                                <input type="number" class="form-control @error('order') is-invalid @enderror"
                                       id="order" name="order" value="{{ old('order', 0) }}" min="0">
                                <div class="form-text">Lower numbers appear first</div>
                                @error('order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label d-block">Status</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                           {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Active (Display on gallery)
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between pt-3">
                            <a href="{{ route('superadmin.website.gallery.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Back to Gallery
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Add to Gallery
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info bg-opacity-10 py-3">
                    <h6 class="mb-0"><i class="bi bi-lightbulb me-2"></i>Image Guidelines</h6>
                </div>
                <div class="card-body">
                    <h6 class="text-dark mb-2">Image Requirements</h6>
                    <ul class="small mb-3">
                        <li>Format: JPEG or PNG</li>
                        <li>Recommended size: 1200x800px</li>
                        <li>Aspect ratio: 3:2 (landscape)</li>
                        <li>Maximum file size: 2MB</li>
                        <li>High quality, well-lit photos</li>
                    </ul>

                    <h6 class="text-dark mb-2">Categories</h6>
                    <ul class="small mb-3">
                        <li><strong>Events:</strong> Conferences, workshops, ceremonies</li>
                        <li><strong>Facilities:</strong> Offices, infrastructure, equipment</li>
                        <li><strong>Community:</strong> Outreach programs, health camps</li>
                        <li><strong>Awards:</strong> Recognition, achievements, trophies</li>
                    </ul>

                    <h6 class="text-dark mb-2">Best Practices</h6>
                    <ul class="small mb-0">
                        <li>Use descriptive, clear titles</li>
                        <li>Ensure images are properly oriented</li>
                        <li>Avoid blurry or low-quality photos</li>
                        <li>Show diversity and inclusivity</li>
                        <li>Maintain professional appearance</li>
                    </ul>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-warning bg-opacity-10 py-3">
                    <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Important Notes</h6>
                </div>
                <div class="card-body">
                    <ul class="small mb-0">
                        <li>Required fields are marked with <span class="text-danger">*</span></li>
                        <li>Images are automatically optimized for web</li>
                        <li>Inactive images won't appear on the website</li>
                        <li>You can change display order anytime</li>
                        <li>Gallery supports unlimited images</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

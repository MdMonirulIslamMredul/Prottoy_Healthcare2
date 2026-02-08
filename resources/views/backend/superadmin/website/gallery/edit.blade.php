@extends('backend.layouts.app')

@section('title', 'Edit Gallery Image')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="bi bi-pencil me-2"></i>Edit Gallery Image</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('superadmin.website.gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   id="title" name="title" value="{{ old('title', $gallery->title) }}" required
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
                                <option value="events" {{ old('category', $gallery->category) == 'events' ? 'selected' : '' }}>Events</option>
                                <option value="facilities" {{ old('category', $gallery->category) == 'facilities' ? 'selected' : '' }}>Facilities</option>
                                <option value="community" {{ old('category', $gallery->category) == 'community' ? 'selected' : '' }}>Community</option>
                                <option value="awards" {{ old('category', $gallery->category) == 'awards' ? 'selected' : '' }}>Awards</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="3">{{ old('description', $gallery->description) }}</textarea>
                            <div class="form-text">Optional: Brief description of the image</div>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>

                            @if($gallery->image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $gallery->image) }}"
                                         alt="{{ $gallery->title }}"
                                         class="img-thumbnail"
                                         style="max-height: 200px;">
                                    <p class="text-muted small mt-1">Current image</p>
                                </div>
                            @endif

                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                                   id="image" name="image" accept="image/jpeg,image/png,image/jpg">
                            <div class="form-text">Leave empty to keep current image. Recommended: 1200x800px landscape, Max 2MB, JPG/PNG</div>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="order" class="form-label">Display Order</label>
                                <input type="number" class="form-control @error('order') is-invalid @enderror"
                                       id="order" name="order" value="{{ old('order', $gallery->order) }}" min="0">
                                <div class="form-text">Lower numbers appear first</div>
                                @error('order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label d-block">Status</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                           {{ old('is_active', $gallery->is_active) ? 'checked' : '' }}>
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
                                <i class="bi bi-check-circle me-2"></i>Update Image
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="card shadow-sm border-danger mt-4">
                <div class="card-header bg-danger bg-opacity-10 py-3">
                    <h6 class="mb-0 text-danger"><i class="bi bi-exclamation-triangle me-2"></i>Danger Zone</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Delete Gallery Image</h6>
                            <p class="text-muted small mb-0">This action cannot be undone. The image file will also be permanently deleted.</p>
                        </div>
                        <form action="{{ route('superadmin.website.gallery.destroy', $gallery->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this image? This action cannot be undone.')">
                                <i class="bi bi-trash me-2"></i>Delete Image
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary bg-opacity-10 py-3">
                    <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Current Information</h6>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>Title:</strong> {{ $gallery->title }}</p>
                    <p class="mb-2"><strong>Category:</strong>
                        <span class="badge bg-primary">{{ ucfirst($gallery->category) }}</span>
                    </p>
                    <p class="mb-2"><strong>Display Order:</strong> {{ $gallery->order }}</p>
                    <p class="mb-2">
                        <strong>Status:</strong>
                        <span class="badge {{ $gallery->is_active ? 'bg-success' : 'bg-secondary' }}">
                            {{ $gallery->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </p>
                    @if($gallery->description)
                        <hr>
                        <p class="mb-0"><strong>Description:</strong><br>{{ $gallery->description }}</p>
                    @endif
                </div>
            </div>

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
                    <ul class="small mb-0">
                        <li><strong>Events:</strong> Conferences, workshops, ceremonies</li>
                        <li><strong>Facilities:</strong> Offices, infrastructure, equipment</li>
                        <li><strong>Community:</strong> Outreach programs, health camps</li>
                        <li><strong>Awards:</strong> Recognition, achievements, trophies</li>
                    </ul>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-warning bg-opacity-10 py-3">
                    <h6 class="mb-0"><i class="bi bi-clock-history me-2"></i>Update History</h6>
                </div>
                <div class="card-body">
                    <p class="small mb-2"><strong>Created:</strong> {{ $gallery->created_at->format('M d, Y h:i A') }}</p>
                    <p class="small mb-0"><strong>Last Updated:</strong> {{ $gallery->updated_at->format('M d, Y h:i A') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

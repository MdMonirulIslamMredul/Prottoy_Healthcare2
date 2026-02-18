@extends('backend.layouts.app')

@section('title', 'Edit Hero Slider')

@section('content')
    <div class="container-fluid py-4">
        <div class="mb-4">
            <h2>Edit Hero Slider</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('superadmin.website.sliders.index') }}">Hero Sliders</a>
                    </li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="{{ route('superadmin.website.sliders.update', $slider) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="title" class="form-label">Slide Title <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title" name="title" value="{{ old('title', $slider->title) }}"
                                    placeholder="Enter slide title" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="subtitle" class="form-label">Subtitle/Description</label>
                                <textarea class="form-control @error('subtitle') is-invalid @enderror" id="subtitle" name="subtitle" rows="3"
                                    placeholder="Enter subtitle or mission statement">{{ old('subtitle', $slider->subtitle) }}</textarea>
                                @error('subtitle')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label">Background Image</label>

                                @if ($slider->image)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $slider->image) }}" alt="Current slider image"
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
                                    Leave empty to keep current image. Recommended size: 1920x1080px. Max 2MB
                                </small>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="button_text" class="form-label">Button Text</label>
                                    <input type="text" class="form-control @error('button_text') is-invalid @enderror"
                                        id="button_text" name="button_text"
                                        value="{{ old('button_text', $slider->button_text) }}"
                                        placeholder="e.g., Learn More">
                                    @error('button_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="button_link" class="form-label">Button Link</label>
                                    <input type="text" class="form-control @error('button_link') is-invalid @enderror"
                                        id="button_link" name="button_link"
                                        value="{{ old('button_link', $slider->button_link) }}" placeholder="/about">
                                    @error('button_link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="order" class="form-label">Display Order</label>
                                    <input type="number" class="form-control @error('order') is-invalid @enderror"
                                        id="order" name="order" value="{{ old('order', $slider->order) }}"
                                        min="0">
                                    @error('order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Lower numbers appear first</small>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label d-block">Status</label>
                                    <div class="form-check form-switch mt-2">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                            value="1" {{ old('is_active', $slider->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Active (Visible on website)
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('superadmin.website.sliders.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left me-2"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-2"></i>Update Slider
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Slider Guidelines</h5>
                    </div>
                    <div class="card-body">
                        <h6>Image Requirements:</h6>
                        <ul class="small">
                            <li>Recommended: 1920x1080px (Full HD)</li>
                            <li>Format: JPEG, PNG</li>
                            <li>Maximum size: 2MB</li>
                            <li>Use high-quality, professional images</li>
                        </ul>

                        <hr>

                        <h6>Best Practices:</h6>
                        <ul class="small">
                            <li>Keep titles short and impactful</li>
                            <li>Use clear, readable fonts</li>
                            <li>Ensure good contrast with background</li>
                            <li>Test on mobile devices</li>
                            <li>Limit to 3-5 active slides</li>
                        </ul>

                        <hr>

                        <h6>Display Order:</h6>
                        <p class="small mb-0">Slides are displayed in ascending order. Use numbers like 1, 2, 3 to control
                            the sequence.</p>
                    </div>
                </div>

                <div class="card shadow-sm mt-3">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0"><i class="bi bi-trash me-2"></i>Danger Zone</h5>
                    </div>
                    <div class="card-body">
                        <p class="small mb-2">Permanently delete this slider. This action cannot be undone.</p>
                        <form action="{{ route('superadmin.website.sliders.destroy', $slider) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this slider?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="bi bi-trash me-1"></i>Delete Slider
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

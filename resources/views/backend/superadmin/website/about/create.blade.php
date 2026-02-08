@extends('backend.layouts.app')

@section('title', 'Add Mission/Vision Content')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <h2>Add Mission/Vision Content</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('superadmin.website.about.index') }}">About Content</a></li>
                <li class="breadcrumb-item active">Add New</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('superadmin.website.about.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="type" class="form-label">Content Type <span class="text-danger">*</span></label>
                            <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                <option value="">Select type</option>
                                <option value="mission" {{ old('type') == 'mission' ? 'selected' : '' }}>Mission</option>
                                <option value="vision" {{ old('type') == 'vision' ? 'selected' : '' }}>Vision</option>
                                <option value="about" {{ old('type') == 'about' ? 'selected' : '' }}>About Us</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   id="title" name="title" value="{{ old('title') }}"
                                   placeholder="Enter title" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('content') is-invalid @enderror"
                                      id="content" name="content" rows="8"
                                      placeholder="Enter detailed content..." required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Describe your mission, vision, or about us information</small>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Image (Optional)</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                                   id="image" name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Recommended size: 800x600px. Max 2MB</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label d-block">Status</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active"
                                       name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active (Visible on website)
                                </label>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('superadmin.website.about.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Create Content
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Content Guidelines</h5>
                </div>
                <div class="card-body">
                    <h6>Mission Statement:</h6>
                    <ul class="small">
                        <li>Define your organization's purpose</li>
                        <li>Explain what you do and why</li>
                        <li>Keep it concise and inspiring</li>
                        <li>Focus on present activities</li>
                    </ul>

                    <hr>

                    <h6>Vision Statement:</h6>
                    <ul class="small">
                        <li>Describe your future aspirations</li>
                        <li>Paint a picture of success</li>
                        <li>Be ambitious but achievable</li>
                        <li>Inspire and motivate</li>
                    </ul>

                    <hr>

                    <h6>About Us:</h6>
                    <ul class="small">
                        <li>Tell your organization's story</li>
                        <li>Highlight key achievements</li>
                        <li>Showcase your values</li>
                        <li>Build trust and credibility</li>
                    </ul>

                    <hr>

                    <h6>Image Tips:</h6>
                    <ul class="small">
                        <li>Use relevant, high-quality images</li>
                        <li>Ensure good lighting and focus</li>
                        <li>Professional presentation</li>
                        <li>Consistent with brand identity</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

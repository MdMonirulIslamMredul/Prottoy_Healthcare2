@extends('backend.layouts.app')

@section('title', 'Add Leadership Team Member')

@push('styles')
<!-- Summernote CSS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<style>
    .note-editor.note-frame {
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
    }
    .note-editor.note-frame.is-invalid {
        border-color: #dc3545;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="bi bi-person-plus me-2"></i>Add Leadership Team Member</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('superadmin.website.leadership.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="designation" class="form-label">Designation <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('designation') is-invalid @enderror"
                                       id="designation" name="designation" value="{{ old('designation') }}" required
                                       placeholder="e.g., Chairman, Managing Director, CEO">
                                @error('designation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="bio" class="form-label">Biography</label>
                            <textarea class="form-control @error('bio') is-invalid @enderror"
                                      id="bio" name="bio">{{ old('bio') }}</textarea>
                            <div class="form-text">Professional background, experience, achievements, and message</div>
                            @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email" value="{{ old('email') }}"
                                       placeholder="contact@example.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                       id="phone" name="phone" value="{{ old('phone') }}"
                                       placeholder="+880 1XXX-XXXXXX">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="photo" class="form-label">Photo</label>
                            <input type="file" class="form-control @error('photo') is-invalid @enderror"
                                   id="photo" name="photo" accept="image/jpeg,image/png,image/jpg">
                            <div class="form-text">Recommended: Square image (800x800px), Max 2MB, JPG/PNG</div>
                            @error('photo')
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
                                        Active (Display on website)
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between pt-3">
                            <a href="{{ route('superadmin.website.leadership.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Back to List
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Create Team Member
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
                    <h6 class="mb-0"><i class="bi bi-lightbulb me-2"></i>Leadership Profile Tips</h6>
                </div>
                <div class="card-body">
                    <h6 class="text-dark mb-2">Name & Designation</h6>
                    <ul class="small mb-3">
                        <li>Use full formal name</li>
                        <li>Include academic titles if relevant (Dr., Prof.)</li>
                        <li>Be specific with designations</li>
                    </ul>

                    <h6 class="text-dark mb-2">Biography Content</h6>
                    <ul class="small mb-3">
                        <li><strong>Background:</strong> Education and expertise</li>
                        <li><strong>Experience:</strong> Years in healthcare/business</li>
                        <li><strong>Achievements:</strong> Key milestones with dates</li>
                        <li><strong>Message:</strong> Vision or inspirational quote</li>
                    </ul>

                    <h6 class="text-dark mb-2">Photo Guidelines</h6>
                    <ul class="small mb-3">
                        <li>Professional headshot or formal portrait</li>
                        <li>Square format works best (800x800px)</li>
                        <li>Neutral or office background</li>
                        <li>Business formal attire</li>
                    </ul>

                    <h6 class="text-dark mb-2">Display Order</h6>
                    <ul class="small mb-0">
                        <li>0 = First position (Chairman/CEO)</li>
                        <li>1 = Second position (MD/COO)</li>
                        <li>2+ = Other executives</li>
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
                        <li>Photo is optional - default icon will be used if not provided</li>
                        <li>Email and phone are optional contact details</li>
                        <li>Inactive members won't appear on the website</li>
                        <li>You can reorder members anytime using the order field</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- jQuery (required for Summernote) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Summernote JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function() {
        $('#bio').summernote({
            height: 300,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['insert', ['link']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            placeholder: 'Enter biography details including professional background, experience, achievements, and message...'
        });
    });
</script>
@endpush

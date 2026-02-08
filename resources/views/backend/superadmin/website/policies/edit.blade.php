@extends('backend.layouts.app')

@section('title', 'Edit Policy Document')

@push('styles')
<!-- Summernote CSS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<style>
    .note-editor.note-frame {
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
    }
    .color-preview {
        width: 40px;
        height: 40px;
        border-radius: 0.375rem;
        border: 2px solid #dee2e6;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Policy Document</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('superadmin.website.policies.update', $policy) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label for="title" class="form-label">Policy Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                       id="title" name="title" value="{{ old('title', $policy->title) }}" required
                                       placeholder="e.g., Privacy Policy">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="category" class="form-label">Category</label>
                                <input type="text" class="form-control @error('category') is-invalid @enderror"
                                       id="category" name="category" value="{{ old('category', $policy->category) }}"
                                       placeholder="e.g., Legal">
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Short Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="3">{{ old('description', $policy->description) }}</textarea>
                            <div class="form-text">Brief summary that appears in the document header</div>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Policy Content <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('content') is-invalid @enderror"
                                      id="content" name="content">{{ old('content', $policy->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="icon" class="form-label">Icon (Bootstrap Icon)</label>
                                <input type="text" class="form-control @error('icon') is-invalid @enderror"
                                       id="icon" name="icon" value="{{ old('icon', $policy->icon) }}"
                                       placeholder="bi-shield-lock">
                                <div class="form-text">
                                    Browse: <a href="https://icons.getbootstrap.com/" target="_blank">Bootstrap Icons</a>
                                </div>
                                @error('icon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="color" class="form-label">Accent Color</label>
                                <input type="color" class="form-control form-control-color @error('color') is-invalid @enderror"
                                       id="color" name="color" value="{{ old('color', $policy->color) }}">
                                <div class="form-text">Border and icon color</div>
                                @error('color')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="slug" class="form-label">URL Slug</label>
                                <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                       id="slug" name="slug" value="{{ old('slug', $policy->slug) }}"
                                       placeholder="auto-generated-from-title">
                                <div class="form-text">Leave empty to auto-generate from title</div>
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="order" class="form-label">Display Order</label>
                                <input type="number" class="form-control @error('order') is-invalid @enderror"
                                       id="order" name="order" value="{{ old('order', $policy->order) }}" min="0">
                                @error('order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label d-block">Status</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                           {{ old('is_active', $policy->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">Active</label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between pt-3">
                            <a href="{{ route('superadmin.website.policies.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Back to Policies
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Update Policy
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="card shadow-sm mt-4 border-danger">
                <div class="card-header bg-danger bg-opacity-10 py-3">
                    <h6 class="mb-0 text-danger"><i class="bi bi-exclamation-triangle me-2"></i>Danger Zone</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Delete this policy</h6>
                            <p class="text-muted small mb-0">Once deleted, this policy cannot be recovered</p>
                        </div>
                        <form action="{{ route('superadmin.website.policies.destroy', $policy) }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this policy? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash me-2"></i>Delete Policy
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
                    <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Current Details</h6>
                </div>
                <div class="card-body">
                    <dl class="row mb-0 small">
                        <dt class="col-sm-5">Category:</dt>
                        <dd class="col-sm-7">
                            <span class="badge bg-secondary">{{ $policy->category ?: 'N/A' }}</span>
                        </dd>

                        <dt class="col-sm-5">Icon:</dt>
                        <dd class="col-sm-7">
                            @if($policy->icon)
                                <i class="{{ $policy->icon }} fs-4"></i>
                                <code class="small">{{ $policy->icon }}</code>
                            @else
                                <span class="text-muted">No icon</span>
                            @endif
                        </dd>

                        <dt class="col-sm-5">Color:</dt>
                        <dd class="col-sm-7">
                            <div class="d-flex align-items-center gap-2">
                                <div class="color-preview" style="background-color: {{ $policy->color }};"></div>
                                <code>{{ $policy->color }}</code>
                            </div>
                        </dd>

                        <dt class="col-sm-5">Slug:</dt>
                        <dd class="col-sm-7">
                            <code>{{ $policy->slug }}</code>
                        </dd>

                        <dt class="col-sm-5">Status:</dt>
                        <dd class="col-sm-7">
                            @if($policy->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </dd>

                        <dt class="col-sm-5">Created:</dt>
                        <dd class="col-sm-7">{{ $policy->created_at->format('M d, Y') }}</dd>

                        <dt class="col-sm-5">Last Updated:</dt>
                        <dd class="col-sm-7">{{ $policy->updated_at->diffForHumans() }}</dd>
                    </dl>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info bg-opacity-10 py-3">
                    <h6 class="mb-0"><i class="bi bi-lightbulb me-2"></i>Policy Guidelines</h6>
                </div>
                <div class="card-body">
                    <h6 class="text-dark mb-2">Content Best Practices</h6>
                    <ul class="small mb-3">
                        <li>Use clear, simple language</li>
                        <li>Organize with headings and lists</li>
                        <li>Include effective date</li>
                        <li>Define key terms</li>
                        <li>Update regularly</li>
                    </ul>

                    <h6 class="text-dark mb-2">Icon Examples</h6>
                    <ul class="small mb-0">
                        <li><code>bi-shield-lock</code> - Privacy</li>
                        <li><code>bi-file-earmark-ruled</code> - Terms</li>
                        <li><code>bi-cash-coin</code> - Refund</li>
                        <li><code>bi-file-earmark-text</code> - General</li>
                    </ul>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-warning bg-opacity-10 py-3">
                    <h6 class="mb-0"><i class="bi bi-exclamation-circle me-2"></i>Important Notes</h6>
                </div>
                <div class="card-body">
                    <ul class="small mb-0">
                        <li>Required fields marked with <span class="text-danger">*</span></li>
                        <li>Content supports HTML formatting</li>
                        <li>Slug must be unique</li>
                        <li>Inactive policies won't appear on website</li>
                        <li>Lower order numbers appear first</li>
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
        $('#content').summernote({
            height: 400,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            placeholder: 'Enter the full policy content here...'
        });

        // Auto-generate slug from title only if manually changed
        let originalTitle = $('#title').val();
        let manualSlugEdit = false;

        $('#title').on('input', function() {
            if (!manualSlugEdit && $(this).val() !== originalTitle) {
                const slug = $(this).val()
                    .toLowerCase()
                    .replace(/[^\w\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
                $('#slug').val(slug);
            }
        });

        $('#slug').on('input', function() {
            manualSlugEdit = true;
        });
    });
</script>
@endpush

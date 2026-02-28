@extends('backend.layouts.app')

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
        <div class="mb-4">
            <h2>Edit Package</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('packages.index') }}">Packages</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('packages.update', $package->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Package Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name', $package->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="details" class="form-label">Details <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('details') is-invalid @enderror" id="details" name="details" rows="5"
                            required>{{ old('details', $package->details) }}</textarea>
                        @error('details')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Price (৳) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('price') is-invalid @enderror" id="price"
                            name="price" step="0.01" min="0" value="{{ old('price', $package->price) }}"
                            required>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                                {{ old('is_active', $package->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Active
                            </label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('packages.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Package</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <!-- jQuery (required for Summernote) -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Summernote JS -->
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#details').summernote({
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
                    placeholder: 'Enter package details (features, inclusions, terms)...'
                });
            });
        </script>
    @endpush
@endsection

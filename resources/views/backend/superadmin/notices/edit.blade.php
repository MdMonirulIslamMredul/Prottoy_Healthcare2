@extends('backend.layouts.app')

@section('title', 'Edit Notice')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <h2>Edit Notice</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('superadmin.notices.index') }}">Notices</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('superadmin.notices.update', $notice->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="title" class="form-label">Notice Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   id="title" name="title" value="{{ old('title', $notice->title) }}"
                                   placeholder="Enter notice title" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Notice Content <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('content') is-invalid @enderror"
                                      id="content" name="content" rows="6"
                                      placeholder="Enter the full notice content" required>{{ old('content', $notice->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Provide detailed information about the notice.
                            </small>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="type" class="form-label">Notice Type <span class="text-danger">*</span></label>
                                <select class="form-select @error('type') is-invalid @enderror"
                                        id="type" name="type" required>
                                    <option value="">Select Type</option>
                                    <option value="general" {{ old('type', $notice->type) == 'general' ? 'selected' : '' }}>General</option>
                                    <option value="emergency" {{ old('type', $notice->type) == 'emergency' ? 'selected' : '' }}>Emergency</option>
                                    <option value="announcement" {{ old('type', $notice->type) == 'announcement' ? 'selected' : '' }}>Announcement</option>
                                    <option value="event" {{ old('type', $notice->type) == 'event' ? 'selected' : '' }}>Event</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="published_at" class="form-label">Published Date</label>
                                <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror"
                                       id="published_at" name="published_at"
                                       value="{{ old('published_at', $notice->published_at ? $notice->published_at->format('Y-m-d\TH:i') : '') }}">
                                @error('published_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    Leave empty for current date/time
                                </small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active"
                                       name="is_active" value="1" {{ old('is_active', $notice->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active Status (Visible on website)
                                </label>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('superadmin.notices.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Update Notice
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Notice Information</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2">
                        <strong>Created:</strong><br>
                        <small class="text-muted">{{ $notice->created_at->format('M d, Y h:i A') }}</small>
                    </p>
                    <p class="mb-2">
                        <strong>Last Updated:</strong><br>
                        <small class="text-muted">{{ $notice->updated_at->format('M d, Y h:i A') }}</small>
                    </p>
                    <p class="mb-0">
                        <strong>Current Status:</strong><br>
                        <span class="badge {{ $notice->is_active ? 'bg-success' : 'bg-secondary' }}">
                            {{ $notice->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </p>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-lightbulb me-2"></i>Guidelines</h5>
                </div>
                <div class="card-body">
                    <h6>Notice Types:</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <span class="badge bg-secondary">General</span> - Regular information
                        </li>
                        <li class="mb-2">
                            <span class="badge bg-danger">Emergency</span> - Urgent alerts
                        </li>
                        <li class="mb-2">
                            <span class="badge bg-primary">Announcement</span> - Important updates
                        </li>
                        <li class="mb-2">
                            <span class="badge bg-success">Event</span> - Upcoming events
                        </li>
                    </ul>

                    <hr>

                    <h6>Best Practices:</h6>
                    <ul class="small">
                        <li>Keep titles clear and concise</li>
                        <li>Use proper notice type for better categorization</li>
                        <li>Set inactive for draft notices</li>
                        <li>Schedule future notices by setting published date</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

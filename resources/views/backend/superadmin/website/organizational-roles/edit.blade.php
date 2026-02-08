@extends('backend.layouts.app')

@section('title', 'Edit Organizational Role')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-9">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Organizational Role</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('superadmin.website.organizational-roles.update', $organizationalRole) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-7">
                                <label for="title" class="form-label">Role Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                       id="title" name="title" value="{{ old('title', $organizationalRole->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="level" class="form-label">Hierarchy Level <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('level') is-invalid @enderror"
                                       id="level" name="level" value="{{ old('level', $organizationalRole->level) }}" required min="1" max="10">
                                @error('level')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2">
                                <label for="order" class="form-label">Display Order</label>
                                <input type="number" class="form-control @error('order') is-invalid @enderror"
                                       id="order" name="order" value="{{ old('order', $organizationalRole->order) }}" min="0">
                                @error('order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="subtitle" class="form-label">Subtitle / Description</label>
                            <input type="text" class="form-control @error('subtitle') is-invalid @enderror"
                                   id="subtitle" name="subtitle" value="{{ old('subtitle', $organizationalRole->subtitle) }}">
                            @error('subtitle')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="icon" class="form-label">Icon (Bootstrap Icon)</label>
                                <input type="text" class="form-control @error('icon') is-invalid @enderror"
                                       id="icon" name="icon" value="{{ old('icon', $organizationalRole->icon) }}">
                                <div class="form-text">
                                    Browse: <a href="https://icons.getbootstrap.com/" target="_blank">Bootstrap Icons</a>
                                </div>
                                @error('icon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="color_start" class="form-label">Gradient Start Color</label>
                                <input type="color" class="form-control form-control-color @error('color_start') is-invalid @enderror"
                                       id="color_start" name="color_start" value="{{ old('color_start', $organizationalRole->color_start) }}">
                                @error('color_start')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="color_end" class="form-label">Gradient End Color</label>
                                <input type="color" class="form-control form-control-color @error('color_end') is-invalid @enderror"
                                       id="color_end" name="color_end" value="{{ old('color_end', $organizationalRole->color_end) }}">
                                @error('color_end')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="mb-4">
                            <label class="form-label">Key Responsibilities <span class="text-danger">*</span></label>
                            <div id="responsibilities-container">
                                @php
                                    $responsibilities = old('responsibilities', $organizationalRole->responsibilities ?? []);
                                @endphp
                                @foreach($responsibilities as $index => $responsibility)
                                    <div class="input-group mb-2 responsibility-item">
                                        <input type="text" class="form-control" name="responsibilities[]"
                                               value="{{ $responsibility }}" placeholder="Enter a responsibility" required>
                                        <button type="button" class="btn btn-outline-danger remove-responsibility">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary" id="add-responsibility">
                                <i class="bi bi-plus-circle me-1"></i>Add Responsibility
                            </button>
                            @error('responsibilities')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Stats Badges (Optional)</label>
                            <div id="stats-container">
                                @php
                                    $stats = old('stats', $organizationalRole->stats ?? []);
                                @endphp
                                @foreach($stats as $index => $stat)
                                    <div class="input-group mb-2 stat-item">
                                        <input type="text" class="form-control" name="stats[]"
                                               value="{{ $stat }}" placeholder="e.g., 8 Divisions">
                                        <button type="button" class="btn btn-outline-danger remove-stat">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-secondary" id="add-stat">
                                <i class="bi bi-plus-circle me-1"></i>Add Stat Badge
                            </button>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                       {{ old('is_active', $organizationalRole->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between pt-3">
                            <a href="{{ route('superadmin.website.organizational-roles.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Back
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Update Role
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
                            <h6 class="mb-1">Delete this organizational role</h6>
                            <p class="text-muted small mb-0">Once deleted, this role cannot be recovered</p>
                        </div>
                        <form action="{{ route('superadmin.website.organizational-roles.destroy', $organizationalRole) }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this role? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash me-2"></i>Delete Role
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-primary bg-opacity-10 py-3">
                    <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Current Details</h6>
                </div>
                <div class="card-body">
                    <dl class="row mb-0 small">
                        <dt class="col-sm-5">Level:</dt>
                        <dd class="col-sm-7">
                            <span class="badge bg-secondary">{{ $organizationalRole->level }}</span>
                        </dd>

                        <dt class="col-sm-5">Icon:</dt>
                        <dd class="col-sm-7">
                            @if($organizationalRole->icon)
                                <i class="{{ $organizationalRole->icon }} fs-4"></i>
                            @else
                                <span class="text-muted">No icon</span>
                            @endif
                        </dd>

                        <dt class="col-sm-5">Colors:</dt>
                        <dd class="col-sm-7">
                            <div class="d-flex gap-2 align-items-center">
                                <div style="width: 30px; height: 30px; border-radius: 5px; background: {{ $organizationalRole->color_start }};"></div>
                                <div style="width: 30px; height: 30px; border-radius: 5px; background: {{ $organizationalRole->color_end }};"></div>
                            </div>
                        </dd>

                        <dt class="col-sm-5">Status:</dt>
                        <dd class="col-sm-7">
                            @if($organizationalRole->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </dd>

                        <dt class="col-sm-5">Created:</dt>
                        <dd class="col-sm-7">{{ $organizationalRole->created_at->format('M d, Y') }}</dd>

                        <dt class="col-sm-5">Last Updated:</dt>
                        <dd class="col-sm-7">{{ $organizationalRole->updated_at->diffForHumans() }}</dd>
                    </dl>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-info bg-opacity-10 py-3">
                    <h6 class="mb-0"><i class="bi bi-lightbulb me-2"></i>Guidelines</h6>
                </div>
                <div class="card-body">
                    <ul class="small mb-0">
                        <li>Keep titles concise</li>
                        <li>Use clear role descriptions</li>
                        <li>List 5-10 key responsibilities</li>
                        <li>Add relevant stats badges</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add responsibility
    document.getElementById('add-responsibility').addEventListener('click', function() {
        const container = document.getElementById('responsibilities-container');
        const newItem = document.createElement('div');
        newItem.className = 'input-group mb-2 responsibility-item';
        newItem.innerHTML = `
            <input type="text" class="form-control" name="responsibilities[]"
                   placeholder="Enter a responsibility" required>
            <button type="button" class="btn btn-outline-danger remove-responsibility">
                <i class="bi bi-trash"></i>
            </button>
        `;
        container.appendChild(newItem);
    });

    // Remove responsibility
    document.getElementById('responsibilities-container').addEventListener('click', function(e) {
        if (e.target.closest('.remove-responsibility')) {
            const items = document.querySelectorAll('.responsibility-item');
            if (items.length > 1) {
                e.target.closest('.responsibility-item').remove();
            } else {
                alert('At least one responsibility is required.');
            }
        }
    });

    // Add stat
    document.getElementById('add-stat').addEventListener('click', function() {
        const container = document.getElementById('stats-container');
        const newItem = document.createElement('div');
        newItem.className = 'input-group mb-2 stat-item';
        newItem.innerHTML = `
            <input type="text" class="form-control" name="stats[]"
                   placeholder="e.g., 8 Divisions">
            <button type="button" class="btn btn-outline-danger remove-stat">
                <i class="bi bi-trash"></i>
            </button>
        `;
        container.appendChild(newItem);
    });

    // Remove stat
    document.getElementById('stats-container').addEventListener('click', function(e) {
        if (e.target.closest('.remove-stat')) {
            e.target.closest('.stat-item').remove();
        }
    });
});
</script>
@endsection

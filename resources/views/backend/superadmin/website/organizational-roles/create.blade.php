@extends('backend.layouts.app')

@section('title', 'Add Organizational Role')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-9">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="bi bi-diagram-3 me-2"></i>Add Organizational Role</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('superadmin.website.organizational-roles.store') }}" method="POST">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-7">
                                <label for="title" class="form-label">Role Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                       id="title" name="title" value="{{ old('title') }}" required
                                       placeholder="e.g., Managing Director">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="level" class="form-label">Hierarchy Level <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('level') is-invalid @enderror"
                                       id="level" name="level" value="{{ old('level', 1) }}" required min="1" max="10">
                                @error('level')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-2">
                                <label for="order" class="form-label">Display Order</label>
                                <input type="number" class="form-control @error('order') is-invalid @enderror"
                                       id="order" name="order" value="{{ old('order', 0) }}" min="0">
                                @error('order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="subtitle" class="form-label">Subtitle / Description</label>
                            <input type="text" class="form-control @error('subtitle') is-invalid @enderror"
                                   id="subtitle" name="subtitle" value="{{ old('subtitle') }}"
                                   placeholder="e.g., Central Management & Oversight">
                            @error('subtitle')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="icon" class="form-label">Icon (Bootstrap Icon)</label>
                                <input type="text" class="form-control @error('icon') is-invalid @enderror"
                                       id="icon" name="icon" value="{{ old('icon', 'bi-person-badge') }}"
                                       placeholder="bi-person-badge">
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
                                       id="color_start" name="color_start" value="{{ old('color_start', '#667eea') }}">
                                @error('color_start')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="color_end" class="form-label">Gradient End Color</label>
                                <input type="color" class="form-control form-control-color @error('color_end') is-invalid @enderror"
                                       id="color_end" name="color_end" value="{{ old('color_end', '#764ba2') }}">
                                @error('color_end')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="mb-4">
                            <label class="form-label">Key Responsibilities <span class="text-danger">*</span></label>
                            <div id="responsibilities-container">
                                @if(old('responsibilities'))
                                    @foreach(old('responsibilities') as $index => $responsibility)
                                        <div class="input-group mb-2 responsibility-item">
                                            <input type="text" class="form-control" name="responsibilities[]"
                                                   value="{{ $responsibility }}" placeholder="Enter a responsibility" required>
                                            <button type="button" class="btn btn-outline-danger remove-responsibility">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="input-group mb-2 responsibility-item">
                                        <input type="text" class="form-control" name="responsibilities[]"
                                               placeholder="Enter a responsibility" required>
                                        <button type="button" class="btn btn-outline-danger remove-responsibility">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                @endif
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
                                @if(old('stats'))
                                    @foreach(old('stats') as $index => $stat)
                                        <div class="input-group mb-2 stat-item">
                                            <input type="text" class="form-control" name="stats[]"
                                                   value="{{ $stat }}" placeholder="e.g., 8 Divisions">
                                            <button type="button" class="btn btn-outline-danger remove-stat">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-secondary" id="add-stat">
                                <i class="bi bi-plus-circle me-1"></i>Add Stat Badge
                            </button>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                       {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between pt-3">
                            <a href="{{ route('superadmin.website.organizational-roles.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Back
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Create Role
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card shadow-sm">
                <div class="card-header bg-info bg-opacity-10 py-3">
                    <h6 class="mb-0"><i class="bi bi-lightbulb me-2"></i>Guidelines</h6>
                </div>
                <div class="card-body">
                    <h6 class="text-dark mb-2">Hierarchy Levels</h6>
                    <ul class="small mb-3">
                        <li><strong>Level 1:</strong> Top management</li>
                        <li><strong>Level 2:</strong> Divisional heads</li>
                        <li><strong>Level 3:</strong> District managers</li>
                        <li><strong>Level 4:</strong> Upazila supervisors</li>
                        <li><strong>Level 5:</strong> Frontline officers</li>
                        <li><strong>Level 6:</strong> Customers/Users</li>
                    </ul>

                    <h6 class="text-dark mb-2">Best Practices</h6>
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

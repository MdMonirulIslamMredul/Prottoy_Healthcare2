@extends('backend.layouts.app')

@section('title', 'Add Divisional Chief')
@section('page-title', 'Add Divisional Chief')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <a href="{{ route('superadmin.divisional-chiefs.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i>Back to List
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 col-xl-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">Create New Divisional Chief</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('superadmin.divisional-chiefs.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="name"
                                   name="name"
                                   value="{{ old('name') }}"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   id="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="division_id" class="form-label">Division <span class="text-danger">*</span></label>
                            <select class="form-select @error('division_id') is-invalid @enderror"
                                    id="division_id"
                                    name="division_id"
                                    required>
                                <option value="">Select Division</option>
                                @foreach($divisions as $division)
                                    <option value="{{ $division->id }}"
                                            {{ old('division_id') == $division->id ? 'selected' : '' }}
                                            {{ in_array($division->id, $assignedDivisions) ? 'disabled' : '' }}>
                                        {{ $division->name }} ({{ $division->bn_name }})
                                        @if(in_array($division->id, $assignedDivisions))
                                            - Already Assigned
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('division_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Each division can have only one Divisional Chief</small>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   id="password"
                                   name="password"
                                   required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Minimum 8 characters</small>
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password"
                                   class="form-control"
                                   id="password_confirmation"
                                   name="password_confirmation"
                                   required>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-1"></i>Create Divisional Chief
                            </button>
                            <a href="{{ route('superadmin.divisional-chiefs.index') }}" class="btn btn-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-xl-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="bi bi-info-circle me-1"></i>Information</h6>
                </div>
                <div class="card-body">
                    <h6>Divisional Chief Role</h6>
                    <p class="text-muted small">A Divisional Chief manages all healthcare operations within their assigned division.</p>

                    <h6 class="mt-3">Responsibilities:</h6>
                    <ul class="small text-muted">
                        <li>Oversee all districts within the division</li>
                        <li>Manage divisional healthcare staff</li>
                        <li>Monitor healthcare services</li>
                        <li>Generate divisional reports</li>
                    </ul>

                    <div class="alert alert-info mt-3">
                        <small><i class="bi bi-lightbulb me-1"></i>Each division can only have ONE Divisional Chief assigned.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

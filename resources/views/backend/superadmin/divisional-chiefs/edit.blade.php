@extends('backend.layouts.app')

@section('title', 'Edit Divisional Chief')
@section('page-title', 'Edit Divisional Chief')

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
                    <h5 class="mb-0">Edit Divisional Chief</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('superadmin.divisional-chiefs.update', $divisionalChief) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="name"
                                   name="name"
                                   value="{{ old('name', $divisionalChief->name) }}"
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
                                   value="{{ old('email', $divisionalChief->email) }}"
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
                                            {{ old('division_id', $divisionalChief->division_id) == $division->id ? 'selected' : '' }}
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
                            <label for="password" class="form-label">Password</label>
                            <input type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   id="password"
                                   name="password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Leave blank to keep current password. Minimum 8 characters if changing.</small>
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password"
                                   class="form-control"
                                   id="password_confirmation"
                                   name="password_confirmation">
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-1"></i>Update Divisional Chief
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
                    <h6 class="mb-0"><i class="bi bi-person-badge me-1"></i>Current Information</h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <td class="text-muted">User ID:</td>
                            <td><strong>#{{ $divisionalChief->id }}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Current Division:</td>
                            <td>
                                @if($divisionalChief->division)
                                    <span class="badge bg-info">{{ $divisionalChief->division->name }}</span>
                                @else
                                    <span class="text-muted">Not Assigned</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Created:</td>
                            <td>{{ $divisionalChief->created_at->format('M d, Y h:i A') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Last Updated:</td>
                            <td>{{ $divisionalChief->updated_at->format('M d, Y h:i A') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('backend.layouts.app')

@section('title', 'Edit District Manager')
@section('page-title', 'Edit District Manager')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <a href="{{ route('superadmin.district-managers.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i>Back to List
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 col-xl-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">Edit District Manager</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('superadmin.district-managers.update', $districtManager) }}" method="POST" id="districtManagerForm">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="name"
                                   name="name"
                                   value="{{ old('name', $districtManager->name) }}"
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
                                   value="{{ old('email', $districtManager->email) }}"
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
                                            {{ old('division_id', $districtManager->division_id) == $division->id ? 'selected' : '' }}>
                                        {{ $division->name }} ({{ $division->bn_name }})
                                    </option>
                                @endforeach
                            </select>
                            @error('division_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="district_id" class="form-label">District <span class="text-danger">*</span></label>
                            <select class="form-select @error('district_id') is-invalid @enderror"
                                    id="district_id"
                                    name="district_id"
                                    required>
                                <option value="">Select District</option>
                                @foreach($districts as $district)
                                    <option value="{{ $district->id }}"
                                            {{ old('district_id', $districtManager->district_id) == $district->id ? 'selected' : '' }}
                                            {{ in_array($district->id, $assignedDistricts) ? 'disabled' : '' }}>
                                        {{ $district->name }} ({{ $district->bn_name }})
                                        @if(in_array($district->id, $assignedDistricts))
                                            - Already Assigned
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('district_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Each district can have only one District Manager</small>
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
                                <i class="bi bi-check-circle me-1"></i>Update District Manager
                            </button>
                            <a href="{{ route('superadmin.district-managers.index') }}" class="btn btn-secondary">
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
                            <td><strong>#{{ $districtManager->id }}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Current Division:</td>
                            <td>
                                @if($districtManager->division)
                                    <span class="badge bg-info">{{ $districtManager->division->name }}</span>
                                @else
                                    <span class="text-muted">Not Assigned</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Current District:</td>
                            <td>
                                @if($districtManager->district)
                                    <span class="badge bg-success">{{ $districtManager->district->name }}</span>
                                @else
                                    <span class="text-muted">Not Assigned</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Created:</td>
                            <td>{{ $districtManager->created_at->format('M d, Y h:i A') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Last Updated:</td>
                            <td>{{ $districtManager->updated_at->format('M d, Y h:i A') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const divisionSelect = document.getElementById('division_id');
    const districtSelect = document.getElementById('district_id');
    const currentDistrictId = {{ $districtManager->district_id ?? 'null' }};

    divisionSelect.addEventListener('change', function() {
        const divisionId = this.value;

        if (!divisionId) {
            districtSelect.innerHTML = '<option value="">Select Division First</option>';
            return;
        }

        // Show loading state
        districtSelect.innerHTML = '<option value="">Loading...</option>';

        // Fetch districts for selected division
        fetch(`/superadmin/get-districts/${divisionId}`)
            .then(response => response.json())
            .then(data => {
                districtSelect.innerHTML = '<option value="">Select District</option>';

                data.districts.forEach(district => {
                    const option = document.createElement('option');
                    option.value = district.id;
                    option.textContent = `${district.name} (${district.bn_name})`;

                    // Don't disable current district, but disable others that are assigned
                    if (data.assignedDistricts.includes(district.id) && district.id !== currentDistrictId) {
                        option.textContent += ' - Already Assigned';
                        option.disabled = true;
                    }

                    // Select current district
                    if (district.id === currentDistrictId) {
                        option.selected = true;
                    }

                    districtSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error fetching districts:', error);
                districtSelect.innerHTML = '<option value="">Error loading districts</option>';
            });
    });
});
</script>
@endpush

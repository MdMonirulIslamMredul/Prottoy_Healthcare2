@extends('backend.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <h2>Edit Upazila Supervisor</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('superadmin.upazila-supervisors.index') }}">Upazila Supervisors</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('superadmin.upazila-supervisors.update', $upazilaSupervisor->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name', $upazilaSupervisor->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email', $upazilaSupervisor->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Password <small class="text-muted">(Leave blank to keep current)</small></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                       id="password" name="password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control"
                                       id="password_confirmation" name="password_confirmation">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="division_id" class="form-label">Division <span class="text-danger">*</span></label>
                            <select class="form-select @error('division_id') is-invalid @enderror"
                                    id="division_id" name="division_id" required>
                                <option value="">Select Division</option>
                                @foreach($divisions as $division)
                                    <option value="{{ $division->id }}"
                                        {{ old('division_id', $upazilaSupervisor->division_id) == $division->id ? 'selected' : '' }}>
                                        {{ $division->name }}
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
                                    id="district_id" name="district_id" required>
                                <option value="">Select District</option>
                            </select>
                            @error('district_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="upzila_id" class="form-label">Upazila <span class="text-danger">*</span></label>
                            <select class="form-select @error('upzila_id') is-invalid @enderror"
                                    id="upzila_id" name="upzila_id" required>
                                <option value="">Select Upazila</option>
                            </select>
                            @error('upzila_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>Update Upazila Supervisor
                            </button>
                            <a href="{{ route('superadmin.upazila-supervisors.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-info-circle text-primary me-2"></i>Current Information
                    </h5>
                    <hr>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <strong>Name:</strong><br>
                            {{ $upazilaSupervisor->name }}
                        </li>
                        <li class="mb-2">
                            <strong>Email:</strong><br>
                            {{ $upazilaSupervisor->email }}
                        </li>
                        <li class="mb-2">
                            <strong>Current Division:</strong><br>
                            {{ $upazilaSupervisor->division->name ?? 'N/A' }}
                        </li>
                        <li class="mb-2">
                            <strong>Current District:</strong><br>
                            {{ $upazilaSupervisor->district->name ?? 'N/A' }}
                        </li>
                        <li class="mb-2">
                            <strong>Current Upazila:</strong><br>
                            {{ $upazilaSupervisor->upzila->name ?? 'N/A' }}
                        </li>
                        <li class="mb-2">
                            <strong>Created:</strong><br>
                            {{ $upazilaSupervisor->created_at->format('d M Y, h:i A') }}
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card shadow-sm mt-3">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-exclamation-triangle text-warning me-2"></i>Note
                    </h5>
                    <hr>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            Leave password blank to keep current password
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            Select division to load districts
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            Select district to load upzilas
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-exclamation-triangle text-warning me-2"></i>
                            Already assigned upzilas will be disabled
                        </li>
                    </ul>
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
    const upzilaSelect = document.getElementById('upzila_id');

    const currentDivisionId = '{{ old("division_id", $upazilaSupervisor->division_id) }}';
    const currentDistrictId = '{{ old("district_id", $upazilaSupervisor->district_id) }}';
    const currentUpzilaId = '{{ old("upzila_id", $upazilaSupervisor->upzila_id) }}';
    const currentSupervisorId = '{{ $upazilaSupervisor->id }}';

    // Load districts for selected division
    function loadDistricts(divisionId, selectDistrictId = null) {
        if (!divisionId) {
            districtSelect.innerHTML = '<option value="">Select District</option>';
            upzilaSelect.innerHTML = '<option value="">Select Upazila</option>';
            districtSelect.disabled = true;
            upzilaSelect.disabled = true;
            return;
        }

        fetch(`/superadmin/get-districts/${divisionId}`)
            .then(response => response.json())
            .then(data => {
                districtSelect.innerHTML = '<option value="">Select District</option>';

                data.districts.forEach(district => {
                    const option = document.createElement('option');
                    option.value = district.id;
                    option.textContent = district.name;

                    if (selectDistrictId && district.id == selectDistrictId) {
                        option.selected = true;
                    }

                    districtSelect.appendChild(option);
                });

                districtSelect.disabled = false;

                // Load upzilas if district is selected
                if (selectDistrictId) {
                    loadUpzilas(selectDistrictId, currentUpzilaId);
                }
            })
            .catch(error => console.error('Error:', error));
    }

    // Load upzilas for selected district
    function loadUpzilas(districtId, selectUpzilaId = null) {
        if (!districtId) {
            upzilaSelect.innerHTML = '<option value="">Select Upazila</option>';
            upzilaSelect.disabled = true;
            return;
        }

        fetch(`/superadmin/get-upzilas/${districtId}`)
            .then(response => response.json())
            .then(data => {
                upzilaSelect.innerHTML = '<option value="">Select Upazila</option>';

                data.upzilas.forEach(upzila => {
                    const option = document.createElement('option');
                    option.value = upzila.id;
                    option.textContent = upzila.name;

                    // Disable if already assigned (except current one)
                    if (data.assignedUpzilas.includes(upzila.id) && upzila.id != currentUpzilaId) {
                        option.disabled = true;
                        option.textContent += ' (Already Assigned)';
                    }

                    if (selectUpzilaId && upzila.id == selectUpzilaId) {
                        option.selected = true;
                    }

                    upzilaSelect.appendChild(option);
                });

                upzilaSelect.disabled = false;
            })
            .catch(error => console.error('Error:', error));
    }

    // When division changes
    divisionSelect.addEventListener('change', function() {
        const divisionId = this.value;
        upzilaSelect.innerHTML = '<option value="">Select Upazila</option>';
        upzilaSelect.disabled = true;
        loadDistricts(divisionId);
    });

    // When district changes
    districtSelect.addEventListener('change', function() {
        const districtId = this.value;
        loadUpzilas(districtId);
    });

    // Load initial districts and upzilas
    if (currentDivisionId) {
        loadDistricts(currentDivisionId, currentDistrictId);
    }
});
</script>
@endpush

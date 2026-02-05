@extends('backend.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <h2>Add New Upazila Supervisor</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('superadmin.upazila-supervisors.index') }}">Upazila Supervisors</a></li>
                <li class="breadcrumb-item active">Add New</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('superadmin.upazila-supervisors.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                       id="password" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control"
                                       id="password_confirmation" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="division_id" class="form-label">Division <span class="text-danger">*</span></label>
                            <select class="form-select @error('division_id') is-invalid @enderror"
                                    id="division_id" name="division_id" required>
                                <option value="">Select Division</option>
                                @foreach($divisions as $division)
                                    <option value="{{ $division->id }}" {{ old('division_id') == $division->id ? 'selected' : '' }}>
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
                                    id="district_id" name="district_id" required disabled>
                                <option value="">Select District</option>
                            </select>
                            @error('district_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="upzila_id" class="form-label">Upazila <span class="text-danger">*</span></label>
                            <select class="form-select @error('upzila_id') is-invalid @enderror"
                                    id="upzila_id" name="upzila_id" required disabled>
                                <option value="">Select Upazila</option>
                            </select>
                            @error('upzila_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>Create Upazila Supervisor
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
                        <i class="bi bi-info-circle text-primary me-2"></i>Information
                    </h5>
                    <hr>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            Fill in all required fields marked with <span class="text-danger">*</span>
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            Password must be at least 8 characters
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            Select division first to load districts
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            Select district to load upzilas
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            Only one supervisor can be assigned per upazila
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

    // When division changes, load districts
    divisionSelect.addEventListener('change', function() {
        const divisionId = this.value;

        // Reset district and upazila
        districtSelect.innerHTML = '<option value="">Select District</option>';
        upzilaSelect.innerHTML = '<option value="">Select Upazila</option>';
        districtSelect.disabled = true;
        upzilaSelect.disabled = true;

        if (divisionId) {
            // Fetch districts for selected division
            fetch(`/superadmin/get-districts/${divisionId}`)
                .then(response => response.json())
                .then(data => {
                    data.districts.forEach(district => {
                        const option = document.createElement('option');
                        option.value = district.id;
                        option.textContent = district.name;
                        districtSelect.appendChild(option);
                    });
                    districtSelect.disabled = false;
                })
                .catch(error => console.error('Error:', error));
        }
    });

    // When district changes, load upzilas
    districtSelect.addEventListener('change', function() {
        const districtId = this.value;

        // Reset upazila
        upzilaSelect.innerHTML = '<option value="">Select Upazila</option>';
        upzilaSelect.disabled = true;

        if (districtId) {
            // Fetch upzilas for selected district
            fetch(`/superadmin/get-upzilas/${districtId}`)
                .then(response => response.json())
                .then(data => {
                    data.upzilas.forEach(upzila => {
                        const option = document.createElement('option');
                        option.value = upzila.id;
                        option.textContent = upzila.name;

                        // Disable if already assigned
                        if (data.assignedUpzilas.includes(upzila.id)) {
                            option.disabled = true;
                            option.textContent += ' (Already Assigned)';
                        }

                        upzilaSelect.appendChild(option);
                    });
                    upzilaSelect.disabled = false;
                })
                .catch(error => console.error('Error:', error));
        }
    });

    // Trigger change if old values exist
    if (divisionSelect.value) {
        divisionSelect.dispatchEvent(new Event('change'));

        // Wait for districts to load, then set district value
        setTimeout(() => {
            const oldDistrict = '{{ old("district_id") }}';
            if (oldDistrict) {
                districtSelect.value = oldDistrict;
                districtSelect.dispatchEvent(new Event('change'));

                // Wait for upzilas to load, then set upzila value
                setTimeout(() => {
                    const oldUpzila = '{{ old("upzila_id") }}';
                    if (oldUpzila) {
                        upzilaSelect.value = oldUpzila;
                    }
                }, 500);
            }
        }, 500);
    }
});
</script>
@endpush

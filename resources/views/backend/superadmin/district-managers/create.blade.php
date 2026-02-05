@extends('backend.layouts.app')

@section('title', 'Add District Manager')
@section('page-title', 'Add District Manager')

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
                    <h5 class="mb-0">Create New District Manager</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('superadmin.district-managers.store') }}" method="POST" id="districtManagerForm">
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
                                            {{ old('division_id') == $division->id ? 'selected' : '' }}>
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
                                    required
                                    disabled>
                                <option value="">Select Division First</option>
                            </select>
                            @error('district_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Each district can have only one District Manager</small>
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
                                <i class="bi bi-check-circle me-1"></i>Create District Manager
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
                    <h6 class="mb-0"><i class="bi bi-info-circle me-1"></i>Information</h6>
                </div>
                <div class="card-body">
                    <h6>District Manager Role</h6>
                    <p class="text-muted small">A District Manager oversees healthcare operations within their assigned district.</p>

                    <h6 class="mt-3">Responsibilities:</h6>
                    <ul class="small text-muted">
                        <li>Manage all upzilas within the district</li>
                        <li>Supervise healthcare facilities</li>
                        <li>Monitor district health services</li>
                        <li>Generate district-level reports</li>
                        <li>Coordinate with Divisional Chief</li>
                    </ul>

                    <div class="alert alert-info mt-3">
                        <small><i class="bi bi-lightbulb me-1"></i>Each district can only have ONE District Manager assigned.</small>
                    </div>
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
    const assignedDistricts = @json($assignedDistricts);

    divisionSelect.addEventListener('change', function() {
        const divisionId = this.value;

        if (!divisionId) {
            districtSelect.innerHTML = '<option value="">Select Division First</option>';
            districtSelect.disabled = true;
            return;
        }

        // Show loading state
        districtSelect.innerHTML = '<option value="">Loading...</option>';
        districtSelect.disabled = true;

        // Fetch districts for selected division
        fetch(`/superadmin/get-districts/${divisionId}`)
            .then(response => response.json())
            .then(data => {
                districtSelect.innerHTML = '<option value="">Select District</option>';

                data.districts.forEach(district => {
                    const option = document.createElement('option');
                    option.value = district.id;
                    option.textContent = `${district.name} (${district.bn_name})`;

                    // Disable if already assigned
                    if (data.assignedDistricts.includes(district.id)) {
                        option.textContent += ' - Already Assigned';
                        option.disabled = true;
                    }

                    districtSelect.appendChild(option);
                });

                districtSelect.disabled = false;

                // Restore old value if exists
                const oldDistrictId = "{{ old('district_id') }}";
                if (oldDistrictId) {
                    districtSelect.value = oldDistrictId;
                }
            })
            .catch(error => {
                console.error('Error fetching districts:', error);
                districtSelect.innerHTML = '<option value="">Error loading districts</option>';
            });
    });

    // Trigger change if division is already selected (for old input)
    if (divisionSelect.value) {
        divisionSelect.dispatchEvent(new Event('change'));
    }
});
</script>
@endpush

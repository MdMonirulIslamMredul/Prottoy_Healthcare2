@extends('backend.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <h2>Edit PHO</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('superadmin.phos.index') }}">PHOs</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('superadmin.phos.update', $pho->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name', $pho->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email', $pho->email) }}" required>
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

                        <hr class="my-4">
                        <h5 class="mb-3">Hierarchical Selection</h5>

                        <div class="mb-3">
                            <label for="divisional_chief_id" class="form-label">Divisional Chief <span class="text-danger">*</span></label>
                            <select class="form-select" id="divisional_chief_id" name="divisional_chief_id" required>
                                <option value="">Select Divisional Chief</option>
                                @foreach($divisionalChiefs as $chief)
                                    <option value="{{ $chief->id }}"
                                        data-division-id="{{ $chief->division_id }}">
                                        {{ $chief->name }} ({{ $chief->division->name ?? '' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="district_manager_id" class="form-label">District Manager <span class="text-danger">*</span></label>
                            <select class="form-select" id="district_manager_id" name="district_manager_id" required>
                                <option value="">Select District Manager</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="upazila_supervisor_id" class="form-label">Upazila Supervisor <span class="text-danger">*</span></label>
                            <select class="form-select @error('upazila_supervisor_id') is-invalid @enderror"
                                    id="upazila_supervisor_id" name="upazila_supervisor_id" required>
                                <option value="">Select Upazila Supervisor</option>
                            </select>
                            @error('upazila_supervisor_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <input type="hidden" id="division_id" name="division_id" value="{{ old('division_id', $pho->division_id) }}">
                        <input type="hidden" id="district_id" name="district_id" value="{{ old('district_id', $pho->district_id) }}">
                        <input type="hidden" id="upzila_id" name="upzila_id" value="{{ old('upzila_id', $pho->upzila_id) }}">

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>Update PHO
                            </button>
                            <a href="{{ route('superadmin.phos.index') }}" class="btn btn-secondary">
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
                            {{ $pho->name }}
                        </li>
                        <li class="mb-2">
                            <strong>Email:</strong><br>
                            {{ $pho->email }}
                        </li>
                        <li class="mb-2">
                            <strong>Division:</strong><br>
                            {{ $pho->division->name ?? 'N/A' }}
                        </li>
                        <li class="mb-2">
                            <strong>District:</strong><br>
                            {{ $pho->district->name ?? 'N/A' }}
                        </li>
                        <li class="mb-2">
                            <strong>Upazila:</strong><br>
                            {{ $pho->upzila->name ?? 'N/A' }}
                        </li>
                        <li class="mb-2">
                            <strong>Supervisor:</strong><br>
                            {{ $pho->upazilaSupervisor->name ?? 'N/A' }}
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
    const divisionalChiefSelect = document.getElementById('divisional_chief_id');
    const districtManagerSelect = document.getElementById('district_manager_id');
    const upazilaSupervisorSelect = document.getElementById('upazila_supervisor_id');
    const divisionIdInput = document.getElementById('division_id');
    const districtIdInput = document.getElementById('district_id');
    const upzilaIdInput = document.getElementById('upzila_id');

    const currentUpazilaSupervisorId = '{{ old("upazila_supervisor_id", $pho->upazila_supervisor_id) }}';

    // Load initial data
    loadInitialData();

    function loadInitialData() {
        // Find divisional chief that matches current division
        const divisionId = '{{ $pho->division_id }}';

        Array.from(divisionalChiefSelect.options).forEach(option => {
            if (option.getAttribute('data-division-id') == divisionId) {
                divisionalChiefSelect.value = option.value;
                loadDistrictManagers(option.value, '{{ $pho->upazilaSupervisor->upazilaSupervisor->id ?? "" }}');
            }
        });
    }

    function loadDistrictManagers(divisionalChiefId, selectManagerId = null) {
        if (!divisionalChiefId) return;

        fetch(`/superadmin/get-district-managers/${divisionalChiefId}`)
            .then(response => response.json())
            .then(data => {
                districtManagerSelect.innerHTML = '<option value="">Select District Manager</option>';

                data.districtManagers.forEach(manager => {
                    const option = document.createElement('option');
                    option.value = manager.id;
                    option.textContent = manager.name;
                    option.setAttribute('data-district-id', manager.district_id);

                    if (selectManagerId && manager.id == selectManagerId) {
                        option.selected = true;
                    }

                    districtManagerSelect.appendChild(option);
                });

                districtManagerSelect.disabled = false;

                if (selectManagerId) {
                    loadUpazilaSupervisors(selectManagerId, currentUpazilaSupervisorId);
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function loadUpazilaSupervisors(districtManagerId, selectSupervisorId = null) {
        if (!districtManagerId) return;

        fetch(`/superadmin/get-upazila-supervisors/${districtManagerId}`)
            .then(response => response.json())
            .then(data => {
                upazilaSupervisorSelect.innerHTML = '<option value="">Select Upazila Supervisor</option>';

                data.upazilaSupervisors.forEach(supervisor => {
                    const option = document.createElement('option');
                    option.value = supervisor.id;
                    option.textContent = supervisor.name;
                    option.setAttribute('data-upzila-id', supervisor.upzila_id);
                    option.setAttribute('data-division-id', supervisor.division_id);
                    option.setAttribute('data-district-id', supervisor.district_id);

                    if (selectSupervisorId && supervisor.id == selectSupervisorId) {
                        option.selected = true;
                    }

                    upazilaSupervisorSelect.appendChild(option);
                });

                upazilaSupervisorSelect.disabled = false;
            })
            .catch(error => console.error('Error:', error));
    }

    // Event listeners
    divisionalChiefSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        divisionIdInput.value = selectedOption.getAttribute('data-division-id') || '';

        districtManagerSelect.innerHTML = '<option value="">Select District Manager</option>';
        upazilaSupervisorSelect.innerHTML = '<option value="">Select Upazila Supervisor</option>';
        districtManagerSelect.disabled = true;
        upazilaSupervisorSelect.disabled = true;

        if (this.value) {
            loadDistrictManagers(this.value);
        }
    });

    districtManagerSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        districtIdInput.value = selectedOption.getAttribute('data-district-id') || '';

        upazilaSupervisorSelect.innerHTML = '<option value="">Select Upazila Supervisor</option>';
        upazilaSupervisorSelect.disabled = true;

        if (this.value) {
            loadUpazilaSupervisors(this.value);
        }
    });

    upazilaSupervisorSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        upzilaIdInput.value = selectedOption.getAttribute('data-upzila-id') || '';
        divisionIdInput.value = selectedOption.getAttribute('data-division-id') || '';
        districtIdInput.value = selectedOption.getAttribute('data-district-id') || '';
    });
});
</script>
@endpush

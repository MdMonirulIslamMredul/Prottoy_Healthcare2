@extends('backend.layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="mb-4">
            <h2>Add New Customer</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('superadmin.customers.index') }}">Customers</a></li>
                    <li class="breadcrumb-item active">Add New</li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="{{ route('superadmin.customers.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address <span
                                        class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">Password <span
                                            class="text-danger">*</span></label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm Password <span
                                            class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    id="phone" name="phone" value="{{ old('phone') }}"
                                    placeholder="Enter phone number" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3"
                                    placeholder="Enter full address">{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr class="my-4">
                            <h5 class="mb-3">Hierarchical Selection</h5>

                            <div class="mb-3">
                                <label for="divisional_chief_id" class="form-label">Divisional Chief <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('divisional_chief_id') is-invalid @enderror"
                                    id="divisional_chief_id" name="divisional_chief_id" required>
                                    <option value="">Select Divisional Chief</option>
                                    @foreach ($divisionalChiefs as $chief)
                                        <option value="{{ $chief->id }}" data-division-id="{{ $chief->division_id }}"
                                            {{ old('divisional_chief_id') == $chief->id ? 'selected' : '' }}>
                                            {{ $chief->name }} ({{ $chief->division->name ?? '' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('divisional_chief_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="district_manager_id" class="form-label">District Manager <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('district_manager_id') is-invalid @enderror"
                                    id="district_manager_id" name="district_manager_id" required disabled>
                                    <option value="">Select District Manager</option>
                                </select>
                                @error('district_manager_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="upazila_supervisor_id" class="form-label">Upazila Supervisor <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('upazila_supervisor_id') is-invalid @enderror"
                                    id="upazila_supervisor_id" name="upazila_supervisor_id" required disabled>
                                    <option value="">Select Upazila Supervisor</option>
                                </select>
                                @error('upazila_supervisor_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="union_id" class="form-label">Union</label>
                                <select class="form-select @error('union_id') is-invalid @enderror" id="union_id"
                                    name="union_id" disabled>
                                    <option value="">Select Union (Optional)</option>
                                </select>
                                @error('union_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label for="pho_id" class="form-label">PHO <span class="text-danger">*</span></label>
                                <select class="form-select @error('pho_id') is-invalid @enderror" id="pho_id"
                                    name="pho_id" required disabled>
                                    <option value="">Select PHO</option>
                                </select>
                                @error('pho_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <input type="hidden" id="division_id" name="division_id">
                            <input type="hidden" id="district_id" name="district_id">
                            <input type="hidden" id="upzila_id" name="upzila_id">

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-2"></i>Create Customer
                                </button>
                                <a href="{{ route('superadmin.customers.index') }}" class="btn btn-secondary">
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
                                <i class="bi bi-1-circle text-info me-2"></i>
                                Select Divisional Chief first
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-2-circle text-info me-2"></i>
                                Then select District Manager
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-3-circle text-info me-2"></i>
                                Then select Upazila Supervisor
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-4-circle text-info me-2"></i>
                                Optionally select Union
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-5-circle text-info me-2"></i>
                                Finally select PHO
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-exclamation-triangle text-warning me-2"></i>
                                Customer will be created under the selected PHO
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
            const unionSelect = document.getElementById('union_id');
            const phoSelect = document.getElementById('pho_id');
            const divisionIdInput = document.getElementById('division_id');
            const districtIdInput = document.getElementById('district_id');
            const upzilaIdInput = document.getElementById('upzila_id');

            // When divisional chief changes, load district managers
            divisionalChiefSelect.addEventListener('change', function() {
                const divisionalChiefId = this.value;
                const selectedOption = this.options[this.selectedIndex];
                const divisionId = selectedOption.getAttribute('data-division-id');

                divisionIdInput.value = divisionId || '';

                // Reset downstream selects
                districtManagerSelect.innerHTML = '<option value="">Select District Manager</option>';
                upazilaSupervisorSelect.innerHTML = '<option value="">Select Upazila Supervisor</option>';
                unionSelect.innerHTML = '<option value="">Select Union (Optional)</option>';
                phoSelect.innerHTML = '<option value="">Select PHO</option>';
                districtManagerSelect.disabled = true;
                upazilaSupervisorSelect.disabled = true;
                unionSelect.disabled = true;
                phoSelect.disabled = true;
                districtIdInput.value = '';
                upzilaIdInput.value = '';

                if (divisionalChiefId) {
                    fetch(`/superadmin/get-district-managers/${divisionalChiefId}`)
                        .then(response => response.json())
                        .then(data => {
                            data.districtManagers.forEach(manager => {
                                const option = document.createElement('option');
                                option.value = manager.id;
                                option.textContent = manager.name;
                                option.setAttribute('data-district-id', manager.district_id);
                                districtManagerSelect.appendChild(option);
                            });
                            districtManagerSelect.disabled = false;
                        })
                        .catch(error => console.error('Error:', error));
                }
            });

            // When district manager changes, load upazila supervisors
            districtManagerSelect.addEventListener('change', function() {
                const districtManagerId = this.value;
                const selectedOption = this.options[this.selectedIndex];
                const districtId = selectedOption.getAttribute('data-district-id');

                districtIdInput.value = districtId || '';

                // Reset downstream selects
                upazilaSupervisorSelect.innerHTML = '<option value="">Select Upazila Supervisor</option>';
                unionSelect.innerHTML = '<option value="">Select Union (Optional)</option>';
                phoSelect.innerHTML = '<option value="">Select PHO</option>';
                upazilaSupervisorSelect.disabled = true;
                unionSelect.disabled = true;
                phoSelect.disabled = true;
                upzilaIdInput.value = '';

                if (districtManagerId) {
                    fetch(`/superadmin/get-upazila-supervisors/${districtManagerId}`)
                        .then(response => response.json())
                        .then(data => {
                            data.upazilaSupervisors.forEach(supervisor => {
                                const option = document.createElement('option');
                                option.value = supervisor.id;
                                option.textContent = supervisor.name;
                                option.setAttribute('data-upzila-id', supervisor.upzila_id);
                                option.setAttribute('data-division-id', supervisor.division_id);
                                option.setAttribute('data-district-id', supervisor.district_id);
                                upazilaSupervisorSelect.appendChild(option);
                            });
                            upazilaSupervisorSelect.disabled = false;
                        })
                        .catch(error => console.error('Error:', error));
                }
            });

            // When upazila supervisor changes, load unions and PHOs
            upazilaSupervisorSelect.addEventListener('change', function() {
                const upazilaSupervisorId = this.value;
                const selectedOption = this.options[this.selectedIndex];

                upzilaIdInput.value = selectedOption.getAttribute('data-upzila-id') || '';
                divisionIdInput.value = selectedOption.getAttribute('data-division-id') || '';
                districtIdInput.value = selectedOption.getAttribute('data-district-id') || '';

                // Reset downstream selects
                unionSelect.innerHTML = '<option value="">Select Union (Optional)</option>';
                phoSelect.innerHTML = '<option value="">Select PHO</option>';
                unionSelect.disabled = true;
                phoSelect.disabled = true;

                if (upazilaSupervisorId) {
                    const upzilaId = selectedOption.getAttribute('data-upzila-id');

                    // Load unions for this upazila
                    if (upzilaId) {
                        fetch(`/superadmin/get-unions/${upzilaId}`)
                            .then(response => response.json())
                            .then(data => {
                                data.unions.forEach(union => {
                                    const option = document.createElement('option');
                                    option.value = union.id;
                                    option.textContent = union.name;
                                    unionSelect.appendChild(option);
                                });
                                unionSelect.disabled = false;
                            })
                            .catch(error => console.error('Error:', error));
                    }

                    // Load PHOs for this upazila supervisor
                    fetch(`/superadmin/get-phos/${upazilaSupervisorId}`)
                        .then(response => response.json())
                        .then(data => {
                            data.phos.forEach(pho => {
                                const option = document.createElement('option');
                                option.value = pho.id;
                                option.textContent = pho.name;
                                phoSelect.appendChild(option);
                            });
                            phoSelect.disabled = false;
                        })
                        .catch(error => console.error('Error:', error));
                }
            });
        });
    </script>
@endpush

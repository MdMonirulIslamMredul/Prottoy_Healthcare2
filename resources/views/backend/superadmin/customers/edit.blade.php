@extends('backend.layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="mb-4">
            <h2>Edit Customer</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('superadmin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('superadmin.customers.index') }}">Customers</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="{{ route('superadmin.customers.update', $customer->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $customer->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address <span
                                        class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email', $customer->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">Password <small class="text-muted">(Leave blank
                                            to keep current)</small></label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    id="phone" name="phone" value="{{ old('phone', $customer->phone) }}"
                                    pattern="^01[3-9][0-9]{8}$" inputmode="tel" placeholder="e.g. 01712345678" required>
                                <div class="form-text text-muted">Accepts local 01XXXXXXXXX format only.</div>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3"
                                    placeholder="Enter full address">{{ old('address', $customer->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr class="my-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0">Location Information</h5>
                                <button type="button" class="btn btn-sm btn-outline-primary" id="changeLocationBtn">
                                    <i class="bi bi-pencil me-1"></i>Change Location & PHO
                                </button>
                            </div>

                            <div class="alert alert-info" id="locationAlert">
                                <i class="bi bi-info-circle me-2"></i>
                                Location and PHO assignment are locked. Click "Change Location & PHO" button to modify.
                            </div>

                            <div class="row" id="locationFieldsReadonly">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Division</label>
                                        <input type="text" class="form-control"
                                            value="{{ $customer->division->name ?? 'N/A' }}" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">District</label>
                                        <input type="text" class="form-control"
                                            value="{{ $customer->district->name ?? 'N/A' }}" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Upazila</label>
                                        <input type="text" class="form-control"
                                            value="{{ $customer->upzila->name ?? 'N/A' }}" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Union</label>
                                        <input type="text" class="form-control"
                                            value="{{ $customer->union->name ?? 'N/A' }}" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">PHO</label>
                                        <input type="text" class="form-control"
                                            value="{{ $customer->pho->name ?? 'N/A' }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div id="locationFieldsEditable" style="display: none;">
                                <div class="mb-3">
                                    <label for="divisional_chief_id" class="form-label">Divisional Chief <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="divisional_chief_id" name="divisional_chief_id">
                                        <option value="">Select Divisional Chief</option>
                                        @foreach ($divisionalChiefs as $chief)
                                            <option value="{{ $chief->id }}"
                                                data-division-id="{{ $chief->division_id }}">
                                                {{ $chief->name }} ({{ $chief->division->name ?? '' }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="district_manager_id" class="form-label">District Manager <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="district_manager_id" name="district_manager_id"
                                        disabled>
                                        <option value="">Select District Manager</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="upazila_supervisor_id" class="form-label">Upazila Supervisor <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="upazila_supervisor_id" name="upazila_supervisor_id"
                                        disabled>
                                        <option value="">Select Upazila Supervisor</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="union_id_select" class="form-label">Union</label>
                                    <select class="form-select" id="union_id_select" name="union_id_editable" disabled>
                                        <option value="">Select Union (Optional)</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="pho_id_select" class="form-label">PHO <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="pho_id_select" name="pho_id_editable" disabled>
                                        <option value="">Select PHO</option>
                                    </select>
                                </div>

                                <input type="hidden" id="division_id_editable" name="division_id_editable">
                                <input type="hidden" id="district_id_editable" name="district_id_editable">
                                <input type="hidden" id="upzila_id_editable" name="upzila_id_editable">
                            </div>

                            <input type="hidden" id="division_id" name="division_id"
                                value="{{ $customer->division_id }}">
                            <input type="hidden" id="district_id" name="district_id"
                                value="{{ $customer->district_id }}">
                            <input type="hidden" id="upzila_id" name="upzila_id" value="{{ $customer->upzila_id }}">
                            <input type="hidden" id="union_id" name="union_id" value="{{ $customer->union_id }}">
                            <input type="hidden" id="pho_id" name="pho_id" value="{{ $customer->pho_id }}">

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-2"></i>Update Customer
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
                            <i class="bi bi-info-circle text-primary me-2"></i>Current Information
                        </h5>
                        <hr>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <strong>Name:</strong><br>
                                {{ $customer->name }}
                            </li>
                            <li class="mb-2">
                                <strong>Email:</strong><br>
                                {{ $customer->email }}
                            </li>
                            <li class="mb-2">
                                <strong>Division:</strong><br>
                                {{ $customer->division->name ?? 'N/A' }}
                            </li>
                            <li class="mb-2">
                                <strong>District:</strong><br>
                                {{ $customer->district->name ?? 'N/A' }}
                            </li>
                            <li class="mb-2">
                                <strong>Upazila:</strong><br>
                                {{ $customer->upzila->name ?? 'N/A' }}
                            </li>
                            <li class="mb-2">
                                <strong>Union:</strong><br>
                                {{ $customer->union->name ?? 'N/A' }}
                            </li>
                            <li class="mb-2">
                                <strong>PHO:</strong><br>
                                {{ $customer->pho->name ?? 'N/A' }}
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
            const changeLocationBtn = document.getElementById('changeLocationBtn');
            const locationFieldsReadonly = document.getElementById('locationFieldsReadonly');
            const locationFieldsEditable = document.getElementById('locationFieldsEditable');
            const locationAlert = document.getElementById('locationAlert');

            const divisionalChiefSelect = document.getElementById('divisional_chief_id');
            const districtManagerSelect = document.getElementById('district_manager_id');
            const upazilaSupervisorSelect = document.getElementById('upazila_supervisor_id');
            const unionSelect = document.getElementById('union_id_select');
            const phoSelect = document.getElementById('pho_id_select');

            const divisionIdInput = document.getElementById('division_id');
            const districtIdInput = document.getElementById('district_id');
            const upzilaIdInput = document.getElementById('upzila_id');
            const unionIdInput = document.getElementById('union_id');
            const phoIdInput = document.getElementById('pho_id');

            const divisionIdEditableInput = document.getElementById('division_id_editable');
            const districtIdEditableInput = document.getElementById('district_id_editable');
            const upzilaIdEditableInput = document.getElementById('upzila_id_editable');

            let isLocationEditable = false;
            const currentData = {
                divisionId: '{{ $customer->division_id }}',
                districtId: '{{ $customer->district_id }}',
                upzilaId: '{{ $customer->upzila_id }}',
                unionId: '{{ $customer->union_id }}',
                phoId: '{{ $customer->pho_id }}'
            };

            // Change Location Button Click
            changeLocationBtn.addEventListener('click', function() {
                isLocationEditable = !isLocationEditable;

                if (isLocationEditable) {
                    locationFieldsReadonly.style.display = 'none';
                    locationFieldsEditable.style.display = 'block';
                    locationAlert.innerHTML =
                        '<i class="bi bi-exclamation-triangle me-2"></i>You are now editing location. Select hierarchy carefully.';
                    locationAlert.className = 'alert alert-warning';
                    changeLocationBtn.innerHTML = '<i class="bi bi-x-circle me-1"></i>Cancel Changes';
                    changeLocationBtn.className = 'btn btn-sm btn-outline-danger';

                    // Load initial data
                    loadInitialData();
                } else {
                    locationFieldsReadonly.style.display = 'block';
                    locationFieldsEditable.style.display = 'none';
                    locationAlert.innerHTML =
                        '<i class="bi bi-info-circle me-2"></i>Location and PHO assignment are locked. Click "Change Location & PHO" button to modify.';
                    locationAlert.className = 'alert alert-info';
                    changeLocationBtn.innerHTML = '<i class="bi bi-pencil me-1"></i>Change Location & PHO';
                    changeLocationBtn.className = 'btn btn-sm btn-outline-primary';

                    // Reset hidden fields to original values
                    divisionIdInput.value = currentData.divisionId;
                    districtIdInput.value = currentData.districtId;
                    upzilaIdInput.value = currentData.upzilaId;
                    unionIdInput.value = currentData.unionId;
                    phoIdInput.value = currentData.phoId;
                }
            });

            function loadInitialData() {
                // Find and select divisional chief by division
                Array.from(divisionalChiefSelect.options).forEach(option => {
                    if (option.getAttribute('data-division-id') == currentData.divisionId) {
                        divisionalChiefSelect.value = option.value;
                        const divisionalChiefId = option.value;

                        // Load district managers
                        fetch(`/superadmin/get-district-managers/${divisionalChiefId}`)
                            .then(response => response.json())
                            .then(data => {
                                districtManagerSelect.innerHTML =
                                    '<option value="">Select District Manager</option>';

                                data.districtManagers.forEach(manager => {
                                    const opt = document.createElement('option');
                                    opt.value = manager.id;
                                    opt.textContent = manager.name;
                                    opt.setAttribute('data-district-id', manager.district_id);

                                    if (manager.district_id == currentData.districtId) {
                                        opt.selected = true;
                                    }

                                    districtManagerSelect.appendChild(opt);
                                });

                                districtManagerSelect.disabled = false;

                                // Load upazila supervisors
                                const selectedManager = districtManagerSelect.value;
                                if (selectedManager) {
                                    loadUpazilaSupervisors(selectedManager);
                                }
                            });
                    }
                });
            }

            function loadUpazilaSupervisors(districtManagerId) {
                fetch(`/superadmin/get-upazila-supervisors/${districtManagerId}`)
                    .then(response => response.json())
                    .then(data => {
                        upazilaSupervisorSelect.innerHTML =
                            '<option value="">Select Upazila Supervisor</option>';

                        data.upazilaSupervisors.forEach(supervisor => {
                            const opt = document.createElement('option');
                            opt.value = supervisor.id;
                            opt.textContent = supervisor.name;
                            opt.setAttribute('data-upzila-id', supervisor.upzila_id);
                            opt.setAttribute('data-division-id', supervisor.division_id);
                            opt.setAttribute('data-district-id', supervisor.district_id);

                            if (supervisor.upzila_id == currentData.upzilaId) {
                                opt.selected = true;
                            }

                            upazilaSupervisorSelect.appendChild(opt);
                        });

                        upazilaSupervisorSelect.disabled = false;

                        // Load union and PHOs
                        const selectedSupervisor = upazilaSupervisorSelect.value;
                        if (selectedSupervisor) {
                            const selectedOpt = upazilaSupervisorSelect.options[upazilaSupervisorSelect
                                .selectedIndex];
                            const upzilaId = selectedOpt.getAttribute('data-upzila-id');
                            if (upzilaId) {
                                loadUnions(upzilaId);
                            }
                            loadPHOs(selectedSupervisor);
                        }
                    });
            }

            function loadUnions(upzilaId) {
                fetch(`/superadmin/get-unions/${upzilaId}`)
                    .then(response => response.json())
                    .then(data => {
                        unionSelect.innerHTML = '<option value="">Select Union (Optional)</option>';

                        data.unions.forEach(union => {
                            const opt = document.createElement('option');
                            opt.value = union.id;
                            opt.textContent = union.name;

                            if (union.id == currentData.unionId) {
                                opt.selected = true;
                            }

                            unionSelect.appendChild(opt);
                        });

                        unionSelect.disabled = false;
                    });
            }

            function loadPHOs(upazilaSupervisorId) {
                fetch(`/superadmin/get-phos/${upazilaSupervisorId}`)
                    .then(response => response.json())
                    .then(data => {
                        phoSelect.innerHTML = '<option value="">Select PHO</option>';

                        data.phos.forEach(pho => {
                            const opt = document.createElement('option');
                            opt.value = pho.id;
                            opt.textContent = pho.name;

                            if (pho.id == currentData.phoId) {
                                opt.selected = true;
                            }

                            phoSelect.appendChild(opt);
                        });

                        phoSelect.disabled = false;
                    });
            }

            // Event listeners for cascading dropdowns
            divisionalChiefSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const divisionId = selectedOption.getAttribute('data-division-id') || '';

                divisionIdInput.value = divisionId;
                divisionIdEditableInput.value = divisionId;

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
                unionIdInput.value = '';
                phoIdInput.value = '';

                if (this.value) {
                    fetch(`/superadmin/get-district-managers/${this.value}`)
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
                        });
                }
            });

            districtManagerSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const districtId = selectedOption.getAttribute('data-district-id') || '';

                districtIdInput.value = districtId;
                districtIdEditableInput.value = districtId;

                upazilaSupervisorSelect.innerHTML = '<option value="">Select Upazila Supervisor</option>';
                unionSelect.innerHTML = '<option value="">Select Union (Optional)</option>';
                phoSelect.innerHTML = '<option value="">Select PHO</option>';
                upazilaSupervisorSelect.disabled = true;
                unionSelect.disabled = true;
                phoSelect.disabled = true;

                upzilaIdInput.value = '';
                unionIdInput.value = '';
                phoIdInput.value = '';

                if (this.value) {
                    fetch(`/superadmin/get-upazila-supervisors/${this.value}`)
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
                        });
                }
            });

            upazilaSupervisorSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];

                upzilaIdInput.value = selectedOption.getAttribute('data-upzila-id') || '';
                upzilaIdEditableInput.value = selectedOption.getAttribute('data-upzila-id') || '';
                divisionIdInput.value = selectedOption.getAttribute('data-division-id') || '';
                districtIdInput.value = selectedOption.getAttribute('data-district-id') || '';

                unionSelect.innerHTML = '<option value="">Select Union (Optional)</option>';
                phoSelect.innerHTML = '<option value="">Select PHO</option>';
                unionSelect.disabled = true;
                phoSelect.disabled = true;
                unionIdInput.value = '';
                phoIdInput.value = '';

                if (this.value) {
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
                            });
                    }

                    fetch(`/superadmin/get-phos/${this.value}`)
                        .then(response => response.json())
                        .then(data => {
                            data.phos.forEach(pho => {
                                const option = document.createElement('option');
                                option.value = pho.id;
                                option.textContent = pho.name;
                                phoSelect.appendChild(option);
                            });
                            phoSelect.disabled = false;
                        });
                }
            });

            unionSelect.addEventListener('change', function() {
                unionIdInput.value = this.value;
            });

            phoSelect.addEventListener('change', function() {
                phoIdInput.value = this.value;
            });
        });
    </script>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const phoneInput = document.getElementById('phone');
            const phoneRegex = /^01[3-9][0-9]{8}$/;
            if (form && phoneInput) {
                form.addEventListener('submit', function(e) {
                    const val = phoneInput.value.trim();
                    if (val && !phoneRegex.test(val)) {
                        e.preventDefault();
                        phoneInput.classList.add('is-invalid');
                        let fb = phoneInput.parentElement.querySelector('.invalid-feedback');
                        if (!fb) {
                            fb = document.createElement('div');
                            fb.className = 'invalid-feedback';
                            phoneInput.parentElement.appendChild(fb);
                        }
                        fb.textContent =
                            'Please enter a valid Bangladeshi phone number in 01XXXXXXXXX format (e.g. 01712345678).';
                        phoneInput.focus();
                    }
                });
                phoneInput.addEventListener('input', function() {
                    if (phoneInput.classList.contains('is-invalid')) phoneInput.classList.remove(
                        'is-invalid');
                });
            }
        });
    </script>
@endpush

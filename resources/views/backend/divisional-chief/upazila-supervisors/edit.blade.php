@extends('backend.layouts.app')

@section('title', 'Edit Upazila Supervisor')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Edit Upazila Supervisor</h2>
        <a href="{{ route('divisionalchief.upazila-supervisors.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('divisionalchief.upazila-supervisors.update', $upazilaSupervisor->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name', $upazilaSupervisor->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email', $upazilaSupervisor->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                   id="phone" name="phone" value="{{ old('phone', $upazilaSupervisor->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="district_id" class="form-label">Select District <span class="text-danger">*</span></label>
                            <select class="form-select @error('district_id') is-invalid @enderror"
                                    id="district_id" name="district_id" required>
                                <option value="">-- Select District --</option>
                                @foreach($districts as $district)
                                    <option value="{{ $district->id }}"
                                            {{ old('district_id', $upazilaSupervisor->district_id) == $district->id ? 'selected' : '' }}>
                                        {{ $district->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('district_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="upzila_id" class="form-label">Select Upazila <span class="text-danger">*</span></label>
                            <select class="form-select @error('upzila_id') is-invalid @enderror"
                                    id="upzila_id" name="upzila_id" required>
                                <option value="">-- Select District First --</option>
                            </select>
                            @error('upzila_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Each upazila can have only one supervisor</small>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Division (Readonly)</label>
                            <input type="text" class="form-control"
                                   value="{{ $upazilaSupervisor->division->name ?? 'N/A' }}"
                                   readonly>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <hr>
                        <h5 class="mb-3">Change Password (Optional)</h5>
                        <p class="text-muted small">Leave blank to keep current password</p>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control"
                                   id="password_confirmation" name="password_confirmation">
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('divisionalchief.upazila-supervisors.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Update Upazila Supervisor
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
const currentUpzilaId = {{ $upazilaSupervisor->upzila_id }};

document.getElementById('district_id').addEventListener('change', function() {
    loadUpzilas(this.value);
});

// Load upzilas on page load
document.addEventListener('DOMContentLoaded', function() {
    const districtId = document.getElementById('district_id').value;
    if (districtId) {
        loadUpzilas(districtId, currentUpzilaId);
    }
});

function loadUpzilas(districtId, selectedUpzilaId = null) {
    const upzilaSelect = document.getElementById('upzila_id');

    upzilaSelect.innerHTML = '<option value="">-- Loading... --</option>';

    if (districtId) {
        fetch(`/divisional-chief/get-upzilas/${districtId}`)
            .then(response => response.json())
            .then(data => {
                upzilaSelect.innerHTML = '<option value="">-- Select Upazila --</option>';
                data.forEach(upzila => {
                    const option = document.createElement('option');
                    option.value = upzila.id;
                    option.textContent = upzila.name;
                    if (selectedUpzilaId && upzila.id == selectedUpzilaId) {
                        option.selected = true;
                    }
                    upzilaSelect.appendChild(option);
                });
            });
    } else {
        upzilaSelect.innerHTML = '<option value="">-- Select District First --</option>';
    }
}
</script>
@endsection

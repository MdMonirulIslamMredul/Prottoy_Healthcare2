@extends('backend.layouts.app')

@section('title', 'Add New Upazila Supervisor')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Add New Upazila Supervisor</h2>
        <a href="{{ route('divisionalchief.upazila-supervisors.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('divisionalchief.upazila-supervisors.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                   id="phone" name="phone" value="{{ old('phone') }}">
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
                                            {{ old('district_id') == $district->id ? 'selected' : '' }}>
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
                            <label class="form-label">Division (Inherited)</label>
                            <input type="text" class="form-control"
                                   value="{{ $divisionalChief->division->name ?? 'N/A' }}"
                                   readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control"
                                   id="password_confirmation" name="password_confirmation" required>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('divisionalchief.upazila-supervisors.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Create Upazila Supervisor
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('district_id').addEventListener('change', function() {
    const districtId = this.value;
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
                    upzilaSelect.appendChild(option);
                });
            });
    } else {
        upzilaSelect.innerHTML = '<option value="">-- Select District First --</option>';
    }
});
</script>
@endsection

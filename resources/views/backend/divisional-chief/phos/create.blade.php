@extends('backend.layouts.app')

@section('title', 'Add New PHO')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Add New PHO</h2>
        <a href="{{ route('divisionalchief.phos.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('divisionalchief.phos.store') }}" method="POST">
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
                            <label for="upazila_supervisor_id" class="form-label">Select Upazila Supervisor <span class="text-danger">*</span></label>
                            <select class="form-select @error('upazila_supervisor_id') is-invalid @enderror"
                                    id="upazila_supervisor_id" name="upazila_supervisor_id" required>
                                <option value="">-- Select Upazila Supervisor --</option>
                                @foreach($upazilaSupervisors as $supervisor)
                                    <option value="{{ $supervisor->id }}"
                                            {{ old('upazila_supervisor_id') == $supervisor->id ? 'selected' : '' }}>
                                        {{ $supervisor->name }} - {{ $supervisor->district->name ?? 'N/A' }} - {{ $supervisor->upzila->name ?? 'N/A' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('upazila_supervisor_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Division (Inherited)</label>
                            <input type="text" class="form-control"
                                   value="{{ $divisionalChief->division->name ?? 'N/A' }}"
                                   readonly>
                            <small class="text-muted">Location details will be inherited from selected supervisor</small>
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
                    <a href="{{ route('divisionalchief.phos.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Create PHO
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

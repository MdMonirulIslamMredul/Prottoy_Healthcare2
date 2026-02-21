@extends('backend.layouts.app')

@section('title', 'Add New Customer')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Add New Customer</h2>
            <a href="{{ route('divisionalchief.customers.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to List
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('divisionalchief.customers.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name <span
                                        class="text-danger">*</span></label>
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
                                <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    id="phone" name="phone" value="{{ old('phone') }}" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3"
                                    placeholder="Enter full address">{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pho_id" class="form-label">Select PHO <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('pho_id') is-invalid @enderror" id="pho_id"
                                    name="pho_id" required>
                                    <option value="">-- Select PHO --</option>
                                    @foreach ($phos as $pho)
                                        <option value="{{ $pho->id }}" data-upzila-id="{{ $pho->upzila_id }}"
                                            {{ old('pho_id') == $pho->id ? 'selected' : '' }}>
                                            {{ $pho->name }} - {{ $pho->district->name ?? 'N/A' }} -
                                            {{ $pho->upzila->name ?? 'N/A' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('pho_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="union_id" class="form-label">Union <span
                                        class="text-muted">(Optional)</span></label>
                                <select class="form-select @error('union_id') is-invalid @enderror" id="union_id"
                                    name="union_id">
                                    <option value="">Select Union (Optional)</option>
                                </select>
                                @error('union_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Division (Inherited)</label>
                                <input type="text" class="form-control"
                                    value="{{ $divisionalChief->division->name ?? 'N/A' }}" readonly>
                                <small class="text-muted">Location details will be inherited from selected PHO</small>
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
                                <label for="password_confirmation" class="form-label">Confirm Password <span
                                        class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" required>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('divisionalchief.customers.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Create Customer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const phoSelect = document.getElementById('pho_id');
            const unionSelect = document.getElementById('union_id');

            // Function to load unions based on upzila
            function loadUnions(upzilaId) {
                if (!upzilaId) {
                    unionSelect.innerHTML = '<option value="">Select Union (Optional)</option>';
                    return;
                }

                fetch('{{ route('superadmin.filter-unions', ':upzila') }}'.replace(':upzila', upzilaId))
                    .then(response => response.json())
                    .then(data => {
                        let html = '<option value="">Select Union (Optional)</option>';
                        data.forEach(union => {
                            const selected = '{{ old('union_id') }}' === union.id.toString() ?
                                'selected' : '';
                            html += `<option value="${union.id}" ${selected}>${union.name}</option>`;
                        });
                        unionSelect.innerHTML = html;
                    })
                    .catch(error => console.error('Error loading unions:', error));
            }

            // Load unions when PHO is selected
            phoSelect.addEventListener('change', function() {
                const upzilaId = this.options[this.selectedIndex].getAttribute('data-upzila-id');
                loadUnions(upzilaId);
            });

            // Load unions on page load if PHO is already selected
            if (phoSelect.value) {
                const upzilaId = phoSelect.options[phoSelect.selectedIndex].getAttribute('data-upzila-id');
                loadUnions(upzilaId);
            }
        });
    </script>
@endsection

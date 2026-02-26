@extends('backend.layouts.app')

@section('title', 'Add New Customer')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Add New Customer</h2>
            <a href="{{ route('pho.customers.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to List
            </a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('pho.customers.store') }}" method="POST">
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
                                <label class="form-label">Location (Inherited from PHO)</label>
                                <input type="text" class="form-control"
                                    value="{{ $pho->upzila->name ?? 'N/A' }}, {{ $pho->district->name ?? 'N/A' }}, {{ $pho->division->name ?? 'N/A' }}"
                                    readonly>
                                <small class="text-muted">Customer will be created under your location</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="union_id" class="form-label">Union <span
                                        class="text-muted">(Optional)</span></label>
                                <select class="form-select @error('union_id') is-invalid @enderror" id="union_id"
                                    name="union_id">
                                    <option value="">Select Union (Optional)</option>
                                    @if ($pho->upzila)
                                        @foreach ($pho->upzila->unions as $union)
                                            <option value="{{ $union->id }}"
                                                {{ old('union_id') == $union->id ? 'selected' : '' }}>
                                                {{ $union->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('union_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="word_id" class="form-label">Word <span
                                        class="text-muted">(Optional)</span></label>
                                <select id="word_id" name="word_id"
                                    class="form-select @error('word_id') is-invalid @enderror" disabled
                                    data-url="{{ url('pho/get-words') }}">
                                    <option value="">Select Word (Optional)</option>
                                </select>
                                @error('word_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
                        <a href="{{ route('pho.customers.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create Customer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const unionSelect = document.getElementById('union_id');
                const wordSelect = document.getElementById('word_id');
                const baseUrl = wordSelect ? wordSelect.dataset.url : null;

                function clearWords() {
                    wordSelect.innerHTML = '<option value="">Select Word (Optional)</option>';
                    wordSelect.disabled = true;
                }

                if (!unionSelect || !wordSelect || !baseUrl) return;

                // Pre-populate if old value exists
                const oldUnion = '{{ old('union_id') }}';
                const oldWord = '{{ old('word_id') }}';
                if (oldUnion) {
                    fetch(`${baseUrl}/${oldUnion}`)
                        .then(res => res.json())
                        .then(data => {
                            if (data.words && data.words.length) {
                                data.words.forEach(w => {
                                    const opt = document.createElement('option');
                                    opt.value = w.id;
                                    opt.textContent = w.name;
                                    if (String(w.id) === String(oldWord)) opt.selected = true;
                                    wordSelect.appendChild(opt);
                                });
                                wordSelect.disabled = false;
                            }
                        }).catch(clearWords);
                }

                unionSelect.addEventListener('change', function() {
                    const unionId = this.value;
                    clearWords();
                    if (!unionId) return;
                    fetch(`${baseUrl}/${unionId}`)
                        .then(res => res.json())
                        .then(data => {
                            if (data.words && data.words.length) {
                                data.words.forEach(w => {
                                    const opt = document.createElement('option');
                                    opt.value = w.id;
                                    opt.textContent = w.name;
                                    wordSelect.appendChild(opt);
                                });
                                wordSelect.disabled = false;
                            }
                        }).catch(clearWords);
                });
            });
        </script>
    @endpush
@endsection

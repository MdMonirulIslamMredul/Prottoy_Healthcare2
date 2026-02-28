@extends('backend.layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Customers</h2>
            <a href="{{ route('superadmin.customers.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>Add New Customer
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                {{-- Filters: Division -> District -> Upzila -> Union -> Word --}}
                <form method="GET" id="filterForm" class="mb-3">
                    <div class="row g-2 align-items-end">
                        <div class="col-6 col-md-2">
                            <label class="form-label">Division</label>
                            <select name="division_id" class="form-select" id="divisionSelect">
                                <option value="">All</option>
                                @foreach ($divisions as $division)
                                    <option value="{{ $division->id }}"
                                        {{ request('division_id') == $division->id ? 'selected' : '' }}>
                                        {{ $division->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-6 col-md-2">
                            <label class="form-label">District</label>
                            <select name="district_id" class="form-select" id="districtSelect">
                                <option value="">All</option>
                                @foreach ($districts as $district)
                                    <option value="{{ $district->id }}"
                                        {{ request('district_id') == $district->id ? 'selected' : '' }}>
                                        {{ $district->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-6 col-md-2">
                            <label class="form-label">Upzila</label>
                            <select name="upzila_id" class="form-select" id="upzilaSelect">
                                <option value="">All</option>
                                @foreach ($upzilas as $upzila)
                                    <option value="{{ $upzila->id }}"
                                        {{ request('upzila_id') == $upzila->id ? 'selected' : '' }}>{{ $upzila->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-6 col-md-2">
                            <label class="form-label">Union</label>
                            <select name="union_id" class="form-select" id="unionSelect">
                                <option value="">All</option>
                                @foreach ($unions as $union)
                                    <option value="{{ $union->id }}"
                                        {{ request('union_id') == $union->id ? 'selected' : '' }}>{{ $union->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-6 col-md-2">
                            <label class="form-label">Word</label>
                            <select name="word_id" class="form-select" id="wordSelect">
                                <option value="">All</option>
                                @foreach ($words as $word)
                                    <option value="{{ $word->id }}"
                                        {{ request('word_id') == $word->id ? 'selected' : '' }}>{{ $word->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="{{ route('superadmin.customers.index') }}"
                                class="btn btn-outline-secondary ms-1">Reset</a>
                        </div>
                    </div>
                </form>

                {{-- Desktop table (md and up) --}}

                {{-- AJAX: auto-load words and auto-submit on word selection --}}
                @push('scripts')
                    <script>
                        (function() {
                            const divisionSelect = document.getElementById('divisionSelect');
                            const districtSelect = document.getElementById('districtSelect');
                            const upzilaSelect = document.getElementById('upzilaSelect');
                            const unionSelect = document.getElementById('unionSelect');
                            const wordSelect = document.getElementById('wordSelect');
                            const filterForm = document.getElementById('filterForm');
                            if (!filterForm) return;

                            function fetchAndPopulate(url, selectEl, placeholder = 'All') {
                                selectEl.innerHTML = `<option value="">${placeholder}</option>`;
                                fetch(url, {
                                        headers: {
                                            'X-Requested-With': 'XMLHttpRequest'
                                        }
                                    })
                                    .then(r => r.json())
                                    .then(data => {
                                        if (!Array.isArray(data)) {
                                            // some endpoints return object wrappers
                                            data = data.districts || data.upzilas || data.unions || data.words || data;
                                        }
                                        (data || []).forEach(item => {
                                            const opt = document.createElement('option');
                                            opt.value = item.id;
                                            opt.textContent = item.name;
                                            selectEl.appendChild(opt);
                                        });
                                    })
                                    .catch(() => {});
                            }

                            if (divisionSelect) {
                                divisionSelect.addEventListener('change', function() {
                                    const divisionId = this.value;
                                    // clear downstream
                                    districtSelect && (districtSelect.innerHTML = '<option value="">All</option>');
                                    upzilaSelect && (upzilaSelect.innerHTML = '<option value="">All</option>');
                                    unionSelect && (unionSelect.innerHTML = '<option value="">All</option>');
                                    wordSelect && (wordSelect.innerHTML = '<option value="">All</option>');
                                    if (!divisionId) return;
                                    const url = '{{ route('superadmin.get-districts', ['division' => ':id']) }}'.replace(':id',
                                        divisionId);
                                    fetchAndPopulate(url, districtSelect, 'All');
                                });
                            }

                            if (districtSelect) {
                                districtSelect.addEventListener('change', function() {
                                    const districtId = this.value;
                                    upzilaSelect && (upzilaSelect.innerHTML = '<option value="">All</option>');
                                    unionSelect && (unionSelect.innerHTML = '<option value="">All</option>');
                                    wordSelect && (wordSelect.innerHTML = '<option value="">All</option>');
                                    if (!districtId) return;
                                    const url = '{{ route('superadmin.get-upzilas', ['district' => ':id']) }}'.replace(':id',
                                        districtId);
                                    fetchAndPopulate(url, upzilaSelect, 'All');
                                });
                            }

                            if (upzilaSelect) {
                                upzilaSelect.addEventListener('change', function() {
                                    const upzilaId = this.value;
                                    unionSelect && (unionSelect.innerHTML = '<option value="">All</option>');
                                    wordSelect && (wordSelect.innerHTML = '<option value="">All</option>');
                                    if (!upzilaId) return;
                                    const url = '{{ route('superadmin.get-unions', ['upazila' => ':id']) }}'.replace(':id',
                                        upzilaId);
                                    fetchAndPopulate(url, unionSelect, 'All');
                                });
                            }

                            if (unionSelect) {
                                unionSelect.addEventListener('change', function() {
                                    const unionId = this.value;
                                    wordSelect && (wordSelect.innerHTML = '<option value="">All</option>');
                                    if (!unionId) return;
                                    const url = '{{ route('superadmin.get-words', ['union' => ':id']) }}'.replace(':id',
                                        unionId);
                                    fetchAndPopulate(url, wordSelect, 'All');
                                });
                            }

                            if (wordSelect) {
                                wordSelect.addEventListener('change', function() {
                                    // auto-submit when a word selected or cleared
                                    filterForm.submit();
                                });
                            }
                        })();
                    </script>
                @endpush
                <div class="table-responsive d-none d-md-block">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Location</th>
                                <th>PHO</th>
                                <th>Packages</th>
                                <th>Total</th>
                                <th>Paid</th>
                                <th>Due</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customers as $index => $customer)
                                <tr>
                                    <td style="width:60px"> #{{ $customer->id }}</td>
                                    <td style="min-width:120px">{{ $customer->name }}</td>
                                    <td style="min-width:220px">{{ $customer->email }}</td>
                                    <td>
                                        {{ $customer->union->name ?? 'N/A' }}, {{ $customer->upzila->name ?? 'N/A' }},
                                        {{ $customer->district->name ?? 'N/A' }}
                                    </td>
                                    <td>{{ $customer->pho->name ?? 'N/A' }}</td>
                                    <td><span class="badge bg-primary">{{ $customer->package_purchases_count ?? 0 }}</span>
                                    </td>
                                    <td>৳{{ number_format($customer->package_purchases_sum_total_price ?? 0, 0) }}</td>
                                    <td class="text-success">
                                        ৳{{ number_format($customer->package_purchases_sum_paid_amount ?? 0, 0) }}</td>
                                    <td class="text-danger">
                                        ৳{{ number_format($customer->package_purchases_sum_due_amount ?? 0, 0) }}</td>
                                    <td style="white-space:nowrap">
                                        <a href="{{ route('superadmin.customers.show', $customer->id) }}"
                                            class="btn btn-sm btn-outline-info me-1">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('superadmin.customers.edit', $customer->id) }}"
                                            class="btn btn-sm btn-outline-primary me-1">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('superadmin.customers.destroy', $customer->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Are you sure you want to delete this customer?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                        No customers found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Mobile stacked cards --}}
                <div class="d-block d-md-none">
                    @forelse($customers as $index => $customer)
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5 class="mb-1">{{ $customer->name }}</h5>
                                        <div class="text-muted small">{{ $customer->email }}</div>
                                        <div class="text-muted small">{{ $customer->upzila->name ?? 'N/A' }},
                                            {{ $customer->district->name ?? 'N/A' }}</div>
                                    </div>
                                    <div class="text-end">
                                        <div><span
                                                class="badge bg-primary">{{ $customer->package_purchases_count ?? 0 }}</span>
                                        </div>
                                        <div class="mt-2">
                                            <a href="{{ route('superadmin.customers.show', $customer->id) }}"
                                                class="btn btn-sm btn-outline-info me-1">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('superadmin.customers.edit', $customer->id) }}"
                                                class="btn btn-sm btn-outline-primary me-1">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('superadmin.customers.destroy', $customer->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Are you sure you want to delete this customer?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between small">
                                    <div>Total:
                                        <strong>৳{{ number_format($customer->package_purchases_sum_total_price ?? 0, 0) }}</strong>
                                    </div>
                                    <div class="text-success">Paid:
                                        <strong>৳{{ number_format($customer->package_purchases_sum_paid_amount ?? 0, 0) }}</strong>
                                    </div>
                                    <div class="text-danger">Due:
                                        <strong>৳{{ number_format($customer->package_purchases_sum_due_amount ?? 0, 0) }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            No customers found
                        </div>
                    @endforelse
                </div>

                @if ($customers->hasPages())
                    <div class="mt-3">
                        {{ $customers->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

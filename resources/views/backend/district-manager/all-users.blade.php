@extends('backend.layouts.app')

@section('title', 'All Users')
@section('page-title', 'All Users')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-0">All Users</h2>
                    <p class="text-muted mb-0">View and filter all users in the system</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="bi bi-funnel text-primary me-2"></i>Filter Users
                    </h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('districtmanager.all-users') }}" id="filterForm">
                        <div class="row g-3">
                            <!-- Upazila Filter -->
                            <div class="col-md-4">
                                <label for="upzila_id" class="form-label">Upazila</label>
                                <select name="upzila_id" id="upzila_id" class="form-select">
                                    <option value="">All Upazilas</option>
                                    @foreach($upzilas as $upzila)
                                        <option value="{{ $upzila->id }}" {{ request('upzila_id') == $upzila->id ? 'selected' : '' }}>
                                            {{ $upzila->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- PHO Filter -->
                            <div class="col-md-4">
                                <label for="pho_id" class="form-label">PHO</label>
                                <select name="pho_id" id="pho_id" class="form-select">
                                    <option value="">All PHOs</option>
                                    @foreach($phos as $pho)
                                        <option value="{{ $pho->id }}" {{ request('pho_id') == $pho->id ? 'selected' : '' }}>
                                            {{ $pho->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Role Filter -->
                            <div class="col-md-4">
                                <label for="role" class="form-label">Role</label>
                                <select name="role" id="role" class="form-select">
                                    <option value="">All Roles</option>
                                    <option value="divisional_chief" {{ request('role') == 'divisional_chief' ? 'selected' : '' }}>Divisional Chief</option>
                                    <option value="district_manager" {{ request('role') == 'district_manager' ? 'selected' : '' }}>District Manager</option>
                                    <option value="upazila_supervisor" {{ request('role') == 'upazila_supervisor' ? 'selected' : '' }}>Upazila Supervisor</option>
                                    <option value="pho" {{ request('role') == 'pho' ? 'selected' : '' }}>PHO</option>
                                    <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                                </select>
                            </div>

                            <!-- Action Buttons -->
                            <div class="col-md-12 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="bi bi-search me-1"></i>Apply Filters
                                </button>
                                <a href="{{ route('districtmanager.all-users') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle me-1"></i>Clear Filters
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            Users List
                            <span class="badge bg-primary ms-2">{{ $users->total() }} users</span>
                        </h5>
                        @if($users->count() > 0)
                            <a href="{{ route('districtmanager.generate-users-report', request()->all()) }}" class="btn btn-danger btn-sm" target="_blank">
                                <i class="bi bi-file-pdf me-1"></i>Generate PDF Report
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($users->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="px-4">ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Role</th>
                                        <th>Division</th>
                                        <th>District</th>
                                        <th>Upazila</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td class="px-4">#{{ $user->id }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-person-circle fs-4 text-muted me-2"></i>
                                                    <span>{{ $user->name }}</span>
                                                </div>
                                            </td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->phone ?? '-' }}</td>
                                            <td>
                                                @php
                                                    $roleColors = [
                                                        'divisional_chief' => 'primary',
                                                        'district_manager' => 'success',
                                                        'upazila_supervisor' => 'info',
                                                        'pho' => 'warning',
                                                        'customer' => 'secondary'
                                                    ];
                                                    $color = $roleColors[$user->role] ?? 'secondary';
                                                @endphp
                                                <span class="badge bg-{{ $color }}">
                                                    {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                                </span>
                                            </td>
                                            <td>{{ $user->division->name ?? '-' }}</td>
                                            <td>{{ $user->district->name ?? '-' }}</td>
                                            <td>{{ $user->upzila->name ?? '-' }}</td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ $user->created_at->format('M d, Y') }}
                                                </small>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="p-3">
                            {{ $users->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-inbox fs-1 text-muted"></i>
                            <p class="text-muted mt-2">No users found matching your filters</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const upzilaSelect = document.getElementById('upzila_id');
    const phoSelect = document.getElementById('pho_id');

    // When upazila changes, load PHOs
    upzilaSelect.addEventListener('change', function() {
        const upzilaId = this.value;

        // Reset PHO dropdown
        phoSelect.innerHTML = '<option value="">All PHOs</option>';

        if (upzilaId) {
            fetch(`/districtmanager/filter-phos/${upzilaId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(pho => {
                        const option = document.createElement('option');
                        option.value = pho.id;
                        option.textContent = pho.name;
                        phoSelect.appendChild(option);
                    });
                });
        }
    });
});
</script>
@endpush

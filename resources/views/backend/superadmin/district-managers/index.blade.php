@extends('backend.layouts.app')

@section('title', 'District Managers')
@section('page-title', 'District Managers Management')

@section('content')
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">District Managers</h4>
                    <a href="{{ route('superadmin.district-managers.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i>Add District Manager
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        @if ($districtManagers->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="px-4">ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Division</th>
                                            <th>District</th>
                                            <th>Created At</th>
                                            <th class="text-end pe-4">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($districtManagers as $manager)
                                            <tr>
                                                <td class="px-4">#{{ $manager->id }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-sm me-2">
                                                            <i class="bi bi-person-badge fs-4 text-success"></i>
                                                        </div>
                                                        <span class="fw-semibold">{{ $manager->name }}</span>
                                                    </div>
                                                </td>
                                                <td>{{ $manager->email }}</td>
                                                <td>
                                                    @if ($manager->division)
                                                        <span class="badge bg-info">
                                                            {{ $manager->division->name }}
                                                        </span>
                                                    @else
                                                        <span class="text-muted">N/A</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($manager->district)
                                                        <span class="badge bg-success">
                                                            <i class="bi bi-geo-alt me-1"></i>{{ $manager->district->name }}
                                                        </span>
                                                    @else
                                                        <span class="text-muted">Not Assigned</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <small class="text-muted">
                                                        <i class="bi bi-clock me-1"></i>
                                                        {{ $manager->created_at->format('M d, Y') }}
                                                    </small>
                                                </td>
                                                <td class="text-end pe-4">
                                                    <a href="{{ route('superadmin.district-managers.show', $manager) }}"
                                                        class="btn btn-sm btn-light" title="View">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="{{ route('superadmin.district-managers.edit', $manager) }}"
                                                        class="btn btn-sm btn-light" title="Edit">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form
                                                        action="{{ route('superadmin.district-managers.destroy', $manager) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('Are you sure you want to delete this District Manager?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-light text-danger"
                                                            title="Delete">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="p-3 border-top">
                                {{ $districtManagers->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-inbox fs-1 text-muted"></i>
                                <p class="text-muted mt-2">No District Managers found</p>
                                <a href="{{ route('superadmin.district-managers.create') }}" class="btn btn-primary">
                                    <i class="bi bi-plus-circle me-1"></i>Add First District Manager
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

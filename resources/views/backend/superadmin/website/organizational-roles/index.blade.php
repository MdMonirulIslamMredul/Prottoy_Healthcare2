@extends('backend.layouts.app')

@section('title', 'Organizational Roles Management')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Organizational Roles</h4>
            <p class="text-muted mb-0">Manage hierarchy and role descriptions</p>
        </div>
        <a href="{{ route('superadmin.website.organizational-roles.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Add New Role
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;">Level</th>
                            <th>Title</th>
                            <th>Subtitle</th>
                            <th style="width: 80px;">Icon</th>
                            <th style="width: 100px">Order</th>
                            <th style="width: 100px;">Status</th>
                            <th style="width: 150px;" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $role)
                            <tr>
                                <td>
                                    <span class="badge bg-secondary">{{ $role->level }}</span>
                                </td>
                                <td>
                                    <strong>{{ $role->title }}</strong>
                                </td>
                                <td class="text-muted small">{{ Str::limit($role->subtitle, 40) }}</td>
                                <td class="text-center">
                                    @if($role->icon)
                                        <i class="{{ $role->icon }} fs-4" style="color: {{ $role->color_start }};"></i>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $role->order }}</td>
                                <td>
                                    @if($role->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('superadmin.website.organizational-roles.edit', $role) }}"
                                           class="btn btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('superadmin.website.organizational-roles.destroy', $role) }}"
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this role?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox display-4 d-block mb-3"></i>
                                    <p>No organizational roles found. <a href="{{ route('superadmin.website.organizational-roles.create') }}">Add one now</a></p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($roles->hasPages())
            <div class="card-footer">
                {{ $roles->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@extends('backend.layouts.app')

@section('title', 'Divisional Chiefs')
@section('page-title', 'Divisional Chiefs Management')

@section('content')
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Divisional Chiefs</h4>
                    <a href="{{ route('superadmin.divisional-chiefs.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i>Add Divisional Chief
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-0">
                        @if ($divisionalChiefs->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="px-4">ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Division</th>
                                            <th>Created At</th>
                                            <th class="text-end pe-4">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($divisionalChiefs as $chief)
                                            <tr>
                                                <td class="px-4">#{{ $chief->id }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-sm me-2">
                                                            <i class="bi bi-person-badge fs-4 text-primary"></i>
                                                        </div>
                                                        <span class="fw-semibold">{{ $chief->name }}</span>
                                                    </div>
                                                </td>
                                                <td>{{ $chief->email }}</td>
                                                <td>
                                                    @if ($chief->division)
                                                        <span class="badge bg-info">
                                                            <i class="bi bi-geo-alt me-1"></i>{{ $chief->division->name }}
                                                        </span>
                                                    @else
                                                        <span class="text-muted">Not Assigned</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <small class="text-muted">
                                                        <i class="bi bi-clock me-1"></i>
                                                        {{ $chief->created_at->format('M d, Y') }}
                                                    </small>
                                                </td>
                                                <td class="text-end pe-4">
                                                    <a href="{{ route('superadmin.divisional-chiefs.show', $chief) }}"
                                                        class="btn btn-sm btn-light" title="View">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="{{ route('superadmin.divisional-chiefs.edit', $chief) }}"
                                                        class="btn btn-sm btn-light" title="Edit">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form
                                                        action="{{ route('superadmin.divisional-chiefs.destroy', $chief) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('Are you sure you want to delete this Divisional Chief?');">
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
                                {{ $divisionalChiefs->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-inbox fs-1 text-muted"></i>
                                <p class="text-muted mt-2">No Divisional Chiefs found</p>
                                <a href="{{ route('superadmin.divisional-chiefs.create') }}" class="btn btn-primary">
                                    <i class="bi bi-plus-circle me-1"></i>Add First Divisional Chief
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

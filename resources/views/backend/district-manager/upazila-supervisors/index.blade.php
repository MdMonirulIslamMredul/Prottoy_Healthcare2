@extends('backend.layouts.app')

@section('title', 'Upazila Supervisors Management')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Upazila Supervisors Management</h2>
        <a href="{{ route('districtmanager.upazila-supervisors.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add New Upazila Supervisor
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
            @if($upazilaSupervisors->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Upazila</th>
                                <th>PHOs</th>
                                <th>Created</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($upazilaSupervisors as $supervisor)
                                <tr>
                                    <td><strong>{{ $supervisor->name }}</strong></td>
                                    <td>{{ $supervisor->email }}</td>
                                    <td>{{ $supervisor->phone ?? 'N/A' }}</td>
                                    <td>
                                        <small class="text-muted">{{ $supervisor->upzila->name ?? 'N/A' }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $supervisor->phos->count() }} PHOs</span>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $supervisor->created_at->format('d M, Y') }}</small>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('districtmanager.upazila-supervisors.edit', $supervisor->id) }}"
                                           class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <form action="{{ route('districtmanager.upazila-supervisors.destroy', $supervisor->id) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this supervisor?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $upazilaSupervisors->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-pin-map-fill text-muted" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-3">No Upazila Supervisors found.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

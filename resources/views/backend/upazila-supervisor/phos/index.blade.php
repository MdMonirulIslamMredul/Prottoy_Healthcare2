@extends('backend.layouts.app')

@section('title', 'PHOs Management')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>PHOs Management</h2>
        <a href="{{ route('upazilasupervisor.phos.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add New PHO
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
            @if($phos->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Location</th>
                                <th>Customers</th>
                                <th>Created</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($phos as $pho)
                                <tr>
                                    <td>
                                        <strong>{{ $pho->name }}</strong>
                                    </td>
                                    <td>{{ $pho->email }}</td>
                                    <td>{{ $pho->phone ?? 'N/A' }}</td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $pho->upzila->name ?? 'N/A' }},
                                            {{ $pho->district->name ?? 'N/A' }},
                                            {{ $pho->division->name ?? 'N/A' }}
                                        </small>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $pho->customers->count() }} Customers</span>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $pho->created_at->format('d M, Y') }}</small>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('upazilasupervisor.phos.edit', $pho->id) }}"
                                           class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <form action="{{ route('upazilasupervisor.phos.destroy', $pho->id) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this PHO?');">
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
                    {{ $phos->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-person-vcard text-muted" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-3">No PHOs found. Click "Add New PHO" to create one.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@extends('backend.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>PHOs (Prottoy Health Officers)</h2>
        <a href="{{ route('superadmin.phos.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Add New PHO
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
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Division</th>
                            <th>District</th>
                            <th>Upazila</th>
                            <th>Supervisor</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($phos as $index => $pho)
                            <tr>
                                <td>{{ $phos->firstItem() + $index }}</td>
                                <td>{{ $pho->name }}</td>
                                <td>{{ $pho->email }}</td>
                                <td>{{ $pho->division->name ?? 'N/A' }}</td>
                                <td>{{ $pho->district->name ?? 'N/A' }}</td>
                                <td>{{ $pho->upzila->name ?? 'N/A' }}</td>
                                <td>{{ $pho->upazilaSupervisor->name ?? 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('superadmin.phos.edit', $pho->id) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('superadmin.phos.destroy', $pho->id) }}"
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Are you sure you want to delete this PHO?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    No PHOs found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($phos->hasPages())
                <div class="mt-3">
                    {{ $phos->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

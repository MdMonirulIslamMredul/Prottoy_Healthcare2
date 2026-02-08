@extends('backend.layouts.app')

@section('title', 'Leadership Team')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-people me-2"></i>Leadership Team</h2>
        <a href="{{ route('superadmin.website.leadership.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Add Team Member
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 8%">Order</th>
                            <th style="width: 12%">Photo</th>
                            <th style="width: 20%">Name</th>
                            <th style="width: 20%">Designation</th>
                            <th style="width: 15%">Contact</th>
                            <th style="width: 15%">Bio</th>
                            <th style="width: 8%">Status</th>
                            <th style="width: 10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leaderships as $leader)
                            <tr>
                                <td><span class="badge bg-secondary">{{ $leader->order }}</span></td>
                                <td>
                                    @if($leader->photo)
                                        <img src="{{ asset('storage/' . $leader->photo) }}"
                                             alt="{{ $leader->name }}"
                                             class="rounded-circle"
                                             style="width: 60px; height: 60px; object-fit: cover;">
                                    @else
                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                                             style="width: 60px; height: 60px;">
                                            <i class="bi bi-person fs-3 text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $leader->name }}</strong>
                                </td>
                                <td>{{ $leader->designation }}</td>
                                <td>
                                    @if($leader->email)
                                        <small><i class="bi bi-envelope me-1"></i>{{ $leader->email }}</small><br>
                                    @endif
                                    @if($leader->phone)
                                        <small><i class="bi bi-telephone me-1"></i>{{ $leader->phone }}</small>
                                    @endif
                                    @if(!$leader->email && !$leader->phone)
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($leader->bio)
                                        <small class="text-muted">{{ Str::limit($leader->bio, 50) }}</small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $leader->is_active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $leader->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('superadmin.website.leadership.edit', $leader->id) }}"
                                           class="btn btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('superadmin.website.leadership.destroy', $leader->id) }}"
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Delete"
                                                    onclick="return confirm('Remove this team member?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-5">
                                    <i class="bi bi-people fs-1 d-block mb-3"></i>
                                    <h5>No Leadership Team Members</h5>
                                    <p>Add your organization's leadership team</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($leaderships->hasPages())
                <div class="mt-3">
                    {{ $leaderships->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

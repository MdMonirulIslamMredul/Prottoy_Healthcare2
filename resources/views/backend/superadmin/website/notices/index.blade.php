@extends('backend.layouts.app')

@section('title', 'Notices - Website Settings')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2>Notices Management</h2>
        <p class="text-muted">Manage important notices and announcements</p>
    </div>
    <a href="{{ route('superadmin.website.notices.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Add Notice
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-body">
        @if($notices->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th style="width: 120px;">Type</th>
                            <th style="width: 120px;">Published Date</th>
                            <th style="width: 100px;" class="text-center">Status</th>
                            <th style="width: 150px;" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($notices as $notice)
                            <tr>
                                <td>
                                    <strong>{{ $notice->title }}</strong>
                                    <div class="text-muted small">
                                        {{ Str::limit($notice->content, 100) }}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge
                                        @if($notice->type == 'emergency') bg-danger
                                        @elseif($notice->type == 'announcement') bg-primary
                                        @elseif($notice->type == 'event') bg-success
                                        @else bg-secondary
                                        @endif">
                                        {{ ucfirst($notice->type) }}
                                    </span>
                                </td>
                                <td>{{ $notice->published_at ? $notice->published_at->format('M d, Y') : 'Not set' }}</td>
                                <td class="text-center">
                                    @if($notice->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('superadmin.website.notices.edit', $notice) }}"
                                       class="btn btn-sm btn-outline-primary"
                                       title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('superadmin.website.notices.destroy', $notice) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this notice?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $notices->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-megaphone" style="font-size: 3rem; color: #ccc;"></i>
                <p class="text-muted mt-3">No notices found. Start by adding your first notice.</p>
                <a href="{{ route('superadmin.website.notices.create') }}" class="btn btn-primary mt-2">
                    <i class="bi bi-plus-circle me-2"></i>Add Notice
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

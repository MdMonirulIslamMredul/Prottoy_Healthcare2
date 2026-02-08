@extends('backend.layouts.app')

@section('title', 'Notices Management')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Notices Management</h2>
        <a href="{{ route('superadmin.notices.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Add New Notice
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%">SL</th>
                            <th style="width: 25%">Title</th>
                            <th style="width: 35%">Content</th>
                            <th style="width: 10%">Type</th>
                            <th style="width: 10%">Status</th>
                            <th style="width: 10%">Published</th>
                            <th style="width: 5%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($notices as $index => $notice)
                            <tr>
                                <td>{{ $notices->firstItem() + $index }}</td>
                                <td>
                                    <strong>{{ $notice->title }}</strong>
                                </td>
                                <td>
                                    {{ Str::limit($notice->content, 80) }}
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
                                <td>
                                    <form action="{{ route('superadmin.notices.toggle-status', $notice->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm {{ $notice->is_active ? 'btn-success' : 'btn-secondary' }}" title="Click to toggle status">
                                            @if($notice->is_active)
                                                <i class="bi bi-check-circle-fill"></i> Active
                                            @else
                                                <i class="bi bi-x-circle-fill"></i> Inactive
                                            @endif
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $notice->published_at ? $notice->published_at->format('M d, Y') : 'Not set' }}
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('superadmin.notices.edit', $notice->id) }}"
                                           class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('superadmin.notices.destroy', $notice->id) }}"
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"
                                                    onclick="return confirm('Are you sure you want to delete this notice?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    No notices found. Create your first notice!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($notices->hasPages())
                <div class="mt-3">
                    {{ $notices->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

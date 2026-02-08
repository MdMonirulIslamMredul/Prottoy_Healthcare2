@extends('backend.layouts.app')

@section('title', 'News & Events - Website Settings')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2>News & Events</h2>
        <p class="text-muted">Manage news articles and upcoming events</p>
    </div>
    <a href="{{ route('superadmin.website.news-events.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Add News/Event
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
        @if($newsEvents->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th style="width: 80px;">Image</th>
                            <th>Title</th>
                            <th style="width: 120px;">Published Date</th>
                            <th style="width: 80px;" class="text-center">Order</th>
                            <th style="width: 100px;" class="text-center">Status</th>
                            <th style="width: 150px;" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($newsEvents as $newsEvent)
                            <tr>
                                <td>
                                    @if($newsEvent->image)
                                        <img src="{{ asset('storage/' . $newsEvent->image) }}"
                                             alt="{{ $newsEvent->title }}"
                                             class="img-thumbnail"
                                             style="width: 60px; height: 60px; object-fit: cover;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center"
                                             style="width: 60px; height: 60px;">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $newsEvent->title }}</strong>
                                    <div class="text-muted small">
                                        {{ Str::limit(strip_tags($newsEvent->content), 80) }}
                                    </div>
                                </td>
                                <td>{{ $newsEvent->published_at->format('M d, Y') }}</td>
                                <td class="text-center">{{ $newsEvent->order }}</td>
                                <td class="text-center">
                                    @if($newsEvent->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('superadmin.website.news-events.edit', $newsEvent) }}"
                                       class="btn btn-sm btn-outline-primary"
                                       title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('superadmin.website.news-events.destroy', $newsEvent) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this news/event?');">
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
                {{ $newsEvents->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-newspaper" style="font-size: 3rem; color: #ccc;"></i>
                <p class="text-muted mt-3">No news or events found. Start by adding your first item.</p>
                <a href="{{ route('superadmin.website.news-events.create') }}" class="btn btn-primary mt-2">
                    <i class="bi bi-plus-circle me-2"></i>Add News/Event
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

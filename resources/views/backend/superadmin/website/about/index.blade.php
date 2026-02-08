@extends('backend.layouts.app')

@section('title', 'About Content')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-info-square me-2"></i>About Us Content</h2>
        <a href="{{ route('superadmin.website.about.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Add New Content
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 15%">Type</th>
                            <th style="width: 20%">Title</th>
                            <th style="width: 40%">Content</th>
                            <th style="width: 10%">Image</th>
                            <th style="width: 8%">Status</th>
                            <th style="width: 7%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contents as $content)
                            <tr>
                                <td>
                                    <span class="badge
                                        @if($content->type == 'mission') bg-primary
                                        @elseif($content->type == 'vision') bg-success
                                        @else bg-info
                                        @endif">
                                        {{ ucfirst($content->type) }}
                                    </span>
                                </td>
                                <td><strong>{{ $content->title }}</strong></td>
                                <td>
                                    <p class="mb-0 text-muted small">{{ Str::limit($content->content, 120) }}</p>
                                </td>
                                <td>
                                    @if($content->image)
                                        <img src="{{ asset('storage/' . $content->image) }}"
                                             alt="{{ $content->title }}"
                                             class="img-thumbnail"
                                             style="width: 60px; height: 60px; object-fit: cover;">
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $content->is_active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $content->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('superadmin.website.about.edit', $content->id) }}"
                                           class="btn btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('superadmin.website.about.destroy', $content->id) }}"
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Delete"
                                                    onclick="return confirm('Delete this content?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <i class="bi bi-info-square fs-1 d-block mb-3"></i>
                                    <h5>No About Content</h5>
                                    <p>Add Mission, Vision, and About Us content</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($contents->hasPages())
                <div class="mt-3">
                    {{ $contents->links() }}
                </div>
            @endif
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="alert alert-info">
                <h6><i class="bi bi-lightbulb me-2"></i>Content Types</h6>
                <ul class="mb-0 small">
                    <li><strong>Mission:</strong> Your organization's purpose</li>
                    <li><strong>Vision:</strong> Your long-term goals</li>
                    <li><strong>About:</strong> General company information</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

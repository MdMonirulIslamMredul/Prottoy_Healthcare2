@extends('backend.layouts.app')

@section('title', 'Policies & Legal')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-file-text me-2"></i>Policies & Legal Documents</h2>
        <a href="{{ route('superadmin.website.policies.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Add New Policy
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="list-group">
                @forelse($policies as $policy)
                    <div class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="badge bg-secondary me-2">{{ $policy->order }}</span>
                                    <h5 class="mb-0">{{ $policy->title }}</h5>
                                    <span class="badge {{ $policy->is_active ? 'bg-success' : 'bg-secondary' }} ms-2">
                                        {{ $policy->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                                <p class="mb-2 text-muted">{{ Str::limit($policy->content, 150) }}</p>
                                <small class="text-muted">
                                    <i class="bi bi-link-45deg me-1"></i>
                                    Slug: <code>{{ $policy->slug }}</code>
                                </small>
                                <small class="text-muted ms-3">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    Updated: {{ $policy->updated_at->format('M d, Y') }}
                                </small>
                            </div>
                            <div class="btn-group btn-group-sm ms-3">
                                <a href="{{ route('superadmin.website.policies.edit', $policy->id) }}"
                                   class="btn btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('superadmin.website.policies.destroy', $policy->id) }}"
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" title="Delete"
                                            onclick="return confirm('Delete this policy?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-file-text fs-1 d-block mb-3"></i>
                        <h5>No Policies Added</h5>
                        <p>Create policy documents like Privacy Policy, Terms of Service, etc.</p>
                        <a href="{{ route('superadmin.website.policies.create') }}" class="btn btn-primary mt-2">
                            <i class="bi bi-plus-circle me-2"></i>Add First Policy
                        </a>
                    </div>
                @endforelse
            </div>

            @if($policies->hasPages())
                <div class="mt-4">
                    {{ $policies->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    .list-group-item {
        border-left: 4px solid transparent;
        transition: all 0.3s ease;
    }
    .list-group-item:hover {
        border-left-color: #667eea;
        transform: translateX(5px);
    }
</style>
@endpush
@endsection

@extends('backend.layouts.app')

@section('title', 'Manage Services')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-briefcase me-2"></i>Our Services</h2>
        <a href="{{ route('superadmin.website.services.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Add New Service
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @forelse($services as $service)
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            @if($service->image)
                                <img src="{{ asset('storage/' . $service->image) }}" class="card-img-top" alt="{{ $service->title }}"
                                     style="height: 200px; object-fit: cover;">
                            @else
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                    @if($service->icon)
                                        <i class="{{ $service->icon }} display-4 text-primary"></i>
                                    @else
                                        <i class="bi bi-briefcase display-4 text-muted"></i>
                                    @endif
                                </div>
                            @endif
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title">{{ $service->title }}</h5>
                                    <span class="badge {{ $service->is_active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $service->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                                <p class="card-text text-muted small">{{ Str::limit($service->description, 100) }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge bg-secondary">Order: {{ $service->order }}</span>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('superadmin.website.services.edit', $service->id) }}"
                                           class="btn btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('superadmin.website.services.destroy', $service->id) }}"
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Delete"
                                                    onclick="return confirm('Are you sure?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center text-muted py-5">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            <p>No services found. Add your first service!</p>
                        </div>
                    </div>
                @endforelse
            </div>

            @if($services->hasPages())
                <div class="mt-4">
                    {{ $services->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

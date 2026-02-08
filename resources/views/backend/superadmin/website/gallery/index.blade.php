@extends('backend.layouts.app')

@section('title', 'Manage Gallery')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-images me-2"></i>Gallery Management</h2>
        <a href="{{ route('superadmin.website.gallery.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Add New Image
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">
                @forelse($images as $image)
                    <div class="col">
                        <div class="card h-100 shadow-sm position-relative">
                            <img src="{{ asset('storage/' . $image->image) }}"
                                 class="card-img-top" alt="{{ $image->title }}"
                                 style="height: 200px; object-fit: cover;">

                            <span class="position-absolute top-0 end-0 m-2">
                                <span class="badge {{ $image->is_active ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $image->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </span>

                            @if($image->category)
                                <span class="position-absolute top-0 start-0 m-2">
                                    <span class="badge bg-primary">{{ $image->category }}</span>
                                </span>
                            @endif

                            <div class="card-body p-2">
                                <h6 class="card-title mb-1 small">{{ Str::limit($image->title, 30) }}</h6>
                                @if($image->description)
                                    <p class="card-text text-muted" style="font-size: 0.75rem;">
                                        {{ Str::limit($image->description, 50) }}
                                    </p>
                                @endif
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <small class="text-muted">Order: {{ $image->order }}</small>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('superadmin.website.gallery.edit', $image->id) }}"
                                           class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('superadmin.website.gallery.destroy', $image->id) }}"
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"
                                                    onclick="return confirm('Delete this image?')">
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
                            <i class="bi bi-images fs-1 d-block mb-3"></i>
                            <h5>No Images in Gallery</h5>
                            <p>Start building your gallery by adding images</p>
                            <a href="{{ route('superadmin.website.gallery.create') }}" class="btn btn-primary mt-2">
                                <i class="bi bi-plus-circle me-2"></i>Add First Image
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            @if($images->hasPages())
                <div class="mt-4">
                    {{ $images->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    .card-img-top {
        transition: transform 0.3s ease;
    }
    .card:hover .card-img-top {
        transform: scale(1.05);
    }
    .card {
        overflow: hidden;
    }
</style>
@endpush
@endsection

@extends('backend.layouts.app')

@section('title', 'Manage Hero Sliders')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-image me-2"></i>Hero Sliders</h2>
        <a href="{{ route('superadmin.website.sliders.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Add New Slide
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%">Order</th>
                            <th style="width: 15%">Image</th>
                            <th style="width: 25%">Title</th>
                            <th style="width: 30%">Subtitle</th>
                            <th style="width: 10%">Button</th>
                            <th style="width: 8%">Status</th>
                            <th style="width: 7%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sliders as $slider)
                            <tr>
                                <td><span class="badge bg-secondary">{{ $slider->order }}</span></td>
                                <td>
                                    @if($slider->image)
                                        <img src="{{ asset('storage/' . $slider->image) }}" alt="{{ $slider->title }}"
                                             class="img-thumbnail" style="width: 100px; height: 60px; object-fit: cover;">
                                    @else
                                        <div class="bg-light text-center py-3" style="width: 100px;">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td><strong>{{ $slider->title }}</strong></td>
                                <td>{{ Str::limit($slider->subtitle, 60) }}</td>
                                <td>
                                    @if($slider->button_text)
                                        <span class="badge bg-info">{{ $slider->button_text }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $slider->is_active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $slider->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('superadmin.website.sliders.edit', $slider->id) }}"
                                           class="btn btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('superadmin.website.sliders.destroy', $slider->id) }}"
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Delete"
                                                    onclick="return confirm('Are you sure you want to delete this slider?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    <p>No sliders found. Create your first hero slide!</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($sliders->hasPages())
                <div class="mt-3">
                    {{ $sliders->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

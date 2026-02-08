@extends('backend.layouts.app')

@section('title', 'Testimonials Management')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Testimonials Management</h2>
        <a href="{{ route('superadmin.testimonials.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Add New Testimonial
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%">SL</th>
                            <th style="width: 10%">Photo</th>
                            <th style="width: 15%">Customer</th>
                            <th style="width: 40%">Testimonial</th>
                            <th style="width: 10%">Rating</th>
                            <th style="width: 10%">Status</th>
                            <th style="width: 10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($testimonials as $index => $testimonial)
                            <tr>
                                <td>{{ $testimonials->firstItem() + $index }}</td>
                                <td>
                                    @if($testimonial->customer_photo)
                                        <img src="{{ asset('storage/' . $testimonial->customer_photo) }}"
                                             alt="{{ $testimonial->customer_name }}"
                                             class="rounded-circle"
                                             style="width: 50px; height: 50px; object-fit: cover;">
                                    @else
                                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                                             style="width: 50px; height: 50px; background: #f8f9fa;">
                                            <i class="bi bi-person-circle" style="font-size: 2rem; color: #6c757d;"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $testimonial->customer_name }}</strong>
                                    @if($testimonial->customer_designation)
                                        <br><small class="text-muted">{{ $testimonial->customer_designation }}</small>
                                    @endif
                                </td>
                                <td>
                                    <em>"{{ Str::limit($testimonial->testimonial, 100) }}"</em>
                                </td>
                                <td>
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $testimonial->rating)
                                            <i class="bi bi-star-fill text-warning"></i>
                                        @else
                                            <i class="bi bi-star text-warning"></i>
                                        @endif
                                    @endfor
                                    <br><small class="text-muted">{{ $testimonial->rating }}/5</small>
                                </td>
                                <td>
                                    <form action="{{ route('superadmin.testimonials.toggle-status', $testimonial->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm {{ $testimonial->is_active ? 'btn-success' : 'btn-secondary' }}" title="Click to toggle status">
                                            @if($testimonial->is_active)
                                                <i class="bi bi-check-circle-fill"></i> Active
                                            @else
                                                <i class="bi bi-x-circle-fill"></i> Inactive
                                            @endif
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('superadmin.testimonials.edit', $testimonial->id) }}"
                                           class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('superadmin.testimonials.destroy', $testimonial->id) }}"
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"
                                                    onclick="return confirm('Are you sure you want to delete this testimonial?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="bi bi-chat-quote fs-1 d-block mb-2"></i>
                                    No testimonials found. Create your first testimonial!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($testimonials->hasPages())
                <div class="mt-3">
                    {{ $testimonials->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

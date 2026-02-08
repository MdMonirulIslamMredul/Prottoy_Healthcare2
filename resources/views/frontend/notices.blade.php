@extends('frontend.layouts.app')

@section('title', 'Notices')
@section('meta_description', 'View all important notices and announcements from Prottoy Healthcare')

@section('styles')
<style>
    .page-header {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: white;
        padding: 80px 0 60px;
        margin-bottom: 60px;
    }

    .page-header h1 {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 1rem;
    }

    .page-header p {
        font-size: 1.3rem;
        opacity: 0.95;
    }

    .notice-card {
        transition: all 0.3s ease;
        border: none;
        border-left: 5px solid transparent;
        margin-bottom: 1.5rem;
        cursor: pointer;
    }

    .notice-card:hover {
        transform: translateX(10px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        border-left-color: #dc3545;
    }

    .notice-card.emergency {
        border-left-color: #dc3545;
        background: #fff5f5;
    }

    .notice-card.announcement {
        border-left-color: #0d6efd;
        background: #f0f7ff;
    }

    .notice-card.event {
        border-left-color: #198754;
        background: #f0fdf4;
    }

    .notice-card .card-body {
        padding: 2rem;
    }

    .notice-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 1rem;
    }

    .notice-badge {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-block;
        margin-bottom: 1rem;
    }

    .notice-content {
        color: #555;
        line-height: 1.8;
        margin-bottom: 1.5rem;
    }

    .notice-details {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 8px;
        border-left: 4px solid #667eea;
        line-height: 1.8;
    }

    .notice-details h1,
    .notice-details h2,
    .notice-details h3,
    .notice-details h4 {
        color: #333;
        margin-top: 1.5rem;
        margin-bottom: 1rem;
    }

    .notice-details ul,
    .notice-details ol {
        margin-left: 1.5rem;
        margin-bottom: 1rem;
    }

    .notice-details p {
        margin-bottom: 1rem;
    }

    .notice-meta {
        display: flex;
        gap: 2rem;
        color: #6c757d;
        font-size: 0.9rem;
    }

    .notice-meta i {
        margin-right: 0.5rem;
    }

    .breadcrumb {
        background: transparent;
        padding: 0;
        margin: 0;
    }

    .breadcrumb-item + .breadcrumb-item::before {
        color: rgba(255, 255, 255, 0.7);
    }

    .breadcrumb-item a {
        color: rgba(255, 255, 255, 0.9);
        text-decoration: none;
    }

    .breadcrumb-item a:hover {
        color: white;
    }

    .breadcrumb-item.active {
        color: white;
    }

    .pagination {
        margin-top: 3rem;
    }

    .page-link {
        color: #dc3545;
        border: 1px solid #dee2e6;
        padding: 0.5rem 1rem;
    }

    .page-link:hover {
        color: #c82333;
        background-color: #f8f9fa;
        border-color: #dee2e6;
    }

    .page-item.active .page-link {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .search-filter-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        padding: 2rem;
        margin-bottom: 3rem;
    }

    .search-filter-card .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
    }

    .search-filter-card .form-control,
    .search-filter-card .form-select {
        border-radius: 8px;
        border: 1px solid #dee2e6;
        padding: 0.75rem 1rem;
    }

    .search-filter-card .form-control:focus,
    .search-filter-card .form-select:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }

    .btn-search {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        border: none;
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-search:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
        color: white;
    }

    .btn-clear {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        color: #6c757d;
        padding: 0.75rem 2rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-clear:hover {
        background: #e9ecef;
        color: #495057;
    }

    .filter-tabs {
        margin-bottom: 2rem;
        border-bottom: 2px solid #dee2e6;
    }

    .filter-tabs .nav-link {
        color: #6c757d;
        font-weight: 600;
        padding: 1rem 1.5rem;
        border: none;
        border-bottom: 3px solid transparent;
        transition: all 0.3s ease;
    }

    .filter-tabs .nav-link:hover {
        color: #333;
        border-bottom-color: #dee2e6;
    }

    .filter-tabs .nav-link.active {
        color: #dc3545;
        border-bottom-color: #dc3545;
        background: transparent;
    }

    @media (max-width: 768px) {
        .page-header h1 {
            font-size: 2rem;
        }

        .page-header p {
            font-size: 1.1rem;
        }

        .notice-card .card-body {
            padding: 1.5rem;
        }

        .notice-title {
            font-size: 1.2rem;
        }

        .notice-meta {
            flex-direction: column;
            gap: 0.5rem;
        }
    }
</style>
@endsection

@section('content')
<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('frontend.home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Notices</li>
            </ol>
        </nav>
        <h1>Important Notices</h1>
        <p>Stay informed with our official announcements and important updates</p>
    </div>
</section>

<!-- Search & Filter Section -->
<section class="py-5">
    <div class="container">
        <div class="search-filter-card">
            <form action="{{ route('frontend.notices') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="search" class="form-label">
                            <i class="bi bi-search me-1"></i>Search Notices
                        </label>
                        <input type="text"
                               class="form-control"
                               id="search"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Search by title or content...">
                    </div>
                    <div class="col-md-2">
                        <label for="type" class="form-label">
                            <i class="bi bi-funnel me-1"></i>Type
                        </label>
                        <select class="form-select" id="type" name="type">
                            <option value="">All Types</option>
                            <option value="emergency" {{ request('type') == 'emergency' ? 'selected' : '' }}>Emergency</option>
                            <option value="announcement" {{ request('type') == 'announcement' ? 'selected' : '' }}>Announcement</option>
                            <option value="event" {{ request('type') == 'event' ? 'selected' : '' }}>Event</option>
                            <option value="general" {{ request('type') == 'general' ? 'selected' : '' }}>General</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="date_from" class="form-label">
                            <i class="bi bi-calendar-event me-1"></i>From Date
                        </label>
                        <input type="date"
                               class="form-control"
                               id="date_from"
                               name="date_from"
                               value="{{ request('date_from') }}">
                    </div>
                    <div class="col-md-2">
                        <label for="date_to" class="form-label">
                            <i class="bi bi-calendar-check me-1"></i>To Date
                        </label>
                        <input type="date"
                               class="form-control"
                               id="date_to"
                               name="date_to"
                               value="{{ request('date_to') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label d-block">&nbsp;</label>
                        <button type="submit" class="btn btn-search w-100">
                            <i class="bi bi-funnel me-1"></i>Filter
                        </button>
                    </div>
                </div>
                @if(request()->hasAny(['search', 'type', 'date_from', 'date_to']))
                    <div class="row mt-3">
                        <div class="col-12">
                            <a href="{{ route('frontend.notices') }}" class="btn btn-clear">
                                <i class="bi bi-x-circle me-1"></i>Clear Filters
                            </a>
                            <span class="ms-3 text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                Showing filtered results
                                @if(request('search'))
                                    for "<strong>{{ request('search') }}</strong>"
                                @endif
                                @if(request('type'))
                                    in <strong>{{ ucfirst(request('type')) }}</strong> notices
                                @endif
                            </span>
                        </div>
                    </div>
                @endif
            </form>
        </div>

        @if($notices->count() > 0)
            <div class="row">
                <div class="col-lg-12">
                    @foreach($notices as $notice)
                    <div class="card notice-card shadow-sm {{ strtolower($notice->type) }}">
                        <div class="card-body">
                            <span class="notice-badge
                                @if($notice->type == 'emergency') bg-danger text-white
                                @elseif($notice->type == 'announcement') bg-primary text-white
                                @elseif($notice->type == 'event') bg-success text-white
                                @else bg-secondary text-white
                                @endif">
                                <i class="bi
                                    @if($notice->type == 'emergency') bi-exclamation-triangle
                                    @elseif($notice->type == 'announcement') bi-megaphone
                                    @elseif($notice->type == 'event') bi-calendar-event
                                    @else bi-info-circle
                                    @endif me-1"></i>
                                {{ ucfirst($notice->type) }}
                            </span>

                            <h2 class="notice-title">{{ $notice->title }}</h2>

                            <div class="notice-content">
                                {{ $notice->content }}
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div class="notice-meta">
                                    <span>
                                        <i class="bi bi-calendar3"></i>
                                        Published: {{ $notice->published_at->format('F d, Y') }}
                                    </span>
                                    <span>
                                        <i class="bi bi-clock"></i>
                                        {{ $notice->published_at->diffForHumans() }}
                                    </span>
                                </div>
                                <a href="{{ route('frontend.notice.show', $notice->id) }}" class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-arrow-right-circle me-1"></i>View Details
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $notices->links() }}
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-megaphone text-muted" style="font-size: 5rem;"></i>
                <h3 class="mt-4 text-muted">No Notices Available</h3>
                <p class="text-muted">Please check back later for important announcements.</p>
                <a href="{{ route('frontend.home') }}" class="btn btn-danger mt-3">
                    <i class="bi bi-house me-2"></i>Back to Home
                </a>
            </div>
        @endif
    </div>
</section>

<!-- Quick Stats -->
@if($notices->count() > 0)
<section class="py-5" style="background: #f8f9fa;">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4">
                <div class="stat-item">
                    <h3 class="text-danger">{{ $notices->total() }}</h3>
                    <p class="text-muted mb-0">Total Notices</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-item">
                    <h3 class="text-primary">{{ \App\Models\Notice::where('type', 'announcement')->count() }}</h3>
                    <p class="text-muted mb-0">Announcements</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-item">
                    <h3 class="text-success">{{ \App\Models\Notice::where('type', 'event')->count() }}</h3>
                    <p class="text-muted mb-0">Events</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="py-5" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white;">
    <div class="container text-center">
        <h2 class="mb-3">Need More Information?</h2>
        <p class="mb-4" style="font-size: 1.1rem;">Contact our support team for assistance</p>
        <a href="{{ route('frontend.home') }}" class="btn btn-light btn-lg me-2">
            <i class="bi bi-house me-2"></i>Homepage
        </a>
        <a href="{{ route('frontend.customer-service') }}" class="btn btn-outline-light btn-lg">
            <i class="bi bi-headset me-2"></i>Customer Service
        </a>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Make notice cards clickable
        document.querySelectorAll('.notice-card').forEach(card => {
            card.addEventListener('click', function(e) {
                // Don't trigger if clicking on the button directly
                if (!e.target.closest('.btn')) {
                    const link = this.querySelector('a.btn');
                    if (link) {
                        window.location.href = link.href;
                    }
                }
            });
        });
    });
</script>
@endpush

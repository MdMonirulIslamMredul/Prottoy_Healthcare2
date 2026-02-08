@extends('frontend.layouts.app')

@section('title', 'News & Events')
@section('meta_description', 'Stay updated with the latest news and events from Prottoy Healthcare')

@section('styles')
<style>
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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

    .news-card {
        transition: all 0.3s ease;
        border: none;
        height: 100%;
        cursor: pointer;
    }

    .news-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15) !important;
    }

    .news-card .card-img-top {
        height: 250px;
        object-fit: cover;
    }

    .news-card .card-body {
        display: flex;
        flex-direction: column;
    }

    .news-card .card-title {
        font-weight: 700;
        color: #333;
        font-size: 1.3rem;
        line-height: 1.4;
        margin-bottom: 1rem;
    }

    .news-card .card-text {
        flex-grow: 1;
        color: #6c757d;
        line-height: 1.6;
    }

    .news-date {
        font-size: 0.9rem;
        color: #667eea;
        font-weight: 600;
        margin-top: auto;
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
        color: #667eea;
        border: 1px solid #dee2e6;
        padding: 0.5rem 1rem;
    }

    .page-link:hover {
        color: #764ba2;
        background-color: #f8f9fa;
        border-color: #dee2e6;
    }

    .page-item.active .page-link {
        background-color: #667eea;
        border-color: #667eea;
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

    .search-filter-card .form-control {
        border-radius: 8px;
        border: 1px solid #dee2e6;
        padding: 0.75rem 1rem;
    }

    .search-filter-card .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .btn-search {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-search:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
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

    @media (max-width: 768px) {
        .page-header h1 {
            font-size: 2rem;
        }

        .page-header p {
            font-size: 1.1rem;
        }

        .news-card .card-img-top {
            height: 200px;
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
                <li class="breadcrumb-item active" aria-current="page">News & Events</li>
            </ol>
        </nav>
        <h1>News & Events</h1>
        <p>Stay informed with our latest updates, announcements, and upcoming events</p>
    </div>
</section>

<!-- Search & Filter Section -->
<section class="py-5">
    <div class="container">
        <div class="search-filter-card">
            <form action="{{ route('frontend.news-events') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="search" class="form-label">
                            <i class="bi bi-search me-1"></i>Search News & Events
                        </label>
                        <input type="text"
                               class="form-control"
                               id="search"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Search by title or content...">
                    </div>
                    <div class="col-md-3">
                        <label for="date_from" class="form-label">
                            <i class="bi bi-calendar-event me-1"></i>From Date
                        </label>
                        <input type="date"
                               class="form-control"
                               id="date_from"
                               name="date_from"
                               value="{{ request('date_from') }}">
                    </div>
                    <div class="col-md-3">
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
                @if(request()->hasAny(['search', 'date_from', 'date_to']))
                    <div class="row mt-3">
                        <div class="col-12">
                            <a href="{{ route('frontend.news-events') }}" class="btn btn-clear">
                                <i class="bi bi-x-circle me-1"></i>Clear Filters
                            </a>
                            <span class="ms-3 text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                Showing filtered results
                                @if(request('search'))
                                    for "<strong>{{ request('search') }}</strong>"
                                @endif
                            </span>
                        </div>
                    </div>
                @endif
            </form>
        </div>

        @if($newsEvents->count() > 0)
            <div class="row g-4">
                @foreach($newsEvents as $newsEvent)
                <div class="col-lg-4 col-md-6">
                    <div class="card news-card shadow-sm">
                        @if($newsEvent->image)
                            <img src="{{ asset('storage/' . $newsEvent->image) }}"
                                 alt="{{ $newsEvent->title }}"
                                 class="card-img-top">
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center">
                                <i class="bi bi-newspaper text-muted" style="font-size: 4rem;"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $newsEvent->title }}</h5>
                            <p class="card-text">
                                {{ Str::limit(strip_tags($newsEvent->content), 150) }}
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="news-date">
                                    <i class="bi bi-calendar3 me-2"></i>{{ $newsEvent->published_at->format('F d, Y') }}
                                </div>
                                <a href="{{ route('frontend.news-event.show', $newsEvent->id) }}" class="btn btn-sm btn-primary">
                                    Read More <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $newsEvents->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-newspaper text-muted" style="font-size: 5rem;"></i>
                <h3 class="mt-4 text-muted">No News or Events Available</h3>
                <p class="text-muted">Please check back later for updates.</p>
                <a href="{{ route('frontend.home') }}" class="btn btn-primary mt-3">
                    <i class="bi bi-house me-2"></i>Back to Home
                </a>
            </div>
        @endif
    </div>
</section>

<!-- CTA Section -->
<section class="py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
    <div class="container text-center">
        <h2 class="mb-3">Stay Updated</h2>
        <p class="mb-4" style="font-size: 1.1rem;">Don't miss out on our latest news and announcements</p>
        <a href="{{ route('frontend.home') }}" class="btn btn-light btn-lg">
            <i class="bi bi-house me-2"></i>Visit Homepage
        </a>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Make news cards clickable
        document.querySelectorAll('.news-card').forEach(card => {
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

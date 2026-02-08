@extends('frontend.layouts.app')

@section('title', $newsEvent->title)
@section('meta_description', Str::limit(strip_tags($newsEvent->content), 150))

@section('styles')
<style>
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 80px 0 60px;
        margin-bottom: 60px;
    }

    .page-header h1 {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 1rem;
        line-height: 1.3;
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

    .news-detail-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .news-featured-image {
        width: 100%;
        height: 400px;
        object-fit: cover;
    }

    .news-meta-header {
        padding: 1.5rem 2rem;
        background: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
    }

    .news-meta-item {
        display: inline-flex;
        align-items: center;
        margin-right: 2rem;
        color: #6c757d;
        font-size: 0.95rem;
    }

    .news-meta-item i {
        margin-right: 0.5rem;
        font-size: 1.1rem;
    }

    .news-content {
        padding: 3rem 2rem;
        line-height: 1.8;
        color: #333;
        font-size: 1.05rem;
    }

    .news-content h1,
    .news-content h2,
    .news-content h3,
    .news-content h4 {
        color: #333;
        margin-top: 2rem;
        margin-bottom: 1rem;
        font-weight: 700;
    }

    .news-content h1 {
        font-size: 2rem;
        border-bottom: 2px solid #667eea;
        padding-bottom: 0.5rem;
    }

    .news-content h2 {
        font-size: 1.75rem;
        color: #667eea;
    }

    .news-content h3 {
        font-size: 1.5rem;
    }

    .news-content h4 {
        font-size: 1.25rem;
    }

    .news-content ul,
    .news-content ol {
        margin-left: 2rem;
        margin-bottom: 1.5rem;
    }

    .news-content li {
        margin-bottom: 0.5rem;
    }

    .news-content p {
        margin-bottom: 1.5rem;
    }

    .news-content strong {
        color: #667eea;
        font-weight: 700;
    }

    .news-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 1.5rem 0;
    }

    .news-actions {
        padding: 1.5rem 2rem;
        background: #f8f9fa;
        border-top: 2px solid #dee2e6;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .share-buttons .btn {
        margin-right: 0.5rem;
    }

    .related-news-card {
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .related-news-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .related-news-card img {
        height: 180px;
        object-fit: cover;
    }

    @media (max-width: 768px) {
        .page-header h1 {
            font-size: 1.75rem;
        }

        .news-featured-image {
            height: 250px;
        }

        .news-content {
            padding: 2rem 1.5rem;
            font-size: 1rem;
        }

        .news-meta-header {
            padding: 1rem 1.5rem;
        }

        .news-meta-item {
            display: block;
            margin-bottom: 0.5rem;
            margin-right: 0;
        }

        .news-actions {
            flex-direction: column;
            gap: 1rem;
        }

        .related-news-card img {
            height: 150px;
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
                <li class="breadcrumb-item"><a href="{{ route('frontend.news-events') }}">News & Events</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($newsEvent->title, 50) }}</li>
            </ol>
        </nav>

        <h1>{{ $newsEvent->title }}</h1>
    </div>
</section>

<!-- News Content -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="news-detail-card">
                    <!-- Featured Image -->
                    @if($newsEvent->image)
                    <img src="{{ asset('storage/' . $newsEvent->image) }}"
                         alt="{{ $newsEvent->title }}"
                         class="news-featured-image">
                    @endif

                    <!-- Meta Information -->
                    <div class="news-meta-header">
                        <span class="news-meta-item">
                            <i class="bi bi-calendar3"></i>
                            Published: {{ $newsEvent->published_at->format('F d, Y') }}
                        </span>
                        <span class="news-meta-item">
                            <i class="bi bi-clock"></i>
                            {{ $newsEvent->published_at->diffForHumans() }}
                        </span>
                        <span class="news-meta-item">
                            <i class="bi bi-newspaper"></i>
                            News & Events
                        </span>
                    </div>

                    <!-- Full Content -->
                    <div class="news-content">
                        {!! $newsEvent->content !!}
                    </div>

                    <!-- Actions -->
                    <div class="news-actions">
                        <div>
                            <a href="{{ route('frontend.news-events') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-1"></i>Back to All News
                            </a>
                        </div>
                        <div class="share-buttons">
                            <button class="btn btn-outline-primary btn-sm" onclick="window.print()">
                                <i class="bi bi-printer"></i> Print
                            </button>
                            <button class="btn btn-outline-success btn-sm" onclick="copyLink()">
                                <i class="bi bi-link-45deg"></i> Share
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Related News -->
                @php
                    $relatedNews = \App\Models\NewsEvent::active()
                        ->where('id', '!=', $newsEvent->id)
                        ->orderBy('published_at', 'desc')
                        ->limit(3)
                        ->get();
                @endphp

                @if($relatedNews->count() > 0)
                <div class="mt-5">
                    <h3 class="mb-4">Related News & Events</h3>
                    <div class="row g-4">
                        @foreach($relatedNews as $related)
                        <div class="col-md-4">
                            <div class="card related-news-card h-100 shadow-sm" onclick="window.location.href='{{ route('frontend.news-event.show', $related->id) }}'">
                                @if($related->image)
                                    <img src="{{ asset('storage/' . $related->image) }}"
                                         alt="{{ $related->title }}"
                                         class="card-img-top">
                                @else
                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 180px;">
                                        <i class="bi bi-newspaper text-muted" style="font-size: 3rem;"></i>
                                    </div>
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ Str::limit($related->title, 60) }}</h5>
                                    <p class="card-text text-muted small">
                                        {{ Str::limit(strip_tags($related->content), 80) }}
                                    </p>
                                    <div class="text-primary small">
                                        <i class="bi bi-calendar3 me-1"></i>{{ $related->published_at->format('M d, Y') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
    <div class="container text-center">
        <h2 class="mb-3">Stay Updated</h2>
        <p class="mb-4" style="font-size: 1.1rem;">Don't miss out on our latest news and announcements</p>
        <a href="{{ route('frontend.news-events') }}" class="btn btn-light btn-lg me-2">
            <i class="bi bi-newspaper me-2"></i>All News & Events
        </a>
        <a href="{{ route('frontend.home') }}" class="btn btn-outline-light btn-lg">
            <i class="bi bi-house me-2"></i>Homepage
        </a>
    </div>
</section>
@endsection

@push('scripts')
<script>
    function copyLink() {
        const url = window.location.href;
        navigator.clipboard.writeText(url).then(() => {
            alert('Link copied to clipboard!');
        }).catch(err => {
            console.error('Failed to copy link:', err);
        });
    }
</script>
@endpush

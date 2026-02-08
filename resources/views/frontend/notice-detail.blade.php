@extends('frontend.layouts.app')

@section('title', $notice->title)
@section('meta_description', Str::limit(strip_tags($notice->content), 150))

@section('styles')
<style>
    .page-header {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
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

    .page-header .notice-badge {
        display: inline-block;
        padding: 0.5rem 1.5rem;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 1rem;
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

    .notice-detail-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .notice-meta-header {
        padding: 1.5rem 2rem;
        background: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
    }

    .notice-meta-item {
        display: inline-flex;
        align-items: center;
        margin-right: 2rem;
        color: #6c757d;
        font-size: 0.95rem;
    }

    .notice-meta-item i {
        margin-right: 0.5rem;
        font-size: 1.1rem;
    }

    .notice-summary {
        padding: 2rem;
        background: #fff9e6;
        border-left: 5px solid #ffc107;
        margin: 2rem;
        border-radius: 8px;
    }

    .notice-summary h3 {
        font-size: 1.2rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
    }

    .notice-summary h3 i {
        margin-right: 0.5rem;
        color: #ffc107;
    }

    .notice-summary p {
        color: #555;
        line-height: 1.8;
        margin: 0;
    }

    .notice-details-content {
        padding: 2rem;
        line-height: 1.8;
        color: #333;
    }

    .notice-details-content h1,
    .notice-details-content h2,
    .notice-details-content h3,
    .notice-details-content h4 {
        color: #333;
        margin-top: 2rem;
        margin-bottom: 1rem;
        font-weight: 700;
    }

    .notice-details-content h1 {
        font-size: 2rem;
        border-bottom: 2px solid #dc3545;
        padding-bottom: 0.5rem;
    }

    .notice-details-content h2 {
        font-size: 1.75rem;
        color: #dc3545;
    }

    .notice-details-content h3 {
        font-size: 1.5rem;
    }

    .notice-details-content h4 {
        font-size: 1.25rem;
    }

    .notice-details-content ul,
    .notice-details-content ol {
        margin-left: 2rem;
        margin-bottom: 1.5rem;
    }

    .notice-details-content li {
        margin-bottom: 0.5rem;
    }

    .notice-details-content p {
        margin-bottom: 1.5rem;
    }

    .notice-details-content strong {
        color: #dc3545;
        font-weight: 700;
    }

    .notice-actions {
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

    @media (max-width: 768px) {
        .page-header h1 {
            font-size: 1.75rem;
        }

        .notice-summary,
        .notice-details-content {
            padding: 1.5rem;
        }

        .notice-meta-header {
            padding: 1rem 1.5rem;
        }

        .notice-meta-item {
            display: block;
            margin-bottom: 0.5rem;
            margin-right: 0;
        }

        .notice-actions {
            flex-direction: column;
            gap: 1rem;
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
                <li class="breadcrumb-item"><a href="{{ route('frontend.notices') }}">Notices</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($notice->title, 50) }}</li>
            </ol>
        </nav>

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

        <h1>{{ $notice->title }}</h1>
    </div>
</section>

<!-- Notice Content -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="notice-detail-card">
                    <!-- Meta Information -->
                    <div class="notice-meta-header">
                        <span class="notice-meta-item">
                            <i class="bi bi-calendar3"></i>
                            Published: {{ $notice->published_at->format('F d, Y') }}
                        </span>
                        <span class="notice-meta-item">
                            <i class="bi bi-clock"></i>
                            {{ $notice->published_at->diffForHumans() }}
                        </span>
                        <span class="notice-meta-item">
                            <i class="bi bi-eye"></i>
                            Official Notice
                        </span>
                    </div>

                    <!-- Summary -->
                    <div class="notice-summary">
                        <h3><i class="bi bi-info-circle-fill"></i>Summary</h3>
                        <p>{{ $notice->content }}</p>
                    </div>

                    <!-- Full Details -->
                    @if($notice->details)
                    <div class="notice-details-content">
                        {!! $notice->details !!}
                    </div>
                    @else
                    <div class="notice-details-content">
                        <p class="text-muted text-center py-4">
                            <i class="bi bi-info-circle" style="font-size: 2rem;"></i><br>
                            No additional details available for this notice.
                        </p>
                    </div>
                    @endif

                    <!-- Actions -->
                    <div class="notice-actions">
                        <div>
                            <a href="{{ route('frontend.notices') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-1"></i>Back to All Notices
                            </a>
                        </div>
                        <div class="share-buttons">
                            <button class="btn btn-outline-primary btn-sm" onclick="window.print()">
                                <i class="bi bi-printer"></i> Print
                            </button>
                            <button class="btn btn-outline-success btn-sm" onclick="copyLink()">
                                <i class="bi bi-link-45deg"></i> Copy Link
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Related Notices -->
                @php
                    $relatedNotices = \App\Models\Notice::active()
                        ->where('id', '!=', $notice->id)
                        ->where('type', $notice->type)
                        ->orderBy('published_at', 'desc')
                        ->limit(3)
                        ->get();
                @endphp

                @if($relatedNotices->count() > 0)
                <div class="mt-5">
                    <h3 class="mb-4">Related Notices</h3>
                    <div class="row g-3">
                        @foreach($relatedNotices as $related)
                        <div class="col-md-4">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body">
                                    <span class="badge mb-2
                                        @if($related->type == 'emergency') bg-danger
                                        @elseif($related->type == 'announcement') bg-primary
                                        @elseif($related->type == 'event') bg-success
                                        @else bg-secondary
                                        @endif">
                                        {{ ucfirst($related->type) }}
                                    </span>
                                    <h5 class="card-title">{{ Str::limit($related->title, 60) }}</h5>
                                    <p class="card-text text-muted small">
                                        {{ Str::limit($related->content, 80) }}
                                    </p>
                                    <a href="{{ route('frontend.notice.show', $related->id) }}" class="btn btn-sm btn-outline-danger">
                                        Read More <i class="bi bi-arrow-right"></i>
                                    </a>
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

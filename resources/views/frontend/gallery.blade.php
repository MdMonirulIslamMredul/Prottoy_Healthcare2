@extends('frontend.layouts.app')

@section('title', 'Gallery')
@section('meta_description', 'View photos from Prottoy Healthcare events, facilities, and community activities')

@section('styles')
<style>
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 80px 0 60px;
        text-align: center;
    }

    .page-header h1 {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 1rem;
    }

    .gallery-section {
        padding: 80px 0;
    }

    .filter-buttons {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 3rem;
    }

    .filter-btn {
        padding: 0.75rem 2rem;
        border: 2px solid #667eea;
        background: white;
        color: #667eea;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .filter-btn:hover,
    .filter-btn.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    }

    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .gallery-item {
        position: relative;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        transition: all 0.3s ease;
        height: 300px;
    }

    .gallery-item:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
    }

    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: all 0.3s ease;
    }

    .gallery-item:hover img {
        transform: scale(1.1);
    }

    .gallery-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(180deg, transparent 0%, rgba(0, 0, 0, 0.9) 100%);
        color: white;
        padding: 2rem 1.5rem 1.5rem;
        transform: translateY(100%);
        transition: all 0.3s ease;
    }

    .gallery-item:hover .gallery-overlay {
        transform: translateY(0);
    }

    .gallery-title {
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .gallery-category {
        font-size: 0.9rem;
        opacity: 0.8;
    }

    /* Lightbox Modal */
    .lightbox-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.95);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }

    .lightbox-modal.active {
        display: flex;
    }

    .lightbox-content {
        max-width: 90%;
        max-height: 90%;
        position: relative;
    }

    .lightbox-content img {
        max-width: 100%;
        max-height: 90vh;
        border-radius: 10px;
    }

    .lightbox-close {
        position: absolute;
        top: 20px;
        right: 20px;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border: none;
        font-size: 2rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .lightbox-close:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: rotate(90deg);
    }

    .lightbox-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .lightbox-nav:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    .lightbox-prev {
        left: 20px;
    }

    .lightbox-next {
        right: 20px;
    }

    .lightbox-caption {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(0, 0, 0, 0.7);
        color: white;
        padding: 1rem 2rem;
        border-radius: 30px;
        max-width: 80%;
        text-align: center;
    }

    .stats-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 60px 0;
        text-align: center;
    }

    .stat-item {
        padding: 1.5rem;
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        font-size: 1.1rem;
        opacity: 0.9;
    }

    @media (max-width: 768px) {
        .page-header h1 {
            font-size: 2rem;
        }

        .gallery-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .gallery-item {
            height: 250px;
        }

        .filter-buttons {
            gap: 0.5rem;
        }

        .filter-btn {
            padding: 0.5rem 1.25rem;
            font-size: 0.9rem;
        }

        .lightbox-content {
            max-width: 95%;
        }

        .lightbox-nav {
            width: 40px;
            height: 40px;
            font-size: 1.2rem;
        }
    }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="container">
        <h1 class="fade-in-up">Gallery</h1>
        <p class="fade-in-up">Moments captured from our journey of healthcare excellence</p>
    </div>
</div>

<!-- Gallery Section -->
@php
    $galleryImages = \App\Models\GalleryImage::active()->ordered()->get();
    $categories = ['events' => 'Events', 'facilities' => 'Facilities', 'community' => 'Community', 'awards' => 'Awards'];
    $categoryCounts = [
        'events' => $galleryImages->where('category', 'events')->count(),
        'facilities' => $galleryImages->where('category', 'facilities')->count(),
        'community' => $galleryImages->where('category', 'community')->count(),
        'awards' => $galleryImages->where('category', 'awards')->count(),
    ];
@endphp

<section class="gallery-section">
    <div class="container">
        <!-- Filter Buttons -->
        <div class="filter-buttons">
            <button class="filter-btn active" data-filter="all">
                <i class="bi bi-grid me-2"></i>All Photos ({{ $galleryImages->count() }})
            </button>
            @foreach($categories as $key => $label)
                @if($categoryCounts[$key] > 0)
                <button class="filter-btn" data-filter="{{ $key }}">
                    <i class="bi bi-{{ $key == 'events' ? 'calendar-event' : ($key == 'facilities' ? 'building' : ($key == 'community' ? 'people' : 'trophy')) }} me-2"></i>{{ $label }} ({{ $categoryCounts[$key] }})
                </button>
                @endif
            @endforeach
        </div>

        <!-- Gallery Grid -->
        @if($galleryImages->count() > 0)
        <div class="gallery-grid">
            @foreach($galleryImages as $index => $image)
            <div class="gallery-item" data-category="{{ $image->category }}" data-index="{{ $index }}" data-description="{{ $image->description ?? '' }}">
                <img src="{{ asset('storage/' . $image->image) }}" alt="{{ $image->title }}">
                <div class="gallery-overlay">
                    <div class="gallery-title">{{ $image->title }}</div>
                    <div class="gallery-category"><i class="bi bi-tag me-1"></i>{{ ucfirst($image->category) }}</div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-5">
            <i class="bi bi-images fs-1 text-muted d-block mb-3"></i>
            <h4 class="text-muted">No Images Available</h4>
            <p class="text-muted">Gallery images will appear here once they are added</p>
        </div>
        @endif
    </div>
</section>

<!-- Stats Section -->
@php
    $totalImages = $galleryImages->count();
    $eventCount = $categoryCounts['events'];
    $communityCount = $categoryCounts['community'];
    $awardsCount = $categoryCounts['awards'];
@endphp

<section class="stats-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <div class="stat-number">{{ $eventCount }}+</div>
                    <div class="stat-label">Events Captured</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <div class="stat-number">{{ $communityCount }}+</div>
                    <div class="stat-label">Community Programs</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <div class="stat-number">{{ $awardsCount }}+</div>
                    <div class="stat-label">Awards Received</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <div class="stat-number">{{ $totalImages }}+</div>
                    <div class="stat-label">Total Moments</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Lightbox Modal -->
<div class="lightbox-modal" id="lightboxModal">
    <button class="lightbox-close" id="lightboxClose">
        <i class="bi bi-x"></i>
    </button>
    <button class="lightbox-nav lightbox-prev" id="lightboxPrev">
        <i class="bi bi-chevron-left"></i>
    </button>
    <button class="lightbox-nav lightbox-next" id="lightboxNext">
        <i class="bi bi-chevron-right"></i>
    </button>
    <div class="lightbox-content" id="lightboxContent">
        <img src="" alt="" id="lightboxImage">
    </div>
    <div class="lightbox-caption" id="lightboxCaption"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    const filterButtons = document.querySelectorAll('.filter-btn');
    const galleryItems = document.querySelectorAll('.gallery-item');

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');

            // Update active button
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            // Filter gallery items
            galleryItems.forEach(item => {
                const category = item.getAttribute('data-category');
                if (filter === 'all' || category === filter) {
                    item.style.display = 'block';
                    setTimeout(() => {
                        item.style.opacity = '1';
                        item.style.transform = 'scale(1)';
                    }, 10);
                } else {
                    item.style.opacity = '0';
                    item.style.transform = 'scale(0.8)';
                    setTimeout(() => {
                        item.style.display = 'none';
                    }, 300);
                }
            });
        });
    });

    // Lightbox functionality
    const modal = document.getElementById('lightboxModal');
    const modalImg = document.getElementById('lightboxImage');
    const modalCaption = document.getElementById('lightboxCaption');
    const closeBtn = document.getElementById('lightboxClose');
    const prevBtn = document.getElementById('lightboxPrev');
    const nextBtn = document.getElementById('lightboxNext');
    let currentIndex = 0;
    let visibleItems = [];

    // Update visible items based on current filter
    function updateVisibleItems() {
        visibleItems = Array.from(galleryItems).filter(item =>
            item.style.display !== 'none'
        );
    }

    // Open lightbox
    galleryItems.forEach((item, index) => {
        item.addEventListener('click', function() {
            updateVisibleItems();
            const imgSrc = this.querySelector('img').src;
            const title = this.querySelector('.gallery-title').textContent;
            const category = this.querySelector('.gallery-category').textContent;
            const description = this.getAttribute('data-description');

            currentIndex = visibleItems.indexOf(this);
            modalImg.src = imgSrc;
            let captionHTML = `<strong>${title}</strong><br>${category}`;
            if (description) {
                captionHTML += `<br><span style="font-size: 0.9em; opacity: 0.9;">${description}</span>`;
            }
            modalCaption.innerHTML = captionHTML;
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    });

    // Close lightbox
    closeBtn.addEventListener('click', closeLightbox);
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeLightbox();
        }
    });

    function closeLightbox() {
        modal.classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    // Navigate lightbox
    prevBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        currentIndex = (currentIndex - 1 + visibleItems.length) % visibleItems.length;
        updateLightboxImage();
    });

    nextBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        currentIndex = (currentIndex + 1) % visibleItems.length;
        updateLightboxImage();
    });

    function updateLightboxImage() {
        const item = visibleItems[currentIndex];
        const imgSrc = item.querySelector('img').src;
        const title = item.querySelector('.gallery-title').textContent;
        const category = item.querySelector('.gallery-category').textContent;
        const description = item.getAttribute('data-description');

        modalImg.src = imgSrc;
        let captionHTML = `<strong>${title}</strong><br>${category}`;
        if (description) {
            captionHTML += `<br><span style="font-size: 0.9em; opacity: 0.9;">${description}</span>`;
        }
        modalCaption.innerHTML = captionHTML;
    }

    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (modal.classList.contains('active')) {
            if (e.key === 'Escape') {
                closeLightbox();
            } else if (e.key === 'ArrowLeft') {
                prevBtn.click();
            } else if (e.key === 'ArrowRight') {
                nextBtn.click();
            }
        }
    });

    // Initialize visible items
    updateVisibleItems();
});
</script>
@endsection

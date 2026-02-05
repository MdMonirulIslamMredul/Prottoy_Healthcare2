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
<section class="gallery-section">
    <div class="container">
        <!-- Filter Buttons -->
        <div class="filter-buttons">
            <button class="filter-btn active" data-filter="all">
                <i class="bi bi-grid me-2"></i>All Photos
            </button>
            <button class="filter-btn" data-filter="events">
                <i class="bi bi-calendar-event me-2"></i>Events
            </button>
            <button class="filter-btn" data-filter="facilities">
                <i class="bi bi-building me-2"></i>Facilities
            </button>
            <button class="filter-btn" data-filter="community">
                <i class="bi bi-people me-2"></i>Community
            </button>
            <button class="filter-btn" data-filter="awards">
                <i class="bi bi-trophy me-2"></i>Awards
            </button>
        </div>

        <!-- Gallery Grid -->
        <div class="gallery-grid">
            <!-- Event Photos -->
            <div class="gallery-item" data-category="events" data-index="0">
                <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=500" alt="Annual Healthcare Summit 2024">
                <div class="gallery-overlay">
                    <div class="gallery-title">Annual Healthcare Summit 2024</div>
                    <div class="gallery-category"><i class="bi bi-tag me-1"></i>Events</div>
                </div>
            </div>

            <div class="gallery-item" data-category="events" data-index="1">
                <img src="https://images.unsplash.com/photo-1511578314322-379afb476865?w=500" alt="Leadership Conference">
                <div class="gallery-overlay">
                    <div class="gallery-title">Leadership Conference</div>
                    <div class="gallery-category"><i class="bi bi-tag me-1"></i>Events</div>
                </div>
            </div>

            <div class="gallery-item" data-category="events" data-index="2">
                <img src="https://images.unsplash.com/photo-1505373877841-8d25f7d46678?w=500" alt="Customer Appreciation Day">
                <div class="gallery-overlay">
                    <div class="gallery-title">Customer Appreciation Day</div>
                    <div class="gallery-category"><i class="bi bi-tag me-1"></i>Events</div>
                </div>
            </div>

            <!-- Facilities Photos -->
            <div class="gallery-item" data-category="facilities" data-index="3">
                <img src="https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=500" alt="Head Office - Dhaka">
                <div class="gallery-overlay">
                    <div class="gallery-title">Head Office - Dhaka</div>
                    <div class="gallery-category"><i class="bi bi-tag me-1"></i>Facilities</div>
                </div>
            </div>

            <div class="gallery-item" data-category="facilities" data-index="4">
                <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=500" alt="Regional Office - Chittagong">
                <div class="gallery-overlay">
                    <div class="gallery-title">Regional Office - Chittagong</div>
                    <div class="gallery-category"><i class="bi bi-tag me-1"></i>Facilities</div>
                </div>
            </div>

            <div class="gallery-item" data-category="facilities" data-index="5">
                <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?w=500" alt="Customer Service Center">
                <div class="gallery-overlay">
                    <div class="gallery-title">Customer Service Center</div>
                    <div class="gallery-category"><i class="bi bi-tag me-1"></i>Facilities</div>
                </div>
            </div>

            <!-- Community Photos -->
            <div class="gallery-item" data-category="community" data-index="6">
                <img src="https://images.unsplash.com/photo-1559027615-cd4628902d4a?w=500" alt="Health Camp in Rural Areas">
                <div class="gallery-overlay">
                    <div class="gallery-title">Health Camp in Rural Areas</div>
                    <div class="gallery-category"><i class="bi bi-tag me-1"></i>Community</div>
                </div>
            </div>

            <div class="gallery-item" data-category="community" data-index="7">
                <img src="https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?w=500" alt="Healthcare Awareness Program">
                <div class="gallery-overlay">
                    <div class="gallery-title">Healthcare Awareness Program</div>
                    <div class="gallery-category"><i class="bi bi-tag me-1"></i>Community</div>
                </div>
            </div>

            <div class="gallery-item" data-category="community" data-index="8">
                <img src="https://images.unsplash.com/photo-1469571486292-0ba58a3f068b?w=500" alt="Community Outreach">
                <div class="gallery-overlay">
                    <div class="gallery-title">Community Outreach</div>
                    <div class="gallery-category"><i class="bi bi-tag me-1"></i>Community</div>
                </div>
            </div>

            <!-- Awards Photos -->
            <div class="gallery-item" data-category="awards" data-index="9">
                <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?w=500" alt="National Healthcare Excellence Award">
                <div class="gallery-overlay">
                    <div class="gallery-title">National Healthcare Excellence Award</div>
                    <div class="gallery-category"><i class="bi bi-tag me-1"></i>Awards</div>
                </div>
            </div>

            <div class="gallery-item" data-category="awards" data-index="10">
                <img src="https://images.unsplash.com/photo-1523580494863-6f3031224c94?w=500" alt="Best Customer Service Recognition">
                <div class="gallery-overlay">
                    <div class="gallery-title">Best Customer Service Recognition</div>
                    <div class="gallery-category"><i class="bi bi-tag me-1"></i>Awards</div>
                </div>
            </div>

            <div class="gallery-item" data-category="awards" data-index="11">
                <img src="https://images.unsplash.com/photo-1515169273894-7e876dcf13da?w=500" alt="Innovation in Healthcare Award">
                <div class="gallery-overlay">
                    <div class="gallery-title">Innovation in Healthcare Award</div>
                    <div class="gallery-category"><i class="bi bi-tag me-1"></i>Awards</div>
                </div>
            </div>

            <!-- More Events -->
            <div class="gallery-item" data-category="events" data-index="12">
                <img src="https://images.unsplash.com/photo-1591115765373-5207764f72e7?w=500" alt="PHO Training Workshop">
                <div class="gallery-overlay">
                    <div class="gallery-title">PHO Training Workshop</div>
                    <div class="gallery-category"><i class="bi bi-tag me-1"></i>Events</div>
                </div>
            </div>

            <div class="gallery-item" data-category="community" data-index="13">
                <img src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?w=500" alt="Free Medical Check-up Camp">
                <div class="gallery-overlay">
                    <div class="gallery-title">Free Medical Check-up Camp</div>
                    <div class="gallery-category"><i class="bi bi-tag me-1"></i>Community</div>
                </div>
            </div>

            <div class="gallery-item" data-category="facilities" data-index="14">
                <img src="https://images.unsplash.com/photo-1497366754035-f200968a6e72?w=500" alt="Modern IT Infrastructure">
                <div class="gallery-overlay">
                    <div class="gallery-title">Modern IT Infrastructure</div>
                    <div class="gallery-category"><i class="bi bi-tag me-1"></i>Facilities</div>
                </div>
            </div>

            <div class="gallery-item" data-category="events" data-index="15">
                <img src="https://images.unsplash.com/photo-1515187029135-18ee286d815b?w=500" alt="Partnership Signing Ceremony">
                <div class="gallery-overlay">
                    <div class="gallery-title">Partnership Signing Ceremony</div>
                    <div class="gallery-category"><i class="bi bi-tag me-1"></i>Events</div>
                </div>
            </div>

            <div class="gallery-item" data-category="community" data-index="16">
                <img src="https://images.unsplash.com/photo-1593113598332-cd288d649433?w=500" alt="School Health Program">
                <div class="gallery-overlay">
                    <div class="gallery-title">School Health Program</div>
                    <div class="gallery-category"><i class="bi bi-tag me-1"></i>Community</div>
                </div>
            </div>

            <div class="gallery-item" data-category="events" data-index="17">
                <img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=500" alt="Team Building Event">
                <div class="gallery-overlay">
                    <div class="gallery-title">Team Building Event</div>
                    <div class="gallery-category"><i class="bi bi-tag me-1"></i>Events</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <div class="stat-number">50+</div>
                    <div class="stat-label">Events Organized</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <div class="stat-number">100+</div>
                    <div class="stat-label">Community Programs</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <div class="stat-number">15+</div>
                    <div class="stat-label">Awards Received</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item">
                    <div class="stat-number">10K+</div>
                    <div class="stat-label">Lives Touched</div>
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
            
            currentIndex = visibleItems.indexOf(this);
            modalImg.src = imgSrc;
            modalCaption.innerHTML = `<strong>${title}</strong><br>${category}`;
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
        
        modalImg.src = imgSrc;
        modalCaption.innerHTML = `<strong>${title}</strong><br>${category}`;
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

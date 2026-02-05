@extends('frontend.layouts.app')

@section('title', 'About Us')
@section('meta_description', 'Learn about Prottoy Healthcare - Our Mission, Vision, and Leadership Team')

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

    .page-header p {
        font-size: 1.2rem;
        opacity: 0.95;
    }

    .about-section {
        padding: 80px 0;
    }

    .mission-vision-section {
        background: #f8f9fa;
        padding: 80px 0;
    }

    .mv-card {
        background: white;
        padding: 3rem;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        height: 100%;
        transition: all 0.3s ease;
    }

    .mv-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .mv-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        margin-bottom: 1.5rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .mv-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        color: #2c3e50;
    }

    .mv-text {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #555;
    }

    .leadership-section {
        padding: 80px 0;
    }

    .leader-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        margin-bottom: 2rem;
    }

    .leader-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .leader-image {
        width: 100%;
        height: 350px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 8rem;
        color: white;
        position: relative;
    }

    .leader-content {
        padding: 2.5rem;
    }

    .leader-name {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: #2c3e50;
    }

    .leader-title {
        font-size: 1.2rem;
        color: #667eea;
        font-weight: 600;
        margin-bottom: 1.5rem;
    }

    .leader-bio {
        font-size: 1rem;
        line-height: 1.8;
        color: #555;
        margin-bottom: 1rem;
    }

    .timeline {
        position: relative;
        padding: 2rem 0;
    }

    .timeline-item {
        position: relative;
        padding-left: 3rem;
        margin-bottom: 2rem;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 15px;
        height: 15px;
        background: #667eea;
        border-radius: 50%;
        border: 3px solid #f8f9fa;
    }

    .timeline-item::after {
        content: '';
        position: absolute;
        left: 7px;
        top: 15px;
        width: 2px;
        height: calc(100% + 2rem);
        background: #dee2e6;
    }

    .timeline-item:last-child::after {
        display: none;
    }

    .timeline-year {
        font-size: 1.1rem;
        font-weight: 700;
        color: #667eea;
        margin-bottom: 0.5rem;
    }

    .timeline-text {
        color: #555;
        line-height: 1.6;
    }

    .values-section {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: white;
        padding: 80px 0;
    }

    .value-item {
        text-align: center;
        padding: 2rem;
    }

    .value-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        margin: 0 auto 1.5rem;
    }

    .value-title {
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 0.75rem;
    }

    @media (max-width: 768px) {
        .page-header h1 {
            font-size: 2rem;
        }

        .leader-image {
            height: 250px;
            font-size: 5rem;
        }
    }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="container">
        <h1 class="fade-in-up">About Us</h1>
        <p class="fade-in-up">Leading the way in healthcare management excellence</p>
    </div>
</div>

<!-- Mission & Vision Section -->
<section class="mission-vision-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Our Mission & Vision</h2>
            <p class="section-subtitle">Guiding principles that drive our commitment to excellence</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-6">
                <div class="mv-card">
                    <div class="mv-icon">
                        <i class="bi bi-bullseye"></i>
                    </div>
                    <h3 class="mv-title">Our Mission</h3>
                    <p class="mv-text">
                        To provide accessible, affordable, and quality healthcare services to every citizen of Bangladesh. 
                        We strive to create a comprehensive healthcare ecosystem that ensures timely medical assistance, 
                        seamless claims processing, and continuous support for all our members. Our mission is to bridge 
                        the gap between healthcare providers and patients, making quality healthcare a reality for everyone.
                    </p>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="mv-card">
                    <div class="mv-icon">
                        <i class="bi bi-eye"></i>
                    </div>
                    <h3 class="mv-title">Our Vision</h3>
                    <p class="mv-text">
                        To become the most trusted and preferred healthcare management organization in Bangladesh by 2030. 
                        We envision a future where every individual has access to world-class healthcare services regardless 
                        of their location or economic status. Through innovation, technology, and unwavering commitment, 
                        we aim to set new standards in healthcare delivery and customer satisfaction across the nation.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Leadership Section -->
<section class="leadership-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Our Leadership</h2>
            <p class="section-subtitle">Meet the visionaries behind Prottoy Healthcare</p>
        </div>

        <!-- Chairman Section -->
        <div class="leader-card">
            <div class="row g-0">
                <div class="col-lg-4">
                    <div class="leader-image">
                        <i class="bi bi-person-circle"></i>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="leader-content">
                        <h3 class="leader-name">Chairman's Profile</h3>
                        <p class="leader-title">Chairman, Board of Directors</p>
                        
                        <div class="leader-bio">
                            <h5 class="mb-3"><i class="bi bi-book me-2"></i>Professional Background</h5>
                            <p>
                                With over 30 years of experience in healthcare management and administration, our Chairman has been 
                                instrumental in shaping the healthcare landscape of Bangladesh. A distinguished alumnus of Dhaka University 
                                and Harvard Business School, he brings a wealth of knowledge in strategic planning, healthcare policy, 
                                and organizational development.
                            </p>

                            <h5 class="mb-3 mt-4"><i class="bi bi-trophy me-2"></i>Key Achievements</h5>
                            <div class="timeline">
                                <div class="timeline-item">
                                    <div class="timeline-year">2015</div>
                                    <div class="timeline-text">Founded Prottoy Healthcare with a vision to revolutionize healthcare access</div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-year">2018</div>
                                    <div class="timeline-text">Expanded services to all 64 districts of Bangladesh</div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-year">2020</div>
                                    <div class="timeline-text">Received National Healthcare Excellence Award</div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-year">2023</div>
                                    <div class="timeline-text">Launched digital healthcare initiatives reaching 10,000+ customers</div>
                                </div>
                            </div>

                            <h5 class="mb-3"><i class="bi bi-chat-quote me-2"></i>Chairman's Message</h5>
                            <blockquote class="border-start border-4 border-primary ps-3 py-2" style="background: #f8f9fa;">
                                <em>"Healthcare is not a privilege; it is a fundamental right. At Prottoy Healthcare, we are committed 
                                to ensuring that every individual receives the care they deserve. Our journey has been one of dedication, 
                                innovation, and unwavering focus on customer satisfaction. Together, we will continue to build a healthier 
                                Bangladesh for future generations."</em>
                            </blockquote>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Managing Director Section -->
        <div class="leader-card">
            <div class="row g-0">
                <div class="col-lg-4">
                    <div class="leader-image">
                        <i class="bi bi-person-circle"></i>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="leader-content">
                        <h3 class="leader-name">Managing Director's Profile</h3>
                        <p class="leader-title">Managing Director & CEO</p>
                        
                        <div class="leader-bio">
                            <h5 class="mb-3"><i class="bi bi-book me-2"></i>Professional Background</h5>
                            <p>
                                Our Managing Director brings over 25 years of comprehensive experience in healthcare operations, 
                                business development, and technology integration. Armed with an MBA from London Business School 
                                and a medical degree, he uniquely combines clinical knowledge with business acumen to drive 
                                operational excellence at Prottoy Healthcare.
                            </p>

                            <h5 class="mb-3 mt-4"><i class="bi bi-trophy me-2"></i>Career Milestones</h5>
                            <div class="timeline">
                                <div class="timeline-item">
                                    <div class="timeline-year">2010-2015</div>
                                    <div class="timeline-text">Served as COO at leading healthcare institutions in Bangladesh</div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-year">2016</div>
                                    <div class="timeline-text">Joined Prottoy Healthcare as Managing Director</div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-year">2019</div>
                                    <div class="timeline-text">Implemented nationwide digital transformation program</div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-year">2022</div>
                                    <div class="timeline-text">Awarded "Healthcare Leader of the Year" by Bangladesh Healthcare Summit</div>
                                </div>
                            </div>

                            <h5 class="mb-3"><i class="bi bi-chat-quote me-2"></i>MD's Message</h5>
                            <blockquote class="border-start border-4 border-primary ps-3 py-2" style="background: #f8f9fa;">
                                <em>"In today's rapidly evolving healthcare landscape, we must embrace innovation while staying true to 
                                our core values of compassion and excellence. Our dedicated team works tirelessly to ensure that every 
                                customer receives prompt, efficient, and caring service. We are not just managing healthcare; we are 
                                creating lasting partnerships with our customers and healthcare providers for a healthier tomorrow."</em>
                            </blockquote>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="values-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title text-white">Our Core Values</h2>
            <p class="section-subtitle text-white-50">The principles that guide everything we do</p>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="value-item">
                    <div class="value-icon">
                        <i class="bi bi-heart-pulse"></i>
                    </div>
                    <h4 class="value-title">Compassion</h4>
                    <p>Caring for every individual with empathy and understanding</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="value-item">
                    <div class="value-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h4 class="value-title">Integrity</h4>
                    <p>Upholding the highest standards of honesty and ethics</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="value-item">
                    <div class="value-icon">
                        <i class="bi bi-lightning"></i>
                    </div>
                    <h4 class="value-title">Innovation</h4>
                    <p>Embracing new technologies and methods for better service</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="value-item">
                    <div class="value-icon">
                        <i class="bi bi-award"></i>
                    </div>
                    <h4 class="value-title">Excellence</h4>
                    <p>Striving for the best in everything we do</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

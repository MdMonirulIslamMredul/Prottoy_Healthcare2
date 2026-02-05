@extends('frontend.layouts.app')

@section('title', 'Policy & Legal')
@section('meta_description', 'Access Prottoy Healthcare policies, legal documents, memorandum, and official notices')

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

    .policy-section {
        padding: 80px 0;
    }

    .document-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        padding: 2.5rem;
        margin-bottom: 2rem;
        transition: all 0.3s ease;
        border-left: 5px solid #667eea;
    }

    .document-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .document-header {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid #f8f9fa;
    }

    .document-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        color: white;
        margin-right: 1.5rem;
    }

    .document-title {
        font-size: 1.6rem;
        font-weight: 700;
        color: #2c3e50;
        margin: 0;
    }

    .document-meta {
        font-size: 0.9rem;
        color: #6c757d;
        margin-top: 0.5rem;
    }

    .document-content {
        color: #555;
        line-height: 1.8;
    }

    .document-content h5 {
        color: #2c3e50;
        font-weight: 700;
        margin-top: 1.5rem;
        margin-bottom: 1rem;
    }

    .document-content ul {
        list-style: none;
        padding-left: 0;
    }

    .document-content li {
        padding: 0.5rem 0;
        padding-left: 2rem;
        position: relative;
    }

    .document-content li::before {
        content: '▪';
        position: absolute;
        left: 0;
        color: #667eea;
        font-weight: 700;
        font-size: 1.2rem;
    }

    .download-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
    }

    .download-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .notices-section {
        background: #f8f9fa;
        padding: 80px 0;
    }

    .notice-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border-left: 4px solid #667eea;
    }

    .notice-card:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.12);
    }

    .notice-badge {
        display: inline-block;
        padding: 0.375rem 0.75rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
    }

    .notice-badge.important {
        background: #fff3cd;
        color: #856404;
    }

    .notice-badge.general {
        background: #d1ecf1;
        color: #0c5460;
    }

    .notice-badge.urgent {
        background: #f8d7da;
        color: #721c24;
    }

    .notice-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }

    .notice-date {
        font-size: 0.9rem;
        color: #6c757d;
        margin-bottom: 0.75rem;
    }

    .notice-excerpt {
        color: #555;
        line-height: 1.6;
    }

    .compliance-section {
        padding: 80px 0;
    }

    .compliance-card {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        height: 100%;
        transition: all 0.3s ease;
        text-align: center;
    }

    .compliance-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .compliance-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        color: white;
        margin: 0 auto 1.5rem;
    }

    .compliance-title {
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: #2c3e50;
    }

    @media (max-width: 768px) {
        .page-header h1 {
            font-size: 2rem;
        }

        .document-header {
            flex-direction: column;
            text-align: center;
        }

        .document-icon {
            margin-right: 0;
            margin-bottom: 1rem;
        }
    }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="container">
        <h1 class="fade-in-up">Policy & Legal</h1>
        <p class="fade-in-up">Official documents, policies, and regulatory compliance information</p>
    </div>
</div>

<!-- Policy Documents Section -->
<section class="policy-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Policy Documents</h2>
            <p class="section-subtitle">Access our official policies and legal documents</p>
        </div>

        <!-- Memorandum of Association -->
        <div class="document-card">
            <div class="document-header">
                <div class="document-icon">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
                <div>
                    <h3 class="document-title">Memorandum of Association</h3>
                    <div class="document-meta">
                        <i class="bi bi-calendar3 me-2"></i>Last Updated: January 2024
                        <span class="mx-2">|</span>
                        <i class="bi bi-file-pdf me-2"></i>PDF Document
                    </div>
                </div>
            </div>
            <div class="document-content">
                <p>
                    The Memorandum of Association is the fundamental document that defines the constitution and scope 
                    of Prottoy Healthcare's activities. It establishes our legal existence and outlines our objectives, 
                    powers, and limitations as a healthcare organization.
                </p>

                <h5>Key Provisions:</h5>
                <ul>
                    <li><strong>Name Clause:</strong> Formally establishes "Prottoy Healthcare" as our registered name</li>
                    <li><strong>Registered Office Clause:</strong> Specifies the location of our head office in Bangladesh</li>
                    <li><strong>Objects Clause:</strong> Defines our primary objective to provide comprehensive healthcare management services</li>
                    <li><strong>Liability Clause:</strong> Establishes the extent of members' liability</li>
                    <li><strong>Capital Clause:</strong> Details the authorized capital and share structure</li>
                    <li><strong>Subscription Clause:</strong> Lists founding members and their commitments</li>
                </ul>

                <h5>Objectives:</h5>
                <ul>
                    <li>To provide accessible and affordable healthcare services to citizens of Bangladesh</li>
                    <li>To establish and maintain a comprehensive healthcare network across all divisions</li>
                    <li>To facilitate efficient healthcare claims processing and management</li>
                    <li>To promote healthcare awareness and preventive care practices</li>
                    <li>To collaborate with healthcare providers and government agencies</li>
                    <li>To maintain highest standards of service quality and ethical practices</li>
                </ul>

                <div class="mt-4">
                    <a href="#" class="download-btn me-2">
                        <i class="bi bi-download me-2"></i>Download Full Document
                    </a>
                    <a href="#" class="download-btn" style="background: #6c757d;">
                        <i class="bi bi-eye me-2"></i>View Online
                    </a>
                </div>
            </div>
        </div>

        <!-- Privacy Policy -->
        <div class="document-card" style="border-left-color: #28a745;">
            <div class="document-header">
                <div class="document-icon" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                    <i class="bi bi-shield-lock"></i>
                </div>
                <div>
                    <h3 class="document-title">Privacy Policy</h3>
                    <div class="document-meta">
                        <i class="bi bi-calendar3 me-2"></i>Last Updated: December 2023
                        <span class="mx-2">|</span>
                        <i class="bi bi-file-pdf me-2"></i>PDF Document
                    </div>
                </div>
            </div>
            <div class="document-content">
                <p>
                    Prottoy Healthcare is committed to protecting the privacy and security of our customers' personal 
                    and health information. This policy outlines how we collect, use, store, and protect your data.
                </p>

                <h5>Information We Collect:</h5>
                <ul>
                    <li>Personal identification information (name, address, phone number, email)</li>
                    <li>Healthcare information and medical history</li>
                    <li>Claims and service utilization data</li>
                    <li>Payment and transaction information</li>
                </ul>

                <h5>How We Use Your Information:</h5>
                <ul>
                    <li>To provide healthcare services and process claims</li>
                    <li>To communicate important updates and notifications</li>
                    <li>To improve service quality and customer experience</li>
                    <li>To comply with legal and regulatory requirements</li>
                </ul>

                <h5>Data Security:</h5>
                <ul>
                    <li>Industry-standard encryption for all data transmission</li>
                    <li>Secure storage with regular backups and access controls</li>
                    <li>Compliance with Bangladesh Data Protection regulations</li>
                    <li>Regular security audits and vulnerability assessments</li>
                </ul>

                <div class="mt-4">
                    <a href="#" class="download-btn">
                        <i class="bi bi-download me-2"></i>Download Privacy Policy
                    </a>
                </div>
            </div>
        </div>

        <!-- Terms of Service -->
        <div class="document-card" style="border-left-color: #dc3545;">
            <div class="document-header">
                <div class="document-icon" style="background: linear-gradient(135deg, #dc3545 0%, #ff6b6b 100%);">
                    <i class="bi bi-file-earmark-ruled"></i>
                </div>
                <div>
                    <h3 class="document-title">Terms of Service</h3>
                    <div class="document-meta">
                        <i class="bi bi-calendar3 me-2"></i>Effective: January 2024
                        <span class="mx-2">|</span>
                        <i class="bi bi-file-pdf me-2"></i>PDF Document
                    </div>
                </div>
            </div>
            <div class="document-content">
                <p>
                    These Terms of Service govern your use of Prottoy Healthcare services. By registering as a customer 
                    or using our services, you agree to be bound by these terms.
                </p>

                <h5>Service Agreement:</h5>
                <ul>
                    <li>Eligibility criteria for healthcare services</li>
                    <li>Service coverage and limitations</li>
                    <li>Payment terms and conditions</li>
                    <li>Claim submission procedures and timelines</li>
                    <li>Customer responsibilities and obligations</li>
                </ul>

                <h5>Service Modifications:</h5>
                <ul>
                    <li>Right to modify services with prior notice</li>
                    <li>Updates to terms and conditions</li>
                    <li>Changes in pricing or coverage</li>
                </ul>

                <div class="mt-4">
                    <a href="#" class="download-btn">
                        <i class="bi bi-download me-2"></i>Download Terms of Service
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Official Notices Section -->
<section class="notices-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Official Notices</h2>
            <p class="section-subtitle">Latest updates and announcements</p>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="notice-card">
                    <span class="notice-badge urgent">
                        <i class="bi bi-exclamation-triangle me-1"></i>Urgent
                    </span>
                    <h4 class="notice-title">Service Expansion to New Areas</h4>
                    <div class="notice-date">
                        <i class="bi bi-calendar3 me-1"></i>February 15, 2024
                    </div>
                    <p class="notice-excerpt">
                        We are pleased to announce the expansion of our services to 25 additional upazilas across 
                        Bangladesh. This expansion will provide healthcare access to over 50,000 new customers.
                    </p>
                    <a href="#" class="text-decoration-none">
                        Read more <i class="bi bi-arrow-right"></i>
                    </a>
                </div>

                <div class="notice-card">
                    <span class="notice-badge important">
                        <i class="bi bi-info-circle me-1"></i>Important
                    </span>
                    <h4 class="notice-title">Updated Claim Submission Guidelines</h4>
                    <div class="notice-date">
                        <i class="bi bi-calendar3 me-1"></i>February 10, 2024
                    </div>
                    <p class="notice-excerpt">
                        New claim submission procedures are now in effect. Customers are requested to review the 
                        updated guidelines to ensure faster processing of their claims.
                    </p>
                    <a href="#" class="text-decoration-none">
                        Read more <i class="bi bi-arrow-right"></i>
                    </a>
                </div>

                <div class="notice-card">
                    <span class="notice-badge general">
                        <i class="bi bi-megaphone me-1"></i>General
                    </span>
                    <h4 class="notice-title">Holiday Schedule Notice</h4>
                    <div class="notice-date">
                        <i class="bi bi-calendar3 me-1"></i>February 5, 2024
                    </div>
                    <p class="notice-excerpt">
                        Please note our office hours during upcoming national holidays. Emergency services will 
                        remain available 24/7 through our hotline.
                    </p>
                    <a href="#" class="text-decoration-none">
                        Read more <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="notice-card">
                    <span class="notice-badge important">
                        <i class="bi bi-info-circle me-1"></i>Important
                    </span>
                    <h4 class="notice-title">Annual General Meeting 2024</h4>
                    <div class="notice-date">
                        <i class="bi bi-calendar3 me-1"></i>January 30, 2024
                    </div>
                    <p class="notice-excerpt">
                        The Annual General Meeting will be held on March 15, 2024. All stakeholders are invited to 
                        participate and review our annual performance report.
                    </p>
                    <a href="#" class="text-decoration-none">
                        Read more <i class="bi bi-arrow-right"></i>
                    </a>
                </div>

                <div class="notice-card">
                    <span class="notice-badge general">
                        <i class="bi bi-megaphone me-1"></i>General
                    </span>
                    <h4 class="notice-title">New Partnership Announcement</h4>
                    <div class="notice-date">
                        <i class="bi bi-calendar3 me-1"></i>January 25, 2024
                    </div>
                    <p class="notice-excerpt">
                        We have partnered with 15 additional hospitals and diagnostic centers to expand our service 
                        network and provide better healthcare access to our customers.
                    </p>
                    <a href="#" class="text-decoration-none">
                        Read more <i class="bi bi-arrow-right"></i>
                    </a>
                </div>

                <div class="notice-card">
                    <span class="notice-badge general">
                        <i class="bi bi-megaphone me-1"></i>General
                    </span>
                    <h4 class="notice-title">Customer Satisfaction Survey</h4>
                    <div class="notice-date">
                        <i class="bi bi-calendar3 me-1"></i>January 20, 2024
                    </div>
                    <p class="notice-excerpt">
                        We invite all customers to participate in our annual satisfaction survey. Your feedback helps 
                        us improve our services and better meet your healthcare needs.
                    </p>
                    <a href="#" class="text-decoration-none">
                        Read more <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="#" class="btn btn-primary btn-lg">
                <i class="bi bi-archive me-2"></i>View Notice Archive
            </a>
        </div>
    </div>
</section>

<!-- Compliance Section -->
<section class="compliance-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Regulatory Compliance</h2>
            <p class="section-subtitle">Our commitment to legal and ethical standards</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="compliance-card">
                    <div class="compliance-icon">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <h4 class="compliance-title">Licensed & Registered</h4>
                    <p class="text-muted">Fully licensed healthcare organization registered with relevant authorities</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="compliance-card">
                    <div class="compliance-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h4 class="compliance-title">Data Protection</h4>
                    <p class="text-muted">Compliant with Bangladesh data protection and privacy laws</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="compliance-card">
                    <div class="compliance-icon">
                        <i class="bi bi-file-earmark-check"></i>
                    </div>
                    <h4 class="compliance-title">Quality Standards</h4>
                    <p class="text-muted">Adheres to national healthcare quality and safety standards</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="compliance-card">
                    <div class="compliance-icon">
                        <i class="bi bi-award"></i>
                    </div>
                    <h4 class="compliance-title">Certified Operations</h4>
                    <p class="text-muted">Certified by healthcare regulatory bodies and industry associations</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

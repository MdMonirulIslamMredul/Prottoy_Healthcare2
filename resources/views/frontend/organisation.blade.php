@extends('frontend.layouts.app')

@section('title', 'Organisation & Leadership')
@section('meta_description', 'Learn about Prottoy Healthcare organizational structure, leadership team, and their roles & responsibilities')

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

    .org-section {
        padding: 80px 0;
    }

    .org-chart {
        background: #f8f9fa;
        padding: 80px 0;
    }

    .org-level {
        margin-bottom: 3rem;
        text-align: center;
    }

    .org-box {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        margin: 0 auto 1.5rem;
        max-width: 350px;
        position: relative;
        transition: all 0.3s ease;
    }

    .org-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .org-box.level-1 {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .org-box.level-2 {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }

    .org-box.level-3 {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
    }

    .org-box.level-4 {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        color: white;
    }

    .org-box.level-5 {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        color: white;
    }

    .org-icon {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin: 0 auto 1rem;
    }

    .org-title {
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .org-subtitle {
        font-size: 0.9rem;
        opacity: 0.9;
    }

    .connector {
        width: 2px;
        height: 30px;
        background: #dee2e6;
        margin: 0 auto;
    }

    .role-section {
        padding: 80px 0;
    }

    .role-card {
        background: white;
        border-radius: 15px;
        padding: 2.5rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
        transition: all 0.3s ease;
    }

    .role-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .role-header {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid #f8f9fa;
    }

    .role-icon {
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

    .role-name {
        font-size: 1.6rem;
        font-weight: 700;
        color: #2c3e50;
        margin: 0;
    }

    .responsibility-list {
        list-style: none;
        padding: 0;
    }

    .responsibility-list li {
        padding: 0.75rem 0;
        padding-left: 2rem;
        position: relative;
        color: #555;
        line-height: 1.6;
    }

    .responsibility-list li::before {
        content: '✓';
        position: absolute;
        left: 0;
        color: #667eea;
        font-weight: 700;
        font-size: 1.2rem;
    }

    .stats-badge {
        display: inline-block;
        background: #f8f9fa;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        margin: 0.25rem;
        font-size: 0.9rem;
        color: #667eea;
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .page-header h1 {
            font-size: 2rem;
        }

        .org-box {
            max-width: 100%;
        }

        .role-header {
            flex-direction: column;
            text-align: center;
        }

        .role-icon {
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
        <h1 class="fade-in-up">Organisation & Leadership</h1>
        <p class="fade-in-up">Our structured approach to excellence in healthcare management</p>
    </div>
</div>

<!-- Organizational Chart Section -->
<section class="org-chart">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Organizational Structure</h2>
            <p class="section-subtitle">Hierarchical framework ensuring efficient service delivery</p>
        </div>

        <!-- Level 1: Super Admin -->
        <div class="org-level">
            <div class="org-box level-1">
                <div class="org-icon">
                    <i class="bi bi-person-badge"></i>
                </div>
                <div class="org-title">Super Admin</div>
                <div class="org-subtitle">Central Management & Oversight</div>
            </div>
            <div class="connector"></div>
        </div>

        <!-- Level 2: Divisional Chief -->
        <div class="org-level">
            <div class="org-box level-2">
                <div class="org-icon">
                    <i class="bi bi-diagram-3"></i>
                </div>
                <div class="org-title">Divisional Chief</div>
                <div class="org-subtitle">Division-Level Management</div>
            </div>
            <div class="connector"></div>
        </div>

        <!-- Level 3: District Manager -->
        <div class="org-level">
            <div class="org-box level-3">
                <div class="org-icon">
                    <i class="bi bi-geo-alt"></i>
                </div>
                <div class="org-title">District Manager</div>
                <div class="org-subtitle">District-Level Operations</div>
            </div>
            <div class="connector"></div>
        </div>

        <!-- Level 4: Upazila Supervisor -->
        <div class="org-level">
            <div class="org-box level-4">
                <div class="org-icon">
                    <i class="bi bi-building"></i>
                </div>
                <div class="org-title">Upazila Supervisor</div>
                <div class="org-subtitle">Upazila-Level Coordination</div>
            </div>
            <div class="connector"></div>
        </div>

        <!-- Level 5: PHO (Primary Healthcare Officer) -->
        <div class="org-level">
            <div class="org-box level-5">
                <div class="org-icon">
                    <i class="bi bi-person-hearts"></i>
                </div>
                <div class="org-title">PHO (Primary Healthcare Officer)</div>
                <div class="org-subtitle">Frontline Customer Service</div>
            </div>
        </div>

        <div class="text-center mt-5">
            <p class="text-muted"><i class="bi bi-info-circle me-2"></i>Each level ensures accountability and efficient service delivery across Bangladesh</p>
        </div>
    </div>
</section>

<!-- Roles & Responsibilities Section -->
<section class="role-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Roles & Responsibilities</h2>
            <p class="section-subtitle">Detailed overview of each position's duties and authority</p>
        </div>

        <!-- Super Admin Role -->
        <div class="role-card">
            <div class="role-header">
                <div class="role-icon">
                    <i class="bi bi-person-badge"></i>
                </div>
                <div>
                    <h3 class="role-name">Super Admin</h3>
                    <div class="mt-2">
                        <span class="stats-badge"><i class="bi bi-diagram-3 me-1"></i>8 Divisions</span>
                        <span class="stats-badge"><i class="bi bi-people me-1"></i>All Users</span>
                    </div>
                </div>
            </div>
            <h5 class="mb-3">Key Responsibilities:</h5>
            <ul class="responsibility-list">
                <li>Overall system administration and management</li>
                <li>Create and manage all hierarchical levels (Divisional Chiefs, District Managers, etc.)</li>
                <li>Monitor and oversee operations across all 8 divisions of Bangladesh</li>
                <li>Generate comprehensive reports and analytics for strategic decision-making</li>
                <li>Set policies, guidelines, and operational standards</li>
                <li>Manage customer records and resolve escalated issues</li>
                <li>Ensure data integrity and system security</li>
                <li>Approve major operational changes and initiatives</li>
            </ul>
        </div>

        <!-- Divisional Chief Role -->
        <div class="role-card">
            <div class="role-header">
                <div class="role-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <i class="bi bi-diagram-3"></i>
                </div>
                <div>
                    <h3 class="role-name">Divisional Chief</h3>
                    <div class="mt-2">
                        <span class="stats-badge"><i class="bi bi-geo me-1"></i>1 Division</span>
                        <span class="stats-badge"><i class="bi bi-building me-1"></i>Multiple Districts</span>
                    </div>
                </div>
            </div>
            <h5 class="mb-3">Key Responsibilities:</h5>
            <ul class="responsibility-list">
                <li>Oversee healthcare operations within assigned division</li>
                <li>Manage and coordinate with all District Managers in the division</li>
                <li>Monitor district-level performance and service quality</li>
                <li>Handle customer management for the entire division</li>
                <li>Generate divisional reports and performance metrics</li>
                <li>Ensure compliance with organizational policies and standards</li>
                <li>Resolve inter-district issues and facilitate coordination</li>
                <li>Report division-level insights to Super Admin</li>
            </ul>
        </div>

        <!-- District Manager Role -->
        <div class="role-card">
            <div class="role-header">
                <div class="role-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                    <i class="bi bi-geo-alt"></i>
                </div>
                <div>
                    <h3 class="role-name">District Manager</h3>
                    <div class="mt-2">
                        <span class="stats-badge"><i class="bi bi-geo-alt me-1"></i>1 District</span>
                        <span class="stats-badge"><i class="bi bi-buildings me-1"></i>Multiple Upazilas</span>
                    </div>
                </div>
            </div>
            <h5 class="mb-3">Key Responsibilities:</h5>
            <ul class="responsibility-list">
                <li>Manage healthcare services within assigned district</li>
                <li>Supervise all Upazila Supervisors in the district</li>
                <li>Monitor upazila-level operations and performance</li>
                <li>Manage customer records and service delivery in the district</li>
                <li>Coordinate with Divisional Chief for resources and support</li>
                <li>Generate district-level reports and analytics</li>
                <li>Ensure quality standards across all upazilas</li>
                <li>Address district-wide challenges and implement solutions</li>
            </ul>
        </div>

        <!-- Upazila Supervisor Role -->
        <div class="role-card">
            <div class="role-header">
                <div class="role-icon" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                    <i class="bi bi-building"></i>
                </div>
                <div>
                    <h3 class="role-name">Upazila Supervisor</h3>
                    <div class="mt-2">
                        <span class="stats-badge"><i class="bi bi-building me-1"></i>1 Upazila</span>
                        <span class="stats-badge"><i class="bi bi-person-hearts me-1"></i>Multiple PHOs</span>
                    </div>
                </div>
            </div>
            <h5 class="mb-3">Key Responsibilities:</h5>
            <ul class="responsibility-list">
                <li>Oversee healthcare operations within assigned upazila</li>
                <li>Manage and support all PHOs (Primary Healthcare Officers) in the upazila</li>
                <li>Monitor PHO performance and customer satisfaction</li>
                <li>Manage upazila-level customer records and services</li>
                <li>Generate upazila reports for District Manager review</li>
                <li>Ensure timely service delivery and quality care</li>
                <li>Coordinate with healthcare providers in the upazila</li>
                <li>Address local challenges and implement best practices</li>
            </ul>
        </div>

        <!-- PHO Role -->
        <div class="role-card">
            <div class="role-header">
                <div class="role-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                    <i class="bi bi-person-hearts"></i>
                </div>
                <div>
                    <h3 class="role-name">PHO (Primary Healthcare Officer)</h3>
                    <div class="mt-2">
                        <span class="stats-badge"><i class="bi bi-people me-1"></i>Direct Customer Contact</span>
                        <span class="stats-badge"><i class="bi bi-heart-pulse me-1"></i>Frontline Service</span>
                    </div>
                </div>
            </div>
            <h5 class="mb-3">Key Responsibilities:</h5>
            <ul class="responsibility-list">
                <li>Provide direct healthcare services and support to customers</li>
                <li>Manage assigned customer portfolio and their healthcare needs</li>
                <li>Process customer registrations and maintain records</li>
                <li>Assist customers with claims and service requests</li>
                <li>Ensure timely response to customer inquiries and issues</li>
                <li>Coordinate with local healthcare providers for service delivery</li>
                <li>Report customer feedback and service gaps to Upazila Supervisor</li>
                <li>Maintain accurate documentation and service logs</li>
                <li>Build strong relationships with customers and community</li>
            </ul>
        </div>

        <!-- Customer Role -->
        <div class="role-card">
            <div class="role-header">
                <div class="role-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <i class="bi bi-person"></i>
                </div>
                <div>
                    <h3 class="role-name">Customer</h3>
                    <div class="mt-2">
                        <span class="stats-badge"><i class="bi bi-shield-check me-1"></i>Service Recipient</span>
                        <span class="stats-badge"><i class="bi bi-heart me-1"></i>Healthcare Beneficiary</span>
                    </div>
                </div>
            </div>
            <h5 class="mb-3">Access & Privileges:</h5>
            <ul class="responsibility-list">
                <li>Access healthcare services through designated PHO</li>
                <li>View and manage personal profile and health information</li>
                <li>Submit and track healthcare claims and requests</li>
                <li>Receive notifications about services and updates</li>
                <li>Contact support team for assistance and guidance</li>
                <li>Access healthcare provider network in their area</li>
                <li>View service history and documentation</li>
                <li>Provide feedback to improve service quality</li>
            </ul>
        </div>
    </div>
</section>

<!-- Coverage Stats Section -->
<section class="stats-section" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: white; padding: 60px 0;">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="text-white mb-3">Our National Coverage</h2>
        </div>
        <div class="row text-center">
            <div class="col-lg-3 col-md-6 mb-4">
                <div style="font-size: 2.5rem; font-weight: 800;">8</div>
                <div style="font-size: 1.1rem; opacity: 0.9;">Divisions</div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div style="font-size: 2.5rem; font-weight: 800;">64</div>
                <div style="font-size: 1.1rem; opacity: 0.9;">Districts</div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div style="font-size: 2.5rem; font-weight: 800;">500+</div>
                <div style="font-size: 1.1rem; opacity: 0.9;">Upazilas</div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div style="font-size: 2.5rem; font-weight: 800;">100%</div>
                <div style="font-size: 1.1rem; opacity: 0.9;">National Coverage</div>
            </div>
        </div>
    </div>
</section>
@endsection

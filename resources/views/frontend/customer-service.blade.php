@extends('frontend.layouts.app')

@section('title', 'Customer Service & Claims')
@section('meta_description', 'Learn about Prottoy Healthcare customer service, claims processing, and support services')

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

    .service-section {
        padding: 80px 0;
    }

    .service-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        padding: 2.5rem;
        height: 100%;
        transition: all 0.3s ease;
        border-top: 5px solid #667eea;
    }

    .service-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .service-icon {
        width: 80px;
        height: 80px;
        border-radius: 15px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        color: white;
        margin-bottom: 1.5rem;
    }

    .service-title {
        font-size: 1.6rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: #2c3e50;
    }

    .service-text {
        color: #555;
        line-height: 1.8;
    }

    .claims-process-section {
        background: #f8f9fa;
        padding: 80px 0;
    }

    .process-timeline {
        position: relative;
        padding: 2rem 0;
    }

    .process-step {
        position: relative;
        padding-left: 100px;
        margin-bottom: 3rem;
    }

    .step-number {
        position: absolute;
        left: 0;
        top: 0;
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        font-weight: 800;
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    }

    .step-connector {
        position: absolute;
        left: 35px;
        top: 70px;
        width: 3px;
        height: calc(100% - 70px);
        background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
    }

    .process-step:last-child .step-connector {
        display: none;
    }

    .step-content {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
    }

    .step-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 1rem;
    }

    .step-description {
        color: #555;
        line-height: 1.8;
    }

    .cash-payment-section {
        padding: 80px 0;
    }

    .payment-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 20px;
        padding: 3rem;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    }

    .payment-methods {
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
        gap: 2rem;
        margin-top: 2rem;
    }

    .payment-method {
        text-align: center;
        flex: 1;
        min-width: 150px;
    }

    .payment-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        margin: 0 auto 1rem;
    }

    .contact-section {
        background: #f8f9fa;
        padding: 80px 0;
    }

    .contact-card {
        background: white;
        border-radius: 15px;
        padding: 2.5rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        text-align: center;
        height: 100%;
        transition: all 0.3s ease;
    }

    .contact-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .contact-icon {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: white;
        margin: 0 auto 1.5rem;
    }

    .contact-title {
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: #2c3e50;
    }

    .contact-detail {
        font-size: 1.1rem;
        color: #667eea;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .faq-section {
        padding: 80px 0;
    }

    .faq-item {
        background: white;
        border-radius: 12px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        margin-bottom: 1.5rem;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .faq-question {
        padding: 1.5rem 2rem;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .faq-question:hover {
        opacity: 0.9;
    }

    .faq-answer {
        padding: 1.5rem 2rem;
        color: #555;
        line-height: 1.8;
        display: none;
    }

    .faq-item.active .faq-answer {
        display: block;
    }

    .notice-archive-section {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
        color: white;
        padding: 80px 0;
    }

    .archive-item {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
    }

    .archive-item:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateX(5px);
    }

    .archive-date {
        font-size: 0.9rem;
        opacity: 0.8;
        margin-bottom: 0.5rem;
    }

    .archive-title {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    @media (max-width: 768px) {
        .page-header h1 {
            font-size: 2rem;
        }

        .process-step {
            padding-left: 80px;
        }

        .step-number {
            width: 50px;
            height: 50px;
            font-size: 1.3rem;
        }

        .step-connector {
            left: 25px;
            top: 50px;
            height: calc(100% - 50px);
        }
    }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="container">
        <h1 class="fade-in-up">Customer Service & Claims</h1>
        <p class="fade-in-up">Your complete guide to our services and claims process</p>
    </div>
</div>

<!-- Customer Services Section -->
<section class="service-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Our Customer Services</h2>
            <p class="section-subtitle">Comprehensive support for all your healthcare needs</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="bi bi-headset"></i>
                    </div>
                    <h3 class="service-title">24/7 Helpline</h3>
                    <p class="service-text">
                        Round-the-clock customer support through our dedicated helpline. Our trained representatives
                        are available to assist you with queries, claims, and emergency situations at any time.
                    </p>
                    <div class="mt-3">
                        <strong style="color: #667eea; font-size: 1.2rem;">
                            <i class="bi bi-telephone-fill me-2"></i>16247
                        </strong>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="service-card" style="border-top-color: #28a745;">
                    <div class="service-icon" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                        <i class="bi bi-file-earmark-medical"></i>
                    </div>
                    <h3 class="service-title">Claims Processing</h3>
                    <p class="service-text">
                        Fast and efficient claims processing with transparent procedures. Submit your claims online
                        or through your PHO, and track the status in real-time through our portal.
                    </p>
                    <div class="mt-3">
                        <strong style="color: #28a745;">
                            <i class="bi bi-clock-history me-2"></i>48-72 Hours Processing
                        </strong>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="service-card" style="border-top-color: #dc3545;">
                    <div class="service-icon" style="background: linear-gradient(135deg, #dc3545 0%, #ff6b6b 100%);">
                        <i class="bi bi-hospital"></i>
                    </div>
                    <h3 class="service-title">Healthcare Network</h3>
                    <p class="service-text">
                        Access to a vast network of hospitals, clinics, and diagnostic centers across Bangladesh.
                        Receive quality healthcare services from our partner providers with direct billing facility.
                    </p>
                    <div class="mt-3">
                        <strong style="color: #dc3545;">
                            <i class="bi bi-geo-alt-fill me-2"></i>500+ Partner Facilities
                        </strong>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="service-card" style="border-top-color: #ffc107;">
                    <div class="service-icon" style="background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);">
                        <i class="bi bi-person-check"></i>
                    </div>
                    <h3 class="service-title">Personal PHO</h3>
                    <p class="service-text">
                        Each customer is assigned a dedicated Primary Healthcare Officer who serves as your point
                        of contact for all healthcare needs, assistance, and support services.
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="service-card" style="border-top-color: #6f42c1;">
                    <div class="service-icon" style="background: linear-gradient(135deg, #6f42c1 0%, #9b59b6 100%);">
                        <i class="bi bi-laptop"></i>
                    </div>
                    <h3 class="service-title">Online Portal</h3>
                    <p class="service-text">
                        User-friendly online portal to manage your profile, view service history, submit claims,
                        download documents, and access all healthcare information conveniently.
                    </p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="service-card" style="border-top-color: #17a2b8;">
                    <div class="service-icon" style="background: linear-gradient(135deg, #17a2b8 0%, #00bcd4 100%);">
                        <i class="bi bi-bell"></i>
                    </div>
                    <h3 class="service-title">Notifications</h3>
                    <p class="service-text">
                        Stay informed with timely notifications about claim status, policy updates, service reminders,
                        and important announcements through SMS, email, and portal notifications.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Claims Process Section -->
<section class="claims-process-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Claims Process</h2>
            <p class="section-subtitle">Step-by-step guide to submitting and tracking your claims</p>
        </div>

        <div class="process-timeline">
            <div class="process-step">
                <div class="step-number">1</div>
                <div class="step-connector"></div>
                <div class="step-content">
                    <h4 class="step-title">Receive Healthcare Service</h4>
                    <p class="step-description">
                        Visit any of our partner healthcare facilities and receive the medical service you need.
                        Inform the provider that you are a Prottoy Healthcare customer and present your customer ID
                        or card. Many of our partner facilities offer direct billing, so you may not need to pay upfront.
                    </p>
                </div>
            </div>

            <div class="process-step">
                <div class="step-number">2</div>
                <div class="step-connector"></div>
                <div class="step-content">
                    <h4 class="step-title">Collect Required Documents</h4>
                    <p class="step-description">
                        Gather all necessary documents for your claim:
                        <ul class="mt-2">
                            <li>Original medical bills and invoices</li>
                            <li>Prescription from registered physician</li>
                            <li>Diagnostic test reports (if applicable)</li>
                            <li>Discharge summary (for hospitalization)</li>
                            <li>Any other supporting medical documents</li>
                        </ul>
                    </p>
                </div>
            </div>

            <div class="process-step">
                <div class="step-number">3</div>
                <div class="step-connector"></div>
                <div class="step-content">
                    <h4 class="step-title">Submit Claim</h4>
                    <p class="step-description">
                        Submit your claim through one of the following methods:
                        <ul class="mt-2">
                            <li><strong>Online Portal:</strong> Upload documents through your customer dashboard</li>
                            <li><strong>Through PHO:</strong> Submit documents to your assigned Primary Healthcare Officer</li>
                            <li><strong>Email:</strong> Send scanned copies to claims@prottoyhealthcare.com</li>
                            <li><strong>In Person:</strong> Visit your nearest Prottoy Healthcare office</li>
                        </ul>
                    </p>
                </div>
            </div>

            <div class="process-step">
                <div class="step-number">4</div>
                <div class="step-connector"></div>
                <div class="step-content">
                    <h4 class="step-title">Claim Verification</h4>
                    <p class="step-description">
                        Our claims team will verify your submission within 24 hours. They will review all documents,
                        check service eligibility, and may contact you if additional information is required. You will
                        receive a confirmation email/SMS with your claim reference number.
                    </p>
                </div>
            </div>

            <div class="process-step">
                <div class="step-number">5</div>
                <div class="step-connector"></div>
                <div class="step-content">
                    <h4 class="step-title">Processing & Approval</h4>
                    <p class="step-description">
                        Claims are typically processed within 48-72 hours. You can track the status through:
                        <ul class="mt-2">
                            <li>Online portal using your claim reference number</li>
                            <li>SMS updates sent automatically</li>
                            <li>Contacting your PHO or our helpline</li>
                        </ul>
                    </p>
                </div>
            </div>

            <div class="process-step">
                <div class="step-number">6</div>
                <div class="step-content">
                    <h4 class="step-title">Payment & Settlement</h4>
                    <p class="step-description">
                        Once approved, reimbursement will be processed immediately. Payment options include:
                        <ul class="mt-2">
                            <li><strong>Bank Transfer:</strong> Direct deposit to your registered bank account (1-2 business days)</li>
                            <li><strong>Mobile Banking:</strong> bKash, Nagad, Rocket transfer (instant)</li>
                            <li><strong>Cash Collection:</strong> Pick up from designated Prottoy Healthcare office</li>
                        </ul>
                        You will receive a settlement statement with detailed breakdown via email.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Cash Payment Options Section -->
<section class="cash-payment-section">
    <div class="container">
        <div class="payment-card">
            <div class="text-center mb-4">
                <h2 class="text-white">Cash Payment & Collection Methods</h2>
                <p class="text-white-50" style="font-size: 1.1rem;">
                    Multiple convenient options for receiving your claim settlements
                </p>
            </div>

            <div class="payment-methods">
                <div class="payment-method">
                    <div class="payment-icon">
                        <i class="bi bi-bank"></i>
                    </div>
                    <h5>Bank Transfer</h5>
                    <p style="font-size: 0.95rem; opacity: 0.9;">
                        Direct deposit to your bank account within 1-2 business days
                    </p>
                </div>

                <div class="payment-method">
                    <div class="payment-icon">
                        <i class="bi bi-phone"></i>
                    </div>
                    <h5>Mobile Banking</h5>
                    <p style="font-size: 0.95rem; opacity: 0.9;">
                        Instant transfer to bKash, Nagad, or Rocket
                    </p>
                </div>

                <div class="payment-method">
                    <div class="payment-icon">
                        <i class="bi bi-cash-coin"></i>
                    </div>
                    <h5>Cash Pickup</h5>
                    <p style="font-size: 0.95rem; opacity: 0.9;">
                        Collect from any Prottoy Healthcare office
                    </p>
                </div>

                <div class="payment-method">
                    <div class="payment-icon">
                        <i class="bi bi-credit-card"></i>
                    </div>
                    <h5>Cheque</h5>
                    <p style="font-size: 0.95rem; opacity: 0.9;">
                        Account payee cheque sent to your address
                    </p>
                </div>
            </div>

            <div class="text-center mt-4">
                <p class="mb-0" style="font-size: 1.1rem;"><i class="bi bi-info-circle me-2"></i>Choose your preferred payment method during claim submission</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Support Section -->
<section class="contact-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Contact Customer Support</h2>
            <p class="section-subtitle">We're here to help you with any questions or concerns</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="bi bi-telephone"></i>
                    </div>
                    <h4 class="contact-title">Phone Support</h4>
                    <div class="contact-detail">16247</div>
                    <p class="text-muted">Available 24/7</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="contact-card">
                    <div class="contact-icon" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                        <i class="bi bi-envelope"></i>
                    </div>
                    <h4 class="contact-title">Email Support</h4>
                    <div class="contact-detail">support@prottoyhealthcare.com</div>
                    <p class="text-muted">Response within 24 hours</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="contact-card">
                    <div class="contact-icon" style="background: linear-gradient(135deg, #dc3545 0%, #ff6b6b 100%);">
                        <i class="bi bi-chat-dots"></i>
                    </div>
                    <h4 class="contact-title">Live Chat</h4>
                    <div class="contact-detail">Online Portal</div>
                    <p class="text-muted">Mon-Fri, 9 AM - 6 PM</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="contact-card">
                    <div class="contact-icon" style="background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);">
                        <i class="bi bi-person-hearts"></i>
                    </div>
                    <h4 class="contact-title">Your PHO</h4>
                    <div class="contact-detail">Direct Contact</div>
                    <p class="text-muted">Check your portal</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="faq-section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Frequently Asked Questions</h2>
            <p class="section-subtitle">Quick answers to common questions</p>
        </div>

        <div class="faq-item active">
            <div class="faq-question">
                <span>How long does it take to process a claim?</span>
                <i class="bi bi-chevron-down"></i>
            </div>
            <div class="faq-answer">
                Most claims are processed within 48-72 hours after submission. Complex cases requiring additional
                verification may take up to 5-7 business days. You will be notified immediately once your claim is approved.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                <span>What documents do I need to submit a claim?</span>
                <i class="bi bi-chevron-down"></i>
            </div>
            <div class="faq-answer">
                You need: (1) Original bills/invoices from the healthcare provider, (2) Prescription from a registered
                physician, (3) Diagnostic test reports if applicable, (4) Discharge summary for hospitalization, and
                (5) Your customer ID. Your PHO can help you gather all required documents.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                <span>Can I choose any hospital or clinic?</span>
                <i class="bi bi-chevron-down"></i>
            </div>
            <div class="faq-answer">
                We recommend visiting our partner facilities for direct billing and faster processing. However, you can
                visit any licensed healthcare provider and submit a reimbursement claim. Check our online portal or
                contact your PHO for the list of partner facilities in your area.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                <span>What if my claim is rejected?</span>
                <i class="bi bi-chevron-down"></i>
            </div>
            <div class="faq-answer">
                You will receive a detailed explanation for any rejection. Common reasons include incomplete documentation,
                services not covered under your plan, or late submission. You have the right to appeal the decision within
                30 days by providing additional information or clarification. Contact our claims department for assistance.
            </div>
        </div>

        <div class="faq-item">
            <div class="faq-question">
                <span>How do I track my claim status?</span>
                <i class="bi bi-chevron-down"></i>
            </div>
            <div class="faq-answer">
                You can track your claim through: (1) Online portal using your claim reference number, (2) SMS updates
                sent automatically to your registered mobile number, (3) Calling our helpline 16247, or (4) Contacting
                your assigned PHO directly.
            </div>
        </div>
    </div>
</section>



<script>
document.addEventListener('DOMContentLoaded', function() {
    // FAQ Toggle
    const faqItems = document.querAll('.faq-item');
    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        question.addEventListener('click', () => {
            // Close others
            faqItems.forEach(otherItem => {
                if (otherItem !== item) {
                    otherItem.classList.remove('active');
                }
            });
            // Toggle current
            item.classList.toggle('active');
        });
    });
});
</script>
@endsection

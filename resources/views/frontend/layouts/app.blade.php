<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Prottoy Healthcare - Comprehensive Healthcare Management System')">
    <title>@yield('title', 'Home') - Prottoy Healthcare</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
            --success-color: #198754;
            --info-color: #0dcaf0;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --dark-color: #212529;
            --light-color: #f8f9fa;
        }

        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            overflow-x: hidden;
        }

        /* Navbar Styles */
        .navbar {
            background: white !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 1rem 0;
            transition: all 0.3s ease;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color) !important;
        }

        .navbar-nav .nav-link {
            color: var(--dark-color);
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            margin: 0 0.25rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: var(--primary-color);
        }

        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 50%;
            background-color: var(--primary-color);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .navbar-nav .nav-link:hover::after,
        .navbar-nav .nav-link.active::after {
            width: 80%;
        }

        .btn-login {
            background: var(--primary-color);
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background: #0b5ed7;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(13, 110, 253, 0.3);
        }

        /* Footer Styles */
        .footer {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 3rem 0 1rem;
            margin-top: 4rem;
        }

        .footer h5 {
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: white;
        }

        .footer a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            display: block;
            margin-bottom: 0.5rem;
        }

        .footer a:hover {
            color: white;
            padding-left: 5px;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 1.5rem;
            margin-top: 2rem;
        }

        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            margin-right: 0.5rem;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background: white;
            color: var(--primary-color);
            transform: translateY(-3px);
        }

        /* Section Styles */
        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--dark-color);
        }

        .section-subtitle {
            color: var(--secondary-color);
            font-size: 1.1rem;
            margin-bottom: 3rem;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .navbar-nav {
                padding: 1rem 0;
            }

            .navbar-nav .nav-link {
                padding: 0.75rem 1rem !important;
            }

            .btn-login {
                margin-top: 1rem;
                width: 100%;
            }
        }

        @yield('styles')
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('frontend.home') }}">
                <i class="bi bi-heart-pulse-fill me-2"></i>Prottoy Healthcare
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('frontend.home') ? 'active' : '' }}" href="{{ route('frontend.home') }}">
                            Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('frontend.about') ? 'active' : '' }}" href="{{ route('frontend.about') }}">
                            About Us
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('frontend.organisation') ? 'active' : '' }}" href="{{ route('frontend.organisation') }}">
                            Organisation & Leadership
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('frontend.policy') ? 'active' : '' }}" href="{{ route('frontend.policy') }}">
                            Policy & Legal
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('frontend.customer-service') ? 'active' : '' }}" href="{{ route('frontend.customer-service') }}">
                            Customers & Claims
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('frontend.gallery') ? 'active' : '' }}" href="{{ route('frontend.gallery') }}">
                            Gallery
                        </a>
                    </li>
                </ul>
                <div class="d-flex">
                    <a href="{{ route('login') }}" class="btn btn-login">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Login
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            @php
                $contactInfo = \App\Models\ContactInfo::getActive();
            @endphp

            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <h5><i class="bi bi-heart-pulse-fill me-2"></i>Prottoy Healthcare</h5>
                    <p class="mb-3">Comprehensive healthcare management system providing quality healthcare services across Bangladesh.</p>
                    @if($contactInfo)
                        <div class="social-links">
                            @if($contactInfo->facebook)
                                <a href="{{ $contactInfo->facebook }}" target="_blank" rel="noopener"><i class="bi bi-facebook"></i></a>
                            @endif
                            @if($contactInfo->twitter)
                                <a href="{{ $contactInfo->twitter }}" target="_blank" rel="noopener"><i class="bi bi-twitter"></i></a>
                            @endif
                            @if($contactInfo->linkedin)
                                <a href="{{ $contactInfo->linkedin }}" target="_blank" rel="noopener"><i class="bi bi-linkedin"></i></a>
                            @endif
                            @if($contactInfo->instagram)
                                <a href="{{ $contactInfo->instagram }}" target="_blank" rel="noopener"><i class="bi bi-instagram"></i></a>
                            @endif
                        </div>
                    @else
                        <div class="social-links">
                            <a href="https://facebook.com/prottoyhealthcare" target="_blank" rel="noopener"><i class="bi bi-facebook"></i></a>
                            <a href="https://twitter.com/prottoyhealthbd" target="_blank" rel="noopener"><i class="bi bi-twitter"></i></a>
                            <a href="https://linkedin.com/company/prottoy-healthcare" target="_blank" rel="noopener"><i class="bi bi-linkedin"></i></a>
                            <a href="https://instagram.com/prottoyhealthcare" target="_blank" rel="noopener"><i class="bi bi-instagram"></i></a>
                        </div>
                    @endif
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5>Quick Links</h5>
                    <a href="{{ route('frontend.home') }}">Home</a>
                    <a href="{{ route('frontend.about') }}">About Us</a>
                    <a href="{{ route('frontend.organisation') }}">Leadership</a>
                    <a href="{{ route('frontend.gallery') }}">Gallery</a>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5>Services</h5>
                    <a href="{{ route('frontend.customer-service') }}">Customer Service</a>
                    <a href="{{ route('frontend.customer-service') }}">Claims Process</a>
                    <a href="{{ route('frontend.policy') }}">Policies</a>
                    <a href="{{ route('login') }}">Portal Login</a>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5>Contact Info</h5>
                    @if($contactInfo)
                        <p class="mb-2"><i class="bi bi-geo-alt-fill me-2"></i>{{ $contactInfo->address }}</p>
                        <p class="mb-2"><i class="bi bi-telephone-fill me-2"></i>{{ $contactInfo->phone }}</p>
                        <p class="mb-2"><i class="bi bi-envelope-fill me-2"></i>{{ $contactInfo->email }}</p>
                        @if($contactInfo->working_hours)
                            <p class="mb-2"><i class="bi bi-clock-fill me-2"></i>{{ $contactInfo->working_hours }}</p>
                        @endif
                    @else
                        <p class="mb-2"><i class="bi bi-geo-alt-fill me-2"></i>Dhaka, Bangladesh</p>
                        <p class="mb-2"><i class="bi bi-telephone-fill me-2"></i>+880 1XXX-XXXXXX</p>
                        <p class="mb-2"><i class="bi bi-envelope-fill me-2"></i>info@prottoyhealthcare.com</p>
                    @endif
                </div>
            </div>
            <div class="footer-bottom text-center">
                <p class="mb-0">&copy; {{ date('Y') }} Prottoy Healthcare System. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Campus Asset Management</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            /* Light Theme Variables */
            --primary-color: #6366f1;
            --primary-hover: #4f46e5;
            --secondary-color: #10b981;
            --dark-color: #1e293b;
            --light-color: #f8fafc;
            --accent-color: #8b5cf6;
            --border-radius: 0.75rem;
            --box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            --text-color: #334155;
            --bg-color: #f8fafc;
            --card-bg: #ffffff;
            --navbar-bg: linear-gradient(135deg, #6366f1, #8b5cf6);
            --navbar-text: rgba(255, 255, 255, 0.85);
        }
        
        [data-bs-theme="dark"] {
            /* Dark Theme Variables */
            --primary-color: #818cf8;
            --primary-hover: #6366f1;
            --secondary-color: #34d399;
            --dark-color: #f8fafc;
            --light-color: #1e293b;
            --accent-color: #a78bfa;
            --text-color: #e2e8f0;
            --bg-color: #0f172a;
            --card-bg: #1e293b;
            --navbar-bg: linear-gradient(135deg, #4f46e5, #7c3aed);
            --navbar-text: rgba(255, 255, 255, 0.9);
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg-color);
            color: var(--text-color);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }
        
        .hero {
            background: var(--navbar-bg);
            color: white;
            padding: 6rem 0;
            position: relative;
            overflow: hidden;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E");
            z-index: 0;
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
        }
        
        .hero h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
        
        .hero p {
            font-size: 1.25rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto 2rem;
        }
        
        .btn-hero {
            padding: 0.75rem 2rem;
            font-size: 1.1rem;
            font-weight: 500;
            border-radius: 9999px;
            background-color: white;
            color: var(--primary-color);
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .btn-hero:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
            background-color: white;
            color: var(--primary-hover);
        }
        
        .feature-card {
            background-color: var(--card-bg);
            border-radius: var(--border-radius);
            padding: 2rem;
            height: 100%;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            box-shadow: var(--box-shadow);
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .feature-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--navbar-bg);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .feature-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--text-color);
        }
        
        footer {
            background-color: var(--card-bg);
            padding: 2rem 0;
            margin-top: auto;
            box-shadow: 0 -1px 3px rgba(0, 0, 0, 0.05);
            color: var(--text-color);
        }
        
        .navbar {
            background: var(--navbar-bg);
            box-shadow: var(--box-shadow);
            padding: 1rem 0;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: white !important;
            font-size: 1.5rem;
            letter-spacing: 0.5px;
        }
        
        .navbar-nav .nav-link {
            color: var(--navbar-text) !important;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: var(--border-radius);
            transition: all 0.3s ease;
        }
        
        .navbar-nav .nav-link:hover {
            color: white !important;
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }
        
        .btn-login {
            background-color: white;
            color: var(--primary-color);
            border: none;
            font-weight: 500;
            padding: 0.5rem 1.5rem;
            border-radius: 9999px;
            transition: all 0.3s ease;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            color: var(--primary-hover);
        }
        
        .btn-register {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            font-weight: 500;
            padding: 0.5rem 1.5rem;
            border-radius: 9999px;
            transition: all 0.3s ease;
        }
        
        .btn-register:hover {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            transform: translateY(-2px);
        }
        
        /* Fix for navbar toggler */
        .navbar-toggler {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.85%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        
        /* Theme toggle button */
        .theme-toggle {
            background: transparent;
            border: none;
            color: white;
            font-size: 1.25rem;
            padding: 0.5rem;
            cursor: pointer;
            transition: transform 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .theme-toggle:hover {
            transform: rotate(30deg);
            background-color: rgba(255, 255, 255, 0.2);
        }
        
        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }
        
        .delay-1 {
            animation-delay: 0.1s;
        }
        
        .delay-2 {
            animation-delay: 0.2s;
        }
        
        .delay-3 {
            animation-delay: 0.3s;
        }
        
        .delay-4 {
            animation-delay: 0.4s;
        }
        
        .delay-5 {
            animation-delay: 0.5s;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="bi bi-boxes me-2"></i> Polteksi Asset Management
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    @auth
                        <li class="nav-item me-2">
                            <a class="nav-link" href="{{ route('assets.index') }}">
                                <i class="bi bi-box me-1"></i> Assets
                            </a>
                        </li>
                        <li class="nav-item me-2">
                            <a class="nav-link" href="{{ route('locations.index') }}">
                                <i class="bi bi-geo-alt me-1"></i> Locations
                            </a>
                        </li>
                    @endauth
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item me-2">
                        <button id="themeToggle" class="theme-toggle" aria-label="Toggle theme">
                            <i class="bi bi-sun-fill" id="lightIcon"></i>
                            <i class="bi bi-moon-fill d-none" id="darkIcon"></i>
                        </button>
                    </li>
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                                @if(Auth::user()->isAdmin())
                                    <span class="badge bg-primary ms-1">Admin</span>
                                @else
                                    <span class="badge bg-info ms-1">Student</span>
                                @endif
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        <i class="bi bi-person me-2"></i> Profile
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-box-arrow-right me-2"></i> Log Out
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item me-2">
                            <a class="btn btn-login" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Log In
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-register" href="{{ route('register') }}">
                                <i class="bi bi-person-plus me-1"></i> Register
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
    
    <header class="hero text-center">
        <div class="container hero-content">
            <h1 class="animate-fade-in">Campus Asset Management</h1>
            <p class="animate-fade-in delay-1">A modern solution for tracking and managing all your campus facility assets with QR code technology</p>
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-hero animate-fade-in delay-2">
                    <i class="bi bi-speedometer2 me-2"></i> Go to Dashboard
                </a>
            @else
                <div class="animate-fade-in delay-2">
                    <a href="{{ route('login') }}" class="btn btn-hero me-2">
                        <i class="bi bi-box-arrow-in-right me-2"></i> Log In
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-hero" style="background-color: rgba(255, 255, 255, 0.2); color: white;">
                        <i class="bi bi-person-plus me-2"></i> Register
                    </a>
                </div>
            @endauth
        </div>
    </header>
    
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5 animate-fade-in">
                <h2 class="fw-bold">Powerful Features</h2>
                <p class="text-muted">Everything you need to manage your campus assets efficiently</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4 animate-fade-in delay-1">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-qr-code"></i>
                        </div>
                        <h3 class="feature-title">QR Code Generation</h3>
                        <p>Automatically generate unique QR codes for each asset for easy scanning and identification.</p>
                    </div>
                </div>
                
                <div class="col-md-4 animate-fade-in delay-2">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <h3 class="feature-title">Location Tracking</h3>
                        <p>Keep track of where each asset is located across your campus facilities.</p>
                    </div>
                </div>
                
                <div class="col-md-4 animate-fade-in delay-3">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-clipboard-data"></i>
                        </div>
                        <h3 class="feature-title">Inventory Management</h3>
                        <p>Comprehensive inventory management with detailed asset information and status tracking.</p>
                    </div>
                </div>
                
                <div class="col-md-4 animate-fade-in delay-2">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-search"></i>
                        </div>
                        <h3 class="feature-title">Quick Search</h3>
                        <p>Easily find assets with powerful search functionality across all asset properties.</p>
                    </div>
                </div>
                
                <div class="col-md-4 animate-fade-in delay-3">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-bar-chart"></i>
                        </div>
                        <h3 class="feature-title">Asset Analytics</h3>
                        <p>Get insights into your asset distribution, conditions, and management efficiency.</p>
                    </div>
                </div>
                
                <div class="col-md-4 animate-fade-in delay-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h3 class="feature-title">Role-Based Access</h3>
                        <p>Secure access control with admin and student roles to manage permissions appropriately.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section class="py-5" style="background-color: var(--bg-color);">
        <div class="container text-center animate-fade-in">
            <h2 class="fw-bold mb-4">Ready to get started?</h2>
            <p class="text-muted mb-4">Start managing your campus assets efficiently today</p>
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg">
                    <i class="bi bi-arrow-right-circle me-2"></i> Go to Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg me-2">
                    <i class="bi bi-box-arrow-in-right me-2"></i> Log In
                </a>
                <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">
                    <i class="bi bi-person-plus me-2"></i> Register
                </a>
            @endauth
        </div>
    </section>
    
    <footer>
        <div class="container text-center">
            <p class="mb-0">
                <i class="bi bi-cpu me-2"></i> {{ date('Y') }} Campus Asset Management System | Powered by AI Technology
            </p>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Theme Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggle = document.getElementById('themeToggle');
            const lightIcon = document.getElementById('lightIcon');
            const darkIcon = document.getElementById('darkIcon');
            const htmlElement = document.documentElement;
            
            // Check for saved theme preference or use preferred color scheme
            const savedTheme = localStorage.getItem('theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            
            // Set initial theme
            if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
                htmlElement.setAttribute('data-bs-theme', 'dark');
                lightIcon.classList.add('d-none');
                darkIcon.classList.remove('d-none');
            } else {
                htmlElement.setAttribute('data-bs-theme', 'light');
                lightIcon.classList.remove('d-none');
                darkIcon.classList.add('d-none');
            }
            
            // Toggle theme on button click
            themeToggle.addEventListener('click', function() {
                const currentTheme = htmlElement.getAttribute('data-bs-theme');
                const newTheme = currentTheme === 'light' ? 'dark' : 'light';
                
                htmlElement.setAttribute('data-bs-theme', newTheme);
                localStorage.setItem('theme', newTheme);
                
                // Toggle icons
                lightIcon.classList.toggle('d-none');
                darkIcon.classList.toggle('d-none');
                
                // Add animation effect
                document.body.style.transition = 'background-color 0.3s ease, color 0.3s ease';
            });
        });
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Asset Management') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700&display=swap" rel="stylesheet" />
        
        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
        
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <!-- Custom CSS -->
        <link href="{{ asset('css/theme.css') }}" rel="stylesheet">
        
        <style>
            .auth-wrapper {
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                background: var(--bg-color);
                padding: 2rem 1rem;
                position: relative;
                overflow: hidden;
            }
            
            .auth-card {
                width: 100%;
                max-width: 450px;
                background: var(--card-bg);
                border-radius: var(--border-radius);
                box-shadow: var(--box-shadow);
                overflow: hidden;
                position: relative;
                z-index: 10;
            }
            
            .auth-header {
                padding: 2rem;
                text-align: center;
                background: var(--navbar-bg);
                color: white;
            }
            
            .auth-header .logo {
                width: 80px;
                height: 80px;
                margin-bottom: 1rem;
                background: rgba(255, 255, 255, 0.1);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 2.5rem;
                margin: 0 auto 1rem;
            }
            
            .auth-header h1 {
                font-weight: 700;
                font-size: 1.75rem;
                margin-bottom: 0.5rem;
            }
            
            .auth-header p {
                opacity: 0.9;
                margin-bottom: 0;
            }
            
            .auth-body {
                padding: 2rem;
            }
            
            .form-floating {
                margin-bottom: 1.5rem;
            }
            
            .form-floating > .form-control {
                padding: 1rem 0.75rem;
                height: calc(3.5rem + 2px);
                line-height: 1.25;
            }
            
            .form-floating > label {
                padding: 1rem 0.75rem;
            }
            
            .btn-auth {
                padding: 0.75rem 2rem;
                font-weight: 500;
                width: 100%;
                border-radius: var(--border-radius);
                background: var(--primary-color);
                border-color: var(--primary-color);
                box-shadow: 0 4px 6px rgba(99, 102, 241, 0.25);
                transition: all 0.3s ease;
            }
            
            .btn-auth:hover {
                background: var(--primary-hover);
                border-color: var(--primary-hover);
                transform: translateY(-2px);
                box-shadow: 0 6px 10px rgba(99, 102, 241, 0.3);
            }
            
            .auth-footer {
                text-align: center;
                padding: 1rem 2rem 2rem;
            }
            
            .auth-footer a {
                color: var(--primary-color);
                text-decoration: none;
                font-weight: 500;
                transition: all 0.2s ease;
            }
            
            .auth-footer a:hover {
                color: var(--primary-hover);
                text-decoration: underline;
            }
            
            .auth-divider {
                display: flex;
                align-items: center;
                margin: 1.5rem 0;
            }
            
            .auth-divider::before,
            .auth-divider::after {
                content: '';
                flex: 1;
                height: 1px;
                background: var(--border-color);
            }
            
            .auth-divider span {
                padding: 0 1rem;
                color: var(--text-color);
                opacity: 0.7;
                font-size: 0.875rem;
            }
            
            .form-check-input:checked {
                background-color: var(--primary-color);
                border-color: var(--primary-color);
            }
            
            .form-check-input:focus {
                border-color: var(--primary-color);
                box-shadow: 0 0 0 0.25rem rgba(99, 102, 241, 0.25);
            }
            
            .theme-toggle-auth {
                position: absolute;
                top: 1rem;
                right: 1rem;
                background: rgba(255, 255, 255, 0.2);
                border: none;
                color: white;
                width: 36px;
                height: 36px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: all 0.3s ease;
                z-index: 10;
            }
            
            .theme-toggle-auth:hover {
                background: rgba(255, 255, 255, 0.3);
                transform: rotate(30deg);
            }
            
            .auth-background {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: 1;
                background-image: url("{{ asset('images/pattern.svg') }}");
                background-size: 200px;
                background-repeat: repeat;
                opacity: 0.04;
            }
            
            [data-bs-theme="dark"] .auth-background {
                opacity: 0.02;
            }
            
            @keyframes float {
                0% {
                    transform: translateY(0px);
                }
                50% {
                    transform: translateY(-20px);
                }
                100% {
                    transform: translateY(0px);
                }
            }
            
            .floating-shape {
                position: absolute;
                opacity: 0.1;
                z-index: 2;
            }
            
            .shape-1 {
                top: 10%;
                left: 10%;
                width: 100px;
                height: 100px;
                border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
                background: var(--primary-color);
                animation: float 8s ease-in-out infinite;
            }
            
            .shape-2 {
                bottom: 10%;
                right: 10%;
                width: 150px;
                height: 150px;
                border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
                background: var(--accent-color);
                animation: float 10s ease-in-out infinite;
                animation-delay: 1s;
            }
            
            .shape-3 {
                top: 50%;
                right: 20%;
                width: 80px;
                height: 80px;
                border-radius: 50%;
                background: var(--success-color);
                animation: float 7s ease-in-out infinite;
                animation-delay: 2s;
            }
            
            .btn-outline-primary {
                color: var(--primary-color);
                border-color: var(--primary-color);
            }
            
            .btn-outline-primary:hover {
                background-color: var(--primary-color);
                border-color: var(--primary-color);
                color: white;
            }
        </style>
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="auth-background"></div>
        <div class="floating-shape shape-1"></div>
        <div class="floating-shape shape-2"></div>
        <div class="floating-shape shape-3"></div>
        
        <div class="auth-wrapper">
            <div class="auth-card">
                <button id="themeToggle" class="theme-toggle-auth" aria-label="Toggle theme">
                    <i class="bi bi-sun-fill" id="lightIcon"></i>
                    <i class="bi bi-moon-fill d-none" id="darkIcon"></i>
                </button>
                
                {{ $slot }}
            </div>
        </div>
        
        <!-- Bootstrap JS -->
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
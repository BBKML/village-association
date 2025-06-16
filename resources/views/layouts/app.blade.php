<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', $association->name ?? 'Association du Village')</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Lightbox CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="{{ mix('css/app.css') }}" rel="stylesheet" />
    <script src="{{ mix('js/app.js') }}" defer></script>

    <style>
        :root {
            --primary: #3b82f6;
            --primary-dark: #2563eb;
            --primary-light: #60a5fa;
            --secondary: #8b5cf6;
            --accent: #f59e0b;
            --success: #10b981;
            --warning: #f59e0b;
            --error: #ef4444;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
        }
        
        * {
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: var(--gray-800);
            scroll-behavior: smooth;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        /* Navigation Styles */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .navbar.scrolled {
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        }
        
        .nav-link {
            position: relative;
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            font-weight: 500;
            font-size: 0.875rem;
            letter-spacing: -0.025em;
            color: var(--gray-600);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .nav-link:hover {
            color: var(--primary);
            background: rgba(59, 130, 246, 0.08);
            transform: translateY(-2px);
        }
        
        .nav-link.active {
            color: var(--primary);
            background: rgba(59, 130, 246, 0.1);
            font-weight: 600;
        }
        
        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            transform: translateX(-50%);
            width: 20px;
            height: 2px;
            background: var(--primary);
            border-radius: 1px;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: transform 0.3s ease;
        }
        
        .logo-container:hover {
            transform: scale(1.05);
        }
        
        .logo-image {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            object-fit: cover;
            border: 2px solid var(--primary);
            transition: all 0.3s ease;
        }
        
        .logo-text {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--gray-800);
            letter-spacing: -0.025em;
        }
        
        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            position: relative;
            overflow: hidden;
            min-height: 70vh;
            display: flex;
            align-items: center;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80') no-repeat center center/cover;
            opacity: 0.15;
            z-index: 0;
        }
        
        .hero-section::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(59, 130, 246, 0.9) 0%, rgba(139, 92, 246, 0.8) 100%);
            z-index: 1;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 1200px;
            margin: 0 auto;
            padding: 4rem 2rem;
            text-align: center;
        }
        
        .hero-title {
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 800;
            color: white;
            margin-bottom: 1.5rem;
            line-height: 1.1;
            letter-spacing: -0.02em;
        }
        
        .hero-subtitle {
            font-size: 1.25rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2.5rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
        }
        
        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.875rem 1.75rem;
            border-radius: 0.75rem;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            letter-spacing: -0.025em;
            cursor: pointer;
            border: none;
            position: relative;
            overflow: hidden;
        }
        
        .btn-primary {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 14px rgba(59, 130, 246, 0.3);
        }
        
        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
        }
        
        .btn-secondary {
            background: white;
            color: var(--primary);
            border: 2px solid white;
        }
        
        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateY(-3px);
        }
        
        .btn-accent {
            background: var(--accent);
            color: white;
            box-shadow: 0 4px 14px rgba(245, 158, 11, 0.3);
        }
        
        .btn-accent:hover {
            background: #d97706;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.4);
        }
        
        /* Section Titles */
        .section-title {
            position: relative;
            display: inline-block;
            margin-bottom: 3rem;
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--gray-800);
            letter-spacing: -0.025em;
            text-align: center;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -12px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            border-radius: 2px;
        }
        
        .section-subtitle {
            color: var(--gray-600);
            font-size: 1.125rem;
            max-width: 600px;
            margin: 0 auto 4rem;
            text-align: center;
            line-height: 1.7;
        }
        
        /* Cards */
        .card {
            background: white;
            border-radius: 1.5rem;
            overflow: hidden;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
            display: flex;
            flex-direction: column;
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            opacity: 0;
            transform: translateY(30px);
        }
        
        .card.animated {
            opacity: 1;
            transform: translateY(0);
        }
        
        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            z-index: 1;
        }
        
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        .card-image {
            height: 240px;
            object-fit: cover;
            width: 100%;
            transition: transform 0.4s ease;
        }
        
        .card:hover .card-image {
            transform: scale(1.05);
        }
        
        .card-body {
            padding: 2rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        
        .card-title {
            font-size: 1.375rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            color: var(--gray-800);
            line-height: 1.3;
        }
        
        .card-text {
            color: var(--gray-600);
            margin-bottom: 1.5rem;
            flex: 1;
            line-height: 1.6;
        }
        
        .card-date {
            display: flex;
            align-items: center;
            color: var(--gray-500);
            font-size: 0.875rem;
            margin-bottom: 1rem;
            font-weight: 500;
        }
        
        .card-link {
            color: var(--primary);
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s ease;
            text-decoration: none;
        }
        
        .card-link:hover {
            color: var(--primary-dark);
            gap: 0.75rem;
        }
        
        /* Mobile Menu */
        .mobile-menu {
            position: fixed;
            top: 0;
            right: -100%;
            width: 85%;
            max-width: 350px;
            height: 100vh;
            background: white;
            padding: 2rem;
            transition: right 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 60;
            box-shadow: -10px 0 30px rgba(0, 0, 0, 0.15);
            backdrop-filter: blur(20px);
        }

        .mobile-menu.active {
            right: 0;
        }

        .mobile-menu-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 50;
            backdrop-filter: blur(4px);
        }

        .mobile-menu-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        
        .mobile-nav-link {
            display: flex;
            align-items: center;
            padding: 1rem;
            border-radius: 0.75rem;
            color: var(--gray-700);
            text-decoration: none;
            transition: all 0.2s ease;
            margin-bottom: 0.5rem;
        }
        
        .mobile-nav-link:hover,
        .mobile-nav-link.active {
            background: rgba(59, 130, 246, 0.1);
            color: var(--primary);
        }
        
        .hamburger {
            display: flex;
            flex-direction: column;
            gap: 4px;
            width: 24px;
            height: 18px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .hamburger span {
            width: 100%;
            height: 2px;
            background: var(--gray-600);
            border-radius: 1px;
            transition: all 0.3s ease;
        }
        
        .hamburger.active span:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }
        
        .hamburger.active span:nth-child(2) {
            opacity: 0;
        }
        
        .hamburger.active span:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -6px);
        }
        
        /* Footer */
        .footer {
            background: linear-gradient(135deg, var(--gray-900) 0%, var(--gray-800) 100%);
            color: white;
            padding: 4rem 0 2rem;
            position: relative;
        }
        
        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        }
        
        .footer-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: white;
        }
        
        .footer-link {
            color: var(--gray-400);
            text-decoration: none;
            transition: color 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.75rem;
        }
        
        .footer-link:hover {
            color: var(--primary-light);
        }
        
        .footer-bottom {
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid var(--gray-700);
            text-align: center;
            color: var(--gray-400);
        }
        
        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
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
        
        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        .fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }
        
        .fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }
        
        .fade-in-left {
            animation: fadeInLeft 0.8s ease-out forwards;
        }
        
        .fade-in-right {
            animation: fadeInRight 0.8s ease-out forwards;
        }
        
        .pulse {
            animation: pulse 2s infinite;
        }
        
        .delay-100 {
            animation-delay: 0.1s;
        }
        
        .delay-200 {
            animation-delay: 0.2s;
        }
        
        .delay-300 {
            animation-delay: 0.3s;
        }
        
        .delay-400 {
            animation-delay: 0.4s;
        }
        
        .delay-500 {
            animation-delay: 0.5s;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-section {
                min-height: 60vh;
            }
            
            .hero-content {
                padding: 3rem 1.5rem;
            }

            .section-title {
                font-size: 2rem;
            }

            .card {
                margin-bottom: 2rem;
            }
            
            .navbar {
                padding: 0.75rem 0;
            }
            
            .nav-link {
                padding: 0.5rem 0.75rem;
                font-size: 0.8rem;
            }
        }
        
        @media (max-width: 480px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .section-title {
                font-size: 1.75rem;
            }
        }
        
        /* Utility Classes */
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .gradient-text {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .container-custom {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        
        .section-padding {
            padding: 5rem 0;
        }
        
        /* Scroll Animations */
        .scroll-reveal {
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .scroll-reveal.revealed {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
    @yield('styles')
</head>
<body class="bg-gray-50 antialiased">

<!-- Navigation -->
<nav class="navbar sticky top-0 z-50" id="navbar">
    <div class="container-custom">
        <div class="flex justify-between items-center py-4">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="logo-container fade-in-left">
                @if($association)
                    <img src="{{ asset('storage/'.$association->main_image) }}" alt="Logo" class="logo-image">
                    <span class="logo-text">{{ $association->name ?? 'Association' }}</span>
                @else
                    <img src="{{ asset('default/logo.png') }}" alt="Logo par défaut" class="logo-image">
                    <span class="logo-text">Association</span>
                @endif
            </a>

            <!-- Menu Desktop -->
            <div class="hidden lg:flex items-center space-x-2">
                @foreach([
                    ['route' => 'home', 'label' => 'Accueil'],
                    ['route' => 'association.about', 'label' => 'Association'],
                    ['route' => 'history.index', 'label' => 'Histoire'],
                    ['route' => 'activities.index', 'label' => 'Activités'],
                    ['route' => 'projects.index', 'label' => 'Projets'],
                    ['route' => 'news.index', 'label' => 'Actualités'],
                    ['route' => 'events.index', 'label' => 'Événements'],
                    ['route' => 'services.index', 'label' => 'Services'],
                    ['route' => 'contact.create', 'label' => 'Contact']
                ] as $item)
                    <a href="{{ route($item['route']) }}"
                       class="nav-link fade-in-up {{ request()->routeIs($item['route']) ? 'active' : '' }}"
                       style="animation-delay: {{ ($loop->index * 0.05 + 0.2) }}s">
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </div>

            <!-- Mobile Menu Button -->
            <button onclick="toggleMobileMenu()" class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition focus:outline-none fade-in-right" aria-label="Menu">
                <div class="hamburger" id="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>
        </div>
    </div>
</nav>

<!-- Mobile Menu -->
<div id="mobileMenuOverlay" class="mobile-menu-overlay" onclick="toggleMobileMenu()"></div>
<div id="mobileMenu" class="mobile-menu">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-xl font-bold text-gray-800">Menu</h2>
        <button onclick="toggleMobileMenu()" class="p-2 rounded-lg hover:bg-gray-100 transition focus:outline-none">
            <i class="fas fa-times text-xl text-gray-600"></i>
        </button>
    </div>
    
    <div class="flex flex-col">
        @foreach([
            ['route' => 'home', 'label' => 'Accueil'],
            ['route' => 'association.about', 'label' => 'Association'],
            ['route' => 'history.index', 'label' => 'Histoire'],
            ['route' => 'activities.index', 'label' => 'Activités'],
            ['route' => 'projects.index', 'label' => 'Projets'],
            ['route' => 'news.index', 'label' => 'Actualités'],
            ['route' => 'events.index', 'label' => 'Événements'],
            ['route' => 'services.index', 'label' => 'Services'],
            ['route' => 'contact.create', 'label' => 'Contact']
        ] as $item)
            <a href="{{ route($item['route']) }}"
               class="mobile-nav-link fade-in-right {{ request()->routeIs($item['route']) ? 'active' : '' }}"
               style="animation-delay: {{ $loop->index * 0.05 + 0.1 }}s">
                <span class="font-medium">{{ $item['label'] }}</span>
            </a>
        @endforeach
    </div>
</div>

<!-- Content -->
<main class="min-h-screen">
    @include('partials.flash-messages')
    @yield('hero-section')
    @yield('content')
</main>

<!-- Footer -->
<footer class="footer">
    <div class="container-custom">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            <div class="fade-in-up">
                <h3 class="footer-title">À propos</h3>
                <p class="text-gray-400 leading-relaxed">
                    {{ $association->description ?? 'Notre association œuvre pour le développement et le bien-être de notre communauté à travers diverses activités et projets innovants.' }}
                </p>
            </div>
            <div class="fade-in-up delay-200">
                <h3 class="footer-title">Liens rapides</h3>
                <div class="space-y-1">
                    <a href="{{ route('home') }}" class="footer-link">
                        <i class="fas fa-home"></i>
                        Accueil
                    </a>
                    <a href="{{ route('activities.index') }}" class="footer-link">
                        <i class="fas fa-running"></i>
                        Activités
                    </a>
                    <a href="{{ route('events.index') }}" class="footer-link">
                        <i class="fas fa-calendar-alt"></i>
                        Événements
                    </a>
                    <a href="{{ route('contact.create') }}" class="footer-link">
                        <i class="fas fa-envelope"></i>
                        Contact
                    </a>
                </div>
            </div>
            <div class="fade-in-up delay-400">
                <h3 class="footer-title">Contact</h3>
                <div class="space-y-3">
                    @if($association)
                        <div class="footer-link">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $association->address }}</span>
                        </div>
                        <div class="footer-link">
                            <i class="fas fa-phone"></i>
                            <span>{{ $association->phone }}</span>
                        </div>
                        <div class="footer-link">
                            <i class="fas fa-envelope"></i>
                            <span>{{ $association->email }}</span>
                        </div>
                    @else
                        <div class="footer-link">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Abidjan, Côte d'Ivoire</span>
                        </div>
                        <div class="footer-link">
                            <i class="fas fa-phone"></i>
                            <span>+225 XX XX XX XX</span>
                        </div>
                        <div class="footer-link">
                            <i class="fas fa-envelope"></i>
                            <span>contact@association.ci</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="footer-bottom fade-in delay-500">
            <p>&copy; {{ date('Y') }} {{ $association->name ?? 'Association du Village' }}. Tous droits réservés.</p>
        </div>
    </div>
</footer>

<script>
// Navigation scroll effect
window.addEventListener('scroll', function() {
    const navbar = document.getElementById('navbar');
    if (window.scrollY > 100) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});

// Mobile menu toggle
function toggleMobileMenu() {
    const menu = document.getElementById('mobileMenu');
    const overlay = document.getElementById('mobileMenuOverlay');
    const hamburger = document.getElementById('hamburger');
    
    menu.classList.toggle('active');
    overlay.classList.toggle('active');
    hamburger.classList.toggle('active');
    
    // Prevent body scroll when menu is open
    document.body.style.overflow = menu.classList.contains('active') ? 'hidden' : '';
}

// Scroll reveal animations
function animateCards() {
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        setTimeout(() => {
            card.classList.add('animated');
        }, index * 150);
    });
}

function revealOnScroll() {
    const reveals = document.querySelectorAll('.scroll-reveal');
    const windowHeight = window.innerHeight;
    const revealPoint = 150;
    
    reveals.forEach(reveal => {
        const revealTop = reveal.getBoundingClientRect().top;
        
        if (revealTop < windowHeight - revealPoint) {
            reveal.classList.add('revealed');
        }
    });
}

// Initialize animations on page load
document.addEventListener('DOMContentLoaded', function() {
    // Animate cards
    animateCards();
    
    // Initial scroll reveal check
    revealOnScroll();
    
    // Add animation to hero content if exists
    const heroContent = document.querySelector('.hero-content');
    if (heroContent) {
        heroContent.classList.add('fade-in-up');
    }
});

// Check scroll position for reveal animations
window.addEventListener('scroll', revealOnScroll);

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});
</script>

@yield('scripts')
</body>
</html>
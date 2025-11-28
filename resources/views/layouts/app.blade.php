<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pawikan Patrol | @yield('title', 'Sea Turtle Conservation')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/web_lg.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/web_lg.png') }}">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400..900&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com/3.4.1"></script>
    
    <!-- Tailwind Configuration -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ocean: {
                            50: '#f0fdfa',
                            100: '#ccfbf1',
                            200: '#99f6e4',
                            300: '#5eead4',
                            400: '#2dd4bf',
                            500: '#14b8a6',
                            600: '#0d9488',
                            700: '#0f766e',
                            800: '#115e59',
                            900: '#134e4a',
                        },
                        deep: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            200: '#e2e8f0',
                            300: '#cbd5e1',
                            400: '#94a3b8',
                            500: '#64748b',
                            600: '#475569',
                            700: '#334155',
                            800: '#1e293b',
                            900: '#0f172a',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Custom Styles -->
    <style>
        /* Universal font styling - Apply Cinzel to all text */
        * {
            font-family: 'Cinzel', serif;
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        /* Optional: Use Poppins for specific elements if needed */
        .font-poppins, .text-body {
            font-family: 'Poppins', sans-serif;
        }

        /* Special handling for map page */
        .map-page {
            overflow: hidden;
        }

        .map-page main {
            padding: 0;
            min-height: 100vh;
            height: 100vh;
            overflow: hidden;
        }

        .map-page .ocean-bg {
            display: none;
        }
        
        /* Cinzel font classes for better typography control */
        .cinzel-heading {
            font-family: 'Cinzel', serif;
            font-weight: 700;
            letter-spacing: 0.05em;
        }
        
        .cinzel-subheading {
            font-family: 'Cinzel', serif;
            font-weight: 600;
            letter-spacing: 0.03em;
        }
        
        .cinzel-text {
            font-family: 'Cinzel', serif;
            font-weight: 400;
            letter-spacing: 0.02em;
        }
        
        .cinzel-body {
            font-family: 'Cinzel', serif;
            font-weight: 400;
            letter-spacing: 0.01em;
            line-height: 1.6;
        }

        /* Active navigation link styling */
        .active-nav-link {
            background-color: rgba(20, 184, 166, 0.3) !important;
            color: #5eead4 !important;
        }
        
        .active-nav-link:hover {
            background-color: rgba(20, 184, 166, 0.4) !important;
        }

        /* Ocean-themed background animation */
        .ocean-bg {
            background: linear-gradient(45deg, #0f4c75, #1b6ec2, #2e8b57, #4682b4);
            background-size: 400% 400%;
            animation: oceanWave 15s ease-in-out infinite;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        /* Enhanced body background */
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 25%, #334155 50%, #1e293b 75%, #0f172a 100%);
            background-size: 400% 400%;
            animation: oceanWave 20s ease-in-out infinite;
            min-height: 100vh;
        }

        .glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .glass-dark {
            background: rgba(15, 76, 117, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(20, 184, 166, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            position: relative;
            z-index: 9999;
        }

        /* Ensure navigation stays on top */
        nav.fixed {
            position: fixed !important;
            z-index: 9999 !important;
        }

        /* Prevent content from bleeding through navigation */
        body {
            padding-top: 0;
        }

        .main-content {
            position: relative;
            z-index: 1;
        }

        /* Animations */
        @keyframes oceanWave {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        @keyframes floatSlow {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .fade-in-up {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease;
        }

        .fade-in-up.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: floatSlow 6s ease-in-out infinite;
        }

        /* Navigation styles */
        .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            transform: translateY(-1px);
        }

        .nav-link.active {
            background: linear-gradient(135deg, rgba(20, 184, 166, 0.2), rgba(13, 148, 136, 0.1));
            color: #14b8a6;
            border: 1px solid rgba(20, 184, 166, 0.3);
        }

        /* Carousel styles */
        .carousel {
            position: relative;
            overflow: hidden;
            width: 100vw;
            height: calc(100vh - 5rem);
            margin-left: calc(50% - 50vw);
            margin-right: calc(50% - 50vw);
            background: transparent;
        }

        .carousel-track {
            display: flex;
            width: auto;
        }

        .carousel-slide {
            flex: 0 0 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            background: linear-gradient(135deg, rgba(3,16,21,0.02), rgba(6,30,30,0.01));
        }

        .carousel-slide img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: contain;
            object-position: center;
            max-height: calc(100vh - 5rem);
            transform: translateZ(0);
            backface-visibility: hidden;
            will-change: transform;
        }

        @media (max-width: 768px) {
            .carousel {
                height: calc(70vh - 5rem);
            }
            
            .carousel-slide img {
                max-height: calc(70vh - 5rem);
            }
        }

        #hero {
            padding-top: 5.5rem;
            min-height: calc(100vh - 5rem);
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
    
    @stack('styles')
</head>
<body class="text-white overflow-x-hidden scroll-smooth @yield('bodyClass')">
    <!-- Ocean Background Layer -->
    <div class="ocean-bg"></div>
    
    <!-- Floating Particles Layer -->
    <div id="particles" class="fixed inset-0 pointer-events-none" style="z-index: 1;"></div>
    
    <!-- Navigation -->
    @include('navigation')

    <!-- Main Content -->
    <main style="position: relative; z-index: 2;">
        @yield('content')
    </main>

    <!-- JavaScript -->
    <script>
        // Mobile menu toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileAccountToggles = document.querySelectorAll('.mobile-account-toggle');
            
            // Toggle main mobile menu
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    mobileMenu.classList.toggle('hidden');
                    // Toggle between menu and close icons
                    const menuIcon = this.querySelector('svg');
                    if (menuIcon) {
                        if (mobileMenu.classList.contains('hidden')) {
                            menuIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />';
                        } else {
                            menuIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />';
                        }
                    }
                });
            }
            
            // Toggle account submenu in mobile
            mobileAccountToggles.forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const submenu = this.nextElementSibling;
                    if (submenu && submenu.classList.contains('mobile-account-menu')) {
                        submenu.classList.toggle('hidden');
                        const icon = this.querySelector('svg');
                        if (icon) {
                            icon.classList.toggle('rotate-180');
                        }
                    }
                });
            });
            
            // Close menu when clicking outside
            document.addEventListener('click', function(event) {
                if (mobileMenu && !mobileMenu.contains(event.target) && mobileMenuButton && !mobileMenuButton.contains(event.target)) {
                    mobileMenu.classList.add('hidden');
                    const menuIcon = mobileMenuButton.querySelector('svg');
                    if (menuIcon) {
                        menuIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />';
                    }
                }
            });
        });
        
        // Floating Particles System
        class ParticleSystem {
            constructor() {
                this.container = document.getElementById('particles');
                this.particles = [];
                this.particleCount = 50;
                this.init();
            }

            init() {
                if (!this.container) return;
                
                for (let i = 0; i < this.particleCount; i++) {
                    this.createParticle();
                }
            }

            createParticle() {
                const particle = document.createElement('div');
                particle.className = 'particle';
                
                // Random properties
                const size = Math.random() * 4 + 2;
                const startX = Math.random() * window.innerWidth;
                const startY = Math.random() * window.innerHeight;
                const duration = Math.random() * 6 + 4;
                const delay = Math.random() * 2;
                
                particle.style.width = size + 'px';
                particle.style.height = size + 'px';
                particle.style.left = startX + 'px';
                particle.style.top = startY + 'px';
                particle.style.animationDuration = duration + 's';
                particle.style.animationDelay = delay + 's';
                
                this.container.appendChild(particle);
                this.particles.push(particle);
            }
        }

        // Fade-in Animation System
        class FadeInSystem {
            constructor() {
                this.elements = document.querySelectorAll('.fade-in-up');
                this.init();
            }

            init() {
                if (this.elements.length === 0) return;
                
                // Initial check for elements in viewport
                this.checkVisibility();
                
                // Add scroll event listener
                window.addEventListener('scroll', () => {
                    this.checkVisibility();
                });
                
                // Add resize event listener
                window.addEventListener('resize', () => {
                    this.checkVisibility();
                });
            }

            checkVisibility() {
                this.elements.forEach(element => {
                    if (this.isElementInViewport(element)) {
                        element.classList.add('visible');
                    }
                });
            }

            isElementInViewport(element) {
                const rect = element.getBoundingClientRect();
                return (
                    rect.top >= 0 &&
                    rect.left >= 0 &&
                    rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                    rect.right <= (window.innerWidth || document.documentElement.clientWidth)
                );
            }
        }

        // Smooth scrolling function
        function smoothScrollToSection(sectionId) {
            const section = document.getElementById(sectionId);
            if (section) {
                const offsetTop = section.offsetTop - 80; // Account for fixed header
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
        }

        // Initialize everything when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize particle system
            new ParticleSystem();
            
            // Initialize fade-in system
            new FadeInSystem();
            
            // Handle navigation link clicks
            document.querySelectorAll('.nav-link, .dropdown-link, .mobile-nav-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');
                    
                    // Only prevent default for internal anchor links (starting with #)
                    if (href && href.startsWith('#')) {
                        e.preventDefault();
                        const sectionId = href.substring(1);
                        smoothScrollToSection(sectionId);
                    }
                    // Let external links (/games, /3d-explorer, /patrol-map) work normally
                });
            });

            const homeScrollLinks = document.querySelectorAll('[data-scroll-target]');
            homeScrollLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    const targetId = this.dataset.scrollTarget;
                    if (!targetId) {
                        return;
                    }

                    const isHomePage = window.location.pathname === '/' || window.location.pathname === '';
                    if (isHomePage) {
                        e.preventDefault();
                        smoothScrollToSection(targetId);
                    }
                });
            });

            // Mobile menu toggle
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }

            // Close mobile menu when clicking on links
            document.querySelectorAll('.mobile-nav-link').forEach(link => {
                link.addEventListener('click', function() {
                    if (mobileMenu) {
                        mobileMenu.classList.add('hidden');
                    }
                });
            });

            // Add hover effects to interactive elements
            document.querySelectorAll('.hover-scale').forEach(element => {
                element.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.05)';
                });
                element.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                });
            });

            // Add glow effects to buttons
            document.querySelectorAll('.btn-ocean').forEach(button => {
                button.addEventListener('mouseenter', function() {
                    this.style.boxShadow = '0 5px 15px rgba(20, 184, 166, 0.4)';
                });
                button.addEventListener('mouseleave', function() {
                    this.style.boxShadow = 'none';
                });
            });
        });

        // Handle window resize for particles
        window.addEventListener('resize', function() {
            // Reposition particles on resize
            const particles = document.querySelectorAll('.particle');
            particles.forEach(particle => {
                const newX = Math.random() * window.innerWidth;
                const newY = Math.random() * window.innerHeight;
                particle.style.left = newX + 'px';
                particle.style.top = newY + 'px';
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>

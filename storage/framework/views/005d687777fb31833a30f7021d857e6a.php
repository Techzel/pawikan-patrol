<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentication - Pawikan Patrol</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(asset('img/lg.png')); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(asset('img/lg.png')); ?>">
    <link rel="apple-touch-icon" href="<?php echo e(asset('img/lg.png')); ?>">
    <link rel="shortcut icon" href="<?php echo e(asset('img/lg.png')); ?>">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Poppins', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
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
                    },
                    animation: {
                        'ocean-wave': 'oceanWave 15s ease-in-out infinite',
                        'float': 'float 20s infinite linear',
                        'swim': 'swim 10s ease-in-out infinite',
                        'glow': 'glow 2s ease-in-out infinite alternate',
                        'fade-up': 'fadeUp 0.8s ease-out forwards',
                        'slide-in': 'slideIn 0.6s ease-out forwards',
                    }
                }
            }
        }
    </script>
    <style>
        * {
            font-family: 'Cinzel', sans-serif;
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
        
        /* Force Poppins font for input elements */
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            font-family: 'Poppins', ui-sans-serif, system-ui, sans-serif !important;
        }
        
        /* Force Poppins font for labels */
        label {
            font-family: 'Poppins', ui-sans-serif, system-ui, sans-serif !important;
        }
        
        @keyframes oceanWave {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        @keyframes float {
            from { 
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }
            10% { opacity: 1; }
            90% { opacity: 1; }
            to { 
                transform: translateY(-100vh) rotate(360deg);
                opacity: 0;
            }
        }

        @keyframes swim {
            0%, 100% { transform: translateX(0) rotate(0deg); }
            50% { transform: translateX(-50px) rotate(-5deg); }
        }

        @keyframes glow {
            from { text-shadow: 0 0 20px rgba(20, 184, 166, 0.5); }
            to { text-shadow: 0 0 40px rgba(20, 184, 166, 0.8), 0 0 60px rgba(20, 184, 166, 0.4); }
        }

        @keyframes fadeUp {
            from { 
                opacity: 0; 
                transform: translateY(30px); 
            }
            to { 
                opacity: 1; 
                transform: translateY(0); 
            }
        }

        @keyframes slideIn {
            from { 
                opacity: 0; 
                transform: translateX(-30px); 
            }
            to { 
                opacity: 1; 
                transform: translateX(0); 
            }
        }

        .ocean-bg {
            background: linear-gradient(45deg, #0f4c75, #1b6ec2, #2e8b57, #4682b4);
            background-size: 400% 400%;
            animation: oceanWave 15s ease-in-out infinite;
        }

        .glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .glass-dark {
            background: rgba(15, 76, 117, 0.15);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(20, 184, 166, 0.4);
        }

        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 20s infinite linear;
        }

        .form-container {
            position: relative;
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
            z-index: 1;
        }
        
        .form-container.hidden {
            display: none !important;
        }
        
        .form-container.active {
            display: block !important;
        }

        .tab-button {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .tab-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(20, 184, 166, 0.2), transparent);
            transition: left 0.5s;
        }

        .tab-button:hover::before {
            left: 100%;
        }

        .tab-button.active {
            background: linear-gradient(135deg, rgba(20, 184, 166, 0.4), rgba(13, 148, 136, 0.3));
            border: 1px solid rgba(20, 184, 166, 0.6);
            box-shadow: 0 0 20px rgba(20, 184, 166, 0.3);
        }

        .password-strength-bar {
            transition: all 0.3s ease;
        }

        .input-group {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #94a3b8;
            transition: color 0.2s;
            z-index: 10;
        }

        .toggle-password:hover {
            color: #14b8a6;
        }

        .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            transform: translateY(-2px);
        }

        .nav-link.active {
            background: linear-gradient(135deg, rgba(20, 184, 166, 0.2), rgba(13, 148, 136, 0.1));
            color: #14b8a6;
            border: 1px solid rgba(20, 184, 166, 0.3);
        }

        .dropdown-link {
            position: relative;
            overflow: hidden;
        }

        .dropdown-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(20, 184, 166, 0.1), transparent);
            transition: left 0.5s;
        }

        .dropdown-link:hover::before {
            left: 100%;
        }

        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            padding-top: 6rem;
        }

        .auth-card {
            animation: fadeInUp 0.8s ease-out;
        }

        .floating-turtle {
            position: absolute;
            animation: swim 20s ease-in-out infinite;
            opacity: 0.3;
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

        @keyframes swim {
            0%, 100% { transform: translateX(-50px) translateY(0) rotate(-5deg); }
            50% { transform: translateX(50px) translateY(-20px) rotate(5deg); }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-deep-900 via-deep-800 to-deep-900 text-white overflow-x-hidden scroll-smooth">
    <!-- Animated Background -->
    <div class="fixed inset-0 ocean-bg -z-10"></div>
    
    <!-- Floating Particles -->
    <div id="particles" class="fixed inset-0 -z-10 pointer-events-none"></div>

    <nav class="fixed top-0 left-0 right-0 z-50 glass-dark border-b border-ocean-500/20">
        <div class="max-w-8xl mx-auto px-10 sm:px-10 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="/" class="flex items-center gap-3 hover:opacity-80 transition-opacity">
                        <img src="<?php echo e(asset('img/lg.png')); ?>" alt="Pawikan Patrol Logo" class="w-16 h-16 rounded-full">
                        <div>
                            <span class="text-xl font-bold bg-gradient-to-r from-ocean-400 to-ocean-300 bg-clip-text text-transparent">
                               Dahican Pawikan Patrol
                            </span>
                            <div class="text-xs text-white mt-1">City of Mati – Dahican, est. 2004</div>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8 ">
                    <!-- Home with Dropdown -->
                    <div class="relative group">
                        <a href="/" class="nav-link flex items-center gap-2 text-white hover:text-ocean-400 transition-colors px-3 py-2 rounded-lg hover:bg-ocean-600/20">
                            <span class="text-lg">🏠</span>
                            <span class="text-sm font-medium">Home</span>
                            <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </a>
                        
                        <!-- Dropdown Menu -->
                        <div class="absolute top-full left-0 mt-2 w-64 bg-gradient-to-br from-deep-800/95 to-deep-900/95 backdrop-blur-lg border border-ocean-500/20 rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                            <div class="p-4 space-y-2">
                                <a href="<?php echo e(url('/#vision')); ?>" class="dropdown-link flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors w-full text-left">
                                    <span class="text-xl">🌟</span>
                                    <span class="text-sm font-medium">Vision & Mission</span>
                                </a>
                                <a href="<?php echo e(url('/#video-showcase')); ?>" class="dropdown-link flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors w-full text-left">
                                    <span class="text-xl">🎬</span>
                                    <span class="text-sm font-medium">Conservation Video</span>
                                </a>
                                <a href="<?php echo e(url('/#lifecycle')); ?>" class="dropdown-link flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors w-full text-left">
                                    <span class="text-xl">🌊</span>
                                    <span class="text-sm font-medium">Life Cycle</span>
                                </a>
                                <a href="<?php echo e(url('/#threats')); ?>" class="dropdown-link flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors w-full text-left">
                                    <span class="text-xl">⚠️</span>
                                    <span class="text-sm font-medium">Threats</span>
                                </a>
                                <a href="<?php echo e(url('/#species')); ?>" class="dropdown-link flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors w-full text-left">
                                    <span class="text-xl">🐢</span>
                                    <span class="text-sm font-medium">Species Guide</span>
                                </a>
                                <a href="<?php echo e(url('/#guidelines')); ?>" class="dropdown-link flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors w-full text-left">
                                    <span class="text-xl">📋</span>
                                    <span class="text-sm font-medium">Guidelines</span>
                                </a>
                                <a href="<?php echo e(url('/#help')); ?>" class="dropdown-link flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors w-full text-left">
                                    <span class="text-lg">🤝</span>
                                    <span class="text-sm font-medium">How to Help</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- 3D Explorer -->
                    <a href="/3d-explorer" class="nav-link flex items-center gap-2 text-white hover:text-ocean-400 transition-colors py-2 rounded-lg hover:bg-ocean-600/20">
                        <span class="text-lg">🧊</span>
                        <span class="text-sm font-medium">3D Explorer</span>
                    </a>

                    <!-- Patrol Map with Dropdown -->
                    <div class="relative group">
                        <a href="/patrol-map" class="nav-link flex items-center gap-2 text-white hover:text-ocean-400 transition-colors  py-2 rounded-lg hover:bg-ocean-600/20">
                            <span class="text-lg">🗺️</span>
                            <span class="text-sm font-medium">Patrol Map</span>
                            <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </a>
                        
                        <!-- Dropdown Menu -->
                        <div class="absolute top-full left-0 mt-2 w-48 bg-gradient-to-br from-deep-800/95 to-deep-900/95 backdrop-blur-lg border border-ocean-500/20 rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                            <div class="p-2 space-y-1">
                                <a href="/patrol-map/gallery" class="dropdown-link flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors w-full text-left">
                                    <span class="text-lg">📸</span>
                                    <span class="text-sm font-medium">Gallery Report</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Games -->
                    <a href="/games" class="nav-link flex items-center gap-2 text-white hover:text-ocean-400 transition-colors py-2 rounded-lg hover:bg-ocean-600/20">
                        <span class="text-lg">🎮</span>
                        <span class="text-sm font-medium">Games</span>
                    </a>

                    <!-- Account Dropdown -->
                    <div class="relative group">
                        <button class="flex items-center gap-2 text-white hover:text-ocean-400 transition-colors py-2 rounded-lg hover:bg-ocean-600/20">
                            <span class="text-lg">👤</span>
                            <span class="text-sm font-medium">Account</span>
                            <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <!-- Account Dropdown Menu -->
                        <div class="absolute top-full right-0 mt-2 w-48 bg-gradient-to-br from-deep-800/95 to-deep-900/95 backdrop-blur-lg border border-ocean-500/20 rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                            <div class="p-2 space-y-1">
                                <a href="/auth" class="flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors">
                                    <span class="text-lg">🔑</span>
                                    <span class="text-sm font-medium">Login</span>
                                </a>
                                <a href="/auth#register" class="flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors">
                                    <span class="text-lg">📝</span>
                                    <span class="text-sm font-medium">Register</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button id="mobile-menu-button" type="button" aria-controls="mobile-menu" aria-expanded="false" aria-label="Open navigation menu" class="text-white hover:text-ocean-400 focus:outline-none focus:text-ocean-400 p-2">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div id="mobile-menu" class="md:hidden hidden glass-dark border-t border-ocean-500/20">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <!-- Home Section -->
                <div class="space-y-1">
                    <a href="/" class="mobile-nav-link flex items-center gap-3 text-white hover:text-ocean-400 hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                        <span class="text-lg">🏠</span>
                        <span class="text-sm font-medium">Home</span>
                    </a>
                    
                    <!-- Home Sub-items -->
                    <div class="ml-8 space-y-1">
                        <a href="<?php echo e(url('/#vision')); ?>" class="mobile-nav-link flex items-center gap-3 text-gray-300 hover:text-white hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                            <span class="text-lg">🌟</span>
                            <span class="text-sm font-medium">Vision & Mission</span>
                        </a>
                        <a href="<?php echo e(url('/#video-showcase')); ?>" class="mobile-nav-link flex items-center gap-3 text-gray-300 hover:text-white hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                            <span class="text-lg">🎬</span>
                            <span class="text-sm font-medium">Conservation Video</span>
                        </a>
                        <a href="/" class="mobile-nav-link flex items-center gap-3 text-gray-300 hover:text-white hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                            <span class="text-lg">🌊</span>
                            <span class="text-sm font-medium">Life Cycle</span>
                        </a>
                        <a href="/" class="mobile-nav-link flex items-center gap-3 text-gray-300 hover:text-white hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                            <span class="text-lg">⚠️</span>
                            <span class="text-sm font-medium">Threats</span>
                        </a>
                        <a href="/" class="mobile-nav-link flex items-center gap-3 text-gray-300 hover:text-white hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                            <span class="text-lg">📋</span>
                            <span class="text-sm font-medium">Guidelines</span>
                        </a>
                        <a href="/" class="mobile-nav-link flex items-center gap-3 text-gray-300 hover:text-white hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                            <span class="text-lg">🤝</span>
                            <span class="text-sm font-medium">How to Help</span>
                        </a>
                    </div>
                </div>
                
                <!-- Other Pages -->
                <a href="/3d-explorer" class="mobile-nav-link flex items-center gap-3 text-white hover:text-ocean-400 hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                    <span class="text-lg">🧊</span>
                    <span class="text-sm font-medium">3D Explorer</span>
                </a>
                
                <!-- Patrol Map Section -->
                <div class="space-y-1">
                    <a href="/patrol-map" class="mobile-nav-link flex items-center gap-3 text-white hover:text-ocean-400 hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                        <span class="text-lg">🗺️</span>
                        <span class="text-sm font-medium">Patrol Map</span>
                    </a>
                    
                    <!-- Patrol Map Sub-items -->
                    <div class="ml-8 space-y-1">
                        <a href="/patrol-map/gallery" class="mobile-nav-link flex items-center gap-3 text-gray-300 hover:text-white hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                            <span class="text-lg">📸</span>
                            <span class="text-sm font-medium">Gallery Report</span>
                        </a>
                    </div>
                </div>
                
                <a href="/games" class="mobile-nav-link flex items-center gap-3 text-white hover:text-ocean-400 hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                    <span class="text-lg">🎮</span>
                    <span class="text-sm font-medium">Games</span>
                </a>
                
                <!-- Account Section -->
                <div class="space-y-1">
                    <button class="mobile-account-toggle flex items-center gap-3 text-white hover:text-ocean-400 hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                        <span class="text-lg">👤</span>
                        <span class="text-sm font-medium">Account</span>
                        <svg class="w-4 h-4 ml-auto transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <!-- Account Sub-items -->
                    <div class="ml-8 space-y-1 mobile-account-menu hidden">
                        <a href="/auth" class="mobile-nav-link flex items-center gap-3 text-gray-300 hover:text-white hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                            <span class="text-lg">🔑</span>
                            <span class="text-sm font-medium">Login</span>
                        </a>
                        <a href="/auth#register" class="mobile-nav-link flex items-center gap-3 text-gray-300 hover:text-white hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                            <span class="text-lg">📝</span>
                            <span class="text-sm font-medium">Register</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Floating Turtle Decorations -->
    <div class="floating-turtle top-20 left-10 text-6xl">🐢</div>
    <div class="floating-turtle bottom-20 right-10 text-4xl" style="animation-delay: -10s;">🐢</div>
    <div class="floating-turtle top-1/2 right-20 text-5xl" style="animation-delay: -5s;">🐢</div>
    
    <!-- Hero Section with Auth Form -->
    <section class="hero-section px-4 py-12 mt-24">
        <div class="max-w-7xl w-full mx-auto grid lg:grid-cols-2 gap-16 items-center">
            <!-- Left Side - Content -->
            <div id="staticLeftContent" class="text-left space-y-8">
                <h1 class="text-5xl lg:text-6xl font-bold bg-gradient-to-r from-ocean-400 via-ocean-300 to-ocean-500 bg-clip-text text-transparent mb-4 leading-tight cinzel-heading">
                    Join Our Ocean Conservation Community
                </h1>
                
                <p class="text-xl text-ocean-200 mb-8 leading-relaxed cinzel-body">
                    Become part of the Pawikan Patrol family and help us protect these magnificent sea turtles for future generations.
                </p>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="glass rounded-xl p-6 text-center transform hover:scale-105 transition-all duration-300">
                        <div class="text-4xl mb-3">🐢</div>
                        <h3 class="font-semibold text-ocean-300 mb-2">Protect Species</h3>
                        <p class="text-sm text-gray-300">Help conserve endangered sea turtles</p>
                    </div>
                    
                    <div class="glass rounded-xl p-6 text-center transform hover:scale-105 transition-all duration-300">
                        <div class="text-4xl mb-3">🌊</div>
                        <h3 class="font-semibold text-ocean-300 mb-2">Clean Oceans</h3>
                        <p class="text-sm text-gray-300">Participate in beach cleanup initiatives</p>
                    </div>
                    
                    <div class="glass rounded-xl p-6 text-center transform hover:scale-105 transition-all duration-300">
                        <div class="text-4xl mb-3">📚</div>
                        <h3 class="font-semibold text-ocean-300 mb-2">Learn & Share</h3>
                        <p class="text-sm text-gray-300">Educate others about marine conservation</p>
                    </div>
                </div>
            </div>
            
            <!-- Right Side - Auth Form -->
            <div class="auth-card">
                <div class="glass-dark rounded-3xl p-8 shadow-2xl border border-ocean-500/30">
                    <!-- Tab Buttons -->
                    <div class="flex mb-8 bg-deep-800/50 rounded-xl p-1 glass">
                        <button id="loginTab" class="tab-button flex-1 py-4 px-6 rounded-xl text-white font-semibold active transition-all duration-400">
                            <i class="fas fa-sign-in-alt mr-2"></i>Login
                        </button>
                        <button id="registerTab" class="tab-button flex-1 py-4 px-6 rounded-xl text-gray-400 font-semibold transition-all duration-400">
                            <i class="fas fa-user-plus mr-2"></i>Register
                        </button>
                    </div>
                    
                    
                    <!-- Forms Container -->
                    <div class="relative">
                        <!-- Login Form -->
                        <div id="loginForm" class="form-container active">
                            <?php if(session('error')): ?>
                                <div class="mb-6 p-4 bg-red-500/20 border border-red-500/50 rounded-xl text-red-200 text-sm backdrop-blur-sm">
                                    <i class="fas fa-exclamation-triangle mr-2"></i>
                                    <?php echo e(session('error')); ?>

                                </div>
                            <?php endif; ?>
                            
                            <?php if(session('success')): ?>
                                <div class="mb-6 p-4 bg-green-500/20 border border-green-500/50 rounded-xl text-green-200 text-sm backdrop-blur-sm">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    <?php echo e(session('success')); ?>

                                </div>
                            <?php endif; ?>
                            
                            <?php $__errorArgs = ['login'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="mb-6 p-4 bg-red-500/20 border border-red-500/50 rounded-xl text-red-200 text-sm backdrop-blur-sm">
                                    <i class="fas fa-exclamation-triangle mr-2"></i>
                                    <?php echo e($message); ?>

                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            
                            <form method="POST" action="<?php echo e(route('login')); ?>">
                                <?php echo csrf_field(); ?>
                                
                                <div class="mb-6">
                                    <label for="loginUsername" class="block text-sm font-medium text-gray-300 mb-3">
                                        <i class="fas fa-user mr-2 text-ocean-400"></i>Username
                                    </label>
                                    <input type="text" id="loginUsername" name="username" required
                                        class="w-full px-4 py-3 bg-deep-800/50 border border-ocean-500/30 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-ocean-500 focus:border-transparent transition-all duration-300 font-poppins <?php echo e($errors->has('username') ? 'border-red-500/50' : ''); ?>"
                                        placeholder="Enter your username">
                                    <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="mt-2 text-sm text-red-400">
                                            <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                
                                <div class="mb-6">
                                    <label for="loginPassword" class="block text-sm font-medium text-gray-300 mb-3">
                                        <i class="fas fa-lock mr-2 text-ocean-400"></i>Password
                                    </label>
                                    <div class="input-group">
                                        <input type="password" id="loginPassword" name="password" required
                                            class="w-full px-4 py-3 bg-deep-800/50 border border-ocean-500/30 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-ocean-500 focus:border-transparent transition-all duration-300 pr-12 font-poppins <?php echo e($errors->has('password') ? 'border-red-500/50' : ''); ?>"
                                            placeholder="Enter your password">
                                        <i class="fas fa-eye toggle-password" data-target="loginPassword"></i>
                                    </div>
                                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="mt-2 text-sm text-red-400">
                                            <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                
                                <button type="submit" class="w-full bg-gradient-to-r from-ocean-500 to-ocean-600 hover:from-ocean-600 hover:to-ocean-700 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                                    <i class="fas fa-sign-in-alt mr-2"></i>Login to Your Account
                                </button>
                            </form>

                        </div>
                        
                        <!-- Register Form -->
                        <div id="registerForm" class="form-container hidden">
                            <?php if(session('error')): ?>
                                <div class="mb-6 p-4 bg-red-500/20 border border-red-500/50 rounded-xl text-red-200 text-sm backdrop-blur-sm">
                                    <i class="fas fa-exclamation-triangle mr-2"></i>
                                    <?php echo e(session('error')); ?>

                                </div>
                            <?php endif; ?>
                            
                            <?php if(session('success')): ?>
                                <div class="mb-6 p-4 bg-green-500/20 border border-green-500/50 rounded-xl text-green-200 text-sm backdrop-blur-sm">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    <?php echo e(session('success')); ?>

                                </div>
                            <?php endif; ?>
                            
                            <form method="POST" action="<?php echo e(route('register')); ?>">
                                <?php echo csrf_field(); ?>
                                
                                <div class="mb-5">
                                    <label for="registerName" class="block text-sm font-medium text-gray-300 mb-3">
                                        <i class="fas fa-user mr-2 text-ocean-400"></i>Full Name
                                    </label>
                                    <input type="text" id="registerName" name="name" required value="<?php echo e(old('name')); ?>"
                                        class="w-full px-4 py-3 bg-deep-800/50 border border-ocean-500/30 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-ocean-500 focus:border-transparent transition-all duration-300 font-poppins <?php echo e($errors->has('name') ? 'border-red-500/50' : ''); ?>"
                                        placeholder="Enter your full name">
                                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="mt-2 text-sm text-red-400">
                                            <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                
                                <div class="mb-5">
                                    <label for="registerUsername" class="block text-sm font-medium text-gray-300 mb-3">
                                        <i class="fas fa-user mr-2 text-ocean-400"></i>Username
                                    </label>
                                    <input type="text" id="registerUsername" name="username" required value="<?php echo e(old('username')); ?>"
                                        class="w-full px-4 py-3 bg-deep-800/50 border border-ocean-500/30 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-ocean-500 focus:border-transparent transition-all duration-300 font-poppins <?php echo e($errors->has('username') ? 'border-red-500/50' : ''); ?>"
                                        placeholder="Choose a username">
                                    <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="mt-2 text-sm text-red-400">
                                            <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                
                                <div class="mb-5">
                                    <label for="registerEmail" class="block text-sm font-medium text-gray-300 mb-3">
                                        <i class="fas fa-envelope mr-2 text-ocean-400"></i>Email Address
                                    </label>
                                    <input type="email" id="registerEmail" name="email" required value="<?php echo e(old('email')); ?>"
                                        class="w-full px-4 py-3 bg-deep-800/50 border border-ocean-500/30 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-ocean-500 focus:border-transparent transition-all duration-300 font-poppins <?php echo e($errors->has('email') ? 'border-red-500/50' : ''); ?>"
                                        placeholder="Enter your email address">
                                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="mt-2 text-sm text-red-400">
                                            <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                
                                <div class="mb-5">
                                    <label for="registerPassword" class="block text-sm font-medium text-gray-300 mb-3">
                                        <i class="fas fa-lock mr-2 text-ocean-400"></i>Password
                                    </label>
                                    <div class="input-group">
                                        <input type="password" id="registerPassword" name="password" required
                                            class="w-full px-4 py-3 bg-deep-800/50 border border-ocean-500/30 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-ocean-500 focus:border-transparent transition-all duration-300 pr-12 font-poppins <?php echo e($errors->has('password') ? 'border-red-500/50' : ''); ?>"
                                            placeholder="Min 8 chars, 1 Upper, 1 Lower, 1 Number, 1 Special (@$!%*?&)">
                                        <i class="fas fa-eye toggle-password" data-target="registerPassword"></i>
                                    </div>
                                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="mt-2 text-sm text-red-400">
                                            <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <div class="mt-3">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-xs text-gray-400">Password Strength</span>
                                            <span id="strengthText" class="text-xs font-semibold">Weak</span>
                                        </div>
                                        <div class="w-full bg-deep-700 rounded-full h-2">
                                            <div id="strengthBar" class="password-strength-bar h-2 rounded-full bg-red-500" style="width: 25%"></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-6">
                                    <label for="registerPasswordConfirmation" class="block text-sm font-medium text-gray-300 mb-3">
                                        <i class="fas fa-lock mr-2 text-ocean-400"></i>Confirm Password
                                    </label>
                                    <div class="input-group">
                                        <input type="password" id="registerPasswordConfirmation" name="password_confirmation" required
                                            class="w-full px-4 py-3 bg-deep-800/50 border border-ocean-500/30 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-ocean-500 focus:border-transparent transition-all duration-300 pr-12 font-poppins"
                                            placeholder="Min 8 chars, 1 Upper, 1 Lower, 1 Number, 1 Special (@$!%*?&)">
                                        <i class="fas fa-eye toggle-password" data-target="registerPasswordConfirmation"></i>
                                    </div>
                                    <div id="passwordValidation" class="mt-2 text-sm hidden">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        <span id="passwordValidationText"></span>
                                    </div>
                                </div>
                                
                                <button type="submit" class="w-full bg-gradient-to-r from-ocean-500 to-ocean-600 hover:from-ocean-600 hover:to-ocean-700 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                                    <i class="fas fa-user-plus mr-2"></i>Create Your Account
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <script>
        // Mobile navigation handling
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        const mobileAccountToggle = document.querySelector('.mobile-account-toggle');
        const mobileAccountMenu = document.querySelector('.mobile-account-menu');

        if (mobileMenuButton && mobileMenu) {
            const iconPath = mobileMenuButton.querySelector('path');
            const hamburgerPath = 'M4 6h16M4 12h16M4 18h16';
            const closePath = 'M6 18L18 6M6 6L18 18';

            const setMenuState = (isOpen) => {
                mobileMenu.classList.toggle('hidden', !isOpen);
                mobileMenuButton.setAttribute('aria-expanded', isOpen.toString());
                mobileMenuButton.setAttribute('aria-label', isOpen ? 'Close navigation menu' : 'Open navigation menu');
                if (iconPath) {
                    iconPath.setAttribute('d', isOpen ? closePath : hamburgerPath);
                }
                if (!isOpen && mobileAccountMenu && !mobileAccountMenu.classList.contains('hidden')) {
                    mobileAccountMenu.classList.add('hidden');
                    const accountIcon = mobileAccountToggle?.querySelector('svg');
                    accountIcon?.classList.remove('rotate-180');
                }
            };

            mobileMenuButton.addEventListener('click', () => {
                const isCurrentlyOpen = !mobileMenu.classList.contains('hidden');
                setMenuState(!isCurrentlyOpen);
            });

            mobileMenu.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', () => setMenuState(false));
            });
        }

        if (mobileAccountToggle && mobileAccountMenu) {
            mobileAccountToggle.addEventListener('click', () => {
                const willOpen = mobileAccountMenu.classList.contains('hidden');
                mobileAccountMenu.classList.toggle('hidden');
                const icon = mobileAccountToggle.querySelector('svg');
                if (icon) {
                    icon.classList.toggle('rotate-180', willOpen);
                }
            });
        }

        // Simple form switching that actually works
        const loginTab = document.getElementById('loginTab');
        const registerTab = document.getElementById('registerTab');
        const loginForm = document.getElementById('loginForm');
        const registerForm = document.getElementById('registerForm');
        const switchToRegister = document.getElementById('switchToRegister');
        const switchToLogin = document.getElementById('switchToLogin');
        
        function showLogin() {
            // Hide register, show login using CSS classes
            registerForm.classList.add('hidden');
            registerForm.classList.remove('active');
            loginForm.classList.add('active');
            loginForm.classList.remove('hidden');
            
            // Update tab styles
            loginTab.classList.add('active', 'text-white');
            loginTab.classList.remove('text-gray-400');
            registerTab.classList.remove('active', 'text-white');
            registerTab.classList.add('text-gray-400');
            
            // Ensure left side content remains static and unchanged
            const staticLeftContent = document.getElementById('staticLeftContent');
            if (staticLeftContent) {
                staticLeftContent.style.display = 'block';
                staticLeftContent.style.visibility = 'visible';
                staticLeftContent.style.opacity = '1';
            }
        }
        
        function showRegister() {
            // Hide login, show register using CSS classes
            loginForm.classList.add('hidden');
            loginForm.classList.remove('active');
            registerForm.classList.add('active');
            registerForm.classList.remove('hidden');
            
            // Update tab styles
            registerTab.classList.add('active', 'text-white');
            registerTab.classList.remove('text-gray-400');
            loginTab.classList.remove('active', 'text-white');
            loginTab.classList.add('text-gray-400');
            
            // Ensure left side content remains static and unchanged
            const staticLeftContent = document.getElementById('staticLeftContent');
            if (staticLeftContent) {
                staticLeftContent.style.display = 'block';
                staticLeftContent.style.visibility = 'visible';
                staticLeftContent.style.opacity = '1';
            }
        }
        
        // Add event listeners
        if (loginTab) loginTab.addEventListener('click', showLogin);
        if (registerTab) registerTab.addEventListener('click', showRegister);
        if (switchToRegister) switchToRegister.addEventListener('click', showRegister);
        if (switchToLogin) switchToLogin.addEventListener('click', showLogin);
        
        // Password strength checker
        const registerPassword = document.getElementById('registerPassword');
        const strengthBar = document.getElementById('strengthBar');
        const strengthText = document.getElementById('strengthText');
        
        if (registerPassword && strengthBar && strengthText) {
            registerPassword.addEventListener('input', function() {
                const password = this.value;
                let strength = 0;
                let strengthLabel = '';
                let strengthColor = '';
                
                // Check password strength
                if (password.length >= 8) strength += 25;
                if (password.length >= 12) strength += 25;
                if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength += 25;
                if (/[0-9]/.test(password)) strength += 12.5;
                if (/[^A-Za-z0-9]/.test(password)) strength += 12.5;
                
                // Determine strength level
                if (strength <= 25) {
                    strengthLabel = 'Weak';
                    strengthColor = 'bg-red-500';
                } else if (strength <= 50) {
                    strengthLabel = 'Fair';
                    strengthColor = 'bg-orange-500';
                } else if (strength <= 75) {
                    strengthLabel = 'Good';
                    strengthColor = 'bg-yellow-500';
                } else {
                    strengthLabel = 'Strong';
                    strengthColor = 'bg-green-500';
                }
                
                // Update strength bar
                strengthBar.style.width = Math.max(strength, 25) + '%';
                strengthBar.className = 'password-strength-bar h-2 rounded-full ' + strengthColor;
                strengthText.textContent = strengthLabel;
                strengthText.className = 'text-xs font-semibold ' + strengthColor.replace('bg-', 'text-');
            });
        }
        
        // Password validation checker
        const registerPasswordConfirmation = document.getElementById('registerPasswordConfirmation');
        const passwordValidation = document.getElementById('passwordValidation');
        const passwordValidationText = document.getElementById('passwordValidationText');
        
        function validatePasswordMatch() {
            const password = registerPassword.value;
            const confirmPassword = registerPasswordConfirmation.value;
            
            if (confirmPassword === '') {
                passwordValidation.classList.add('hidden');
                return true;
            }
            
            if (password !== confirmPassword) {
                passwordValidation.classList.remove('hidden');
                passwordValidation.className = 'mt-2 text-sm text-red-400';
                passwordValidationText.textContent = 'Passwords do not match';
                return false;
            } else {
                passwordValidation.classList.remove('hidden');
                passwordValidation.className = 'mt-2 text-sm text-green-400';
                passwordValidationText.textContent = 'Passwords match';
                return true;
            }
        }
        
        // Add event listeners for password validation
        if (registerPassword && registerPasswordConfirmation && passwordValidation && passwordValidationText) {
            registerPassword.addEventListener('input', validatePasswordMatch);
            registerPasswordConfirmation.addEventListener('input', validatePasswordMatch);
            
            // Prevent form submission if passwords don't match
            const registerForm = document.querySelector('#registerForm form');
            if (registerForm) {
                registerForm.addEventListener('submit', function(e) {
                    if (!validatePasswordMatch()) {
                        e.preventDefault();
                        passwordValidationText.textContent = 'Please make sure passwords match before submitting';
                        passwordValidation.className = 'mt-2 text-sm text-red-400';
                        passwordValidation.classList.remove('hidden');
                    }
                });
            }
        }

        // Toggle Password Visibility
        document.querySelectorAll('.toggle-password').forEach(icon => {
            icon.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const passwordInput = document.getElementById(targetId);
                
                if (passwordInput) {
                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        this.classList.remove('fa-eye');
                        this.classList.add('fa-eye-slash');
                        this.style.color = '#14b8a6'; // Ocean-500 color
                    } else {
                        passwordInput.type = 'password';
                        this.classList.remove('fa-eye-slash');
                        this.classList.add('fa-eye');
                        this.style.color = ''; // Reset color
                    }
                }
            });
        });
        
        // Handle URL hash
        if (window.location.hash === '#register') {
            showRegister();
        } else {
            showLogin();
        }
    </script>
</body>
</html>
<?php /**PATH C:\Users\Rayver\Desktop\pawikan-patrol\my_app\resources\views/auth/combined.blade.php ENDPATH**/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pawikan Educational Games - Learn & Play</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/lg.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/lg.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('img/lg.png') }}">
    <link rel="shortcut icon" href="{{ asset('img/lg.png') }}">
    
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'ocean': {
                            300: '#67e8f9',
                            400: '#22d3ee',
                            500: '#06b6d4',
                            600: '#0891b2',
                            700: '#0e7490',
                            800: '#155e75',
                            900: '#164e63'
                        },
                        'deep': {
                            800: '#1e293b',
                            900: '#0f172a'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        /* Global font family */
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
        
        /* Navigation Bar Styles */
        .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            transform: translateY(-1px);
        }

        .nav-link.active {
            background: linear-gradient(135deg, rgba(20, 184, 166, 0.25), rgba(13, 148, 136, 0.15));
            color: #14b8a6;
            border: 1px solid rgba(20, 184, 166, 0.4);
            padding: 0.5rem 1.25rem;
            margin: 0 -0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transform: scale(1.05);
        }

        .dropdown-link {
            transition: all 0.3s ease;
        }

        .dropdown-link:hover {
            transform: translateX(4px);
        }
        
        .glass { backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.1); }
        .glass-dark { backdrop-filter: blur(10px); background: rgba(0, 0, 0, 0.2); }
        .hover-lift { 
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); 
            cursor: pointer;
        }
        .hover-lift:hover { 
            transform: translateY(-10px) scale(1.02); 
            box-shadow: 0 20px 40px rgba(6, 182, 212, 0.3);
        }
        
        .animate-float { animation: float 6s ease-in-out infinite; }
        @keyframes float { 
            0%, 100% { transform: translateY(0px) rotate(0deg); } 
            50% { transform: translateY(-20px) rotate(5deg); } 
        }
        
        .animate-pulse-slow { animation: pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
        .animate-bounce-slow { animation: bounce 2s infinite; }
        .animate-wiggle { animation: wiggle 2s ease-in-out infinite; }
        
        @keyframes wiggle {
            0%, 7% { transform: rotateZ(0); }
            15% { transform: rotateZ(-15deg); }
            20% { transform: rotateZ(10deg); }
            25% { transform: rotateZ(-10deg); }
            30% { transform: rotateZ(6deg); }
            35% { transform: rotateZ(-4deg); }
            40%, 100% { transform: rotateZ(0); }
        }
        
        /* Floating particles */
        .particle {
            position: absolute;
            background: linear-gradient(45deg, #22d3ee, #06b6d4);
            border-radius: 50%;
            pointer-events: none;
            animation: particleFloat linear infinite;
            opacity: 0.6;
        }
        
        @keyframes particleFloat {
            0% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 0.6;
            }
            90% {
                opacity: 0.6;
            }
            100% {
                transform: translateY(-100px) rotate(360deg);
                opacity: 0;
            }
        }
        
        .game-card {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.3), rgba(6, 182, 212, 0.1));
            border: 1px solid rgba(34, 211, 238, 0.2);
            position: relative;
            overflow: hidden;
        }
        
        .game-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(34, 211, 238, 0.1), transparent);
            transition: left 0.6s;
        }
        
        .game-card:hover::before {
            left: 100%;
        }
        
        .feature-icon {
            transition: all 0.3s ease;
        }
        
        .feature-icon:hover {
            transform: scale(1.2) rotate(10deg);
        }
        
        .play-button {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .play-button::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: all 0.4s ease;
        }
        
        .play-button:hover::before {
            width: 300px;
            height: 300px;
        }
        
        .benefit-card {
            transition: all 0.3s ease;
        }
        
        .benefit-card:hover {
            transform: translateY(-5px);
            background: linear-gradient(135deg, rgba(34, 211, 238, 0.1), rgba(6, 182, 212, 0.05));
        }
    </style>
</head>
<body class="bg-gradient-to-br from-deep-900 via-deep-800 to-ocean-900 min-h-screen text-white overflow-x-hidden">
    <!-- Floating Particles Background -->
    <div id="particles" class="fixed inset-0 pointer-events-none z-0"></div>
    
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 glass-dark border-b border-ocean-500/20">
        <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="/" class="flex items-center gap-3 hover:opacity-80 transition-opacity">
                        <img src="{{ asset('img/lg.png') }}" alt="Pawikan Patrol Logo" class="w-12 h-12 sm:w-16 sm:h-16 rounded-full">
                        <div class="ml-2 sm:ml-0">
                            <span class="text-lg sm:text-xl font-bold text-white">
                                Dahican Pawikan Patrol
                            </span>
                            <div class="text-[10px] sm:text-xs text-gray-300 mt-0.5">City of Mati – Dahican, est. 2004</div>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-4 lg:space-x-6">
                    <!-- Home with Dropdown -->
                    <div class="relative group">
                        <a href="/" class="nav-link flex items-center gap-1.5 text-white hover:text-ocean-300 transition-colors px-3 py-2 rounded-lg hover:bg-ocean-600/20">
                            <span class="text-base">🏠</span>
                            <span class="text-sm font-medium">Home</span>
                            <svg class="w-3.5 h-3.5 mt-0.5 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </a>
                        
                        <!-- Dropdown Menu -->
                        <div class="absolute top-full left-0 mt-2 w-64 bg-gradient-to-br from-deep-800/95 to-deep-900/95 backdrop-blur-lg border border-ocean-500/20 rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                            <div class="p-4 space-y-2">
                                <a href="{{ url('/#vision') }}" class="dropdown-link flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors w-full text-left">
                                    <span class="text-xl">🌟</span>
                                    <span>Vision & Mission</span>
                                </a>
                                <a href="{{ url('/#video-showcase') }}" class="dropdown-link flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors w-full text-left">
                                    <span class="text-xl">🎬</span>
                                    <span>Conservation Video</span>
                                </a>
                                <a href="{{ url('/#lifecycle') }}" class="dropdown-link flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors w-full text-left">
                                    <span class="text-xl">🌊</span>
                                    <span>Life Cycle</span>
                                </a>
                                <a href="{{ url('/#threats') }}" class="dropdown-link flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors w-full text-left">
                                    <span class="text-xl">⚠️</span>
                                    <span>Threats</span>
                                </a>
                                <a href="{{ url('/#species') }}" class="dropdown-link flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors w-full text-left">
                                    <span class="text-xl">🐢</span>
                                    <span>Species Guide</span>
                                </a>
                                <a href="{{ url('/#guidelines') }}" class="dropdown-link flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors w-full text-left">
                                    <span class="text-xl">📋</span>
                                    <span>Guidelines</span>
                                </a>
                                <a href="{{ url('/#dos-donts') }}" class="dropdown-link flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors w-full text-left">
                                    <span class="text-xl">✓✗</span>
                                    <span>DOs & DON'Ts</span>
                                </a>
                                <a href="{{ url('/#help') }}" class="dropdown-link flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors w-full text-left">
                                    <span class="text-lg">🤝</span>
                                    <span>How to Help</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- 3D Explorer -->
                    <a href="/3d-explorer" class="nav-link flex items-center gap-1.5 text-white hover:text-ocean-300 transition-colors px-3 py-2 rounded-lg hover:bg-ocean-600/20">
                        <span class="text-base">🧊</span>
                        <span class="text-sm font-medium">3D Explorer</span>
                    </a>

                    <!-- Patrol Map with Dropdown -->
                    <div class="relative group">
                        <a href="/patrol-map" class="nav-link flex items-center gap-1.5 text-white hover:text-ocean-300 transition-colors px-3 py-2 rounded-lg hover:bg-ocean-600/20">
                            <span class="text-base">🗺️</span>
                            <span class="text-sm font-medium">Patrol Map</span>
                            <svg class="w-3.5 h-3.5 mt-0.5 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
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
                    <a href="/games" class="nav-link flex items-center gap-1.5 text-white hover:text-ocean-300 transition-colors px-3 py-2 rounded-lg hover:bg-ocean-600/20 active">
                        <span class="text-base">🎮</span>
                        <span class="text-sm font-medium">Games</span>
                    </a>

                    <!-- Account Dropdown -->
                    @guest
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
                                    <a href="/auth" class="flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors" data-tab="login">
                                        <span class="text-sm">🔑</span>
                                        <span class="text-sm">Login</span>
                                    </a>
                                    <a href="/auth" class="flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors" data-tab="register">
                                        <span class="text-sm">📝</span>
                                        <span class="text-sm">Register</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="relative group">
                            <button class="flex items-center gap-2 text-white hover:text-ocean-400 transition-colors px-3 py-2 rounded-lg hover:bg-ocean-600/20">
                                @if(auth()->user()->profile_picture)
                                    <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" 
                                         alt="Profile Picture" 
                                         class="w-8 h-8 rounded-full object-cover border-2 border-ocean-500/30"
                                         onerror="this.onerror=null; this.outerHTML='<span class=\'text-lg\'>👤</span>';">
                                @else
                                    <span class="text-lg">👤</span>
                                @endif
                                <span class="text-md">
                                    @if(Auth::user()->role === 'admin')
                                        Admin
                                    @else
                                        {{ Auth::user()->name }}
                                    @endif
                                </span>
                                <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            
                            <!-- User Dropdown -->
                            <div class="absolute top-full right-0 mt-2 w-48 bg-gradient-to-br from-deep-800/95 to-deep-900/95 backdrop-blur-lg border border-ocean-500/20 rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                                <div class="p-2 space-y-1">
                                    @if(Auth::user()->role === 'patroller')
                                        <a href="{{ route('patroller.dashboard') }}" class="flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors">
                                            <span class="text-lg">📊</span>
                                            <span>Dashboard</span>
                                        </a>
                                    @elseif(Auth::user()->role === 'admin')
                                        <a href="/admin/dashboard" class="flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors">
                                            <span class="text-lg">📊</span>
                                            <span>Dashboard</span>
                                        </a>
                                    @else
                                        <a href="/profile" class="flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors">
                                            <span class="text-lg">👤</span>
                                            <span>Profile</span>
                                        </a>
                                    @endif
                                    <form method="POST" action="/logout" class="w-full">
                                        @csrf
                                        <button type="submit" class="flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors w-full text-left">
                                            <span class="text-lg">🚪</span>
                                            <span>Logout</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endguest
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-white hover:text-ocean-400 focus:outline-none focus:text-ocean-400 p-2">
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
                        <span>Home</span>
                    </a>
                    
                    <!-- Home Sub-items -->
                    <div class="ml-8 space-y-1">
                        <a href="{{ url('/#vision') }}" class="mobile-nav-link flex items-center gap-3 text-gray-300 hover:text-white hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                            <span class="text-lg">🌟</span>
                            <span>Vision & Mission</span>
                        </a>
                        <a href="{{ url('/#video-showcase') }}" class="mobile-nav-link flex items-center gap-3 text-gray-300 hover:text-white hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                            <span class="text-lg">🎬</span>
                            <span>Conservation Video</span>
                        </a>
                        <a href="{{ url('/#lifecycle') }}" class="mobile-nav-link flex items-center gap-3 text-gray-300 hover:text-white hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                            <span class="text-lg">🌊</span>
                            <span>Life Cycle</span>
                        </a>
                        <a href="{{ url('/#threats') }}" class="mobile-nav-link flex items-center gap-3 text-gray-300 hover:text-white hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                            <span class="text-lg">⚠️</span>
                            <span>Threats</span>
                        </a>
                        <a href="{{ url('/#species') }}" class="mobile-nav-link flex items-center gap-3 text-gray-300 hover:text-white hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                            <span class="text-lg">🐢</span>
                            <span>Species Guide</span>
                        </a>
                        <a href="{{ url('/#guidelines') }}" class="mobile-nav-link flex items-center gap-3 text-gray-300 hover:text-white hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                            <span class="text-lg">📋</span>
                            <span>Guidelines</span>
                        </a>
                        <a href="{{ url('/#help') }}" class="mobile-nav-link flex items-center gap-3 text-gray-300 hover:text-white hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                            <span class="text-lg">🤝</span>
                            <span>How to Help</span>
                        </a>
                    </div>
                </div>
                
                <!-- Other Pages -->
                <a href="/3d-explorer" class="mobile-nav-link flex items-center gap-3 text-white hover:text-ocean-400 hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                    <span class="text-lg">🌐</span>
                    <span>3D Explorer</span>
                </a>
                
                <!-- Patrol Map Section -->
                <div class="space-y-1">
                    <a href="/patrol-map" class="mobile-nav-link flex items-center gap-3 text-white hover:text-ocean-400 hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                        <span class="text-lg">🗺️</span>
                        <span>Patrol Map</span>
                    </a>
                    
                    <!-- Patrol Map Sub-items -->
                    <div class="ml-8 space-y-1">
                        <a href="/patrol-map/gallery" class="mobile-nav-link flex items-center gap-3 text-gray-300 hover:text-white hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                            <span class="text-lg">📸</span>
                            <span>Gallery Report</span>
                        </a>
                    </div>
                </div>
                
                <a href="/games" class="mobile-nav-link flex items-center gap-3 text-white hover:text-ocean-400 hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                    <span class="text-lg">🎮</span>
                    <span>Games</span>
                </a>
                
                <!-- Account Section -->
                @guest
                    <div class="space-y-1">
                        <button class="mobile-account-toggle flex items-center gap-3 text-white hover:text-ocean-400 hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                            <span class="text-lg">👤</span>
                            <span>Account</span>
                            <svg class="w-4 h-4 ml-auto transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <!-- Account Sub-items -->
                        <div class="ml-8 space-y-1 mobile-account-menu hidden">
                            <a href="/auth" class="mobile-nav-link flex items-center gap-3 text-gray-300 hover:text-white hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                                <span class="text-lg">🔑</span>
                                <span>Login</span>
                            </a>
                            <a href="/register" class="mobile-nav-link flex items-center gap-3 text-gray-300 hover:text-white hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                                <span class="text-lg">📝</span>
                                <span>Register</span>
                            </a>
                        </div>
                    </div>
                @else
                    @if(Auth::user()->role === 'patroller')
                        <a href="{{ route('patroller.dashboard') }}" class="flex items-center gap-3 text-white hover:text-ocean-400 hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors">
                            <span class="text-lg">📊</span>
                            <span>Dashboard</span>
                        </a>
                    @elseif(Auth::user()->role === 'admin')
                        <a href="/admin/dashboard" class="flex items-center gap-3 text-white hover:text-ocean-400 hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors">
                            <span class="text-lg">🛡️</span>
                            <span>Admin Panel</span>
                        </a>
                    @else
                        <a href="/profile" class="flex items-center gap-3 text-white hover:text-ocean-400 hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors">
                            <span class="text-lg">👤</span>
                            <span>Profile</span>
                        </a>
                    @endif
                    <form method="POST" action="/logout" class="w-full">
                        @csrf
                        <button type="submit" class="flex items-center gap-3 text-white hover:text-ocean-400 hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                            <span class="text-lg">🚪</span>
                            <span>Logout</span>
                        </button>
                    </form>
                @endguest
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-20 relative z-10">
        <!-- Hero Section for Games -->
        <section class="py-20 px-4">
            <div class="max-w-6xl mx-auto text-center">
                <div class="flex flex-col md:flex-row items-center justify-center mb-8">
                    <div class="text-8xl mr-0 md:mr-6 mb-4 md:mb-0 animate-float">🐢</div>
                    <div>
                        <h1 class="text-5xl md:text-6xl font-bold text-ocean-300 mb-4 tracking-wide cinzel-heading">
                            Pawikan Educational Games
                        </h1>
                        <p class="text-gray-300 text-xl md:text-2xl font-medium cinzel-body">
                            Learn marine turtle conservation through interactive gameplay
                        </p>
                        <div class="flex items-center justify-center gap-4 mt-6">
                            <div class="flex items-center gap-2 text-ocean-400">
                                <span class="animate-pulse">🎮</span>
                                <span class="text-sm font-medium">2 Interactive Games</span>
                            </div>
                            <div class="w-1 h-1 bg-ocean-400 rounded-full"></div>
                            <div class="flex items-center gap-2 text-ocean-400">
                                <span class="animate-bounce-slow">🏆</span>
                                <span class="text-sm font-medium">Educational & Fun</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Games Grid -->
        <section class="py-16 px-4">
            <div class="max-w-6xl mx-auto">
                <!-- Section Title -->
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-ocean-300 mb-4">Choose Your Adventure</h2>
                    <p class="text-gray-300 text-lg max-w-2xl mx-auto">
                        Dive into the world of marine conservation with our interactive educational games
                    </p>
                </div>
                
                <div class="grid md:grid-cols-2 gap-12">
                    
                    <!-- Quiz Game Card -->
                    <div class="game-card rounded-3xl p-8 hover-lift group">
                        <div class="text-center mb-8 relative z-10">
                            <div class="text-7xl mb-6 animate-wiggle">🧠</div>
                            <h3 class="text-3xl font-bold text-ocean-300 mb-4 cinzel-subheading">Pawikan Quiz Challenge</h3>
                            <p class="text-gray-300 leading-relaxed text-lg cinzel-body">
                                Test your knowledge about sea turtle conservation with 15 challenging multiple-choice questions. 
                                Learn fascinating facts about these amazing marine creatures!
                            </p>
                        </div>
                        
                        <!-- Game Features -->
                        <div class="space-y-4 mb-10 relative z-10">
                            <div class="flex items-center gap-4 text-gray-300 group/feature">
                                <span class="text-2xl text-ocean-400 feature-icon">📝</span>
                                <span class="font-medium">15 Multiple Choice Questions</span>
                            </div>
                            <div class="flex items-center gap-4 text-gray-300 group/feature">
                                <span class="text-2xl text-ocean-400 feature-icon">🔀</span>
                                <span class="font-medium">Randomized Question Order</span>
                            </div>
                            <div class="flex items-center gap-4 text-gray-300 group/feature">
                                <span class="text-2xl text-ocean-400 feature-icon">💡</span>
                                <span class="font-medium">Instant Feedback & Explanations</span>
                            </div>
                            <div class="flex items-center gap-4 text-gray-300 group/feature">
                                <span class="text-2xl text-ocean-400 feature-icon">🏆</span>
                                <span class="font-medium">Score Tracking & Results</span>
                            </div>
                            <div class="flex items-center gap-4 text-gray-300 group/feature">
                                <span class="text-2xl text-ocean-400 feature-icon">🎯</span>
                                <span class="font-medium">Each question worth 10 points</span>
                            </div>
                        </div>
                        
                        <!-- Play Button -->
                        <a href="/games/quiz" class="play-button quiz-start-btn block w-full bg-gradient-to-r from-ocean-600 to-ocean-500 hover:from-ocean-500 hover:to-ocean-400 text-white font-bold py-5 px-8 rounded-2xl text-center text-lg relative z-10 transform group-hover:scale-105 transition-all duration-300" onclick="playClickSound()">
                            <span class="relative z-10">🎯 Start Quiz Challenge</span>
                        </a>
                    </div>

                    <!-- Word Scramble Game Card -->
                    <div class="game-card rounded-3xl p-8 hover-lift group">
                        <div class="text-center mb-8 relative z-10">
                            <div class="text-7xl mb-6 animate-wiggle">🔤</div>
                            <h3 class="text-3xl font-bold text-ocean-300 mb-4 cinzel-subheading">Pawikan Word Challenge</h3>
                            <p class="text-gray-300 leading-relaxed text-lg cinzel-body">
                                Unscramble mixed-up letters to form words related to marine turtle conservation. 
                                Race against time while learning important conservation terms!
                            </p>
                        </div>
                        
                        <!-- Game Features -->
                        <div class="space-y-4 mb-10 relative z-10">
                            <div class="flex items-center gap-4 text-gray-300 group/feature">
                                <span class="text-2xl text-ocean-400 feature-icon">🔤</span>
                                <span class="font-medium">20+ Conservation Vocabulary</span>
                            </div>
                            <div class="flex items-center gap-4 text-gray-300 group/feature">
                                <span class="text-2xl text-ocean-400 feature-icon">⏱️</span>
                                <span class="font-medium">60-Second Timed Challenges</span>
                            </div>
                            <div class="flex items-center gap-4 text-gray-300 group/feature">
                                <span class="text-2xl text-ocean-400 feature-icon">📚</span>
                                <span class="font-medium">Educational Explanations</span>
                            </div>
                            <div class="flex items-center gap-4 text-gray-300 group/feature">
                                <span class="text-2xl text-ocean-400 feature-icon">🎯</span>
                                <span class="font-medium">Streak Scoring System</span>
                            </div>
                            <div class="flex items-center gap-4 text-gray-300 group/feature">
                                <span class="text-2xl text-ocean-400 feature-icon">➕</span>
                                <span class="font-medium">Each word solved earns 10 points</span>
                            </div>
                        </div>
                        
                        <!-- Play Button -->
                        <a href="/games/word-scramble" class="play-button word-start-btn block w-full bg-gradient-to-r from-ocean-600 to-ocean-500 hover:from-ocean-500 hover:to-ocean-400 text-white font-bold py-5 px-8 rounded-2xl text-center text-lg relative z-10 transform group-hover:scale-105 transition-all duration-300" onclick="playClickSound()">
                            <span class="relative z-10">🎮 Start Word Challenge</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        // Mobile menu toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileAccountToggles = document.querySelectorAll('.mobile-account-toggle');
            
            // Toggle main mobile menu
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
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
            
            // Toggle account submenu
            mobileAccountToggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
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
                if (!mobileMenu.contains(event.target) && !mobileMenuButton.contains(event.target)) {
                    mobileMenu.classList.add('hidden');
                    const menuIcon = mobileMenuButton.querySelector('svg');
                    if (menuIcon) {
                        menuIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />';
                    }
                }
            });
        });
        
        // Create floating particles
        function createParticles() {
            const particlesContainer = document.getElementById('particles');
            const particleCount = window.innerWidth < 768 ? 20 : 40;
            
            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                const size = Math.random() * 6 + 3;
                particle.style.width = size + 'px';
                particle.style.height = size + 'px';
                particle.style.animationDuration = (Math.random() * 15 + 10) + 's';
                particle.style.animationDelay = Math.random() * 5 + 's';
                particlesContainer.appendChild(particle);
            }
        }

        // Initialize particles when page loads
        window.addEventListener('load', createParticles);
        
        // Add interactive hover effects
        document.querySelectorAll('.game-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-10px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
        
        // Add click ripple effect to buttons
        document.querySelectorAll('.play-button').forEach(button => {
            button.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                ripple.classList.add('ripple');
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });

        // Content switching system
        const sections = document.querySelectorAll('[data-section]');
        const mainContent = document.querySelector('main');

        sections.forEach(section => {
            section.addEventListener('click', () => {
                const sectionId = section.getAttribute('data-section');
                const sectionContent = document.querySelector(`#${sectionId}`);

                if (sectionContent) {
                    mainContent.innerHTML = '';
                    mainContent.appendChild(sectionContent);
                }
            });
        });

        // Content switching system - replaces anchor link navigation
        class ContentSwitcher {
            constructor() {
                this.currentSection = 'games';
                this.init();
            }

            init() {
                // Set up navigation handlers
                this.setupNavigation();
                
                // Update active states
                this.updateActiveStates();
            }

            setupNavigation() {
                // Handle all navigation buttons with data-section attribute
                document.querySelectorAll('[data-section]').forEach(button => {
                    button.addEventListener('click', (e) => {
                        e.preventDefault();
                        const sectionId = button.getAttribute('data-section');
                        
                        // Handle different types of navigation
                        this.handleNavigation(sectionId);
                    });
                });
            }

            handleNavigation(sectionId) {
                switch(sectionId) {
                    case 'hero':
                    case 'species':
                    case 'vision':
                    case 'lifecycle':
                    case 'threats':
                    case 'guidelines':
                    case 'help':
                        // Navigate back to landing page with section
                        window.location.href = `/#${sectionId}`;
                        break;
                    case '3d-explorer':
                        window.location.href = '/3d-explorer';
                        break;
                    case 'patrol-map':
                        window.location.href = '/patrol-map';
                        break;
                    case 'games':
                        // Stay on current page
                        this.currentSection = 'games';
                        this.updateActiveStates();
                        break;
                    case 'quiz':
                        window.location.href = '/games/quiz';
                        break;
                    case 'word-scramble':
                        window.location.href = '/games/word-scramble';
                        break;
                    default:
                        console.log('Unknown section:', sectionId);
                }
            }

            updateActiveStates() {
                // Update navigation active states
                document.querySelectorAll('[data-section]').forEach(button => {
                    button.classList.remove('active');
                    if (button.getAttribute('data-section') === this.currentSection) {
                        button.classList.add('active');
                    }
                });
            }
        }

        // Initialize content switcher when DOM is loaded
        document.addEventListener('DOMContentLoaded', () => {
            window.contentSwitcher = new ContentSwitcher();
        });

        // Click sound function
        function playClickSound() {
            try {
                // Create audio context for better browser compatibility
                const audioContext = new (window.AudioContext || window.webkitAudioContext)();
                
                // Create oscillator for click sound
                const oscillator = audioContext.createOscillator();
                const gainNode = audioContext.createGain();
                
                // Connect nodes
                oscillator.connect(gainNode);
                gainNode.connect(audioContext.destination);
                
                // Configure sound - pleasant click sound
                oscillator.frequency.setValueAtTime(800, audioContext.currentTime);
                oscillator.frequency.exponentialRampToValueAtTime(400, audioContext.currentTime + 0.1);
                
                // Configure volume envelope
                gainNode.gain.setValueAtTime(0, audioContext.currentTime);
                gainNode.gain.linearRampToValueAtTime(0.3, audioContext.currentTime + 0.01);
                gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.15);
                
                // Play sound
                oscillator.start(audioContext.currentTime);
                oscillator.stop(audioContext.currentTime + 0.15);
                
                // Add visual feedback
                const clickedElement = event.target.closest('.play-button');
                if (clickedElement) {
                    clickedElement.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        clickedElement.style.transform = '';
                    }, 100);
                }
                
            } catch (error) {
                // Fallback for browsers that don't support Web Audio API
                console.log('Audio not supported, using visual feedback only');
                
                // Still provide visual feedback
                const clickedElement = event.target.closest('.play-button');
                if (clickedElement) {
                    clickedElement.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        clickedElement.style.transform = '';
                    }, 100);
                }
            }
        }
    </script>
</body>
</html>

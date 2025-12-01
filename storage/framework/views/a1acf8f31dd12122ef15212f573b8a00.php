<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Pawikan Quiz Challenge - Test Your Knowledge</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(asset('img/lg.png')); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(asset('img/lg.png')); ?>">
    <link rel="apple-touch-icon" href="<?php echo e(asset('img/lg.png')); ?>">
    <link rel="shortcut icon" href="<?php echo e(asset('img/lg.png')); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="<?php echo e(asset('js/game-activity.js')); ?>"></script>
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
        
        .glass-dark { backdrop-filter: blur(10px); background: rgba(0, 0, 0, 0.2); }
        .animate-bounce-slow { animation: bounce 2s infinite; }
        .animate-pulse-fast { animation: pulse 1s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
        .correct-answer { background: linear-gradient(135deg, #10b981, #059669); }
        .wrong-answer { background: linear-gradient(135deg, #ef4444, #dc2626); }
        .option-hover:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(34, 211, 238, 0.3); }
    </style>
</head>
<body class="bg-gradient-to-br from-deep-900 via-deep-800 to-ocean-900 min-h-screen text-white">
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 glass-dark border-b border-ocean-500/20">
        <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="/" class="flex items-center gap-3 hover:opacity-80 transition-opacity">
                        <img src="<?php echo e(asset('img/lg.png')); ?>" alt="Pawikan Patrol Logo" class="w-16 h-16 rounded-full">
                        <div>
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
                        <a href="#hero" class="nav-link flex items-center gap-1.5 text-white hover:text-ocean-300 transition-colors px-3 py-2 rounded-lg hover:bg-ocean-600/20">
                            <span class="text-base">🏠</span>
                            <span class="text-sm font-medium">Home</span>
                            <svg class="w-3.5 h-3.5 mt-0.5 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </a>
                        
                        <!-- Dropdown Menu -->
                        <div class="absolute top-full left-0 mt-2 w-64 bg-gradient-to-br from-deep-800/95 to-deep-900/95 backdrop-blur-lg border border-ocean-500/20 rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                            <div class="p-4 space-y-2">
                                <a href="<?php echo e(url('/#vision')); ?>" class="dropdown-link flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors w-full text-left">
                                    <span class="text-xl">🌟</span>
                                    <span>Vision & Mission</span>
                                </a>
                                <a href="<?php echo e(url('/#video-showcase')); ?>" class="dropdown-link flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors w-full text-left">
                                    <span class="text-xl">🎬</span>
                                    <span>Conservation Video</span>
                                </a>
                                <a href="<?php echo e(url('/#lifecycle')); ?>" class="dropdown-link flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors w-full text-left">
                                    <span class="text-xl">🌊</span>
                                    <span>Life Cycle</span>
                                </a>
                                <a href="<?php echo e(url('/#threats')); ?>" class="dropdown-link flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors w-full text-left">
                                    <span class="text-xl">⚠️</span>
                                    <span>Threats</span>
                                </a>
                                <a href="<?php echo e(url('/#species')); ?>" class="dropdown-link flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors w-full text-left">
                                    <span class="text-xl">🐢</span>
                                    <span>Species Guide</span>
                                </a>
                                <a href="<?php echo e(url('/#guidelines')); ?>" class="dropdown-link flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors w-full text-left">
                                    <span class="text-xl">📋</span>
                                    <span>Guidelines</span>
                                </a>
                                <a href="<?php echo e(url('/#dos-donts')); ?>" class="dropdown-link flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors w-full text-left">
                                    <span class="text-xl">✓✗</span>
                                    <span>DOs & DON'Ts</span>
                                </a>
                                <a href="<?php echo e(url('/#help')); ?>" class="dropdown-link flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors w-full text-left">
                                    <span class="text-lg">🤝</span>
                                    <span>How to Help</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- 3D Explorer -->
                    <a href="/3d-explorer" class="nav-link flex items-center gap-1.5 text-white hover:text-ocean-300 transition-colors px-3 py-2 rounded-lg hover:bg-ocean-600/20">
                        <span class="text-base">🌐</span>
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
                    <a href="/games" class="nav-link flex items-center gap-1.5 text-white hover:text-ocean-300 transition-colors px-3 py-2 rounded-lg bg-ocean-600/30 hover:bg-ocean-600/40">
                        <span class="text-base">🎮</span>
                        <span class="text-sm font-medium">Games</span>
                    </a>
                    <?php if(auth()->guard()->guest()): ?>
                        <div class="relative group">
                            <button class="flex items-center gap-2 text-white hover:text-ocean-400 transition-colors py-2 rounded-lg hover:bg-ocean-600/20">
                                <span class="text-lg">👤</span>
                                <span class="text-md">Account</span>
                                <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            
                            <!-- Account Dropdown Menu -->
                            <div class="absolute top-full right-0 mt-2 w-48 bg-gradient-to-br from-deep-800/95 to-deep-900/95 backdrop-blur-lg border border-ocean-500/20 rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                                <div class="p-2 space-y-1">
                                    <a href="/auth" class="flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors">
                                        <span class="text-lg">🔑</span>
                                        <span>Login</span>
                                    </a>
                                    <a href="/auth#register" class="flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors">
                                        <span class="text-lg">📝</span>
                                        <span>Register</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="relative group">
                            <button class="flex items-center gap-2 text-white hover:text-ocean-400 transition-colors px-3 py-2 rounded-lg hover:bg-ocean-600/20">
                                <span class="text-lg">👤</span>
                                <span class="text-md">
                                    <?php if(Auth::user()->role === 'admin'): ?>
                                        Admin
                                    <?php else: ?>
                                        <?php echo e(Auth::user()->name); ?>

                                    <?php endif; ?>
                                </span>
                                <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            
                            <!-- User Dropdown -->
                            <div class="absolute top-full right-0 mt-2 w-48 bg-gradient-to-br from-deep-800/95 to-deep-900/95 backdrop-blur-lg border border-ocean-500/20 rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                                <div class="p-2 space-y-1">
                                    <?php if(Auth::user()->role === 'patroller'): ?>
                                        <a href="<?php echo e(route('patroller.dashboard')); ?>" class="flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors">
                                            <span class="text-lg">📊</span>
                                            <span>Dashboard</span>
                                        </a>
                                    <?php elseif(Auth::user()->role === 'admin'): ?>
                                        <a href="/admin/dashboard" class="flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors">
                                            <span class="text-lg">📊</span>
                                            <span>Dashboard</span>
                                        </a>
                                    <?php else: ?>
                                        <a href="/profile" class="flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors">
                                            <span class="text-lg">👤</span>
                                            <span>Profile</span>
                                        </a>
                                    <?php endif; ?>
                                    <?php if(Auth::user()->isAdmin()): ?>
                                        <!-- Duplicate admin link removed as per user request -->
                                    <?php endif; ?>
                                    <form method="POST" action="/logout" class="w-full">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors w-full text-left">
                                            <span class="text-lg">🚪</span>
                                            <span>Logout</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
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
                    <a href="#hero" class="mobile-nav-link flex items-center gap-3 text-white hover:text-ocean-400 hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                        <span class="text-lg">🏠</span>
                        <span>Home</span>
                    </a>
                    
                    <!-- Home Sub-items -->
                    <div class="ml-8 space-y-1">
                        <a href="<?php echo e(url('/#vision')); ?>" class="mobile-nav-link flex items-center gap-3 text-gray-300 hover:text-white hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                            <span class="text-lg">🌟</span>
                            <span>Vision & Mission</span>
                        </a>
                        <a href="<?php echo e(url('/#video-showcase')); ?>" class="mobile-nav-link flex items-center gap-3 text-gray-300 hover:text-white hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                            <span class="text-lg">🎬</span>
                            <span>Conservation Video</span>
                        </a>
                        <a href="<?php echo e(url('/#lifecycle')); ?>" class="mobile-nav-link flex items-center gap-3 text-gray-300 hover:text-white hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                            <span class="text-lg">🌊</span>
                            <span>Life Cycle</span>
                        </a>
                        <a href="<?php echo e(url('/#threats')); ?>" class="mobile-nav-link flex items-center gap-3 text-gray-300 hover:text-white hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                            <span class="text-lg">⚠️</span>
                            <span>Threats</span>
                        </a>
                        <a href="<?php echo e(url('/#species')); ?>" class="mobile-nav-link flex items-center gap-3 text-gray-300 hover:text-white hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                            <span class="text-lg">🐢</span>
                            <span>Species Guide</span>
                        </a>
                        <a href="<?php echo e(url('/#guidelines')); ?>" class="mobile-nav-link flex items-center gap-3 text-gray-300 hover:text-white hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                            <span class="text-lg">📋</span>
                            <span>Guidelines</span>
                        </a>
                        <a href="<?php echo e(url('/#help')); ?>" class="mobile-nav-link flex items-center gap-3 text-gray-300 hover:text-white hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
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
                
                <div class="space-y-1">
                    <a href="/patrol-map" class="mobile-nav-link flex items-center gap-3 text-white hover:text-ocean-400 hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                        <span class="text-lg">🗺️</span>
                        <span>Patrol Map</span>
                    </a>
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
                <?php if(auth()->guard()->guest()): ?>
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
                            <a href="/auth#register" class="mobile-nav-link flex items-center gap-3 text-gray-300 hover:text-white hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                                <span class="text-lg">📝</span>
                                <span>Register</span>
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="/profile" class="flex items-center gap-3 text-white hover:text-ocean-400 hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors">
                        <span class="text-lg">👤</span>
                        <span>Profile</span>
                    </a>
                    <?php if(Auth::user()->isAdmin()): ?>
                        <!-- Duplicate admin link removed as per user request -->
                    <?php endif; ?>
                    <form method="POST" action="/logout" class="w-full">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="flex items-center gap-3 text-white hover:text-white hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                            <span class="text-lg">🚪</span>
                            <span>Logout</span>
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Game Container -->
    <main class="pt-24 pb-8 px-4">
        <div class="max-w-4xl mx-auto">
            
            <!-- Game Stats -->
            <div class="glass-dark rounded-2xl p-4 sm:p-6 mb-8 border border-ocean-500/20">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-4 sm:gap-6">
                        <div class="text-center">
                            <div class="text-xl sm:text-2xl font-bold text-ocean-300" id="current-question">1</div>
                            <div class="text-xs sm:text-sm text-gray-400 cinzel-text">Question</div>
                        </div>
                        <div class="text-center">
                            <div class="text-xl sm:text-2xl font-bold text-ocean-300" id="score">0</div>
                            <div class="text-xs sm:text-sm text-gray-400 cinzel-text">Score</div>
                        </div>
                        <div class="text-center">
                            <div class="text-xl sm:text-2xl font-bold text-ocean-300" id="correct-count">0</div>
                            <div class="text-xs sm:text-sm text-gray-400 cinzel-text">Correct</div>
                        </div>
                    </div>
                    <div class="text-center sm:text-right w-full sm:w-auto">
                        <div class="text-base sm:text-lg font-semibold text-gray-300 cinzel-text">
                            <span id="progress">1</span> / 15
                        </div>
                        <div class="w-full sm:w-48 bg-gray-700 rounded-full h-2 mt-2">
                            <div class="bg-gradient-to-r from-ocean-500 to-ocean-400 h-2 rounded-full transition-all duration-300" 
                                 id="progress-bar" style="width: 6.67%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Question Card -->
            <div class="glass-dark rounded-3xl p-8 mb-8 border border-ocean-500/20" id="question-card">
                <div class="text-center mb-8">
                    <div class="text-5xl mb-4" id="question-emoji">🐢</div>
                    <h2 class="text-2xl font-bold text-ocean-300 mb-4 cinzel-subheading" id="question-text">
                        Loading question...
                    </h2>
                </div>

                <!-- Answer Options -->
                <div class="space-y-4" id="options-container">
                    <!-- Options will be populated by JavaScript -->
                </div>

                <!-- Feedback Section -->
                <div class="mt-8 p-6 rounded-2xl border hidden" id="feedback-section">
                    <div class="text-center">
                        <div class="text-4xl mb-3" id="feedback-emoji"></div>
                        <div class="text-xl font-bold mb-3" id="feedback-title"></div>
                        <div class="text-gray-300 leading-relaxed" id="feedback-explanation"></div>
                        <button onclick="nextQuestion()" 
                                class="mt-6 bg-gradient-to-r from-ocean-600 to-ocean-500 hover:from-ocean-500 hover:to-ocean-400 text-white font-bold py-3 px-8 rounded-xl transition-all duration-300">
                            Next Question →
                        </button>
                    </div>
                </div>
            </div>

            <!-- Results Screen -->
            <div class="glass-dark rounded-3xl p-8 border border-ocean-500/20 hidden" id="results-screen">
                <div class="text-center">
                    <div class="text-6xl mb-6" id="results-emoji">🏆</div>
                    <h2 class="text-4xl font-bold text-ocean-300 mb-4" id="results-title">Quiz Complete!</h2>
                    <div class="text-2xl text-gray-300 mb-8" id="results-score"></div>
                    
                    <!-- Performance Breakdown -->
                    <div class="grid md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-green-500/20 border border-green-500/30 rounded-xl p-4">
                            <div class="text-3xl font-bold text-green-400" id="final-correct">0</div>
                            <div class="text-sm text-gray-300">Correct Answers</div>
                        </div>
                        <div class="bg-red-500/20 border border-red-500/30 rounded-xl p-4">
                            <div class="text-3xl font-bold text-red-400" id="final-wrong">0</div>
                            <div class="text-sm text-gray-300">Wrong Answers</div>
                        </div>
                        <div class="bg-ocean-500/20 border border-ocean-500/30 rounded-xl p-4">
                            <div class="text-3xl font-bold text-ocean-400" id="final-percentage">0%</div>
                            <div class="text-sm text-gray-300">Accuracy</div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-4 justify-center mb-4">
                        <button onclick="restartQuiz()" 
                                class="bg-gradient-to-r from-ocean-600 to-ocean-500 hover:from-ocean-500 hover:to-ocean-400 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300">
                            🔄 Play Again
                        </button>
                        <a href="/games" 
                           class="bg-gradient-to-r from-gray-600 to-gray-500 hover:from-gray-500 hover:to-gray-400 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300">
                            🎮 More Games
                        </a>
                    </div>

                    <!-- Save Record Section -->
                    <?php if(auth()->guard()->check()): ?>
                        <?php if(Auth::user()->role === 'user'): ?>
                    <div class="border-t border-gray-600/30 pt-6">
                        <div id="save-status" class="mb-4 hidden">
                            <div class="bg-green-500/20 border border-green-500/30 rounded-lg p-3 text-green-400">
                                <div class="flex items-center gap-2">
                                    <span class="text-lg">✅</span>
                                    <span>Game record saved successfully!</span>
                                </div>
                            </div>
                        </div>
                        
                        <button id="save-record-btn" onclick="saveQuizRecord()" 
                                class="bg-gradient-to-r from-green-600 to-green-500 hover:from-green-500 hover:to-green-400 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 flex items-center gap-2 mx-auto">
                            <span>💾</span>
                            <span>Save Record</span>
                        </button>
                        
                        <div id="save-error" class="mt-3 hidden">
                            <div class="bg-red-500/20 border border-red-500/30 rounded-lg p-3 text-red-400">
                                <div class="flex items-center gap-2">
                                    <span class="text-lg">❌</span>
                                    <span>Failed to save record. Please try again.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                        <?php else: ?>
                    <div class="border-t border-gray-600/30 pt-6">
                        <div class="bg-blue-500/20 border border-blue-500/30 rounded-lg p-3 text-blue-400 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <span class="text-lg">ℹ️</span>
                                <span>Game record saving is available for regular users only</span>
                            </div>
                        </div>
                    </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Quiz Questions Database - Modular for easy expansion
        const quizQuestions = [
            {
                emoji: "🐢",
                question: "What is the scientific name for the Green Sea Turtle?",
                options: ["Chelonia mydas", "Eretmochelys imbricata", "Lepidochelys olivacea", "Caretta caretta"],
                correct: 0,
                explanation: "Chelonia mydas is the scientific name for Green Sea Turtles. They're called 'green' because of their green-colored fat, not their shell color."
            },
            {
                emoji: "🏖️",
                question: "Where do female sea turtles lay their eggs?",
                options: ["In coral reefs", "On sandy beaches", "In seagrass beds", "In deep ocean trenches"],
                correct: 1,
                explanation: "Female sea turtles return to sandy beaches to lay their eggs, often the same beach where they were born. This is called natal homing."
            },
            {
                emoji: "🌙",
                question: "When do sea turtles typically come ashore to nest?",
                options: ["During the day", "At night", "During storms", "Only during full moon"],
                correct: 1,
                explanation: "Sea turtles typically nest at night to avoid predators and hot daytime temperatures. Darkness provides protection for both mothers and hatchlings."
            },
            {
                emoji: "🥚",
                question: "How many eggs does a sea turtle typically lay in one nest?",
                options: ["10-20 eggs", "50-200 eggs", "300-500 eggs", "Over 1000 eggs"],
                correct: 1,
                explanation: "Sea turtles typically lay 50-200 eggs per nest, depending on the species. They may nest multiple times during a single nesting season."
            },
            {
                emoji: "⏰",
                question: "How long does it take for sea turtle eggs to hatch?",
                options: ["2-4 weeks", "6-8 weeks", "3-4 months", "6 months"],
                correct: 1,
                explanation: "Sea turtle eggs typically incubate for 6-8 weeks before hatching. The exact time depends on species and sand temperature."
            },
            {
                emoji: "🌡️",
                question: "What determines the sex of sea turtle hatchlings?",
                options: ["Genetics", "Sand temperature", "Moon phases", "Ocean currents"],
                correct: 1,
                explanation: "Sand temperature during incubation determines sex. Warmer temperatures produce more females, cooler temperatures produce more males."
            },
            {
                emoji: "🔥",
                question: "What is the biggest threat to sea turtle nesting beaches?",
                options: ["Plastic pollution", "Climate change", "Coastal development", "Overfishing"],
                correct: 2,
                explanation: "Coastal development destroys nesting beaches and creates light pollution that confuses hatchlings, making it one of the most serious threats."
            },
            {
                emoji: "💡",
                question: "How does artificial lighting affect sea turtle hatchlings?",
                options: ["It helps them see better", "It confuses their navigation", "It keeps them warm", "It has no effect"],
                correct: 1,
                explanation: "Artificial lights confuse hatchlings who naturally navigate toward the brightest horizon (historically the ocean). Lights can lead them away from the sea."
            },
            {
                emoji: "🥤",
                question: "Why is plastic pollution particularly dangerous for sea turtles?",
                options: ["It tangles their flippers", "They mistake it for food", "It blocks sunlight", "It makes water toxic"],
                correct: 1,
                explanation: "Sea turtles often mistake plastic bags and debris for jellyfish and other food, leading to intestinal blockages and death."
            },
            {
                emoji: "🎣",
                question: "What fishing practice poses the greatest threat to sea turtles?",
                options: ["Spear fishing", "Net fishing", "Hook and line fishing", "Fish traps"],
                correct: 1,
                explanation: "Net fishing, especially with large trawl nets, accidentally captures sea turtles as bycatch, leading to drowning since they need to surface to breathe."
            },
            {
                emoji: "🌊",
                question: "Which sea turtle species is known for its long migrations?",
                options: ["Hawksbill", "Green", "Leatherback", "Loggerhead"],
                correct: 2,
                explanation: "Leatherback turtles make the longest migrations, traveling thousands of miles across ocean basins following jellyfish populations."
            },
            {
                emoji: "🦀",
                question: "What do adult Green Sea Turtles primarily eat?",
                options: ["Fish and crabs", "Jellyfish", "Seagrass and algae", "Coral polyps"],
                correct: 2,
                explanation: "Adult Green Sea Turtles are primarily herbivorous, feeding on seagrass and algae. Juveniles eat more varied diets including jellyfish and crustaceans."
            },
            {
                emoji: "🏥",
                question: "What should you do if you find an injured sea turtle?",
                options: ["Take it home to care for it", "Put it back in the water immediately", "Contact local wildlife authorities", "Feed it and give it water"],
                correct: 2,
                explanation: "Always contact local wildlife authorities or marine turtle rescue organizations. They have the expertise and permits needed to properly help injured turtles."
            },
            {
                emoji: "📸",
                question: "What's the best way to observe nesting sea turtles?",
                options: ["Use bright flashlights", "Get as close as possible", "Follow guided tours with red lights", "Take flash photography"],
                correct: 2,
                explanation: "Join guided tours that use red lights (which don't disturb turtles) and maintain respectful distances. Never use white lights or flash photography."
            },
            {
                emoji: "🌍",
                question: "How can individuals help sea turtle conservation?",
                options: ["Only scientists can help", "Reduce plastic use and support conservation", "Collect turtle eggs for protection", "Build more beachfront hotels"],
                correct: 1,
                explanation: "Everyone can help by reducing plastic use, supporting conservation organizations, participating in beach cleanups, and making responsible tourism choices."
            }
        ];

        // Game State
        let currentQuestionIndex = 0;
        let score = 0;
        let correctAnswers = 0;
        let timeLeft = 600; // 10 minutes
        let gameTimer = null;
        let gameActive = false;
        let startTime = Date.now();
        let totalTimeSpent = 0;
        let gameActivity = null;

        // Initialize Game
        function initializeQuiz() {
            shuffledQuestions = [...quizQuestions].sort(() => Math.random() - 0.5);
            currentQuestionIndex = 0;
            score = 0;
            correctAnswers = 0;
            timeLeft = 600;
            gameActive = true;
            startTime = Date.now();
            
            // Initialize GameActivity helper
            console.log('Checking GameActivity class availability...');
            console.log('typeof GameActivity:', typeof GameActivity);
            console.log('window.GameActivity:', window.GameActivity);
            
            if (typeof GameActivity === 'undefined') {
                console.error('GameActivity class not found. Make sure game-activity.js is loaded.');
                alert('Game system not properly loaded. Please refresh the page.');
                return;
            }
            
            try {
                gameActivity = new GameActivity();
                console.log('GameActivity initialized successfully for quiz:', gameActivity);
            } catch (error) {
                console.error('Error initializing GameActivity for quiz:', error);
                alert('Failed to initialize game system. Please refresh the page.');
            }
            
            document.getElementById('question-card').classList.remove('hidden');
            document.getElementById('results-screen').classList.add('hidden');
            
            displayQuestion();
            startTimer();
        }

        // Display Current Question
        function displayQuestion() {
            const question = shuffledQuestions[currentQuestionIndex];
            hasAnswered = false;
            
            // Update question display
            document.getElementById('question-emoji').textContent = question.emoji;
            document.getElementById('question-text').textContent = question.question;
            document.getElementById('current-question').textContent = currentQuestionIndex + 1;
            document.getElementById('progress').textContent = currentQuestionIndex + 1;
            
            // Update progress bar
            const progressPercent = ((currentQuestionIndex + 1) / 15) * 100;
            document.getElementById('progress-bar').style.width = progressPercent + '%';
            
            // Hide feedback
            document.getElementById('feedback-section').classList.add('hidden');
            
            // Create answer options
            const optionsContainer = document.getElementById('options-container');
            optionsContainer.innerHTML = '';
            
            question.options.forEach((option, index) => {
                const optionButton = document.createElement('button');
                optionButton.className = 'w-full p-4 text-left bg-gradient-to-r from-gray-700 to-gray-600 hover:from-ocean-600 hover:to-ocean-500 rounded-xl transition-all duration-300 option-hover';
                optionButton.innerHTML = `
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-ocean-500 rounded-full flex items-center justify-center text-white font-bold">
                            ${String.fromCharCode(65 + index)}
                        </div>
                        <span class="text-white">${option}</span>
                    </div>
                `;
                optionButton.onclick = () => selectAnswer(index);
                optionsContainer.appendChild(optionButton);
            });
        }

        // Handle Answer Selection
        function selectAnswer(selectedIndex) {
            if (hasAnswered) return;
            
            hasAnswered = true;
            const question = shuffledQuestions[currentQuestionIndex];
            const isCorrect = selectedIndex === question.correct;
            
            // Update score
            if (isCorrect) {
                score += 10;
                correctAnswers++;
                document.getElementById('score').textContent = score;
                document.getElementById('correct-count').textContent = correctAnswers;
            }
            
            // Style the selected answer
            const options = document.querySelectorAll('#options-container button');
            options.forEach((option, index) => {
                if (index === selectedIndex) {
                    option.className = isCorrect ? 
                        'w-full p-4 text-left rounded-xl correct-answer' : 
                        'w-full p-4 text-left rounded-xl wrong-answer';
                } else if (index === question.correct) {
                    option.className = 'w-full p-4 text-left rounded-xl correct-answer';
                } else {
                    option.className = 'w-full p-4 text-left rounded-xl bg-gray-600 opacity-50';
                }
                option.disabled = true;
            });
            
            // Show feedback
            showFeedback(isCorrect, question.explanation);
        }

        // Show Feedback
        function showFeedback(isCorrect, explanation) {
            const feedbackSection = document.getElementById('feedback-section');
            const feedbackEmoji = document.getElementById('feedback-emoji');
            const feedbackTitle = document.getElementById('feedback-title');
            const feedbackExplanation = document.getElementById('feedback-explanation');
            
            // Play sound effect based on answer
            if (isCorrect) {
                playCorrectSound();
                feedbackSection.className = 'mt-8 p-6 rounded-2xl border border-green-500/30 bg-green-500/10';
                feedbackEmoji.textContent = '🎉';
                feedbackTitle.textContent = 'Correct!';
                feedbackTitle.className = 'text-xl font-bold mb-3 text-green-400';
            } else {
                playWrongSound();
                feedbackSection.className = 'mt-8 p-6 rounded-2xl border border-red-500/30 bg-red-500/10';
                feedbackEmoji.textContent = '💡';
                feedbackTitle.textContent = 'Not quite right';
                feedbackTitle.className = 'text-xl font-bold mb-3 text-red-400';
            }
            
            feedbackExplanation.textContent = explanation;
            feedbackSection.classList.remove('hidden');
        }

        // Next Question
        function nextQuestion() {
            currentQuestionIndex++;
            
            if (currentQuestionIndex >= 15) {
                showResults();
            } else {
                displayQuestion();
            }
        }

        // Show Results
        function showResults() {
            // Play completion bell sound
            playCompletionBell();
            
            document.getElementById('question-card').classList.add('hidden');
            document.getElementById('results-screen').classList.remove('hidden');
            
            const percentage = Math.round((correctAnswers / 15) * 100);
            const wrongAnswers = 15 - correctAnswers;
            
            // Calculate total time spent
            totalTimeSpent = Math.floor((Date.now() - startTime) / 1000);
            
            // Update results display
            document.getElementById('results-score').textContent = `You scored ${score} points!`;
            document.getElementById('final-correct').textContent = correctAnswers;
            document.getElementById('final-wrong').textContent = wrongAnswers;
            document.getElementById('final-percentage').textContent = percentage + '%';
            
            // Set results emoji and title based on performance
            const resultsEmoji = document.getElementById('results-emoji');
            const resultsTitle = document.getElementById('results-title');
            
            if (percentage >= 90) {
                resultsEmoji.textContent = '🏆';
                resultsTitle.textContent = 'Outstanding!';
            } else if (percentage >= 70) {
                resultsEmoji.textContent = '🌟';
                resultsTitle.textContent = 'Great Job!';
            } else if (percentage >= 50) {
                resultsEmoji.textContent = '👍';
                resultsTitle.textContent = 'Good Effort!';
            } else {
                resultsEmoji.textContent = '📚';
                resultsTitle.textContent = 'Keep Learning!';
            }
            
            // Stop the timer
            if (gameTimer) {
                clearInterval(gameTimer);
            }
            
            // Save functionality is now manual - user must click the "Save Record" button
        }

        // Restart Quiz
        function restartQuiz() {
            initializeQuiz();
        }

        // Start Timer
        function startTimer() {
            gameTimer = setInterval(() => {
                timeLeft -= 1;
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                document.getElementById('time-left').textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
                
                if (timeLeft <= 0) {
                    clearInterval(gameTimer);
                    showResults();
                }
            }, 1000);
        }


        // Save quiz record
        async function saveQuizRecord() {
            console.log('saveQuizRecord called');
            console.log('gameActivity object:', gameActivity);
            console.log('current variables:', {
                score: score,
                correctAnswers: correctAnswers,
                totalTimeSpent: totalTimeSpent
            });
            
            if (!gameActivity) {
                console.error('GameActivity not initialized');
                alert('GameActivity system not loaded. Please refresh the page and try again.');
                document.getElementById('save-error').classList.remove('hidden');
                setTimeout(() => {
                    document.getElementById('save-error').classList.add('hidden');
                }, 3000);
                return;
            }
            
            try {
                // Determine difficulty level based on performance
                const percentage = Math.round((correctAnswers / 15) * 100);
                let difficulty = 'medium';
                if (percentage >= 90) {
                    difficulty = 'hard';
                } else if (percentage < 50) {
                    difficulty = 'easy';
                }
                
                // Record the game activity
                const result = await gameActivity.recordQuizCompletion(
                    score,              // Final score
                    15,                 // Total questions
                    correctAnswers,     // Correct answers
                    totalTimeSpent,     // Time spent in seconds
                    difficulty          // Difficulty level
                );
                
                // Show success notification
                document.getElementById('save-status').classList.remove('hidden');
                setTimeout(() => {
                    document.getElementById('save-status').classList.add('hidden');
                }, 3000);
                
                // Update statistics display if available
                if (result.user_stats) {
                    gameActivity.updateStatisticsDisplay(result.user_stats);
                }
                
                console.log('Quiz game activity recorded successfully:', result);
                
            } catch (error) {
                console.error('Error recording quiz game activity:', error);
                console.error('Error details:', {
                    message: error.message,
                    response: error.response?.data,
                    status: error.response?.status,
                    config: error.config
                });
                
                // Show detailed error to user
                let errorMessage = 'Failed to save quiz record';
                if (error.response?.status === 401) {
                    errorMessage = 'Please log in to save your quiz records';
                } else if (error.response?.status === 422) {
                    errorMessage = 'Invalid quiz data. Please try again.';
                } else if (error.response?.status === 500) {
                    errorMessage = 'Server error. Please try again later.';
                } else if (error.message) {
                    errorMessage = `Error: ${error.message}`;
                }
                
                alert(errorMessage);
                document.getElementById('save-error').classList.remove('hidden');
                setTimeout(() => {
                    document.getElementById('save-error').classList.add('hidden');
                }, 3000);
            }
        }

        
        // Audio effect functions
        function playCorrectSound() {
            try {
                const audioContext = new (window.AudioContext || window.webkitAudioContext)();
                
                // Create a pleasant "ding" sound for correct answers
                const oscillator = audioContext.createOscillator();
                const gainNode = audioContext.createGain();
                
                oscillator.connect(gainNode);
                gainNode.connect(audioContext.destination);
                
                // Rising tone for success
                oscillator.frequency.setValueAtTime(523, audioContext.currentTime); // C5
                oscillator.frequency.setValueAtTime(659, audioContext.currentTime + 0.1); // E5
                oscillator.frequency.setValueAtTime(784, audioContext.currentTime + 0.2); // G5
                
                // Volume envelope
                gainNode.gain.setValueAtTime(0, audioContext.currentTime);
                gainNode.gain.linearRampToValueAtTime(0.3, audioContext.currentTime + 0.05);
                gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.4);
                
                oscillator.start(audioContext.currentTime);
                oscillator.stop(audioContext.currentTime + 0.4);
                
            } catch (error) {
                console.log('Audio not supported');
            }
        }

        function playWrongSound() {
            try {
                const audioContext = new (window.AudioContext || window.webkitAudioContext)();
                
                // Create a "buzz" sound for wrong answers
                const oscillator = audioContext.createOscillator();
                const gainNode = audioContext.createGain();
                
                oscillator.connect(gainNode);
                gainNode.connect(audioContext.destination);
                
                // Descending tone for failure
                oscillator.frequency.setValueAtTime(300, audioContext.currentTime);
                oscillator.frequency.exponentialRampToValueAtTime(150, audioContext.currentTime + 0.3);
                
                // Volume envelope
                gainNode.gain.setValueAtTime(0, audioContext.currentTime);
                gainNode.gain.linearRampToValueAtTime(0.2, audioContext.currentTime + 0.05);
                gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.3);
                
                oscillator.start(audioContext.currentTime);
                oscillator.stop(audioContext.currentTime + 0.3);
                
            } catch (error) {
                console.log('Audio not supported');
            }
        }

        function playCompletionBell() {
            try {
                const audioContext = new (window.AudioContext || window.webkitAudioContext)();
                
                // Create bell-like sound for game completion
                const oscillator1 = audioContext.createOscillator();
                const oscillator2 = audioContext.createOscillator();
                const gainNode = audioContext.createGain();
                
                oscillator1.connect(gainNode);
                oscillator2.connect(gainNode);
                gainNode.connect(audioContext.destination);
                
                // Bell harmonics
                oscillator1.frequency.setValueAtTime(880, audioContext.currentTime); // A5
                oscillator2.frequency.setValueAtTime(1320, audioContext.currentTime); // E6
                
                // Volume envelope for bell effect
                gainNode.gain.setValueAtTime(0, audioContext.currentTime);
                gainNode.gain.linearRampToValueAtTime(0.4, audioContext.currentTime + 0.1);
                gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 2.0);
                
                oscillator1.start(audioContext.currentTime);
                oscillator2.start(audioContext.currentTime);
                oscillator1.stop(audioContext.currentTime + 2.0);
                oscillator2.stop(audioContext.currentTime + 2.0);
                
            } catch (error) {
                console.log('Audio not supported');
            }
        }
        
        // Start the quiz when page loads
        window.onload = () => {
            initializeQuiz();
        };
    </script>

    <!-- Mobile Navigation Handling -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileAccountToggles = document.querySelectorAll('.mobile-account-toggle');
            const accountMenus = document.querySelectorAll('.mobile-account-menu');

            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                });
            }

            if (mobileAccountToggles.length && accountMenus.length) {
                mobileAccountToggles.forEach((toggle) => {
                    toggle.addEventListener('click', () => {
                        accountMenus.forEach(menu => menu.classList.toggle('hidden'));
                    });
                });
            }
        });
    </script>
</body>
</html>
<?php /**PATH C:\Users\Rayver\Desktop\pawikan-patrol\my_app\resources\views/games/quiz.blade.php ENDPATH**/ ?>
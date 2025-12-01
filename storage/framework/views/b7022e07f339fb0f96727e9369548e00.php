<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Pawikan Word Challenge - Unscramble Conservation Terms</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
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
        .correct-word { 
            background: linear-gradient(135deg, #10b981, #059669);
            animation: correctPulse 0.6s ease-in-out;
        }
        .wrong-word { 
            background: linear-gradient(135deg, #ef4444, #dc2626);
            animation: shake 0.5s ease-in-out;
        }
        @keyframes correctPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
        .timer-warning { color: #ef4444; animation: pulse 1s infinite; }
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
                        <img src="/img/lg.png" alt="Pawikan Patrol Logo" class="w-16 h-16 rounded-full">
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

                    <!-- Account Dropdown -->
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
                                    <a href="/auth" class="dropdown-link flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors">
                                        <span class="text-lg">🔑</span>
                                        <span>Login</span>
                                    </a>
                                    <a href="/auth#register" class="dropdown-link flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors">
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
                                        <a href="<?php echo e(route('patroller.dashboard')); ?>" class="dropdown-link flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors w-full text-left">
                                            <span class="text-lg">📊</span>
                                            <span>Dashboard</span>
                                        </a>
                                    <?php elseif(Auth::user()->role === 'admin'): ?>
                                        <a href="/admin/dashboard" class="dropdown-link flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors w-full text-left">
                                            <span class="text-lg">📊</span>
                                            <span>Dashboard</span>
                                        </a>
                                    <?php else: ?>
                                        <a href="/profile" class="dropdown-link flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors w-full text-left">
                                            <span class="text-lg">👤</span>
                                            <span>Profile</span>
                                        </a>
                                    <?php endif; ?>
                                    <?php if(Auth::user()->isAdmin()): ?>
                                        <!-- Duplicate admin link removed as per user request -->
                                    <?php endif; ?>
                                    <form method="POST" action="/logout" class="w-full">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="dropdown-link flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors w-full text-left">
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
                        <button type="submit" class="flex items-center gap-3 text-white hover:text-ocean-400 hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
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
            <div class="glass-dark rounded-2xl p-6 mb-8 border border-ocean-500/20">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-6">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-ocean-300" id="current-word">1</div>
                            <div class="text-sm text-gray-400 cinzel-text">Word</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-ocean-300" id="score">0</div>
                            <div class="text-sm text-gray-400 cinzel-text">Score</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-ocean-300" id="streak">0</div>
                            <div class="text-sm text-gray-400 cinzel-text">Streak</div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold" id="timer">180</div>
                        <div class="text-sm text-gray-400 cinzel-text">Seconds</div>
                        <div class="w-32 bg-gray-700 rounded-full h-2 mt-2">
                            <div class="bg-gradient-to-r from-green-500 to-yellow-500 h-2 rounded-full transition-all duration-1000" 
                                 id="timer-bar" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Game Area -->
            <div class="glass-dark rounded-3xl p-8 mb-8 border border-ocean-500/20" id="game-area">
                
                <!-- Current Word Challenge -->
                <div class="text-center mb-8">
                    <div class="text-4xl mb-4" id="word-emoji">🐢</div>
                    <h2 class="text-xl text-gray-300 mb-2 cinzel-subheading">Unscramble this word:</h2>
                    <div class="text-3xl font-bold text-ocean-300 mb-4" id="scrambled-word">LOADING...</div>
                    <div class="text-sm text-gray-400 cinzel-text" id="word-hint">Hint will appear here</div>
                </div>

                <!-- Answer Input -->
                <div class="text-center mb-6">
                    <div class="inline-block bg-gray-800 rounded-xl p-6 min-w-80">
                        <div class="text-sm text-gray-400 mb-3 cinzel-text">Type your answer:</div>
                        <input type="text" 
                               id="user-answer-input" 
                               class="w-full px-4 py-3 text-2xl font-bold text-white bg-gray-700 border-2 border-ocean-500 rounded-lg focus:border-ocean-400 focus:outline-none text-center uppercase"
                               maxlength="20">
                        <div class="text-sm text-gray-400 mt-2">Press Enter to submit</div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-center gap-4">
                    <button onclick="clearAnswer()" 
                            class="bg-gradient-to-r from-gray-600 to-gray-500 hover:from-gray-500 hover:to-gray-400 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300">
                        🗑️ Clear
                    </button>
                    <button onclick="submitAnswer()" 
                            class="bg-gradient-to-r from-ocean-600 to-ocean-500 hover:from-ocean-500 hover:to-ocean-400 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300">
                        ✓ Submit
                    </button>
                    <button onclick="skipWord()" 
                            class="bg-gradient-to-r from-yellow-600 to-yellow-500 hover:from-yellow-500 hover:to-yellow-400 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300">
                        ⏭️ Skip
                    </button>
                </div>

                <!-- Feedback Section -->
                <div class="mt-8 p-6 rounded-2xl border hidden" id="feedback-section">
                    <div class="text-center">
                        <div class="text-4xl mb-3" id="feedback-emoji"></div>
                        <div class="text-xl font-bold mb-3" id="feedback-title"></div>
                        <div class="text-lg font-semibold mb-2" id="feedback-word"></div>
                        <div class="text-gray-300 leading-relaxed" id="feedback-explanation"></div>
                        <button onclick="nextWord()" 
                                class="mt-6 bg-gradient-to-r from-ocean-600 to-ocean-500 hover:from-ocean-500 hover:to-ocean-400 text-white font-bold py-3 px-8 rounded-xl transition-all duration-300">
                            Next Word →
                        </button>
                    </div>
                </div>
            </div>

            <!-- Results Screen -->
            <div class="glass-dark rounded-3xl p-8 border border-ocean-500/20 hidden" id="results-screen">
                <div class="text-center">
                    <div class="text-6xl mb-6" id="results-emoji">🎯</div>
                    <h2 class="text-4xl font-bold text-ocean-300 mb-4" id="results-title">Time's Up!</h2>
                    <div class="text-2xl text-gray-300 mb-8" id="results-score"></div>
                    
                    <!-- Performance Breakdown -->
                    <div class="grid md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-green-500/20 border border-green-500/30 rounded-xl p-4">
                            <div class="text-3xl font-bold text-green-400" id="final-correct">0</div>
                            <div class="text-sm text-gray-300">Words Solved</div>
                        </div>
                        <div class="bg-ocean-500/20 border border-ocean-500/30 rounded-xl p-4">
                            <div class="text-3xl font-bold text-ocean-400" id="final-streak">0</div>
                            <div class="text-sm text-gray-300">Best Streak</div>
                        </div>
                        <div class="bg-yellow-500/20 border border-yellow-500/30 rounded-xl p-4">
                            <div class="text-3xl font-bold text-yellow-400" id="final-skipped">0</div>
                            <div class="text-sm text-gray-300">Words Skipped</div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-4 justify-center mb-4">
                        <button onclick="restartGame()" 
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
                        
                        <button id="save-record-btn" onclick="saveWordScrambleRecord()" 
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
        // Word Database - Modular for easy expansion
        const wordDatabase = [
            {
                word: "CONSERVATION",
                emoji: "🌱",
                hint: "Protection and preservation of nature",
                explanation: "Conservation involves protecting and preserving natural resources, including marine turtles and their habitats, for future generations."
            },
            {
                word: "HATCHLING",
                emoji: "🐣",
                hint: "Baby turtle just emerged from egg",
                explanation: "Hatchlings are newly hatched baby sea turtles that must quickly make their way from the nest to the ocean to survive."
            },
            {
                word: "NESTING",
                emoji: "🏖️",
                hint: "When female turtles lay eggs on beach",
                explanation: "Nesting is when female sea turtles come ashore to dig holes in the sand and lay their eggs, typically at night."
            },
            {
                word: "MIGRATION",
                emoji: "🗺️",
                hint: "Long journey across oceans",
                explanation: "Sea turtles undertake incredible migrations, traveling thousands of miles between feeding and nesting areas."
            },
            {
                word: "SANCTUARY",
                emoji: "🏛️",
                hint: "Protected area for wildlife",
                explanation: "Marine sanctuaries are protected areas where sea turtles and other marine life can live safely without human interference."
            },
            {
                word: "ENDANGERED",
                emoji: "⚠️",
                hint: "At risk of extinction",
                explanation: "Many sea turtle species are endangered, meaning they face a high risk of extinction due to human activities and environmental changes."
            },
            {
                word: "PLASTIC",
                emoji: "🥤",
                hint: "Major ocean pollutant harmful to turtles",
                explanation: "Plastic pollution is deadly to sea turtles who mistake plastic bags and debris for food like jellyfish."
            },
            {
                word: "SEAGRASS",
                emoji: "🌿",
                hint: "Underwater plant that green turtles eat",
                explanation: "Seagrass beds are crucial feeding areas for adult green sea turtles and important marine ecosystems."
            },
            {
                word: "HAWKSBILL",
                emoji: "🔶",
                hint: "Turtle species with beak-like mouth",
                explanation: "Hawksbill turtles have a distinctive beak-like mouth and are critically endangered due to hunting for their beautiful shells."
            },
            {
                word: "LEATHERBACK",
                emoji: "🖤",
                hint: "Largest sea turtle species",
                explanation: "Leatherback turtles are the largest sea turtles and can dive deeper than any other turtle species while hunting jellyfish."
            },
            {
                word: "BYCATCH",
                emoji: "🎣",
                hint: "Accidental capture in fishing nets",
                explanation: "Bycatch occurs when sea turtles are accidentally caught in fishing nets and lines, often leading to injury or death."
            },
            {
                word: "CORAL",
                emoji: "🪸",
                hint: "Reef ecosystem where some turtles feed",
                explanation: "Coral reefs provide important feeding habitats for hawksbill turtles who eat sponges and help maintain reef health."
            },
            {
                word: "JELLYFISH",
                emoji: "🪼",
                hint: "Favorite food of leatherback turtles",
                explanation: "Jellyfish are the primary food source for leatherback turtles, who can consume up to 200kg of jellyfish per day."
            },
            {
                word: "ARRIBADA",
                emoji: "🌊",
                hint: "Mass nesting event of olive ridley turtles",
                explanation: "Arribada is a Spanish word meaning 'arrival' - it describes the synchronized mass nesting of olive ridley turtles."
            },
            {
                word: "CARAPACE",
                emoji: "🛡️",
                hint: "Upper shell of a turtle",
                explanation: "The carapace is the upper shell of a turtle, made of bone and covered with scutes (scales) that provide protection."
            },
            {
                word: "SCUTE",
                emoji: "⬡",
                hint: "Scale-like plates on turtle shell",
                explanation: "Scutes are the individual scale-like plates that cover a turtle's shell, each with unique patterns used for identification."
            },
            {
                word: "FLIPPER",
                emoji: "🏊",
                hint: "Turtle's swimming appendage",
                explanation: "Sea turtle flippers are perfectly adapted for swimming, with front flippers providing propulsion and rear ones for steering."
            },
            {
                word: "INCUBATION",
                emoji: "🌡️",
                hint: "Period when eggs develop in sand",
                explanation: "Incubation is the period when turtle eggs develop in the warm sand, typically lasting 6-8 weeks depending on temperature."
            },
            {
                word: "PREDATOR",
                emoji: "🦈",
                hint: "Animal that hunts turtles",
                explanation: "Sea turtles face many predators including sharks, birds, crabs, and fish, especially when they are young and vulnerable."
            },
            {
                word: "ECOSYSTEM",
                emoji: "🌍",
                hint: "Community of living things in environment",
                explanation: "Sea turtles play crucial roles in marine ecosystems, helping maintain healthy seagrass beds and coral reefs."
            }
        ];

        // Game State
        let currentWordIndex = 0;
        let score = 0;
        let streak = 0;
        let bestStreak = 0;
        let correctWords = 0;
        let skippedWords = 0;
        let timeLeft = 60;
        let gameTimer = null;
        let shuffledWords = [];
        let currentAnswer = '';
        let gameActive = false;
        let startTime = Date.now();
        let totalTimeSpent = 0;
        let gameActivity = null;

        // Initialize Game
        function initializeGame() {
            console.log('=== INITIALIZE GAME START ===');
            
            // Check if wordDatabase exists
            console.log('wordDatabase exists:', !!wordDatabase);
            console.log('wordDatabase length:', wordDatabase ? wordDatabase.length : 'undefined');
            
            // Reset game state
            currentWordIndex = 0;
            score = 0;
            streak = 0;
            bestStreak = 0;
            correctWords = 0;
            skippedWords = 0;
            timeLeft = 60;
            gameActive = true;
            startTime = Date.now();
            
            console.log('Game state reset. Time left:', timeLeft);
            
            // Initialize GameActivity helper
            try {
                gameActivity = new GameActivity();
                console.log('GameActivity initialized successfully');
            } catch (error) {
                console.error('Error initializing GameActivity:', error);
            }
            
            // Shuffle words
            try {
                shuffledWords = [...wordDatabase].sort(() => Math.random() - 0.5);
                console.log('Words shuffled. shuffledWords length:', shuffledWords.length);
            } catch (error) {
                console.error('Error shuffling words:', error);
                return;
            }
            
            // Update displays
            try {
                const scoreElement = document.getElementById('score');
                const streakElement = document.getElementById('streak');
                const timerElement = document.getElementById('timer');
                
                console.log('DOM elements found:', {
                    score: !!scoreElement,
                    streak: !!streakElement,
                    timer: !!timerElement
                });
                
                if (scoreElement) scoreElement.textContent = score;
                if (streakElement) streakElement.textContent = streak;
                if (timerElement) timerElement.textContent = timeLeft;
                
                console.log('Displays updated');
            } catch (error) {
                console.error('Error updating displays:', error);
            }
            
            // Show/hide sections
            try {
                const gameArea = document.getElementById('game-area');
                const resultsScreen = document.getElementById('results-screen');
                
                console.log('Section elements found:', {
                    gameArea: !!gameArea,
                    resultsScreen: !!resultsScreen
                });
                
                if (gameArea) gameArea.classList.remove('hidden');
                if (resultsScreen) resultsScreen.classList.add('hidden');
                
                console.log('Sections toggled');
            } catch (error) {
                console.error('Error toggling sections:', error);
            }
            
            console.log('About to start timer...');
            try {
                startTimer();
                console.log('Timer started successfully');
            } catch (error) {
                console.error('Error starting timer:', error);
            }
            
            console.log('About to display first word...');
            try {
                displayWord();
                console.log('First word displayed successfully');
            } catch (error) {
                console.error('Error displaying first word:', error);
            }
            
            console.log('=== INITIALIZE GAME END ===');
        }

        // Start Timer
        function startTimer() {
            console.log('Starting timer...');
            gameTimer = setInterval(() => {
                timeLeft--;
                console.log('Time left:', timeLeft);
                updateTimerDisplay();
                
                if (timeLeft <= 0) {
                    console.log('Time\'s up! Ending game.');
                    endGame();
                }
            }, 1000);
        }

        // Update Timer Display
        function updateTimerDisplay() {
            const timerElement = document.getElementById('timer');
            const timerBar = document.getElementById('timer-bar');
            
            console.log('Updating timer display:', timeLeft);
            
            if (timerElement) {
                timerElement.textContent = timeLeft;
            } else {
                console.error('Timer element not found!');
            }
            
            // Update timer bar
            const percentage = (timeLeft / 60) * 100;
            if (timerBar) {
                timerBar.style.width = percentage + '%';
            } else {
                console.error('Timer bar element not found!');
            }
            
            // Change colors based on time left
            if (timeLeft <= 5) {
                timerElement.className = 'text-3xl font-bold timer-warning';
                timerBar.className = 'bg-gradient-to-r from-red-500 to-red-400 h-2 rounded-full transition-all duration-1000';
            } else if (timeLeft <= 15) {
                timerBar.className = 'bg-gradient-to-r from-yellow-500 to-orange-500 h-2 rounded-full transition-all duration-1000';
            }
        }

        // Display Current Word
        function displayWord() {
            console.log('displayWord() called. currentWordIndex:', currentWordIndex, 'shuffledWords.length:', shuffledWords.length);
            
            if (currentWordIndex >= shuffledWords.length) {
                currentWordIndex = 0; // Loop back to start
            }
            
            const word = shuffledWords[currentWordIndex];
            console.log('Current word object:', word);
            
            if (!word) {
                console.error('No word found at index:', currentWordIndex);
                return;
            }
            
            currentAnswer = '';
            
            // Update display
            const wordEmoji = document.getElementById('word-emoji');
            const scrambledWord = document.getElementById('scrambled-word');
            const wordHint = document.getElementById('word-hint');
            const currentWordElement = document.getElementById('current-word');
            
            console.log('DOM elements found:', {
                wordEmoji: !!wordEmoji,
                scrambledWord: !!scrambledWord,
                wordHint: !!wordHint,
                currentWordElement: !!currentWordElement
            });
            
            if (wordEmoji) wordEmoji.textContent = word.emoji;
            if (scrambledWord) scrambledWord.textContent = scrambleWord(word.word);
            if (wordHint) wordHint.textContent = word.hint;
            if (currentWordElement) currentWordElement.textContent = currentWordIndex + 1;
            
            // Clear and focus input field
            const inputField = document.getElementById('user-answer-input');
            if (inputField) {
                inputField.value = '';
                inputField.focus();
            }
            
            // Hide feedback
            const feedbackSection = document.getElementById('feedback-section');
            if (feedbackSection) {
                feedbackSection.classList.add('hidden');
            }
            
            console.log('Word displayed successfully:', word.word);
        }

        // Scramble Word
        function scrambleWord(word) {
            return word.split('').sort(() => Math.random() - 0.5).join('');
        }


        // Clear Answer
        function clearAnswer() {
            if (!gameActive) return;
            
            currentAnswer = '';
            const inputField = document.getElementById('user-answer-input');
            inputField.value = '';
            inputField.focus();
        }

        // Submit Answer
        function submitAnswer() {
            if (!gameActive) return;
            
            const inputField = document.getElementById('user-answer-input');
            currentAnswer = inputField.value.trim().toUpperCase();
            
            if (!currentAnswer) return;
            
            const word = shuffledWords[currentWordIndex];
            const isCorrect = currentAnswer === word.word.toUpperCase();
            
            if (isCorrect) {
                // Correct answer
                score += 10; // Fixed 10 points per correct answer
                streak++;
                correctWords++;
                bestStreak = Math.max(bestStreak, streak);
                
                // Update display
                document.getElementById('score').textContent = score;
                document.getElementById('streak').textContent = streak;
                
                showFeedback(true, word);
            } else {
                // Wrong answer
                streak = 0;
                document.getElementById('streak').textContent = streak;
                showFeedback(false, word);
            }
        }

        // Skip Word
        function skipWord() {
            if (!gameActive) return;
            
            streak = 0;
            skippedWords++;
            document.getElementById('streak').textContent = streak;
            
            const word = shuffledWords[currentWordIndex];
            showFeedback(false, word, true);
        }

        // Show Feedback
        function showFeedback(isCorrect, word, isSkipped = false) {
            const feedbackSection = document.getElementById('feedback-section');
            const feedbackEmoji = document.getElementById('feedback-emoji');
            const feedbackTitle = document.getElementById('feedback-title');
            const feedbackWord = document.getElementById('feedback-word');
            const feedbackExplanation = document.getElementById('feedback-explanation');
            
            // Play sound effect based on answer
            if (isCorrect) {
                playCorrectSound();
                feedbackSection.className = 'mt-8 p-6 rounded-2xl border border-green-500/30 bg-green-500/10 correct-word';
                feedbackEmoji.textContent = '🎉';
                feedbackTitle.textContent = 'Correct!';
                feedbackTitle.className = 'text-xl font-bold mb-3 text-green-400';
            } else {
                if (!isSkipped) {
                    playWrongSound();
                }
                feedbackSection.className = 'mt-8 p-6 rounded-2xl border border-red-500/30 bg-red-500/10 wrong-word';
                feedbackEmoji.textContent = isSkipped ? '⏭️' : '💡';
                feedbackTitle.textContent = isSkipped ? 'Skipped' : 'Not quite right';
                feedbackTitle.className = 'text-xl font-bold mb-3 text-red-400';
            }
            
            feedbackWord.textContent = `The word was: ${word.word}`;
            feedbackExplanation.textContent = word.explanation;
            feedbackSection.classList.remove('hidden');
        }

        // Next Word
        function nextWord() {
            if (!gameActive) return;
            
            currentWordIndex++;
            displayWord();
        }

        // End Game
        function endGame() {
            gameActive = false;
            clearInterval(gameTimer);
            
            // Play completion bell sound
            playCompletionBell();
            
            // Calculate total time spent
            totalTimeSpent = Math.floor((Date.now() - startTime) / 1000);
            
            document.getElementById('game-area').classList.add('hidden');
            document.getElementById('results-screen').classList.remove('hidden');
            
            // Update results
            document.getElementById('results-score').textContent = `Final Score: ${score} points!`;
            document.getElementById('final-correct').textContent = correctWords;
            document.getElementById('final-streak').textContent = bestStreak;
            document.getElementById('final-skipped').textContent = skippedWords;
            
            // Set results emoji and title based on performance
            const resultsEmoji = document.getElementById('results-emoji');
            const resultsTitle = document.getElementById('results-title');
            
            if (correctWords >= 8) {
                resultsEmoji.textContent = '🏆';
                resultsTitle.textContent = 'Word Master!';
            } else if (correctWords >= 5) {
                resultsEmoji.textContent = '🌟';
                resultsTitle.textContent = 'Excellent!';
            } else if (correctWords >= 2) {
                resultsEmoji.textContent = '👍';
                resultsTitle.textContent = 'Good Job!';
            } else {
                resultsEmoji.textContent = '📚';
                resultsTitle.textContent = 'Keep Practicing!';
            }
            
            // Note: Game activity recording is now manual via the "Save Record" button
        }

        // Restart Game
        function restartGame() {
            clearInterval(gameTimer);
            initializeGame();
        }

        // Save word scramble record
        async function saveWordScrambleRecord() {
            if (!gameActivity) return;

            try {
                // Calculate total words attempted (correct + skipped)
                const totalWords = correctWords + skippedWords;
                
                // Determine difficulty level based on performance
                const accuracy = totalWords > 0 ? (correctWords / totalWords) * 100 : 0;
                let difficulty = 'medium';
                if (accuracy >= 80) {
                    difficulty = 'hard';
                } else if (accuracy < 50) {
                    difficulty = 'easy';
                }

                // Record the game activity
                const result = await gameActivity.recordWordScrambleCompletion(
                    score,              // Final score
                    totalWords,         // Total words attempted
                    correctWords,       // Correct words
                    totalTimeSpent,     // Time spent in seconds
                    difficulty          // Difficulty level
                );

                // Show success notification
                document.getElementById('save-status').classList.remove('hidden');
                setTimeout(() => {
                    document.getElementById('save-status').classList.add('hidden');
                }, 3000);

                console.log('Word scramble record saved successfully:', result);

            } catch (error) {
                console.error('Error saving word scramble record:', error);
                document.getElementById('save-error').classList.remove('hidden');
                setTimeout(() => {
                    document.getElementById('save-error').classList.add('hidden');
                }, 3000);
            }
        }

        // Setup input field event listeners
        function setupInputListeners() {
            const inputField = document.getElementById('user-answer-input');
            
            // Handle Enter key press
            inputField.addEventListener('keydown', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    submitAnswer();
                }
            });
            
            // Convert input to uppercase as user types
            inputField.addEventListener('input', function(event) {
                this.value = this.value.toUpperCase();
            });
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

        // Start the game when page loads
        window.onload = function() {
            initializeGame();
            setupInputListeners();
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

    <!-- Game Activity Helper -->
    <script src="<?php echo e(asset('js/game-activity.js')); ?>"></script>
</body>
</html><?php /**PATH C:\Users\Rayver\Desktop\pawikan-patrol\my_app\resources\views/games/word-scramble.blade.php ENDPATH**/ ?>
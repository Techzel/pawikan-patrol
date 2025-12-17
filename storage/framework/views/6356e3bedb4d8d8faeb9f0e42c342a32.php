<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Pawikan Puzzle - Educational Games</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(asset('img/lg.png')); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(asset('img/lg.png')); ?>">
    <link rel="apple-touch-icon" href="<?php echo e(asset('img/lg.png')); ?>">
    <link rel="shortcut icon" href="<?php echo e(asset('img/lg.png')); ?>">
    
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@hotwired/turbo@7.3.0/dist/turbo.es2017-umd.js"></script>
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
        .turbo-progress-bar { visibility: hidden !important; display: none !important; }
        /* Global font family */
        * {
            font-family: 'Cinzel', sans-serif;
        }

        /* Apply Poppins to main content only */
        main, main * {
            font-family: 'Poppins', sans-serif;
        }

        /* ONLY Page Title uses Cinzel */
        main h1 {
            font-family: 'Cinzel', serif !important;
        }
        
        .cinzel-heading { font-weight: 700; letter-spacing: 0.05em; }
        .cinzel-subheading { font-weight: 600; letter-spacing: 0.03em; }
        .cinzel-body { font-weight: 400; letter-spacing: 0.01em; line-height: 1.6; }
        .font-poppins { font-family: 'Poppins', sans-serif; }
        
        .glass { backdrop-filter: blur(10px); background: rgba(255, 255, 255, 0.1); }
        
        .puzzle-tile {
            transition: left 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), top 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), transform 0.2s, filter 0.2s;
            cursor: pointer;
            background-size: 100% 100%;
            border-radius: 4px;
            box-shadow: inset 0 0 2px rgba(255,255,255,0.2), 0 4px 6px rgba(0,0,0,0.3);
            z-index: 10;
        }
        
        .puzzle-tile:hover {
            filter: brightness(1.15) contrast(1.1);
            transform: scale(1.02);
            z-index: 20;
            box-shadow: 0 0 15px rgba(34, 211, 238, 0.6);
            border-color: rgba(34, 211, 238, 0.8);
        }
        
        .shuffling .puzzle-tile {
            transition: none !important;
        }

        .empty-tile {
            background: rgba(15, 23, 42, 0.5);
            border: 2px dashed rgba(34, 211, 238, 0.3);
        }
    </style>
</head>
<body class="bg-black min-h-screen text-white overflow-x-hidden selection:bg-ocean-500 selection:text-white relative">
    
    <!-- Background Image -->
    <div class="fixed inset-0 z-0">
        <img src="<?php echo e(asset('img/under-sea.gif')); ?>" alt="Background" class="w-full h-full object-cover opacity-90">
        <div class="absolute inset-0 bg-black/70"></div>
    </div>
    
    <!-- Game Activity Script -->
    <script src="<?php echo e(asset('js/game-activity.js')); ?>"></script>
    
    <?php echo $__env->make('navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Back Button -->
    <div class="fixed top-24 left-4 z-50">
        <a href="<?php echo e(route('games.index')); ?>" data-turbo="false" class="bg-deep-800/80 p-2 rounded-full border border-ocean-500/30 text-ocean-300 hover:bg-ocean-900/80 transition-all shadow-md backdrop-blur-sm flex items-center justify-center group" title="Back to Games">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
    </div>

    <?php if(!Auth::check() || (Auth::check() && (Auth::user()->role === 'admin' || Auth::user()->role === 'patroller'))): ?>
    <!-- Warning Audio -->
    <!-- Warning Audio - Autoplay enabled -->
    <audio id="warning-audio" autoplay>
        <source src="<?php echo e(asset('audio/warning.mp3')); ?>" type="audio/mpeg">
    </audio>
    
    <div id="guest-modal" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/0 backdrop-blur-0 transition-all duration-700 ease-out">
        <div class="bg-deep-900 border border-red-500/30 p-8 rounded-2xl max-w-md w-full text-center shadow-2xl relative transform scale-75 opacity-0 transition-all duration-700 ease-out" id="guest-modal-content">
            <button onclick="window.location.href = '<?php echo e(route('games.index')); ?>'" class="absolute top-4 right-4 text-gray-400 hover:text-white transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <div class="text-5xl mb-4">⚠️</div>
            <h2 class="text-2xl font-bold text-white mb-2 cinzel-heading">
                <?php if(auth()->guard()->check()): ?> Warning <?php else: ?> Guest Mode <?php endif; ?>
            </h2>
            <p class="text-gray-300 mb-8 font-poppins">
                <?php if(auth()->guard()->check()): ?>
                    Game recording is disabled for <?php echo e(ucfirst(Auth::user()->role)); ?> accounts.
                <?php else: ?>
                    If you do not login, the game will not be recorded.
                <?php endif; ?>
            </p>
            <div class="flex flex-col gap-3">
                <?php if(auth()->guard()->guest()): ?>
                <a href="#" onclick="event.preventDefault(); openAuthModal('login')" class="bg-ocean-600 hover:bg-ocean-500 text-white font-bold py-3 px-6 rounded-xl transition-colors font-poppins w-full">
                    Login Now
                </a>
                <?php endif; ?>
                <button onclick="closeGuestModal()" class="bg-transparent border border-gray-600 text-gray-400 hover:text-white hover:border-white font-bold py-3 px-6 rounded-xl transition-colors font-poppins w-full">
                    <?php if(auth()->guard()->check()): ?> Play without saving <?php else: ?> Play as Guest <?php endif; ?>
                </button>
            </div>
        </div>
    </div>
    
    <script>
        // Animate modal and play warning music when page loads
        document.addEventListener('turbo:load', function() {
            const warningAudio = document.getElementById('warning-audio');
            const guestModal = document.getElementById('guest-modal');
            const guestModalContent = document.getElementById('guest-modal-content');
            
            if (guestModal && guestModalContent) {
                // Trigger animations after a brief delay
                setTimeout(() => {
                    // Fade in background
                    guestModal.classList.remove('bg-black/0', 'backdrop-blur-0');
                    guestModal.classList.add('bg-black/90', 'backdrop-blur-md');
                    
                    // Scale up and fade in content
                    guestModalContent.classList.remove('scale-75', 'opacity-0');
                    guestModalContent.classList.add('scale-100', 'opacity-100');
                    
                    // Play warning music after modal starts appearing (300ms delay)
                    /* Warning audio handled by HTML autoplay
                    // Play warning music after modal starts appearing (300ms delay)
                    if (warningAudio) {
                        setTimeout(() => {
                            const playPromise = warningAudio.play();
                            
                            if (playPromise !== undefined) {
                                playPromise.catch(error => {
                                    console.log('Warning audio autoplay prevented:', error);
                                });
                            }
                        }, 300);
                    }
                    */
                }, 100);
            }
        });
        
        function closeGuestModal() {
            const warningAudio = document.getElementById('warning-audio');
            const guestModal = document.getElementById('guest-modal');
            const guestModalContent = document.getElementById('guest-modal-content');
            
            // Stop the warning music
            if (warningAudio) {
                warningAudio.pause();
                warningAudio.currentTime = 0;
            }
            
            // Animate out
            if (guestModalContent) {
                guestModalContent.classList.remove('scale-100', 'opacity-100');
                guestModalContent.classList.add('scale-75', 'opacity-0');
            }
            
            // Start game music immediately and audibly
            if (window.currentGameAudio) {
                window.currentGameAudio.volume = 0.5;
                window.currentGameAudio.play().catch(e => console.log('Audio start failed:', e));
                const icon = document.getElementById('music-icon');
                if (icon) icon.textContent = '🔊';
            }
            

            


            if (guestModal) {
                guestModal.classList.remove('bg-black/90', 'backdrop-blur-md');
                guestModal.classList.add('bg-black/0', 'backdrop-blur-0');
                
                // Remove modal after animation completes
                setTimeout(() => {
                    guestModal.remove();
                }, 700);
            }
        }
    </script>
    <?php endif; ?>

    <main class="pt-24 pb-12 relative z-10 min-h-screen flex flex-col">
        <!-- Music Control with Volume -->
        <div class="fixed top-24 right-4 z-50 group">
            <div class="flex items-center gap-2 bg-deep-800/80 rounded-full border border-ocean-500/30 backdrop-blur-sm shadow-lg p-2 transition-all duration-300">
                <button id="music-toggle" class="p-2 text-ocean-300 hover:text-ocean-400 transition-colors">
                    <span id="music-icon">🔇</span>
                </button>
                
                <!-- Volume Slider (appears on hover) -->
                <div class="overflow-hidden transition-all duration-300 w-0 group-hover:w-32 opacity-0 group-hover:opacity-100">
                    <div class="flex items-center gap-2 pr-2">
                        <input type="range" id="volume-slider" min="0" max="100" value="50" 
                            class="w-full h-1 bg-ocean-900/50 rounded-lg appearance-none cursor-pointer slider">
                        <span id="volume-percent" class="text-xs text-ocean-400 font-bold w-8">50%</span>
                    </div>
                </div>
            </div>
        </div>
        
        <style>
            /* Custom slider styling */
            .slider::-webkit-slider-thumb {
                appearance: none;
                width: 12px;
                height: 12px;
                border-radius: 50%;
                background: #22d3ee;
                cursor: pointer;
                transition: all 0.2s;
            }
            
            .slider::-webkit-slider-thumb:hover {
                background: #06b6d4;
                transform: scale(1.2);
            }
            
            .slider::-moz-range-thumb {
                width: 12px;
                height: 12px;
                border-radius: 50%;
                background: #22d3ee;
                cursor: pointer;
                border: none;
                transition: all 0.2s;
            }
            
            .slider::-moz-range-thumb:hover {
                background: #06b6d4;
                transform: scale(1.2);
            }
        </style>
        
        <audio id="bg-music" loop>
            <source src="<?php echo e(asset('audio/puzzle-loop.mp3')); ?>" type="audio/mpeg">
        </audio>
        <audio id="move-sound">
            <source src="<?php echo e(asset('audio/puzzle-move.mp3')); ?>" type="audio/mpeg">
        </audio>
        
        <audio id="congratulations-sound">
            <source src="<?php echo e(asset('audio/ma complete ang task.mp3')); ?>" type="audio/mpeg">
        </audio>
        <audio id="wrong-sound">
            <source src="<?php echo e(asset('audio/wrong.mp3')); ?>" type="audio/mpeg">
        </audio>

        <div class="container mx-auto px-4">
            <!-- Header -->
            <div class="text-center mb-6">
                <h1 class="text-4xl md:text-5xl font-bold text-ocean-300 mb-2 cinzel-heading">Pawikan Puzzle</h1>
                <p class="text-gray-300 cinzel-body">Reassemble the image to reveal the majestic sea turtle!</p>
            </div>

            <!-- Fixed Left Sidebar: Stats (Hidden on mobile, visible on lg+) -->
            <div class="hidden lg:flex fixed left-8 top-0 bottom-0 z-40 w-80 items-center pt-32">
                <div class="space-y-3 w-full">
                <!-- Time Card -->
                <div class="bg-gradient-to-br from-deep-800/90 to-deep-900/90 p-5 rounded-xl border border-ocean-500/20 backdrop-blur-sm shadow-lg hover:shadow-ocean-500/10 transition-all duration-300 hover:border-ocean-500/40">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-lg bg-ocean-500/10 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-ocean-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Time</p>
                                <div class="flex items-baseline gap-2 mt-0.5">
                                    <span id="timer" class="text-3xl font-bold text-white">00:00.00</span>
                                    <span id="time-limit-indicator" class="text-sm text-ocean-400 font-medium opacity-80"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Moves Card -->
                <div class="bg-gradient-to-br from-deep-800/90 to-deep-900/90 p-5 rounded-xl border border-ocean-500/20 backdrop-blur-sm shadow-lg hover:shadow-ocean-500/10 transition-all duration-300 hover:border-ocean-500/40">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-lg bg-ocean-500/10 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-ocean-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3m0 0V11" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Moves</p>
                                <p id="moves" class="text-3xl font-bold text-white mt-0.5">0</p>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>



            <!-- Mobile Stats (Visible on mobile only) -->
            <div class="lg:hidden flex flex-wrap justify-center gap-6 text-lg cinzel-subheading mb-6">
                <div class="bg-deep-800/50 px-5 py-2 rounded-xl border border-ocean-700/50 backdrop-blur-sm">
                    <span class="text-ocean-400">Time:</span>
                    <span id="timer-mobile" class="ml-2 font-bold">00:00.00</span>
                    <span id="time-limit-indicator-mobile" class="text-xs text-ocean-400 opacity-80 ml-1"></span>
                </div>
                <div class="bg-deep-800/50 px-5 py-2 rounded-xl border border-ocean-700/50 backdrop-blur-sm">
                    <span class="text-ocean-400">Moves:</span>
                    <span id="moves-mobile" class="ml-2 font-bold">0</span>
                </div>
            </div>

            <!-- Controls -->
            <div class="w-full max-w-4xl mx-auto mb-6">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4 bg-deep-800/50 p-4 rounded-2xl border border-ocean-700/30 backdrop-blur-sm">
                    <!-- Image Selection -->
                    <div class="flex gap-2">
                        <button onclick="setPuzzleImage(0)" class="w-12 h-12 rounded-lg overflow-hidden border-2 border-transparent hover:border-ocean-400 focus:border-ocean-400 transition-all ring-offset-2 ring-offset-deep-900" title="Green Sea Turtle">
                            <img src="<?php echo e(asset('img/green-sea-turtle.png')); ?>" class="w-full h-full object-cover">
                        </button>
                        <button onclick="setPuzzleImage(1)" class="w-12 h-12 rounded-lg overflow-hidden border-2 border-transparent hover:border-ocean-400 focus:border-ocean-400 transition-all ring-offset-2 ring-offset-deep-900" title="Hawksbill Sea Turtle">
                            <img src="<?php echo e(asset('img/hawksbill-sea-turtle.png')); ?>" class="w-full h-full object-cover">
                        </button>
                        <button onclick="setPuzzleImage(2)" class="w-12 h-12 rounded-lg overflow-hidden border-2 border-transparent hover:border-ocean-400 focus:border-ocean-400 transition-all ring-offset-2 ring-offset-deep-900" title="Olive Sea Turtle">
                            <img src="<?php echo e(asset('img/olive-sea-turtle.png')); ?>" class="w-full h-full object-cover">
                        </button>
                    </div>

                    <!-- Difficulty Selection -->
                    <div class="flex gap-2 bg-deep-900/50 p-1.5 rounded-xl border border-ocean-500/20">
                        <button onclick="setDifficulty('easy')" id="btn-easy" class="px-3 py-1.5 rounded-lg transition-all text-xs font-bold bg-ocean-600 text-white relative group">
                            Easy
                        </button>
                        <button onclick="setDifficulty('medium')" id="btn-medium" class="px-3 py-1.5 rounded-lg transition-all text-xs font-bold text-gray-500 relative group cursor-not-allowed opacity-70">
                            Medium
                            <span class="lock-icon absolute -top-2 -right-2 bg-deep-900 rounded-full p-1 text-xs border border-ocean-500/30">🔒</span>
                        </button>
                        <button onclick="setDifficulty('hard')" id="btn-hard" class="px-3 py-1.5 rounded-lg transition-all text-xs font-bold text-gray-500 relative group cursor-not-allowed opacity-70">
                            Hard
                            <span class="lock-icon absolute -top-2 -right-2 bg-deep-900 rounded-full p-1 text-xs border border-ocean-500/30">🔒</span>
                        </button>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-2">
                        <button onclick="togglePreview()" class="px-4 py-2 rounded-xl border border-ocean-500 text-ocean-300 hover:bg-ocean-900/30 transition-colors text-sm font-bold">
                            👁️ Preview
                        </button>
                        <button onclick="shufflePuzzle()" class="px-4 py-2 rounded-xl bg-ocean-600 hover:bg-ocean-500 text-white transition-colors text-sm font-bold">
                            🔄 Shuffle
                        </button>
                    </div>
                </div>
            </div>

            <!-- Puzzle Board (Centered) -->
            <div class="w-full max-w-7xl mx-auto">
                <div class="flex flex-col lg:flex-row justify-center items-start gap-6">
                    <!-- Puzzle Container -->
                    <div class="relative bg-deep-800/50 p-2 md:p-4 rounded-2xl border border-ocean-700/30 shadow-2xl shadow-ocean-500/10 mx-auto lg:ml-96">
                        <div id="puzzle-board" class="relative bg-deep-900 rounded-lg overflow-hidden shadow-inner">
                            <!-- Tiles generated by JS -->
                        </div>
                        
                        <!-- Preview Overlay -->
                        <div id="preview-overlay" class="absolute inset-4 z-20 hidden rounded-lg overflow-hidden">
                            <img src="<?php echo e(asset('img/green-sea-turtle.png')); ?>" class="w-full h-full object-cover opacity-90" alt="Preview">
                            <div class="absolute bottom-0 left-0 right-0 bg-black/70 text-white text-center py-2 text-sm">Preview Mode</div>
                        </div>
                    </div>

                    <!-- Target Image (Hidden on mobile, visible on lg+) -->
                    <div class="hidden lg:block ml-2">
                        <div class="bg-gradient-to-br from-deep-800/90 to-deep-900/90 p-4 rounded-2xl border border-ocean-500/20 backdrop-blur-sm shadow-lg">
                            <h3 class="text-ocean-300 font-bold text-sm mb-3 text-center uppercase tracking-wider">Target Image</h3>
                            <div class="rounded-lg overflow-hidden border-2 border-ocean-500/30">
                                <img id="reference-image" src="<?php echo e(asset('img/green-sea-turtle.png')); ?>" class="w-full h-auto" alt="Reference" style="max-width: 280px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Modal -->
            <div id="game-over-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm hidden">
                <div class="bg-deep-900 border border-ocean-500/30 p-8 rounded-2xl max-w-md w-full text-center shadow-2xl transform scale-100 transition-all relative">
                    <button onclick="document.getElementById('game-over-modal').classList.add('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    <div class="text-6xl mb-4">🧩</div>
                    <h2 class="text-3xl font-bold text-ocean-300 mb-2 font-poppins">Puzzle Solved!</h2>
                    <p class="text-gray-300 mb-6 font-poppins">You've restored the image!</p>
                    
                    <div class="grid grid-cols-3 gap-2 mb-8 text-left bg-black/30 p-4 rounded-xl font-poppins">
                        <div>
                            <p class="text-sm text-gray-400">Difficulty</p>
                            <p id="final-difficulty" class="text-xl font-bold text-white uppercase">Easy</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Time Taken</p>
                            <p id="final-time" class="text-xl font-bold text-white">00:00</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Moves</p>
                            <p id="final-moves" class="text-xl font-bold text-white">0</p>
                        </div>
                    </div>
                    
                    <?php if(auth()->guard()->check()): ?>
                        <?php if(Auth::user()->role === 'player' || Auth::user()->role === 'user'): ?>
                        <div id="save-status" class="mb-6">
                            <p class="text-yellow-400 text-sm font-poppins flex items-center justify-center gap-2">
                                <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Saving game...
                            </p>
                        </div>
                        <?php else: ?>
                        <p class="text-gray-400 mb-6 font-poppins">&nbsp;</p>
                        <?php endif; ?>
                    <?php else: ?>
                        <p class="text-gray-400 mb-6 font-poppins">&nbsp;</p>
                    <?php endif; ?>
                    
                    <div class="flex gap-4 justify-center">
                        <button id="next-level-btn" onclick="goToNextLevel()" class="bg-gradient-to-r from-ocean-600 to-ocean-500 hover:from-ocean-500 hover:to-ocean-400 text-white font-bold py-3 px-6 rounded-xl transition-all transform hover:scale-105 shadow-lg shadow-ocean-500/30 font-poppins hidden">
                            Next Level →
                        </button>
                        <button onclick="shufflePuzzle(); document.getElementById('game-over-modal').classList.add('hidden');" class="bg-ocean-600 hover:bg-ocean-500 text-white font-bold py-3 px-6 rounded-xl transition-colors font-poppins">
                            Play Again
                        </button>
                        <a href="/games" data-turbo="false" class="bg-transparent border border-ocean-600 text-ocean-300 hover:bg-ocean-900/30 font-bold py-3 px-6 rounded-xl transition-colors font-poppins">
                            Exit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
    {
        // Game State
        const isLoggedIn = <?php if(auth()->guard()->check()): ?> true <?php else: ?> false <?php endif; ?>;
        const userStoragePrefix = <?php if(auth()->guard()->check()): ?> '<?php echo e(Auth::id()); ?>_' <?php else: ?> '' <?php endif; ?>;
        let size = 3; // Default 3x3
        let currentDifficulty = 'easy';
        
        // Time limits in seconds
        const timeLimits = {
            'easy': 180,  // 3 minutes
            'medium': 360, // 6 minutes
            'hard': 540   // 9 minutes
        };
        
        // Independent progress for each image: {0: 1, 1: 1, 2: 1}
        // Independent progress for each image: {0: 1, 1: 1, 2: 1}
        let progressData;
        if (isLoggedIn) {
             progressData = JSON.parse(localStorage.getItem(`${userStoragePrefix}pawikanPuzzleProgress_v2`)) || {0: 1, 1: 1, 2: 1};
        } else {
             progressData = {0: 1, 1: 1, 2: 1};
        }
        let maxUnlockedLevel = 1; // Will be set based on currentImageIndex
        let tiles = [];
        let emptyIndex;
        let moves = 0;
        let timerInterval;
        let seconds = 0;
        let gameStarted = false;
        let isSolving = false;
        
        const board = document.getElementById('puzzle-board');
        const movesDisplay = document.getElementById('moves');
        const timerDisplay = document.getElementById('timer');
        const movesDisplayMobile = document.getElementById('moves-mobile');
        const timerDisplayMobile = document.getElementById('timer-mobile');
        
        // Puzzle Images
        const puzzleImages = [
            "<?php echo e(asset('img/green-sea-turtle.png')); ?>",
            "<?php echo e(asset('img/hawksbill-sea-turtle.png')); ?>",
            "<?php echo e(asset('img/olive-sea-turtle.png')); ?>"
        ];
        let currentImageIndex = 0;
        
        let boardSize = Math.min(window.innerWidth - 40, 500); // Responsive board size

        // Initialize
        function initGame() {
            // Set board dimensions
            board.style.width = `${boardSize}px`;
            board.style.height = `${boardSize}px`;
            
            // Set initial unlocked level for the default image
            maxUnlockedLevel = progressData[currentImageIndex] || 1;
            
            updateLevelButtons();
            createTiles();
            shufflePuzzle();
        }

        window.addEventListener('resize', () => {
             // Debounce
             clearTimeout(window.resizeTimer);
             window.resizeTimer = setTimeout(() => {
                 boardSize = Math.min(window.innerWidth - 40, 500);
                 board.style.width = `${boardSize}px`;
                 board.style.height = `${boardSize}px`;
                 
                 const tileSize = boardSize / size;
                 
                 tiles.forEach(t => {
                     t.element.style.width = `${tileSize}px`;
                     t.element.style.height = `${tileSize}px`;
                     
                     // Update position based on current index
                     const row = Math.floor(t.currentIndex / size);
                     const col = t.currentIndex % size;
                     
                     t.element.style.left = `${col * tileSize}px`;
                     t.element.style.top = `${row * tileSize}px`;
                     
                     // Update background size and position based on SOLVED index
                     if (!t.element.classList.contains('empty-tile')) {
                         t.element.style.backgroundSize = `${boardSize}px ${boardSize}px`;
                         const solvedRow = Math.floor(t.solvedIndex / size);
                         const solvedCol = t.solvedIndex % size;
                         t.element.style.backgroundPosition = `-${solvedCol * tileSize}px -${solvedRow * tileSize}px`;
                     }
                 });
             }, 100);
        });

        function updateLevelButtons() {
            const levels = ['easy', 'medium', 'hard'];
            
            levels.forEach((level, index) => {
                const btn = document.getElementById(`btn-${level}`);
                const levelNum = index + 1;
                const isUnlocked = levelNum <= maxUnlockedLevel;
                const isCurrent = level === currentDifficulty;
                
                // Reset classes
                btn.className = 'px-4 py-2 rounded-lg transition-all text-sm font-bold relative group';
                
                if (isCurrent) {
                    btn.classList.add('bg-ocean-600', 'text-white');
                } else if (isUnlocked) {
                    btn.classList.add('text-ocean-300', 'hover:bg-ocean-600/30', 'cursor-pointer');
                } else {
                    btn.classList.add('text-gray-500', 'cursor-not-allowed', 'opacity-70');
                }
                
                // Handle Lock Icon
                const lockIcon = btn.querySelector('.lock-icon');
                if (lockIcon) {
                    lockIcon.style.display = isUnlocked ? 'none' : 'block';
                }
            });
        }

        function setDifficulty(level) {
            const levels = {'easy': 1, 'medium': 2, 'hard': 3};
            const requestedLevel = levels[level];
            
            if (requestedLevel > maxUnlockedLevel) {
                // Play locked sound or shake effect could go here
                return;
            }
            
            currentDifficulty = level;
            updateLevelButtons();

            // Set size
            if (level === 'easy') size = 3;
            if (level === 'medium') size = 4;
            if (level === 'hard') size = 5;

            createTiles();
            shufflePuzzle();
        }

        function setPuzzleImage(index) {
            if (index < 0 || index >= puzzleImages.length) return;
            currentImageIndex = index;
            
            // Update unlocked level based on selected image
            maxUnlockedLevel = progressData[currentImageIndex] || 1;
            
            // Update preview images
            const imgUrl = puzzleImages[currentImageIndex];
            const previewImg = document.querySelector('#preview-overlay img');
            const referenceImg = document.getElementById('reference-image');
            
            if (previewImg) previewImg.src = imgUrl;
            if (referenceImg) referenceImg.src = imgUrl;
            
            // Reset to Easy difficulty when switching images (optional UX choice, safer)
            currentDifficulty = 'easy';
            size = 3;
            
            updateLevelButtons();
            createTiles();
            shufflePuzzle();
        }

        function createTiles() {
            board.innerHTML = '';
            tiles = [];
            const tileSize = boardSize / size;
            
            for (let i = 0; i < size * size; i++) {
                const tile = document.createElement('div');
                tile.className = 'absolute border border-ocean-900/50 box-border flex items-center justify-center text-2xl font-bold text-transparent';
                tile.style.width = `${tileSize}px`;
                tile.style.height = `${tileSize}px`;
                
                // Position in grid
                const row = Math.floor(i / size);
                const col = i % size;
                
                tile.style.left = `${col * tileSize}px`;
                tile.style.top = `${row * tileSize}px`;
                
                // Background image position
                if (i < size * size - 1) {
                    tile.classList.add('puzzle-tile');
                    tile.style.backgroundImage = `url(${puzzleImages[currentImageIndex]})`;
                    tile.style.backgroundSize = `${boardSize}px ${boardSize}px`;
                    tile.style.backgroundPosition = `-${col * tileSize}px -${row * tileSize}px`;
                    tile.dataset.index = i;
                    tile.onclick = () => moveTile(i);
                } else {
                    tile.classList.add('empty-tile');
                    tile.id = 'empty-tile';
                    emptyIndex = i;
                }
                
                tiles.push({
                    element: tile,
                    currentIndex: i, // Current position in grid
                    solvedIndex: i   // Correct position
                });
                
                board.appendChild(tile);
            }
        }

        function moveTile(originalIndex) {
            const tileObj = tiles.find(t => t.solvedIndex === originalIndex);
            const currentIdx = tileObj.currentIndex;
            
            if (isAdjacent(currentIdx, emptyIndex)) {
                
                // Play move sound
                const moveSound = document.getElementById('move-sound');
                if (moveSound) {
                    moveSound.volume = 0.4;
                    moveSound.currentTime = 0;
                    moveSound.play().catch(e => {});
                }

                // Auto-start game on first move if not started
                if (!gameStarted) {
                    startGame();
                }
                
                // Swap logic
                const emptyTileObj = tiles.find(t => t.currentIndex === emptyIndex);
                
                // Swap current indices
                const tempIndex = currentIdx;
                tileObj.currentIndex = emptyIndex;
                emptyTileObj.currentIndex = tempIndex;
                
                // Update emptyIndex global
                emptyIndex = tempIndex;
                
                // Update visuals
                updateTilePosition(tileObj);
                updateTilePosition(emptyTileObj);
                
                // Game logic
                if (gameStarted) {
                    moves++;
                    movesDisplay.textContent = moves;
                    if (movesDisplayMobile) movesDisplayMobile.textContent = moves;
                    checkWin();
                }
            }
        }

        function updateTilePosition(tileObj) {
            const tileSize = boardSize / size;
            const row = Math.floor(tileObj.currentIndex / size);
            const col = tileObj.currentIndex % size;
            
            tileObj.element.style.left = `${col * tileSize}px`;
            tileObj.element.style.top = `${row * tileSize}px`;
        }

        function isAdjacent(idx1, idx2) {
            const row1 = Math.floor(idx1 / size);
            const col1 = idx1 % size;
            const row2 = Math.floor(idx2 / size);
            const col2 = idx2 % size;
            
            return (Math.abs(row1 - row2) + Math.abs(col1 - col2)) === 1;
        }

        function shufflePuzzle() {
            const isPlaying = gameStarted;

            if (!isPlaying) {
                // Force stop timer only if not playing
                clearInterval(timerInterval);
                
                timerDisplay.classList.remove('text-red-500', 'animate-pulse');
                if (timerDisplayMobile) timerDisplayMobile.classList.remove('text-red-500', 'animate-pulse');
                
                // Reset state
                moves = 0;
                movesDisplay.textContent = '0';
                if (movesDisplayMobile) movesDisplayMobile.textContent = '0';
                
                // Display initial time (00:00.00)
                const initialTime = '00:00.00';
                timerDisplay.textContent = initialTime;
                if (timerDisplayMobile) timerDisplayMobile.textContent = initialTime;
                
                // Set time limit indicator
                const limit = timeLimits[currentDifficulty];
                const limitMins = limit / 60;
                const indicatorText = `/ ${limitMins}m`;
                const indicator = document.getElementById('time-limit-indicator');
                const indicatorMobile = document.getElementById('time-limit-indicator-mobile');
                
                if (indicator) indicator.textContent = indicatorText;
                if (indicatorMobile) indicatorMobile.textContent = indicatorText;
            }
            
            // Simulate random valid moves to shuffle (ensures solvability)
            const shuffleMoves = size * 20; // More moves for larger puzzles
            let lastIndex = -1;
            
            // Disable animations during shuffle
            board.classList.add('shuffling');
            
            // Resume music if it was paused (Play Again)
            const bgMusic = document.getElementById('bg-music');
            if (bgMusic && bgMusic.paused) {
                bgMusic.play().catch(e => console.log('Music resume failed:', e));
                if(typeof isMusicPlaying !== 'undefined') isMusicPlaying = true;
                if(typeof musicIcon !== 'undefined') musicIcon.textContent = '🔊';
            }
            
            for (let i = 0; i < shuffleMoves; i++) {
                const neighbors = getNeighbors(emptyIndex);
                // Avoid undoing the last move immediately
                const validNeighbors = neighbors.filter(n => n !== lastIndex);
                const randomNeighbor = validNeighbors[Math.floor(Math.random() * validNeighbors.length)];
                
                // Perform swap without animation/logic overhead
                const tileToMove = tiles.find(t => t.currentIndex === randomNeighbor);
                const emptyTile = tiles.find(t => t.currentIndex === emptyIndex);
                
                // Swap
                lastIndex = emptyIndex;
                const temp = tileToMove.currentIndex;
                tileToMove.currentIndex = emptyIndex;
                emptyTile.currentIndex = temp;
                emptyIndex = temp;
                
                updateTilePosition(tileToMove);
                updateTilePosition(emptyTile);
            }
            
            // Re-enable animations
            setTimeout(() => {
                board.classList.remove('shuffling');
            }, 100);
            
            if (!isPlaying) {
                // Ensure timer is stopped and game not started
                clearInterval(timerInterval);
                gameStarted = false;
            }
        }

        function startGame() {
            if (!gameStarted) {
                gameStarted = true;
                startTimer();
            }
        }

        function getNeighbors(idx) {
            const neighbors = [];
            const row = Math.floor(idx / size);
            const col = idx % size;
            
            if (row > 0) neighbors.push(idx - size); // Up
            if (row < size - 1) neighbors.push(idx + size); // Down
            if (col > 0) neighbors.push(idx - 1); // Left
            if (col < size - 1) neighbors.push(idx + 1); // Right
            
            return neighbors;
        }

        function goToNextLevel() {
            const modal = document.getElementById('game-over-modal');
            modal.classList.add('hidden');
            
            // Ensure music is playing
            if (typeof bgMusic !== 'undefined' && bgMusic && bgMusic.paused) {
                bgMusic.play().catch(e => console.log('Music resume failed:', e));
                if(typeof isMusicPlaying !== 'undefined') isMusicPlaying = true;
                if(typeof musicIcon !== 'undefined') musicIcon.textContent = '🔊';
            }
            
            if (currentDifficulty === 'easy') {
                setDifficulty('medium');
            } else if (currentDifficulty === 'medium') {
                setDifficulty('hard');
            }
        }

        function startTimer() {
            clearInterval(timerInterval);
            
            // Get time limit for current difficulty
            const limitSeconds = timeLimits[currentDifficulty];
            const limitMs = limitSeconds * 1000;
            let timeElapsed = 0;
            let warningTriggered = false;
            
            // Reset warning state
            timerDisplay.classList.remove('text-red-500', 'animate-pulse');
            if (timerDisplayMobile) timerDisplayMobile.classList.remove('text-red-500', 'animate-pulse');
            
            timerInterval = setInterval(() => {
                timeElapsed += 10;
                
                // Warning Logic (Last 5 seconds)
                const remainingMs = limitMs - timeElapsed;
                if (remainingMs <= 5000 && remainingMs > 0 && !warningTriggered) {
                    warningTriggered = true;
                    timerDisplay.classList.add('text-red-500', 'animate-pulse');
                    if (timerDisplayMobile) timerDisplayMobile.classList.add('text-red-500', 'animate-pulse');
                }
                
                if (timeElapsed >= limitMs) {
                    clearInterval(timerInterval);
                    timeElapsed = limitMs;
                    handleTimeUp();
                }

                const min = Math.floor(timeElapsed / 60000).toString().padStart(2, '0');
                const sec = Math.floor((timeElapsed % 60000) / 1000).toString().padStart(2, '0');
                const ms = Math.floor((timeElapsed % 1000) / 10).toString().padStart(2, '0');
                const timeString = `${min}:${sec}.${ms}`;
                
                timerDisplay.textContent = timeString;
                if (timerDisplayMobile) timerDisplayMobile.textContent = timeString;
                
                // Track elapsed time for saving
                seconds = Math.floor(timeElapsed / 1000);
            }, 10);
        }

        function handleTimeUp() {
            gameStarted = false;
            
            // Update modal for Time Up
            const modal = document.getElementById('game-over-modal');
            const icon = modal.querySelector('.text-6xl');
            const title = modal.querySelector('h2');
            const message = modal.querySelector('p');
            
            if (icon) icon.textContent = '⏰';
            if (title) title.textContent = "Time's Up!";
            if (message) message.textContent = "You ran out of time.";
            
            // Update stats in modal (Show full time limit)
            const limit = timeLimits[currentDifficulty];
            const mins = Math.floor(limit / 60).toString().padStart(2, '0');
            const secs = (limit % 60).toString().padStart(2, '0');
            document.getElementById('final-time').textContent = `${mins}:${secs}`;
            
            document.getElementById('final-moves').textContent = moves;
            document.getElementById('final-difficulty').textContent = currentDifficulty.charAt(0).toUpperCase() + currentDifficulty.slice(1);
            
            // Hide saving indicator
            const saveStatus = document.getElementById('save-status');
            if (saveStatus) saveStatus.style.display = 'none';
            
            // Stop background music
            const bgMusic = document.getElementById('bg-music');
            if (bgMusic) {
                bgMusic.pause();
            }
            
            // Play time's up sound
            const wrongSound = document.getElementById('wrong-sound');
            if (wrongSound) {
                wrongSound.currentTime = 0;
                wrongSound.play().catch(e => console.log('Times up sound failed:', e));
            }
            
            modal.classList.remove('hidden');
        }

        function checkWin() {
            const isSolved = tiles.every(t => t.currentIndex === t.solvedIndex);
            
            if (isSolved) {
                clearInterval(timerInterval);
                gameStarted = false;
                
                timerDisplay.classList.remove('text-red-500', 'animate-pulse');
                if (timerDisplayMobile) timerDisplayMobile.classList.remove('text-red-500', 'animate-pulse');
                
                // Unlock next level
                const levels = {'easy': 1, 'medium': 2, 'hard': 3};
                const currentLevelNum = levels[currentDifficulty];
                
                if (currentLevelNum === maxUnlockedLevel && maxUnlockedLevel < 3) {
                    maxUnlockedLevel++;
                    // Save progress specific to this image
                    progressData[currentImageIndex] = maxUnlockedLevel;
                    if (isLoggedIn) {
                        localStorage.setItem(`${userStoragePrefix}pawikanPuzzleProgress_v2`, JSON.stringify(progressData));
                    }
                    updateLevelButtons();
                }

                // Fill the empty tile
                const emptyTile = tiles.find(t => t.solvedIndex === size * size - 1);
                emptyTile.element.classList.remove('empty-tile');
                emptyTile.element.style.backgroundImage = `url(${puzzleImages[currentImageIndex]})`;
                emptyTile.element.style.backgroundSize = `${boardSize}px ${boardSize}px`;
                emptyTile.element.style.backgroundPosition = `-${(size-1) * (boardSize/size)}px -${(size-1) * (boardSize/size)}px`;
                
                
                // Record game activity for logged-in players
                // Show modal first
                // Show modal first
                setTimeout(() => {
                    // Reset modal to Success
                    const modal = document.getElementById('game-over-modal');
                    const icon = modal.querySelector('.text-6xl');
                    const title = modal.querySelector('h2');
                    const message = modal.querySelector('p');
                    
                    if (icon) icon.textContent = '🧩';
                    if (title) title.textContent = 'Puzzle Solved!';
                    if (message) message.textContent = "You've restored the image!";
                    
                    const saveStatus = document.getElementById('save-status');
                    if (saveStatus) {
                        saveStatus.style.display = 'block';
                        saveStatus.innerHTML = `
                            <p class="text-yellow-400 text-sm font-poppins flex items-center justify-center gap-2">
                                <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Saving game...
                            </p>
                        `;
                    }

                    // Format elapsed time for display
                    const mins = Math.floor(seconds / 60).toString().padStart(2, '0');
                    const secs = (seconds % 60).toString().padStart(2, '0');
                    document.getElementById('final-time').textContent = `${mins}:${secs}`;
                    
                    document.getElementById('final-moves').textContent = moves;
                    document.getElementById('final-difficulty').textContent = currentDifficulty.charAt(0).toUpperCase() + currentDifficulty.slice(1);
                    
                    // Play congratulations sound
                    const congratsSound = document.getElementById('congratulations-sound');
                    if (congratsSound) {
                        congratsSound.currentTime = 0;
                        congratsSound.play().catch(e => console.log('Congrats sound failed:', e));
                    }
                    
                    // Stop background music
                    const bgMusic = document.getElementById('bg-music');
                    if (bgMusic) {
                        bgMusic.pause();
                    }
                    
                    document.getElementById('game-over-modal').classList.remove('hidden');
                    
                    // Show Next Level button logic
                    const nextLevelBtn = document.getElementById('next-level-btn');
                    if (nextLevelBtn) {
                        if (currentDifficulty === 'easy' || currentDifficulty === 'medium') {
                            nextLevelBtn.classList.remove('hidden');
                        } else {
                            nextLevelBtn.classList.add('hidden');
                        }
                    }
                }, 500);
                
                // Record game activity
                <?php if(auth()->guard()->check()): ?>
                <?php if(Auth::user()->role === 'player' || Auth::user()->role === 'user'): ?>
                if (window.gameActivity) {
                    (async () => {
                        try {
                            const result = await window.gameActivity.recordPuzzle(moves, seconds, currentDifficulty);
                            const saveStatus = document.getElementById('save-status');
                            if (saveStatus) {
                                if (result && result.success) {
                                    saveStatus.innerHTML = `
                                        <p class="text-green-400 text-sm font-poppins flex items-center justify-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Game saved successfully!
                                        </p>
                                    `;
                                    window.dispatchEvent(new CustomEvent('gameCompleted', {
                                        detail: { gameType: 'puzzle', timeSpent: seconds, moves: moves }
                                    }));
                                } else {
                                    saveStatus.innerHTML = `
                                        <p class="text-red-400 text-sm font-poppins flex items-center justify-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Failed to save game
                                        </p>
                                    `;
                                }
                            }
                        } catch (error) {
                            console.error('Error saving game:', error);
                        }
                    })();
                }
                <?php endif; ?>
                <?php endif; ?>
            }
        }

        function togglePreview() {
            const overlay = document.getElementById('preview-overlay');
            overlay.classList.toggle('hidden');
        }

        document.addEventListener('turbo:load', () => {
            initGame();
            
            // Ensure music is paused on load (User Request: Mute first before modal)
            if (bgMusic) {
                bgMusic.pause();
                bgMusic.currentTime = 0;
                if(typeof isMusicPlaying !== 'undefined') isMusicPlaying = false;
            }
            // Auto-play music removed (moved to guest modal close)
        });
        window.addEventListener('resize', () => {
            // Simple reload to handle resize logic easily
            // In production, better resize logic would be preferred
            // location.reload(); 
        });

        // Background Music Control with Volume
        const musicToggle = document.getElementById('music-toggle');
        const musicIcon = document.getElementById('music-icon');
        const bgMusic = document.getElementById('bg-music');
        if (bgMusic) window.currentGameAudio = bgMusic;
        const volumeSlider = document.getElementById('volume-slider');
        const volumePercent = document.getElementById('volume-percent');
        let isMusicPlaying = false;

        // Set initial volume
        if (bgMusic && volumeSlider) {
            bgMusic.volume = 0.5;
            
            // Volume slider event
            volumeSlider.addEventListener('input', (e) => {
                const volume = e.target.value;
                bgMusic.volume = volume / 100;
                volumePercent.textContent = volume + '%';
                
                // Update icon based on volume
                if (isMusicPlaying) {
                    if (volume == 0) {
                        musicIcon.textContent = '🔇';
                    } else if (volume < 50) {
                        musicIcon.textContent = '🔉';
                    } else {
                        musicIcon.textContent = '🔊';
                    }
                }
            });
        }

        if (musicToggle && bgMusic) {
            musicToggle.addEventListener('click', () => {
                if (isMusicPlaying) {
                    bgMusic.pause();
                    musicIcon.textContent = '🔇';
                    isMusicPlaying = false;
                } else {
                    const playPromise = bgMusic.play();
                    
                    if (playPromise !== undefined) {
                        playPromise.then(() => {
                            // Set icon based on current volume
                            const volume = volumeSlider.value;
                            if (volume == 0) {
                                musicIcon.textContent = '🔇';
                            } else if (volume < 50) {
                                musicIcon.textContent = '🔉';
                            } else {
                                musicIcon.textContent = '🔊';
                            }
                            isMusicPlaying = true;
                        }).catch(e => {
                            console.log('Audio playback failed:', e);
                            if(e.name === 'NotSupportedError' || e.name === 'NotAllowedError') {
                                 alert('Audio playback issue: ' + e.message);
                            } else {
                                 alert('Please ensure "puzzle.mp3" is in "public/audio/" folder.');
                            }
                        });
                    }
                }
            });
        }

        // Stop music when navigating away via Turbo
        const stopMusic = () => {
            if (bgMusic) {
                bgMusic.pause();
                if(typeof isMusicPlaying !== 'undefined') isMusicPlaying = false;
            }
            document.removeEventListener('turbo:before-visit', stopMusic);
            document.removeEventListener('turbo:before-render', stopMusic);
            window.removeEventListener('beforeunload', stopMusic);
        };

        document.addEventListener('turbo:before-visit', stopMusic);
        document.addEventListener('turbo:before-render', stopMusic);
        window.addEventListener('beforeunload', stopMusic);
    }
    </script>
</body>
</html>
<?php /**PATH C:\Users\Rayver\Desktop\my_app\resources\views/games/puzzle.blade.php ENDPATH**/ ?>
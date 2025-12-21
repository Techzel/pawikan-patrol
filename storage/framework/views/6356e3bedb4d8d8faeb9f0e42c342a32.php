

<?php $__env->startSection('title', 'Pawikan Puzzle - Educational Games'); ?>

<?php $__env->startPush('styles'); ?>
<style>
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

    /* GLOBAL font family override for game */
    #puzzle-game-container {
        font-family: 'Poppins', sans-serif;
    }

    #puzzle-game-container main, #puzzle-game-container main * {
        font-family: 'Poppins', sans-serif;
    }

    #puzzle-game-container main h1 {
        font-family: 'Poppins', sans-serif !important;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div id="puzzle-game-container" class="min-h-screen text-white overflow-x-hidden selection:bg-ocean-500 selection:text-white relative">
    <!-- Background Image -->
    <div class="fixed inset-0 z-0">
        <img src="<?php echo e(asset('img/under-sea.gif')); ?>" alt="Background" class="w-full h-full object-cover opacity-90">
        <div class="absolute inset-0 bg-black/70"></div>
    </div>
    


    <!-- Back Button -->
    <div class="fixed top-24 left-4 z-50">
        <a href="<?php echo e(route('games.index')); ?>" onclick="window.showPageLoader()" class="bg-deep-800/80 p-2 rounded-full border border-ocean-500/30 text-ocean-300 hover:bg-ocean-900/80 transition-all shadow-md backdrop-blur-sm flex items-center justify-center group" title="Back to Games">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
    </div>

    <!-- Game Audio Elements -->
    <audio id="bg-music" loop>
        <source src="<?php echo e(asset('audio/puzzle-loop.mp3')); ?>" type="audio/mpeg">
    </audio>
    <audio id="move-sound">
        <source src="<?php echo e(asset('audio/puzzle-move.mp3')); ?>" type="audio/mpeg">
    </audio>
    <audio id="click-sound">
        <source src="<?php echo e(asset('audio/click sa puzzle ug matching.mp3')); ?>" type="audio/mpeg">
    </audio>
    <audio id="wrong-sound">
        <source src="<?php echo e(asset('audio/wrong.mp3')); ?>" type="audio/mpeg">
    </audio>
    <audio id="congratulations-sound">
        <source src="<?php echo e(asset('audio/ma complete ang task.mp3')); ?>" type="audio/mpeg">
    </audio>

    <?php if(auth()->guard()->guest()): ?>
    <!-- Warning Audio -->
    <audio id="warning-audio">
        <source src="<?php echo e(asset('audio/warning.mp3')); ?>" type="audio/mpeg">
    </audio>
    
    <div id="guest-modal" class="fixed inset-0 z-[100] flex items-center justify-center bg-transparent backdrop-blur-0 transition-all duration-700 ease-out hidden">
        <div class="bg-deep-900 border border-red-500/30 p-8 rounded-2xl max-w-md w-full text-center shadow-2xl relative transform scale-75 opacity-0 transition-all duration-700 ease-out" id="guest-modal-content">
            <button onclick="window.showPageLoader(); window.location.href = '<?php echo e(route('games.index')); ?>'" class="absolute top-4 right-4 text-gray-400 hover:text-white transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <div class="text-5xl mb-4">⚠️</div>
            <h2 class="text-2xl font-bold text-white mb-2">
                <?php if(auth()->guard()->check()): ?> Warning <?php else: ?> Guest Mode <?php endif; ?>
            </h2>
            <p class="text-gray-300 mb-8 font-poppins">
                If you do not login, the game will not be recorded.
            </p>
            <div class="flex flex-col gap-3">
                <?php if(auth()->guard()->guest()): ?>
                <a href="#" onclick="event.preventDefault(); openAuthModal('login')" class="bg-ocean-600 hover:bg-ocean-500 text-white font-bold py-3 px-6 rounded-xl transition-colors font-poppins w-full">
                    Login Now
                </a>
                <?php endif; ?>
                <button onclick="closeGuestModal()" class="bg-transparent border border-gray-600 text-gray-400 hover:text-white hover:border-white font-bold py-3 px-6 rounded-xl transition-colors font-poppins w-full">
                    Play as Guest
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
                guestModal.classList.remove('hidden');
                // Trigger animations after a brief delay
                setTimeout(() => {
                    // Fade in background
                    guestModal.classList.remove('bg-transparent', 'backdrop-blur-0');
                    guestModal.classList.add('bg-black/90', 'backdrop-blur-md');
                    
                    // Scale up and fade in content
                    guestModalContent.classList.remove('scale-75', 'opacity-0');
                    guestModalContent.classList.add('scale-100', 'opacity-100');
                    
                    // Play warning music after modal starts appearing (300ms delay)
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
                }, 100);
            }
        });
        
        window.closeGuestModal = function() {
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
            
            // Start game music immediately and audibly via global helper
            if (typeof window.startPuzzleMusic === 'function') {
                window.startPuzzleMusic();
            } else if (window.currentGameAudio) {
                window.currentGameAudio.volume = 0.5;
                window.currentGameAudio.play().catch(e => console.log('Fallback audio start failed:', e));
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
        };
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
                <h1 class="text-4xl md:text-5xl font-bold text-ocean-300 mb-2 font-poppins">Pawikan Puzzle</h1>
                <p class="text-gray-300 font-poppins">Reassemble the image to reveal the majestic sea turtle!</p>
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

            <!-- Mobile Stats (Moves above Game Board) -->
            <div class="lg:hidden flex flex-wrap justify-center gap-4 text-sm font-bold font-mono mb-4">
                <div class="bg-deep-800/80 px-4 py-2 rounded-lg border border-ocean-500/30 backdrop-blur-sm shadow-lg w-32 text-center">
                    <span class="text-ocean-300 block text-xs uppercase tracking-wider mb-0.5">Time</span>
                    <div class="flex items-center justify-center gap-1">
                         <span id="timer-mobile" class="text-white text-lg tabular-nums">00:00.00</span>
                         <span id="time-limit-indicator-mobile" class="text-[10px] text-ocean-400"></span>
                    </div>
                </div>
                <div class="bg-deep-800/80 px-4 py-2 rounded-lg border border-ocean-500/30 backdrop-blur-sm shadow-lg w-24 text-center">
                    <span class="text-ocean-300 block text-xs uppercase tracking-wider mb-0.5">Moves</span>
                    <span id="moves-mobile" class="text-white text-lg tabular-nums">0</span>
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
                    
                    <div class="flex gap-4 justify-center">
                        <button id="next-level-btn" onclick="goToNextLevel()" class="bg-gradient-to-r from-ocean-600 to-ocean-500 hover:from-ocean-500 hover:to-ocean-400 text-white font-bold py-3 px-6 rounded-xl transition-all transform hover:scale-105 shadow-lg shadow-ocean-500/30 font-poppins hidden">
                            Next Level →
                        </button>
                        <button onclick="shufflePuzzle(); document.getElementById('game-over-modal').classList.add('hidden');" class="bg-ocean-600 hover:bg-ocean-500 text-white font-bold py-3 px-6 rounded-xl transition-colors font-poppins">
                            Play Again
                        </button>
                        <a href="/games" onclick="window.showPageLoader()" class="bg-transparent border border-ocean-600 text-ocean-300 hover:bg-ocean-900/30 font-bold py-3 px-6 rounded-xl transition-colors font-poppins">
                            Exit
                        </a>
                    </div>
                </div>
            </div>
        </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    (function() {
        // Game State
        const isLoggedIn = <?php if(auth()->guard()->check()): ?> true <?php else: ?> false <?php endif; ?>;
        const userStoragePrefix = <?php if(auth()->guard()->check()): ?> '<?php echo e(Auth::id()); ?>_' <?php else: ?> '' <?php endif; ?>;
        
        let size = 3; 
        // ... (rest of the game code remains inside the IIFE)
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
        

        
        // Responsive board size calculation logic
        const getResponsiveBoardSize = () => {
             // For Desktop (lg+), prioritize the standard 500px size for best visibility
             // User prefers larger size on desktop even if scrolling is needed
             if (window.innerWidth >= 1024) {
                 return 500;
             }
             
             // For Mobile/Tablet, constrain by height to prevent vertical scrolling during play
             const widthConstraint = window.innerWidth - 32; // horz padding
             const heightConstraint = window.innerHeight - 420; // vertical overhead (header+controls)
             const calculated = Math.min(widthConstraint, heightConstraint, 500);
             return Math.max(calculated, 280); // Min usable size
        };

        let boardSize = getResponsiveBoardSize();

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
                 boardSize = getResponsiveBoardSize();
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

        window.setDifficulty = function(level) {
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
        };

        window.setPuzzleImage = function(index) {
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
        };

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
                playMoveSound();

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

        window.shufflePuzzle = function() {
            // Always stop the timer and reset state on shuffle/restart to avoid timer collisions
            clearInterval(timerInterval);
            gameStarted = false;
            
            timerDisplay.classList.remove('text-red-500', 'animate-pulse');
            if (timerDisplayMobile) timerDisplayMobile.classList.remove('text-red-500', 'animate-pulse');
            
            // Reset moves and HUD
            moves = 0;
            movesDisplay.textContent = '0';
            if (movesDisplayMobile) movesDisplayMobile.textContent = '0';
            
            // Display initial time (00:00.00)
            const initialTime = '00:00.00';
            timerDisplay.textContent = initialTime;
            if (timerDisplayMobile) timerDisplayMobile.textContent = initialTime;
            
            // Set time limit indicator based on the current difficulty
            const limit = timeLimits[currentDifficulty];
            const limitMins = limit / 60;
            const indicatorText = `/ ${limitMins}m`;
            const indicator = document.getElementById('time-limit-indicator');
            const indicatorMobile = document.getElementById('time-limit-indicator-mobile');
            
            if (indicator) indicator.textContent = indicatorText;
            if (indicatorMobile) indicatorMobile.textContent = indicatorText;
            
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
            
            gameStarted = false;
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

        window.goToNextLevel = function() {
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
        };

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
            if (bgMusic) {
                bgMusic.pause();
                isMusicPlaying = false;
                musicIcon.textContent = '🔇';
            }
            
            // Play time's up sound
            playWrongSound();
            
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
                    playCongratsSound();
                    
                    // Pause background music on victory
                    if (bgMusic) {
                        bgMusic.pause();
                        isMusicPlaying = false;
                        musicIcon.textContent = '🔇';
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
                }, 200);
                
                // Record game activity
                <?php if(auth()->guard()->check()): ?>
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
            }
        }

        window.togglePreview = function() {
            const overlay = document.getElementById('preview-overlay');
            overlay.classList.toggle('hidden');
        };

        // Initialize Everything Immediately
        const runInitialization = () => {
            initGame();
            
            // Auto-play music if no guest modal is present (Logged in user)
            const guestModal = document.getElementById('guest-modal');
            if (!guestModal) {
                // User is likely logged in and authorized, start music automatically
                window.startPuzzleMusic();
                
                // Fallback: If autoplay is blocked, start on first interaction
                const startOnInteraction = () => {
                    if (typeof isMusicPlaying !== 'undefined' && !isMusicPlaying) {
                        window.startPuzzleMusic();
                    }
                    document.removeEventListener('click', startOnInteraction);
                    document.removeEventListener('keydown', startOnInteraction);
                };
                document.addEventListener('click', startOnInteraction, { once: true });
                document.addEventListener('keydown', startOnInteraction, { once: true });
            } else {
                // Guest modal exists - ensure music is paused until they close it
                if (bgMusic) {
                    bgMusic.pause();
                    bgMusic.currentTime = 0;
                    if(typeof isMusicPlaying !== 'undefined') isMusicPlaying = false;
                }
            }
        };

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

        // Expose function to start music from outside
        window.startPuzzleMusic = function() {
            if (!bgMusic) return;
            
            // Force reset state
            bgMusic.muted = false;
            // Only reset time if we are essentially at the start or end to avoid skipping if paused briefly
            if (bgMusic.currentTime > bgMusic.duration - 1 || bgMusic.paused) {
                 bgMusic.currentTime = 0;
            }
            
            // robust volume calculation
            let vol = 0.5;
            if (volumeSlider && volumeSlider.value) {
                vol = parseInt(volumeSlider.value) / 100;
            }
            bgMusic.volume = isNaN(vol) ? 0.5 : vol;

            const attemptPlay = () => {
                const playPromise = bgMusic.play();
                if (playPromise !== undefined) {
                    playPromise.then(() => {
                        isMusicPlaying = true;
                        if (musicIcon) {
                            const v = volumeSlider ? parseInt(volumeSlider.value) : 50;
                            if (v === 0) musicIcon.textContent = '🔇';
                            else if (v < 50) musicIcon.textContent = '🔉';
                            else musicIcon.textContent = '🔊';
                        }
                    }).catch(e => {
                        console.error('Manual music start failed:', e);
                        isMusicPlaying = false;
                        if (musicIcon) musicIcon.textContent = '🔇';
                        
                        // Fallback: waiting for user interaction
                        const onInteract = () => {
                             bgMusic.play().then(() => {
                                 isMusicPlaying = true;
                                 if(musicIcon) musicIcon.textContent = '🔊';
                             }).catch(() => {});
                             document.removeEventListener('click', onInteract);
                        };
                        document.addEventListener('click', onInteract, { once: true });
                    });
                }
            };

            // Check if audio is ready
            if (bgMusic.readyState >= 2) {
                attemptPlay();
            } else {
                bgMusic.addEventListener('canplay', () => attemptPlay(), { once: true });
            }
        };

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
                        });
                    }
                }
            });

            // Precision Loop to hide MP3 gaps (User request: "continues looping effect")
            bgMusic.addEventListener('timeupdate', function() {
                const buffer = 0.2; 
                if (this.currentTime > this.duration - buffer && this.loop) {
                    this.currentTime = 0;
                    this.play().catch(e => {});
                }
            });
        }

        // Sound Effect Helpers
        function playClickSound() {
            const sound = document.getElementById('click-sound');
            if (sound) {
                sound.currentTime = 0;
                sound.volume = 0.6;
                sound.play().catch(e => console.log('Click sound failed:', e));
            }
        }

        function playMoveSound() {
            const sound = document.getElementById('move-sound');
            if (sound) {
                sound.currentTime = 0;
                sound.volume = 0.4;
                sound.play().catch(e => console.log('Move sound failed:', e));
            }
        }

        function playWrongSound() {
            const sound = document.getElementById('wrong-sound');
            if (sound) {
                sound.currentTime = 0;
                sound.volume = 1.0;
                sound.play().catch(e => console.log('Wrong sound failed:', e));
            }
        }

        function playCongratsSound() {
            const sound = document.getElementById('congratulations-sound');
            if (sound) {
                sound.currentTime = 0;
                sound.volume = 1.0;
                sound.play().catch(e => console.log('Congrats sound failed:', e));
            }
        }
        
        // Expose to global for HTML onclick handlers
        window.playClickSound = playClickSound;

        // Stop music when navigating away via Turbo
        const stopMusic = () => {
            // Stop background music
            if (bgMusic) {
                bgMusic.pause();
                bgMusic.currentTime = 0;
                if(typeof isMusicPlaying !== 'undefined') isMusicPlaying = false;
            }
            // Broad cleanup for any other audio elements
            document.querySelectorAll('audio').forEach(el => {
                try {
                    el.pause();
                    el.currentTime = 0;
                } catch(e) {}
            });

            document.removeEventListener('turbo:before-visit', stopMusic);
            document.removeEventListener('turbo:before-render', stopMusic);
            document.removeEventListener('turbo:before-cache', stopMusic);
            window.removeEventListener('beforeunload', stopMusic);
        };

        document.addEventListener('turbo:before-visit', stopMusic);
        document.addEventListener('turbo:before-render', stopMusic);
        document.addEventListener('turbo:before-cache', stopMusic);
        window.addEventListener('beforeunload', stopMusic);
        
        // Run immediately since script is at end of body
        runInitialization();
    })();
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rayver\Desktop\my_app\resources\views/games/puzzle.blade.php ENDPATH**/ ?>
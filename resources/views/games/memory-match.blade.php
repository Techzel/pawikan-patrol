@extends('layouts.app')

@section('title', 'Pawikan Memory Match - Educational Games')

@push('styles')
<style>
    .perspective-1000 {
        perspective: 1000px;
    }

    .transform-style-3d {
        transform-style: preserve-3d;
    }

    .backface-hidden {
        backface-visibility: hidden;
        -webkit-backface-visibility: hidden;
    }

    .rotate-y-180 {
        transform: rotateY(180deg);
    }

    /* Enhanced card flip animation */
    .card {
        transition: transform 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        filter: drop-shadow(0 10px 20px rgba(6, 182, 212, 0.3));
    }

    .card-inner {
        transition: transform 0.4s cubic-bezier(0.4, 0.0, 0.2, 1) !important;
        transform-style: preserve-3d;
    }

    .card.flipped .card-inner {
        transform: rotateY(180deg);
    }

    /* Add subtle wobble on hover when not flipped */
    .card:not(.flipped):hover .card-inner {
        animation: cardWobble 0.5s ease;
    }

    @keyframes cardWobble {
        0%, 100% { transform: rotateY(0deg); }
        25% { transform: rotateY(-5deg); }
        75% { transform: rotateY(5deg); }
    }

    /* Flip animation */
    .card.flipped .card-inner {
        transform: rotateY(180deg);
    }

    /* Glow effect when card is flipped */
    .card.flipped {
        filter: drop-shadow(0 0 15px rgba(34, 211, 238, 0.5));
    }

    .card.matched {
        opacity: 0.6;
        pointer-events: none;
        transform: scale(0.95);
        transition: all 0.5s ease;
    }

    /* Enhanced card faces */
    .card-front, .card-back {
        transition: all 0.3s ease;
    }

    .card:hover .card-front {
        border-color: rgba(6, 182, 212, 0.6);
        box-shadow: 0 0 20px rgba(6, 182, 212, 0.2);
    }

    .status-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: 10;
    }

    .status-overlay.show {
        opacity: 1;
    }

    .status-icon {
        font-size: 3rem;
        animation: iconPop 0.5s ease;
    }

    @keyframes iconPop {
        0% { transform: scale(0); }
        50% { transform: scale(1.2); }
        100% { transform: scale(1); }
    }

    @keyframes zoomOut {
        0% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }

    /* GLOBAL font family override for game */
    #memory-game-container {
        font-family: 'Poppins', sans-serif;
    }

    #memory-game-container main, #memory-game-container main * {
        font-family: 'Poppins', sans-serif;
    }

    #memory-game-container main h1 {
        font-family: 'Poppins', sans-serif !important;
    }
</style>
@endpush

@section('content')
<div id="memory-game-container" class="min-h-screen text-white overflow-x-hidden selection:bg-ocean-500 selection:text-white relative">
    <!-- Background Image -->
    <div class="fixed inset-0 z-0 overflow-hidden">
        <img src="{{ asset('img/under-sea.gif') }}" alt="Background" class="w-full h-full object-cover opacity-90">
        <div class="absolute inset-0 bg-black/70"></div>
    </div>
    


    <!-- Back Button -->
    <div class="fixed top-24 left-4 z-50">
        <a href="{{ route('games.index') }}" onclick="window.showPageLoader()" class="bg-deep-800/80 p-2 rounded-full border border-ocean-500/30 text-ocean-300 hover:bg-ocean-900/80 transition-all shadow-md backdrop-blur-sm flex items-center justify-center group" title="Back to Games">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
    </div>

    <!-- Game Audio Elements -->
    <audio id="bg-music" loop>
        <source src="{{ asset('audio/memory.mp3') }}" type="audio/mpeg">
    </audio>
    <audio id="correct-sound">
        <source src="{{ asset('audio/correct.mp3') }}" type="audio/mpeg">
    </audio>
    <audio id="wrong-sound">
        <source src="{{ asset('audio/wrong.mp3') }}" type="audio/mpeg">
    </audio>
    <audio id="congratulations-sound">
        <source src="{{ asset('audio/ma complete ang task.mp3') }}" type="audio/mpeg">
    </audio>
    <audio id="click-sound">
        <source src="{{ asset('audio/click sa puzzle ug matching.mp3') }}" type="audio/mpeg">
    </audio>

    @guest
    <!-- Warning Audio -->
    <audio id="warning-audio">
        <source src="{{ asset('audio/warning.mp3') }}" type="audio/mpeg">
    </audio>
    
    <div id="guest-modal" class="fixed inset-0 z-[100] flex items-center justify-center bg-transparent backdrop-blur-0 transition-all duration-700 ease-out hidden">
        <div class="bg-deep-900 border border-red-500/30 p-8 rounded-2xl max-w-md w-full text-center shadow-2xl relative transform scale-75 opacity-0 transition-all duration-700 ease-out" id="guest-modal-content">
            <button onclick="window.showPageLoader(); window.location.href = '{{ route('games.index') }}'" class="absolute top-4 right-4 text-gray-400 hover:text-white transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <div class="text-5xl mb-4">⚠️</div>
            <h2 class="text-2xl font-bold text-white mb-2">
                @auth Warning @else Guest Mode @endauth
            </h2>
            <p class="text-gray-300 mb-8 font-poppins">
                If you do not login, the game will not be recorded.
            </p>
            <div class="flex flex-col gap-3">
                @guest
                <a href="#" onclick="event.preventDefault(); openAuthModal('login')" class="bg-ocean-600 hover:bg-ocean-500 text-white font-bold py-3 px-6 rounded-xl transition-colors font-poppins w-full">
                    Login Now
                </a>
                @endguest
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
                setTimeout(() => {
                    guestModal.classList.remove('bg-transparent', 'backdrop-blur-0');
                    guestModal.classList.add('bg-black/90', 'backdrop-blur-md');
                    
                    guestModalContent.classList.remove('scale-75', 'opacity-0');
                    guestModalContent.classList.add('scale-100', 'opacity-100');
                    
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
            
            if (warningAudio) {
                warningAudio.pause();
                warningAudio.currentTime = 0;
            }
            
            if (guestModalContent) {
                guestModalContent.classList.remove('scale-100', 'opacity-100');
                guestModalContent.classList.add('scale-75', 'opacity-0');
            }
            
            // Start game music immediately and audibly via global helper
            if (typeof window.startMemoryMusic === 'function') {
                window.startMemoryMusic();
            } else if (window.currentGameAudio) {
                window.currentGameAudio.volume = 0.5;
                window.currentGameAudio.play().catch(e => console.log('Fallback audio start failed:', e));
                const icon = document.getElementById('music-icon');
                if (icon) icon.textContent = '🔊';
            }
            

            


            if (guestModal) {
                guestModal.classList.remove('bg-black/90', 'backdrop-blur-md');
                guestModal.classList.add('bg-black/0', 'backdrop-blur-0');
                
                setTimeout(() => {
                    guestModal.remove();
                }, 700);
            }
        };
    </script>
    @endguest

    <main class="pt-24 pb-12 relative z-10 min-h-screen">
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
            <source src="{{ asset('audio/memory.mp3') }}" type="audio/mpeg">
        </audio>
        
        <audio id="congratulations-sound">
            <source src="{{ asset('audio/ma complete ang task.mp3') }}" type="audio/mpeg">
        </audio>

        <div class="container mx-auto px-4">
            <!-- Header -->
            <div class="text-center mb-6">
                <h1 class="text-4xl md:text-5xl font-bold text-ocean-300 mb-2 font-poppins">Pawikan Memory Match</h1>
                <p class="text-gray-300 font-poppins">Match the pairs of sea turtles and test your memory!</p>
            </div>

            <!-- Fixed Left Sidebar: Stats (Hidden on mobile, visible on lg+) -->
            <div class="hidden lg:flex fixed left-4 top-0 bottom-0 z-40 w-80 items-center pt-32">
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
                                    <span id="timer" class="text-3xl font-bold text-white tabular-nums font-mono">00:00.00</span>
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
                                <p id="moves" class="text-3xl font-bold text-white mt-0.5 tabular-nums font-mono">0</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pairs Found Card -->
                <div class="bg-gradient-to-br from-deep-800/90 to-deep-900/90 p-5 rounded-xl border border-ocean-500/20 backdrop-blur-sm shadow-lg hover:shadow-ocean-500/10 transition-all duration-300 hover:border-ocean-500/40">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-lg bg-ocean-500/10 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-ocean-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Pairs Found</p>
                                <p id="pairs" class="text-3xl font-bold text-white mt-0.5 tabular-nums font-mono">0/8</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="bg-gradient-to-br from-deep-800/90 to-deep-900/90 p-4 rounded-xl border border-ocean-500/20 backdrop-blur-sm shadow-lg">
                    <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold mb-2">Progress</p>
                    <div class="w-full bg-deep-900/50 rounded-full h-3 overflow-hidden border border-ocean-700/30">
                        <div id="progress-bar" class="h-full bg-gradient-to-r from-ocean-600 to-ocean-400 rounded-full transition-all duration-500 ease-out shadow-lg shadow-ocean-500/50" style="width: 0%"></div>
                    </div>
                    <p class="text-xs text-gray-500 mt-2 text-center font-poppins">Match all pairs to win!</p>
                </div>
                </div>
            </div>

            <!-- Mobile Stats (Visible on mobile only) -->
            <div class="lg:hidden w-full max-w-4xl mx-auto mb-6 bg-deep-800/50 p-4 rounded-2xl border border-ocean-700/30 backdrop-blur-sm">
                <div class="flex gap-4 sm:gap-8 justify-center">
                    <div class="w-28 text-center bg-deep-900/50 rounded-lg p-2 border border-white/5">
                        <span class="text-ocean-400 text-xs block uppercase tracking-wider mb-1">Time</span>
                        <div class="flex items-baseline justify-center gap-1">
                            <span id="timer-mobile" class="text-xl font-bold tabular-nums font-mono">00:00.00</span>
                            <span id="time-limit-indicator-mobile" class="text-[10px] text-ocean-400 opacity-80"></span>
                        </div>
                    </div>

                    <div class="w-20 text-center bg-deep-900/50 rounded-lg p-2 border border-white/5">
                        <span class="text-ocean-400 text-xs block uppercase tracking-wider mb-1">Moves</span>
                        <span id="moves-mobile" class="text-xl font-bold tabular-nums font-mono">0</span>
                    </div>

                    <div class="w-24 text-center bg-deep-900/50 rounded-lg p-2 border border-white/5">
                        <span class="text-ocean-400 text-xs block uppercase tracking-wider mb-1">Pairs</span>
                        <span id="pairs-mobile" class="text-xl font-bold tabular-nums font-mono">0/8</span>
                    </div>
                </div>
            </div>

            <!-- Fixed Right Sidebar: Difficulty Selector (Hidden on mobile, visible on lg+) -->
            <div class="hidden lg:flex fixed right-4 top-0 bottom-0 z-40 w-80 items-center">
                <div class="w-full">
                    <div class="bg-gradient-to-br from-deep-800/90 to-deep-900/90 p-5 rounded-xl border border-ocean-500/20 backdrop-blur-sm shadow-lg">
                        <p class="text-ocean-300 font-bold text-sm mb-4 text-center uppercase tracking-wider">Select Difficulty</p>
                        <div class="flex flex-col gap-3">
                            <!-- Easy -->
                            <button onclick="setDifficulty('easy')" id="btn-easy" class="px-6 py-3 rounded-xl transition-all font-bold bg-ocean-600 text-white relative group hover:bg-ocean-500">
                                <div class="flex flex-col items-center">
                                    <span class="text-lg">Easy</span>
                                    <span class="text-xs opacity-75">4 Pairs</span>
                                </div>
                            </button>
                            
                            <!-- Medium -->
                            <button onclick="setDifficulty('medium')" id="btn-medium" class="px-6 py-3 rounded-xl transition-all font-bold text-gray-500 relative group cursor-not-allowed opacity-70">
                                <div class="flex flex-col items-center">
                                    <span class="text-lg">Medium</span>
                                    <span class="text-xs opacity-75">6 Pairs</span>
                                </div>
                                <span class="lock-icon absolute -top-2 -right-2 bg-deep-900 rounded-full p-1 text-xs border border-ocean-500/30">🔒</span>
                            </button>
                            
                            <!-- Hard -->
                            <button onclick="setDifficulty('hard')" id="btn-hard" class="px-6 py-3 rounded-xl transition-all font-bold text-gray-500 relative group cursor-not-allowed opacity-70">
                                <div class="flex flex-col items-center">
                                    <span class="text-lg">Hard</span>
                                    <span class="text-xs opacity-75">8 Pairs</span>
                                </div>
                                <span class="lock-icon absolute -top-2 -right-2 bg-deep-900 rounded-full p-1 text-xs border border-ocean-500/30">🔒</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile Difficulty Selector (Visible on mobile only) -->
            <div class="lg:hidden w-full max-w-4xl mx-auto mb-6">
                <div class="bg-deep-800/50 p-4 rounded-2xl border border-ocean-700/30 backdrop-blur-sm">
                    <p class="text-ocean-400 text-sm uppercase tracking-wider font-semibold mb-3 text-center">Select Difficulty</p>
                    <div class="flex gap-3 justify-center">
                        <!-- Easy -->
                        <button onclick="setDifficulty('easy')" id="btn-easy-mobile" class="px-4 py-2 rounded-xl transition-all font-bold bg-ocean-600 text-white text-sm">
                            <div class="flex flex-col items-center">
                                <span>Easy</span>
                                <span class="text-xs opacity-75">8</span>
                            </div>
                        </button>
                        
                        <!-- Medium -->
                        <button onclick="setDifficulty('medium')" id="btn-medium-mobile" class="px-4 py-2 rounded-xl transition-all font-bold text-gray-500 relative cursor-not-allowed opacity-70 text-sm">
                            <div class="flex flex-col items-center">
                                <span>Med</span>
                                <span class="text-xs opacity-75">12</span>
                            </div>
                            <span class="lock-icon absolute -top-1 -right-1 bg-deep-900 rounded-full p-0.5 text-xs border border-ocean-500/30">🔒</span>
                        </button>
                        
                        <!-- Hard -->
                        <button onclick="setDifficulty('hard')" id="btn-hard-mobile" class="px-4 py-2 rounded-xl transition-all font-bold text-gray-500 relative cursor-not-allowed opacity-70 text-sm">
                            <div class="flex flex-col items-center">
                                <span>Hard</span>
                                <span class="text-xs opacity-75">16</span>
                            </div>
                            <span class="lock-icon absolute -top-1 -right-1 bg-deep-900 rounded-full p-0.5 text-xs border border-ocean-500/30">🔒</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Game Grid (Original Position - Centered) -->
            <div class="relative w-full max-w-5xl mx-auto mt-4">
                <div id="game-grid" class="grid grid-cols-4 gap-3 md:gap-4 w-fit mx-auto perspective-1000">
                    <!-- Cards will be generated here -->
                </div>
            </div>
        </div>

        <!-- Game Over Modal -->
            <div id="game-over-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm hidden">
                <div class="bg-deep-900 border border-ocean-500/30 p-8 rounded-2xl max-w-md w-full text-center shadow-2xl transform scale-100 transition-all relative">
                    <button onclick="document.getElementById('game-over-modal').classList.add('hidden')" class="absolute top-4 right-4 text-gray-400 hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    <div id="modal-icon" class="text-6xl mb-4">🏆</div>
                    <h2 id="modal-title" class="text-3xl font-bold text-ocean-300 mb-2 font-poppins">Congratulations!</h2>
                    <p id="modal-message" class="text-gray-300 mb-2 font-poppins">You've matched all the pairs!</p>
                    
                    @auth
                        <div id="save-status" class="mb-6">
                            <p class="text-yellow-400 text-sm font-poppins flex items-center justify-center gap-2">
                                <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Saving game...
                            </p>
                        </div>
                    @else
                        <p class="text-gray-400 mb-6 font-poppins">&nbsp;</p>
                    @endauth
                    
                    <div class="grid grid-cols-3 gap-2 mb-8 text-left bg-black/30 p-4 rounded-xl font-poppins">
                        <div>
                            <p class="text-sm text-gray-400">Difficulty</p>
                            <p id="final-difficulty" class="text-xl font-bold text-white capitalize">Easy</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Time Taken</p>
                            <p id="final-time" class="text-xl font-bold text-white">00:00.00</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-400">Moves</p>
                            <p id="final-moves" class="text-xl font-bold text-white">0</p>
                        </div>
                    </div>
                    
                    <div class="flex gap-4 justify-center">
                        <button id="next-level-btn" onclick="goToNextLevel()" class="bg-gradient-to-r from-ocean-600 to-ocean-500 hover:from-ocean-500 hover:to-ocean-400 text-white font-bold py-3 px-6 rounded-xl transition-all transform hover:scale-105 shadow-lg shadow-ocean-500/30 font-poppins hidden">
                            Next Level →
                        </button>
                        <button onclick="window.showPageLoader(); location.reload()" class="bg-ocean-600 hover:bg-ocean-500 text-white font-bold py-3 px-6 rounded-xl transition-colors font-poppins">
                            Play Again
                        </button>
                        <a href="/games" onclick="window.showPageLoader()" class="bg-transparent border border-ocean-600 text-ocean-300 hover:bg-ocean-900/30 font-bold py-3 px-6 rounded-xl transition-colors font-poppins">
                            Exit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

</div>
@endsection

@push('scripts')
<script>
    (function() {
        // Game Configuration
        const allImages = [
            'baby-grn.png',
            'baby-hawks.png',
            'baby-live.png',
            'olive.png',
            'hawksbill.png',
            'green.png',
            'died.png',
            'stranded.png'
        ];
        
        // Difficulty settings
        const difficulties = {
            easy: { pairs: 4, gridCols: 4, totalPairs: 4, timeLimit: 15 },      // 15 seconds
            medium: { pairs: 6, gridCols: 4, totalPairs: 6, timeLimit: 30 },    // 30 seconds
            hard: { pairs: 8, gridCols: 4, totalPairs: 8, timeLimit: 60 }       // 60 seconds (1 minute)
        };
        
        let currentDifficulty = 'easy';
        let images = [];
        let cards = [];
        let flippedCards = [];
        let matchedPairs = 0;
        let moves = 0;
        let timerInterval;
        let seconds = 0;
        let gameStarted = false;
        let canFlip = true;

        // DOM Elements
        const grid = document.getElementById('game-grid');
        const movesDisplay = document.getElementById('moves');
        const timerDisplay = document.getElementById('timer');
        const pairsDisplay = document.getElementById('pairs');
        const movesDisplayMobile = document.getElementById('moves-mobile');
        const timerDisplayMobile = document.getElementById('timer-mobile');
        const pairsDisplayMobile = document.getElementById('pairs-mobile');
        const progressBar = document.getElementById('progress-bar');
        const modal = document.getElementById('game-over-modal');

        // Get user-specific storage key prefix
        // Get user-specific storage key prefix
        const isLoggedIn = @auth true @else false @endauth;
        const userStoragePrefix = @auth '{{ Auth::id() }}_' @else '' @endauth;

        // Check and load unlocked levels from localStorage
        function loadUnlockedLevels() {
            if (!isLoggedIn) return; // Guests do not load saved progress
            
            const easyCompleted = localStorage.getItem(`${userStoragePrefix}memoryMatch_easy_completed`) === 'true';
            const mediumCompleted = localStorage.getItem(`${userStoragePrefix}memoryMatch_medium_completed`) === 'true';
            
            if (easyCompleted) {
                unlockLevel('medium');
            }
            if (mediumCompleted) {
                unlockLevel('hard');
            }
        }

        function unlockLevel(level) {
            // Desktop button
            const btn = document.getElementById(`btn-${level}`);
            if (btn) {
                btn.classList.remove('cursor-not-allowed', 'opacity-70', 'text-gray-500');
                btn.classList.add('cursor-pointer', 'hover:bg-ocean-500', 'border', 'border-ocean-600', 'text-ocean-300');
                const lock = btn.querySelector('.lock-icon');
                if (lock) lock.remove();
            }
            
            // Mobile button
            const btnMobile = document.getElementById(`btn-${level}-mobile`);
            if (btnMobile) {
                btnMobile.classList.remove('cursor-not-allowed', 'opacity-70', 'text-gray-500');
                btnMobile.classList.add('cursor-pointer', 'hover:bg-ocean-500', 'border', 'border-ocean-600', 'text-ocean-300');
                const lockMobile = btnMobile.querySelector('.lock-icon');
                if (lockMobile) lockMobile.remove();
            }
        }

        window.setDifficulty = function(level) {
            const btn = document.getElementById(`btn-${level}`);
            const btnMobile = document.getElementById(`btn-${level}-mobile`);
            
            // Check if level is locked (check both desktop and mobile)
            if ((btn && btn.classList.contains('cursor-not-allowed')) || 
                (btnMobile && btnMobile.classList.contains('cursor-not-allowed'))) return;
            
            currentDifficulty = level;
            
            // Save last played difficulty for logged-in users
            // Save last played difficulty for logged-in users
            if (isLoggedIn) {
                localStorage.setItem(`${userStoragePrefix}memoryMatch_last_difficulty`, level);
            }
            
            // Update button states for both desktop and mobile
            ['easy', 'medium', 'hard'].forEach(diff => {
                const diffBtn = document.getElementById(`btn-${diff}`);
                const diffBtnMobile = document.getElementById(`btn-${diff}-mobile`);
                
                if (diff === level) {
                    // Desktop
                    if (diffBtn) {
                        diffBtn.classList.add('bg-ocean-600', 'text-white');
                        diffBtn.classList.remove('border', 'border-ocean-600', 'text-ocean-300', 'bg-transparent');
                    }
                    // Mobile
                    if (diffBtnMobile) {
                        diffBtnMobile.classList.add('bg-ocean-600', 'text-white');
                        diffBtnMobile.classList.remove('border', 'border-ocean-600', 'text-ocean-300', 'bg-transparent');
                    }
                } else {
                    // Desktop
                    if (diffBtn && !diffBtn.classList.contains('cursor-not-allowed')) {
                        diffBtn.classList.remove('bg-ocean-600', 'text-white');
                        diffBtn.classList.add('border', 'border-ocean-600', 'text-ocean-300', 'bg-transparent');
                    }
                    // Mobile
                    if (diffBtnMobile && !diffBtnMobile.classList.contains('cursor-not-allowed')) {
                        diffBtnMobile.classList.remove('bg-ocean-600', 'text-white');
                        diffBtnMobile.classList.add('border', 'border-ocean-600', 'text-ocean-300', 'bg-transparent');
                    }
                }
            });
            
            initGame();
        }

        // Initialize Game
        function initGame() {
            // Reset game state
            matchedPairs = 0;
            moves = 0;
            seconds = 0;
            gameStarted = false;
            flippedCards = [];
            clearInterval(timerInterval);
            
            // Get difficulty settings
            const diff = difficulties[currentDifficulty];
            
            // Select images based on difficulty
            images = allImages.slice(0, diff.pairs);
            cards = [...images, ...images]; // Duplicate for pairs
            
            // Shuffle cards
            cards.sort(() => Math.random() - 0.5);
            
            // Update grid columns
            // Update grid columns with hybrid sizing: Fluid for Mobile, Fixed/Tight for Desktop
            grid.className = `grid grid-cols-${diff.gridCols} gap-2 md:gap-4 w-full md:w-fit mx-auto perspective-1000 px-2`;
            
            // Clear grid
            grid.innerHTML = '';
            
            if (timerDisplay) timerDisplay.classList.remove('text-red-500', 'animate-pulse');
            if (timerDisplayMobile) timerDisplayMobile.classList.remove('text-red-500', 'animate-pulse');
            
            // Update displays
            movesDisplay.textContent = '0';
            if (movesDisplayMobile) movesDisplayMobile.textContent = '0';
            
            // Display initial time limit
            // Display initial time (00:00.00)
            const initialTime = '00:00.00';
            timerDisplay.textContent = initialTime;
            if (timerDisplayMobile) timerDisplayMobile.textContent = initialTime;
            
            // Set time limit indicator
            const indicatorText = `/ ${diff.timeLimit}s`;
            const indicator = document.getElementById('time-limit-indicator');
            const indicatorMobile = document.getElementById('time-limit-indicator-mobile');
            
            if (indicator) indicator.textContent = indicatorText;
            if (indicatorMobile) indicatorMobile.textContent = indicatorText;
            const pairsText = `0/${diff.totalPairs}`;
            pairsDisplay.textContent = pairsText;
            if (pairsDisplayMobile) pairsDisplayMobile.textContent = pairsText;
            if (progressBar) progressBar.style.width = '0%';
            
            // Create cards
            cards.forEach((img, index) => {
                const card = document.createElement('div');
                // Hybrid Sizing: Fluid aspect-ratio for Mobile, Fixed pixel dimensions for Desktop
                card.className = 'card w-full aspect-square md:w-28 md:h-28 md:aspect-auto relative cursor-pointer group perspective-1000 hover:scale-105 transition-transform duration-300';
                card.dataset.index = index;
                card.dataset.image = img;
                
                card.innerHTML = `
                    <div class="card-inner w-full h-full relative transform-style-3d">
                        <div class="card-front absolute w-full h-full backface-hidden bg-deep-800 border-2 border-ocean-700/30 rounded-xl flex items-center justify-center overflow-hidden shadow-lg group-hover:border-ocean-500/50 transition-colors">
                            <img src="{{ asset('img/lg.png') }}" alt="Card Back" class="w-3/4 h-3/4 object-contain opacity-50">
                        </div>
                        <div class="card-back absolute w-full h-full backface-hidden rotate-y-180 bg-deep-900 border-2 border-ocean-400 rounded-xl flex items-center justify-center overflow-hidden shadow-ocean-500/20 shadow-lg relative">
                            <img src="{{ asset('img') }}/${img}" alt="Card Front" class="w-full h-full object-cover">
                            <!-- Status Icons -->
                            <div class="status-overlay check-overlay hidden rounded-xl">
                                <div class="status-icon">✅</div>
                            </div>
                            <div class="status-overlay x-overlay hidden rounded-xl">
                                <div class="status-icon">❌</div>
                            </div>
                        </div>
                    </div>
                `;
                
                card.addEventListener('click', () => flipCard(card));
                grid.appendChild(card);
            });
        }

        function startTimer() {
            if (!gameStarted) {
                gameStarted = true;
                
                // Get time limit from current difficulty
                const limitSeconds = difficulties[currentDifficulty].timeLimit;
                const limitMs = limitSeconds * 1000;
                let timeElapsed = 0;
                
                // Reset warning state
                let warningTriggered = false;
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
        }

        function handleTimeUp() {
            // Show modal with Time's Up message
            document.getElementById('modal-icon').textContent = '⏰';
            document.getElementById('modal-title').textContent = "Time's Up!";
            document.getElementById('modal-message').textContent = "You ran out of time. Try again!";
            
            // Display accurate time limit instead of countdown (00:00)
            const limitSeconds = difficulties[currentDifficulty].timeLimit;
            const mins = Math.floor(limitSeconds / 60).toString().padStart(2, '0');
            const secs = (limitSeconds % 60).toString().padStart(2, '0');
            document.getElementById('final-time').textContent = `${mins}:${secs}.00`;
            
            document.getElementById('final-difficulty').textContent = currentDifficulty;
            document.getElementById('final-moves').textContent = moves;
            
            // Hide saving status for loss (since we don't save losses)
            const saveStatus = document.getElementById('save-status');
            if (saveStatus) {
                saveStatus.innerHTML = ''; // Clear the "Saving game..." spinner
            }
            
            // Hide next level button
            const nextLevelBtn = document.getElementById('next-level-btn');
            if (nextLevelBtn) nextLevelBtn.classList.add('hidden');
            
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
            canFlip = false;
        }

        function flipCard(card) {
            if (!canFlip || card.classList.contains('flipped') || card.classList.contains('matched')) return;
            
            startTimer();
            playClickSound();
            
            // Use requestAnimationFrame to ensure browser processes the transition
            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    card.classList.add('flipped');
                });
            });
            
            flippedCards.push(card);

            if (flippedCards.length === 2) {
                moves++;
                movesDisplay.textContent = moves;
                if (movesDisplayMobile) movesDisplayMobile.textContent = moves;
                checkMatch();
            }
        }

        function checkMatch() {
            canFlip = false;
            const [card1, card2] = flippedCards;
            const match = card1.dataset.image === card2.dataset.image;

            if (match) {
                handleMatch(card1, card2);
            } else {
                handleMismatch(card1, card2);
            }
        }

        function handleMatch(card1, card2) {
            // Play correct sound immediately
            playCorrectSound();

            // Show Checkmark immediately
            const showCheck = (card) => {
                const overlay = card.querySelector('.check-overlay');
                overlay.classList.remove('hidden');
                setTimeout(() => overlay.classList.add('show'), 10);
                // Hide after 1s to reveal image
                setTimeout(() => {
                    overlay.classList.remove('show');
                    setTimeout(() => overlay.classList.add('hidden'), 300);
                }, 1000);
            };

            showCheck(card1);
            showCheck(card2);

            card1.classList.add('matched');
            card2.classList.add('matched');
            
            matchedPairs++;
            
            const diff = difficulties[currentDifficulty];
            const pairsText = `${matchedPairs}/${diff.totalPairs}`;
            pairsDisplay.textContent = pairsText;
            if (pairsDisplayMobile) pairsDisplayMobile.textContent = pairsText;
            
            // Update progress bar
            const progress = (matchedPairs / images.length) * 100;
            if (progressBar) progressBar.style.width = `${progress}%`;
            
            flippedCards = [];
            canFlip = true;

            if (matchedPairs === images.length) {
                // Stop warning sound if active
                timerDisplay.classList.remove('text-red-500', 'animate-pulse');
                if (timerDisplayMobile) timerDisplayMobile.classList.remove('text-red-500', 'animate-pulse');

                // Save completion status with user-specific key
                if (isLoggedIn) {
                    localStorage.setItem(`${userStoragePrefix}memoryMatch_${currentDifficulty}_completed`, 'true');
                }
                
                // Unlock next level
                if (currentDifficulty === 'easy') {
                    unlockLevel('medium');
                } else if (currentDifficulty === 'medium') {
                    unlockLevel('hard');
                }
                
                endGame();
            }
        }

        function handleMismatch(card1, card2) {
            // Play wrong sound immediately
            playWrongSound();

            // Show X immediately
            const showX = (card) => {
                const overlay = card.querySelector('.x-overlay');
                overlay.classList.remove('hidden');
                setTimeout(() => overlay.classList.add('show'), 10);
            };
            
            showX(card1);
            showX(card2);

            // Flip back after brief viewing time
            setTimeout(() => {
                card1.classList.remove('flipped');
                card2.classList.remove('flipped');
                
                // Hide X
                const hideX = (card) => {
                    const overlay = card.querySelector('.x-overlay');
                    overlay.classList.remove('show');
                    setTimeout(() => overlay.classList.add('hidden'), 300);
                };
                hideX(card1);
                hideX(card2);

                flippedCards = [];
                canFlip = true;
            }, 800); // Reduced from 1500ms to 800ms
        }

        async function endGame() {
            clearInterval(timerInterval);
            
            // Show modal first
            setTimeout(() => {
                // Set Win Message
                document.getElementById('modal-icon').textContent = '🏆';
                document.getElementById('modal-title').textContent = 'Congratulations!';
                document.getElementById('modal-message').textContent = "You've matched all the pairs!";

                document.getElementById('final-difficulty').textContent = currentDifficulty;
                document.getElementById('final-time').textContent = timerDisplay.textContent;
                document.getElementById('final-moves').textContent = moves;
                
                // Show Next Level button if not on hard difficulty
                const nextLevelBtn = document.getElementById('next-level-btn');
                if (currentDifficulty === 'easy' || currentDifficulty === 'medium') {
                    nextLevelBtn.classList.remove('hidden');
                } else {
                    nextLevelBtn.classList.add('hidden');
                }
                
                // Play congratulations sound
                const congratsSound = document.getElementById('congratulations-sound');
                if (congratsSound) {
                    congratsSound.currentTime = 0;
                    congratsSound.play().catch(e => console.log('Congrats sound failed:', e));
                }
                
                // Pause background music on victory
                if (bgMusic) {
                    bgMusic.pause();
                    isMusicPlaying = false;
                    musicIcon.textContent = '🔇';
                }
                
                modal.classList.remove('hidden');
            }, 200);
            
            // Record game activity for logged-in players
            @auth
            console.log('Checking gameActivity...', window.gameActivity);
            if (window.gameActivity) {
                try {
                    console.log('Recording game: moves=', moves, 'seconds=', seconds);
                    const result = await window.gameActivity.recordMemoryMatch(moves, seconds, currentDifficulty);
                    console.log('Record result:', result);
                    
                    // Update save status message
                    const saveStatus = document.getElementById('save-status');
                    if (saveStatus) {
                        if (result && result.success) {
                            saveStatus.innerHTML = `
                                <p class="text-green-400 text-sm font-poppins flex items-center justify-center gap-2 animate-fade-in">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Game saved successfully!
                                </p>
                            `;
                            
                            // Trigger profile update event
                            window.dispatchEvent(new CustomEvent('gameCompleted', {
                                detail: {
                                    gameType: 'memory-match',
                                    timeSpent: seconds,
                                    moves: moves
                                }
                            }));
                        } else {
                            console.error('Save failed - result:', result);
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
                    const saveStatus = document.getElementById('save-status');
                    if (saveStatus) {
                        saveStatus.innerHTML = `
                            <p class="text-red-400 text-sm font-poppins flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Error saving game
                            </p>
                        `;
                    }
                }
            } else {
                console.error('gameActivity not found on window object');
                const saveStatus = document.getElementById('save-status');
                if (saveStatus) {
                    saveStatus.innerHTML = `
                        <p class="text-red-400 text-sm font-poppins flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Game activity system not loaded
                        </p>
                    `;
                }
            }
            @endauth
        }

        // Click sound function - Card Flip Style
        function playClickSound() {
            const sound = document.getElementById('click-sound');
            if (sound) {
                sound.currentTime = 0;
                sound.volume = 0.6;
                sound.play().catch(e => console.log('Click sound failed:', e));
            }
        }

        function playCorrectSound() {
            const sound = document.getElementById('correct-sound');
            if (sound) {
                sound.currentTime = 0;
                sound.volume = 1.0;
                sound.play().catch(e => console.log('Audio play failed:', e));
            }
        }

        function playWrongSound() {
            const sound = document.getElementById('wrong-sound');
            if (sound) {
                sound.currentTime = 0;
                sound.volume = 1.0;
                sound.play().catch(e => console.log('Audio play failed:', e));
            }
        }

        // Background Music Control with Volume
        const musicToggle = document.getElementById('music-toggle');
        const musicIcon = document.getElementById('music-icon');
        const bgMusic = document.getElementById('bg-music');
        if (bgMusic) {
            window.currentGameAudio = bgMusic;
        }
        const volumeSlider = document.getElementById('volume-slider');
        const volumePercent = document.getElementById('volume-percent');
        let isMusicPlaying = false;

        // Expose a function to start music from outside (e.g., from the guest modal)
        window.startMemoryMusic = function() {
            if (!bgMusic) return;
            
            // Force reset state
            bgMusic.muted = false;
            // Only reset time if we are essentially at the start or end
            if (bgMusic.currentTime > bgMusic.duration - 1 || bgMusic.paused) {
                 bgMusic.currentTime = 0;
            }
            
            // Robust volume calculation
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
            bgMusic.volume = 0.5; // Set default volume to 50%
            
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
        if (bgMusic) {
            bgMusic.addEventListener('timeupdate', function() {
                // Return to start slightly before the technical end to hide silent trailing padding
                const buffer = 0.2; 
                if (this.currentTime > this.duration - buffer && this.loop) {
                    this.currentTime = 0;
                    this.play().catch(e => {});
                }
            });
        }

        // Stop music when navigating away via Turbo or reloading
        const stopMusic = () => {
            if (bgMusic) {
                bgMusic.pause();
                bgMusic.currentTime = 0;
                isMusicPlaying = false;
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
        // Initialize Everything Immediately
        // Since this script is at the bottom of the body, it runs after content is swapped
        const runInitialization = () => {
            // Reset progress for guest users
            @guest
            localStorage.removeItem('memoryMatch_easy_completed');
            localStorage.removeItem('memoryMatch_medium_completed');
            localStorage.removeItem('memoryMatch_last_difficulty');
            @endguest
            
            // First, unlock levels based on completion
            loadUnlockedLevels();
            
            // Then, load last played difficulty for logged-in users
            @auth
            const lastDifficulty = localStorage.getItem(`${userStoragePrefix}memoryMatch_last_difficulty`);
            if (lastDifficulty && (lastDifficulty === 'easy' || lastDifficulty === 'medium' || lastDifficulty === 'hard')) {
                // Check if the level is actually unlocked before loading it
                const btn = document.getElementById(`btn-${lastDifficulty}`);
                const isUnlocked = !btn || !btn.classList.contains('cursor-not-allowed');
                
                if (isUnlocked) {
                    currentDifficulty = lastDifficulty;
                    // Update button states to reflect loaded difficulty
                    ['easy', 'medium', 'hard'].forEach(diff => {
                        const diffBtn = document.getElementById(`btn-${diff}`);
                        const diffBtnMobile = document.getElementById(`btn-${diff}-mobile`);
                        
                        if (diff === lastDifficulty) {
                            if (diffBtn) {
                                diffBtn.classList.add('bg-ocean-600', 'text-white');
                                diffBtn.classList.remove('border', 'border-ocean-600', 'text-ocean-300', 'bg-transparent');
                            }
                            if (diffBtnMobile) {
                                diffBtnMobile.classList.add('bg-ocean-600', 'text-white');
                                diffBtnMobile.classList.remove('border', 'border-ocean-600', 'text-ocean-300', 'bg-transparent');
                            }
                        } else {
                            if (diffBtn && !diffBtn.classList.contains('cursor-not-allowed')) {
                                diffBtn.classList.remove('bg-ocean-600', 'text-white');
                                diffBtn.classList.add('border', 'border-ocean-600', 'text-ocean-300', 'bg-transparent');
                            }
                            if (diffBtnMobile && !diffBtnMobile.classList.contains('cursor-not-allowed')) {
                                diffBtnMobile.classList.remove('bg-ocean-600', 'text-white');
                                diffBtnMobile.classList.add('border', 'border-ocean-600', 'text-ocean-300', 'bg-transparent');
                            }
                        }
                    });
                }
            }
            @endauth
            
            initGame();
            
            // Auto-play music if no guest modal is present (Logged in user)
            const guestModal = document.getElementById('guest-modal');
            if (!guestModal) {
                // User is likely logged in and authorized, start music automatically
                window.startMemoryMusic();
                
                // Fallback: If autoplay is blocked, start on first interaction
                const startOnInteraction = () => {
                    if (!isMusicPlaying) {
                        window.startMemoryMusic();
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
                    isMusicPlaying = false;
                }
            }
        };


        // Function to go to next level
        window.goToNextLevel = function() {
            // Close modal
            modal.classList.add('hidden');
            
            // Ensure music is playing
            if (bgMusic && bgMusic.paused) {
                bgMusic.play().catch(e => console.log('Music resume failed:', e));
                isMusicPlaying = true;
                musicIcon.textContent = '🔊';
            }
            
            // Determine next level
            let nextLevel = 'easy';
            if (currentDifficulty === 'easy') {
                nextLevel = 'medium';
            } else if (currentDifficulty === 'medium') {
                nextLevel = 'hard';
            }
            
            // Set difficulty and start new game
            setDifficulty(nextLevel);
        };

        // Run immediately since script is at end of body
        runInitialization();
    })();
</script>
@endpush
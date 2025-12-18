@extends('layouts.app')

@section('title', 'Pawikan Educational Games - Learn & Play')

@push('styles')
<style>
    /* Global font family for index */
    #games-index-container {
        font-family: 'Cinzel', sans-serif;
    }

    #games-index-container main, #games-index-container main * {
        font-family: 'Poppins', sans-serif;
    }

    #games-index-container main h1, #games-index-container main h2, #games-index-container main h3 {
        font-family: 'Cinzel', serif !important;
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

    .game-card {
        background: linear-gradient(135deg, rgba(0, 0, 0, 0.3), rgba(6, 182, 212, 0.1));
        border: 1px solid rgba(34, 211, 238, 0.2);
        position: relative;
        overflow: hidden;
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
    
    .ripple {
        position: absolute;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        transform: scale(0);
        animation: ripple 0.6s linear;
        pointer-events: none;
    }

    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
    
    .benefit-card {
        transition: all 0.3s ease;
    }
    
    .benefit-card:hover {
        transform: translateY(-5px);
        background: linear-gradient(135deg, rgba(34, 211, 238, 0.1), rgba(6, 182, 212, 0.05));
    }
</style>
@endpush

@section('content')
<div id="games-index-container" class="bg-gray-800 min-h-screen text-white overflow-x-hidden relative">

    
    @include('navigation')


    <!-- Main Content -->
    <main class="pt-20 relative z-10">
        <!-- Hero Section for Games -->
        <section class="py-20 px-4">
            <div class="max-w-6xl mx-auto text-center">
                <div class="flex flex-col md:flex-row items-center justify-center mb-8">
                    <div class="text-8xl mr-0 md:mr-6 mb-4 md:mb-0 animate-float">🐢</div>
                    <div>
                        <h1 class="text-[3rem] font-bold text-green-400 mb-4 tracking-wide font-poppins">
                            Pawikan Educational Games
                        </h1>
                        <p class="text-gray-300 text-xl md:text-2xl font-medium font-poppins">
                            Learn marine turtle conservation through interactive gameplay
                        </p>
                        <div class="flex items-center justify-center gap-4 mt-6">
                            <div class="flex items-center gap-2 text-green-400">
                                <span class="animate-pulse">🎮</span>
                                <span class="text-sm font-medium font-poppins">3 Interactive Games</span>
                            </div>
                            <div class="w-1 h-1 bg-green-400 rounded-full"></div>
                            <div class="flex items-center gap-2 text-green-400">
                                <span class="animate-bounce-slow">🏆</span>
                                <span class="text-sm font-medium font-poppins">Educational & Fun</span>
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
                    <h2 class="text-4xl font-bold text-green-400 mb-4 font-poppins">Choose Your Adventure</h2>
                    <p class="text-gray-300 text-lg max-w-2xl mx-auto font-poppins">
                        Dive into the world of marine conservation with our interactive educational games
                    </p>
                </div>
                
                <div class="grid md:grid-cols-3 gap-8">

                    <!-- Memory Match Game Card -->
                    <div class="game-card rounded-3xl p-8 hover-lift group">
                        <div class="text-center mb-8 relative z-10">
                            <div class="text-7xl mb-6 animate-wiggle">🧠</div>
                            <h3 class="text-3xl font-bold text-green-400 mb-4 font-poppins">Memory Match</h3>
                            <p class="text-gray-300 leading-relaxed text-lg font-poppins">
                                Test your memory by matching pairs of sea turtles and conservation items. 
                                A fun way to improve your focus!
                            </p>
                        </div>
                        
                        <!-- Game Features -->
                        <div class="space-y-4 mb-10 relative z-10">
                            <div class="flex items-center gap-4 text-gray-300 group/feature">
                                <span class="text-2xl text-green-400 feature-icon">🃏</span>
                                <span class="font-medium font-poppins">3 Difficulty Levels</span>
                            </div>
                            <div class="flex items-center gap-4 text-gray-300 group/feature">
                                <span class="text-2xl text-ocean-400 feature-icon">⏱️</span>
                                <span class="font-medium font-poppins">Time & Move Tracking</span>
                            </div>
                            <div class="flex items-center gap-4 text-gray-300 group/feature">
                                <span class="text-2xl text-ocean-400 feature-icon">🧠</span>
                                <span class="font-medium font-poppins">Boosts Memory Skills</span>
                            </div>
                            <div class="flex items-center gap-4 text-gray-300 group/feature">
                                <span class="text-2xl text-ocean-400 feature-icon">🐢</span>
                                <span class="font-medium font-poppins">Learn Turtle Species</span>
                            </div>
                            <div class="flex items-center gap-4 text-gray-300 group/feature">
                                <span class="text-2xl text-ocean-400 feature-icon">🔄</span>
                                <span class="font-medium font-poppins">Randomized Each Game</span>
                            </div>
                        </div>
                        
                        <!-- Play Button -->
                        <a href="/games/memory-match" class="play-button memory-start-btn block w-full bg-gradient-to-r from-green-600 to-green-500 hover:from-green-500 hover:to-green-400 text-white font-bold py-5 px-8 rounded-2xl text-center text-lg relative z-10 transform group-hover:scale-105 transition-all duration-300" onclick="playClickSound(); window.showPageLoader();">
                            <span class="relative z-10">🃏 Start Memory Game</span>
                        </a>
                    </div>

                    <!-- Puzzle Game Card -->
                    <div class="game-card rounded-3xl p-8 hover-lift group">
                        <div class="text-center mb-8 relative z-10">
                            <div class="text-7xl mb-6 animate-wiggle">🧩</div>
                            <h3 class="text-3xl font-bold text-green-400 mb-4 font-poppins">Pawikan Puzzle</h3>
                            <p class="text-gray-300 leading-relaxed text-lg font-poppins">
                                Reassemble the scattered pieces to reveal the majestic sea turtle. 
                                Choose from Easy, Medium, or Hard difficulty levels!
                            </p>
                        </div>
                        
                        <!-- Game Features -->
                        <div class="space-y-4 mb-10 relative z-10">
                            <div class="flex items-center gap-4 text-gray-300 group/feature">
                                <span class="text-2xl text-ocean-400 feature-icon">🎚️</span>
                                <span class="font-medium font-poppins">3 Difficulty Levels</span>
                            </div>
                            <div class="flex items-center gap-4 text-gray-300 group/feature">
                                <span class="text-2xl text-ocean-400 feature-icon">⏱️</span>
                                <span class="font-medium font-poppins">Time & Move Tracking</span>
                            </div>
                            <div class="flex items-center gap-4 text-gray-300 group/feature">
                                <span class="text-2xl text-ocean-400 feature-icon">🖼️</span>
                                <span class="font-medium font-poppins">Beautiful Turtle Imagery</span>
                            </div>
                            <div class="flex items-center gap-4 text-gray-300 group/feature">
                                <span class="text-2xl text-ocean-400 feature-icon">🧠</span>
                                <span class="font-medium font-poppins">Logic & Spatial Skills</span>
                            </div>
                            <div class="flex items-center gap-4 text-gray-300 group/feature">
                                <span class="text-2xl text-ocean-400 feature-icon">🔄</span>
                                <span class="font-medium font-poppins">Infinite Replayability</span>
                            </div>
                        </div>
                        
                        <!-- Play Button -->
                        <a href="/games/puzzle" class="play-button puzzle-start-btn block w-full bg-gradient-to-r from-green-600 to-green-500 hover:from-green-500 hover:to-green-400 text-white font-bold py-5 px-8 rounded-2xl text-center text-lg relative z-10 transform group-hover:scale-105 transition-all duration-300" onclick="playClickSound(); window.showPageLoader();">
                            <span class="relative z-10">🧩 Start Puzzle</span>
                        </a>
                    </div>

                    <!-- Ocean Guardian Game Card (Replaces Pawikan Rush) -->
                    <div class="game-card rounded-3xl p-8 hover-lift group">
                        <div class="text-center mb-8 relative z-10">
                            <div class="text-7xl mb-6 animate-wiggle">🛡️</div>
                            <h3 class="text-3xl font-bold text-green-400 mb-4 font-poppins">Ocean Guardian</h3>
                            <p class="text-gray-300 leading-relaxed text-lg font-poppins">
                                Defend the reef from pollution! Tap to collect trash and protect the sea turtles 
                                in this fast-paced clicker game.
                            </p>
                        </div>
                        
                        <!-- Game Features -->
                        <div class="space-y-4 mb-10 relative z-10">
                            <div class="flex items-center gap-4 text-gray-300 group/feature">
                                <span class="text-2xl text-ocean-400 feature-icon">👆</span>
                                <span class="font-medium font-poppins">Tap to Clean</span>
                            </div>
                            <div class="flex items-center gap-4 text-gray-300 group/feature">
                                <span class="text-2xl text-ocean-400 feature-icon">🐢</span>
                                <span class="font-medium font-poppins">Protect Marine Life</span>
                            </div>
                            <div class="flex items-center gap-4 text-gray-300 group/feature">
                                <span class="text-2xl text-ocean-400 feature-icon">🚮</span>
                                <span class="font-medium font-poppins">Remove Debris</span>
                            </div>
                            <div class="flex items-center gap-4 text-gray-300 group/feature">
                                <span class="text-2xl text-ocean-400 feature-icon">🌊</span>
                                <span class="font-medium font-poppins">Beautiful Underwater View</span>
                            </div>
                            <div class="flex items-center gap-4 text-gray-300 group/feature">
                                <span class="text-2xl text-ocean-400 feature-icon">🏆</span>
                                <span class="font-medium font-poppins">Beat Your High Score</span>
                            </div>
                        </div>
                        
                        <!-- Play Button -->
                        <a href="/games/find-the-pawikan" class="play-button block w-full bg-gradient-to-r from-green-600 to-green-500 hover:from-green-500 hover:to-green-400 text-white font-bold py-5 px-8 rounded-2xl text-center text-lg relative z-10 transform group-hover:scale-105 transition-all duration-300" onclick="playClickSound(); window.showPageLoader();">
                            <span class="relative z-10">🛡️ Start Defending</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

</div>
@endsection

@push('scripts')
<script>
    (function() {
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

        // Click sound function
        window.playClickSound = function() {
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
                
            } catch (error) {
                console.log('Audio not supported');
            }
        };

        // Initialize when ready or on Turbo load
        const init = () => {
            // Any additional initialization logic for the games index
        };

        document.addEventListener('turbo:load', init);
        init();
    })();
</script>
@endpush

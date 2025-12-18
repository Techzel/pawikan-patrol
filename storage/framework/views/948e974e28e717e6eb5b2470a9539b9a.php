

<?php $__env->startSection('title', 'Ocean Guardian - Defense Game'); ?>

<?php $__env->startPush('styles'); ?>
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
        transform: scale(1.2);
        box-shadow: 0 0 10px rgba(34, 211, 238, 0.5);
    }

    .animate-float { animation: float 6s ease-in-out infinite; }
    @keyframes float { 0%,100%{transform:translateY(0);} 50%{transform:translateY(-20px);} }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div id="pawikan-game-container" class="min-h-screen text-white overflow-hidden selection:bg-ocean-500 selection:text-white relative">
    <!-- Background (CSS fallback / Main Design) -->
    <div class="fixed inset-0 z-0 bg-gradient-to-b from-ocean-800 to-deep-900"></div>
    
    <!-- Game Activity Script -->
    <script src="<?php echo e(asset('js/game-activity.js')); ?>"></script>
    
    <!-- Audio Elements -->
    <audio id="bg-music" loop>
        <source src="<?php echo e(asset('audio/ocean-bg.mp3')); ?>" type="audio/mpeg">
    </audio>
    <audio id="click-sound">
        <source src="<?php echo e(asset('audio/click sa puzzle ug matching.mp3')); ?>" type="audio/mpeg">
    </audio>
    <audio id="congratulations-sound">
        <source src="<?php echo e(asset('audio/ma complete ang task.mp3')); ?>" type="audio/mpeg">
    </audio>
    <audio id="wrong-sound">
        <source src="<?php echo e(asset('audio/wrong.mp3')); ?>" type="audio/mpeg">
    </audio>
    <audio id="warning-audio">
        <source src="<?php echo e(asset('audio/warning.mp3')); ?>" type="audio/mpeg">
    </audio>

    <!-- Back Button -->
    <div class="fixed top-24 left-4 z-50 mb-4">
        <a href="<?php echo e(route('games.index')); ?>" onclick="window.showPageLoader()" class="bg-deep-800/80 p-2 rounded-full border border-ocean-500/30 text-ocean-300 hover:bg-ocean-900/80 transition-all shadow-md backdrop-blur-sm flex items-center justify-center group" title="Back to Games">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
    </div>

    <!-- Music Control with Volume -->
    <div class="fixed bottom-8 left-4 z-50 group">
        <div class="flex items-center gap-2 bg-deep-800/80 rounded-full border border-ocean-500/30 backdrop-blur-sm shadow-lg p-2 transition-all duration-300">
            <button id="music-toggle" class="p-2 text-ocean-300 hover:text-ocean-400 transition-colors">
                <span id="music-icon">🔇</span>
            </button>
            
            <!-- Volume Slider (appears on hover) -->
            <div class="overflow-hidden transition-all duration-300 w-0 group-hover:w-32 opacity-0 group-hover:opacity-100">
                <div class="flex items-center gap-2 pr-2">
                    <input type="range" id="volume-slider" min="0" max="100" value="70" 
                        class="w-full h-1 bg-ocean-900/50 rounded-lg appearance-none cursor-pointer slider">
                    <span id="volume-percent" class="text-xs text-ocean-400 font-bold w-8">70%</span>
                </div>
            </div>
        </div>
    </div>

    <style>
        .turbo-progress-bar { visibility: hidden !important; display: none !important; }
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
            transform: scale(1.2);
            box-shadow: 0 0 10px rgba(34, 211, 238, 0.5);
        }
    </style>

    <!-- Main Content & Game Layer (Fullscreen) -->
    <div class="fixed inset-0 z-10 w-full h-full">
        <!-- Canvas -->
        <canvas id="gameCanvas" class="block w-full h-full cursor-pointer outline-none"></canvas>

        <!-- Floating UI Layer -->
        <div class="absolute inset-0 pointer-events-none flex flex-col justify-between px-4 pb-2 pt-24 md:px-8 md:pb-8 md:pt-32 z-20">
            
            <!-- Top Bar -->
            <div class="flex flex-row justify-center md:justify-between items-start w-full relative">
                <!-- Header (Hidden on Mobile) -->
                <div class="pointer-events-auto pl-14 hidden md:block">
                    <h1 class="text-2xl md:text-4xl font-bold text-white font-poppins drop-shadow-[0_0_10px_rgba(74,222,128,0.5)] leading-tight">
                        Ocean<br class="hidden md:block"> Guardian
                    </h1>
                    <p class="text-green-100/70 font-poppins text-[10px] md:text-xs mt-1 max-w-[150px] md:max-w-none uppercase tracking-widest">Defend the Turtle</p>
                </div>

                <!-- Stats HUD (Horizontal on Mobile, Vertical on Desktop) -->
                <div id="gameHUD" class="flex flex-row md:flex-col gap-2 items-start md:items-end pointer-events-auto mx-auto md:mx-0">
                    
                    <!-- Status Group -->
                    <div class="bg-black/40 backdrop-blur-md rounded-2xl border border-white/10 shadow-lg flex flex-col overflow-hidden w-28 md:w-32 transform transition-all hover:scale-105">
                        <div class="px-3 py-1.5 border-b border-white/10 flex justify-between items-center bg-white/5">
                            <span class="text-xs md:text-base">⭐</span> 
                            <span id="levelDisplay" class="font-poppins text-[10px] md:text-xs font-bold text-white tracking-widest">EASY</span>
                        </div>
                        <div class="px-3 py-1.5 flex justify-between items-center">
                            <span class="text-xs md:text-base">❤️</span> 
                            <span id="healthDisplay" class="font-poppins text-xs md:text-sm font-bold text-green-400">100</span>
                        </div>
                    </div>

                    <!-- Progress Group -->
                    <div class="bg-black/40 backdrop-blur-md rounded-2xl border border-white/10 shadow-lg flex flex-col overflow-hidden w-28 md:w-32 transform transition-all hover:scale-105">
                        <div class="px-3 py-1.5 border-b border-white/10 flex justify-between items-center bg-white/5">
                            <span class="text-xs md:text-base text-green-400">🗑️</span> 
                            <span id="scoreDisplay" class="font-poppins text-xs md:text-sm font-bold text-white">0/50</span>
                        </div>
                        <div class="px-3 py-1.5 flex justify-between items-center">
                            <span class="text-xs md:text-base">⏱️</span> 
                            <span id="timerDisplay" class="font-poppins text-xs md:text-sm font-bold text-white">00:00</span>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Bottom Bar (Controls & Info) -->
            <div class="flex flex-col items-center gap-3 pointer-events-auto pb-1 w-full">
                <!-- In-Game Difficulty Control -->
                <div class="flex gap-2 bg-black/20 backdrop-blur-md p-1 md:p-1.5 rounded-xl border border-white/10 shadow-lg max-w-full overflow-x-auto">
                    <button id="hud-btn-easy" onclick="startGame('easy')" class="px-3 py-1 md:px-4 md:py-1.5 rounded-lg text-[10px] md:text-xs font-bold font-poppins transition-all bg-green-600 text-white border border-green-400">
                        EASY
                    </button>
                    <button id="hud-btn-medium" onclick="startGame('medium')" class="px-3 py-1 md:px-4 md:py-1.5 rounded-lg text-[10px] md:text-xs font-bold font-poppins transition-all bg-transparent text-white/50 border border-white/5 cursor-not-allowed flex items-center gap-1" disabled>
                        MEDIUM <span>🔒</span>
                    </button>
                    <button id="hud-btn-hard" onclick="startGame('hard')" class="px-3 py-1 md:px-4 md:py-1.5 rounded-lg text-[10px] md:text-xs font-bold font-poppins transition-all bg-transparent text-white/50 border border-white/5 cursor-not-allowed flex items-center gap-1" disabled>
                        HARD <span>🔒</span>
                    </button>
                </div>

                <?php if(auth()->guard()->check()): ?>
                <div class="bg-black/20 backdrop-blur-sm px-4 py-1 rounded-full border border-white/10 text-[10px] text-green-100/80 mt-1">
                    Guardian: <?php echo e(Auth::user()->name); ?>

                </div>
                <?php endif; ?>
            </div>

            <!-- Main Start Button (Centered) -->
            <div id="mainStartContainer" class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 pointer-events-auto z-30 w-full flex justify-center px-4">
                <button onclick="playClickSound(); startGame(currentLevel)" class="group relative px-6 py-3 md:px-10 md:py-5 bg-green-600 rounded-2xl font-bold text-white text-lg md:text-xl overflow-hidden shadow-[0_0_30px_rgba(72,187,120,0.5)] transition-all hover:bg-green-500 hover:shadow-[0_0_50px_rgba(72,187,120,0.7)] border border-white/20 whitespace-nowrap">
                    <span class="relative z-10 font-poppins tracking-widest">START DEFENSE</span>
                    <div class="absolute inset-0 bg-white/20 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </button>
            </div>
        </div>



        <!-- Game Over Overlay -->
        <!-- Game Result Modal -->
        <div id="gameOverScreen" class="absolute inset-0 flex items-center justify-center bg-black/80 backdrop-blur-sm z-50 hidden transition-opacity duration-300">
            <div class="bg-gray-900 border border-white/10 p-6 rounded-2xl max-w-sm w-[90%] text-center relative overflow-hidden">
                
                <div id="resultIcon" class="text-5xl mb-3">💔</div>
                <h2 id="resultTitle" class="text-xl font-bold text-white mb-2 font-poppins tracking-wider uppercase">Mission Failed</h2>
                
                <div class="bg-white/5 rounded-lg p-4 mb-5 border border-white/5">
                    <div class="grid grid-cols-2 gap-2 mt-2">
                        <div class="text-center">
                            <p class="text-[10px] text-gray-400 font-poppins uppercase tracking-widest">Time</p>
                            <span id="finalTime" class="font-poppins text-xl font-bold text-ocean-300">00:00</span>
                        </div>
                        <div class="text-center">
                            <p class="text-[10px] text-gray-400 font-poppins uppercase tracking-widest">Score</p>
                            <span id="finalScore" class="font-poppins text-xl font-bold text-white">0</span>
                        </div>
                    </div>
                    <p class="text-[10px] text-gray-500 mt-3 font-poppins uppercase tracking-wider" id="difficultyLabel">LEVEL: -</p>
                </div>
                
                <div class="flex flex-col gap-3">
                    <button id="actionBtn" onclick="startGame(currentLevel)" class="w-full py-3 bg-green-600 hover:bg-green-500 text-white rounded-xl font-bold font-poppins transition-all shadow-lg hover:shadow-green-500/25 border border-white/10">
                        Try Again
                    </button>
                    <a href="<?php echo e(route('games.index')); ?>" onclick="window.showPageLoader()" class="w-full py-3 bg-transparent border border-white/10 text-gray-400 hover:bg-white/5 hover:text-white rounded-xl font-bold font-poppins transition-all text-sm">
                        Exit
                    </a>
                </div>
                
                <div id="saveStatus" class="mt-4 h-4 text-xs font-poppins text-gray-500"></div>
            </div>
        </div>
        
        <!-- Guest Mode Modal --> 

        <!-- Guest Mode Modal (Animated) --> 
        <?php if(auth()->guard()->guest()): ?>
        <div id="guest-modal" class="absolute inset-0 z-[100] flex items-center justify-center bg-black/90 backdrop-blur-md transition-all duration-700 ease-out hidden pointer-events-auto cursor-default"> <!-- Start with background effect -->
            <div id="guest-modal-content" class="bg-deep-900 border border-red-500/30 p-8 rounded-2xl max-w-md w-full text-center shadow-2xl relative transform scale-75 opacity-0 transition-all duration-700 ease-out">
                <button onclick="window.showPageLoader(); window.location.href = '<?php echo e(route('games.index')); ?>'" class="absolute top-4 right-4 text-gray-400 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                
                <div class="text-5xl mb-4">⚠️</div>
                <h2 class="text-2xl font-bold text-white mb-2 font-poppins tracking-wider">GUEST MODE</h2>
                <p class="text-gray-300 font-poppins text-sm mb-8 leading-relaxed">
                    If you do not login, the game will not be recorded.
                </p>
                
                <div class="flex flex-col gap-3">
                    <button onclick="openAuthModal('login')" class="w-full py-3.5 bg-ocean-600 hover:bg-ocean-500 text-white rounded-xl font-bold font-poppins transition-all shadow-lg text-lg">
                        Login Now
                    </button>
                    <button onclick="closeGuestModal()" class="w-full py-3.5 bg-transparent border border-gray-600 text-gray-400 hover:text-white hover:border-white rounded-xl font-bold font-poppins transition-all">
                        Play as Guest
                    </button>
                </div>
            </div>
        </div>
        <?php endif; ?>

    <!-- Game Activity Script -->
    <script src="<?php echo e(asset('js/game-activity.js')); ?>"></script>

    <!-- Scripts -->
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    (function() {
        const canvas = document.getElementById('gameCanvas');
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        // ... (rest of the game code remains inside the IIFE)
        
        // UI Refs
        const mainStartContainer = document.getElementById('mainStartContainer');
        const gameOverScreen = document.getElementById('gameOverScreen');
        const scoreDisplay = document.getElementById('scoreDisplay');
        const levelDisplay = document.getElementById('levelDisplay');
        const healthDisplay = document.getElementById('healthDisplay');
        const finalScore = document.getElementById('finalScore');
        const saveStatus = document.getElementById('saveStatus');
        const difficultyLabel = document.getElementById('difficultyLabel');
        const timerDisplay = document.getElementById('timerDisplay');

        // Music Controls
        const musicToggle = document.getElementById('music-toggle');
        const musicIcon = document.getElementById('music-icon');
        const volumeSlider = document.getElementById('volume-slider');
        const volumePercent = document.getElementById('volume-percent');
        const bgMusic = document.getElementById('bg-music');
        if (bgMusic) window.currentGameAudio = bgMusic;
        let isMusicPlaying = false;

        // Initialize Audio
        if (bgMusic) {
            bgMusic.volume = 0.7;
        }

        // Music Event Listeners
        if (musicToggle && bgMusic) {
            musicToggle.addEventListener('click', () => {
                if (bgMusic.paused) {
                    bgMusic.play().then(() => {
                        isMusicPlaying = true;
                        updateMusicIcon();
                    }).catch(e => console.log('Audio playback failed:', e));
                } else {
                    bgMusic.pause();
                    isMusicPlaying = false;
                    updateMusicIcon();
                }
            });

            // Precision Loop to hide MP3 gaps (User request: "continues looping effect")
            bgMusic.addEventListener('timeupdate', function() {
                // Return to start slightly before the technical end to hide silent trailing padding
                const buffer = 0.2; // 200ms
                if (this.currentTime > this.duration - buffer && this.loop) {
                    this.currentTime = 0;
                    this.play().catch(e => {});
                }
            });
        }

        if (volumeSlider && bgMusic) {
            volumeSlider.addEventListener('input', (e) => {
                const value = e.target.value;
                bgMusic.volume = value / 100;
                if (volumePercent) volumePercent.textContent = value + '%';
                updateMusicIcon();
            });
        }

        function updateMusicIcon() {
            if (!bgMusic || bgMusic.paused) {
                musicIcon.textContent = '🔇';
            } else {
                const vol = bgMusic.volume;
                if (vol === 0) musicIcon.textContent = '🔇';
                else if (vol < 0.5) musicIcon.textContent = '🔉';
                else musicIcon.textContent = '🔊';
            }
        }

        // State
        let gameActive = false;
        let score = 0;
        let health = 100;
        let difficulty = 1; // Internal ramping factor
        window.currentLevel = 'easy'; 
        
        let startTime;
        let timerInterval;
        let elapsedSeconds = 0;
        
        // Sound effect helper functions
        function playClickSound() {
            const clickSound = document.getElementById('click-sound');
            if (clickSound) {
                clickSound.currentTime = 0;
                clickSound.volume = 1.0;
                clickSound.play().catch(e => console.log('Click sound failed:', e));
            }
        }

        function playCorrectSound() {
            const sound = document.getElementById('click-sound'); // Use click sound for trash collection
            if (sound) {
                sound.currentTime = 0;
                sound.volume = 1.0;
                sound.play().catch(e => console.log('Correct sound failed:', e));
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
        
        // Progress Logic:
        // Guests: always restart/reset on refresh (Session only)
        // Users: save/load progress (Persistent)
        const isLoggedIn = <?php if(auth()->guard()->check()): ?> true <?php else: ?> false <?php endif; ?>;
        
        let unlockedLevels = ['easy']; // Default
        
        try {
            if (isLoggedIn) {
                const stored = localStorage.getItem('ocean_guardian_progress_v2');
                if (stored) {
                    const parsed = JSON.parse(stored);
                    if (Array.isArray(parsed)) {
                        unlockedLevels = parsed;
                    }
                }
            }
        } catch (e) {
            console.error("Error loading progress, resetting:", e);
            unlockedLevels = ['easy'];
        }
        
        // Final Safety Checks
        if (!Array.isArray(unlockedLevels)) unlockedLevels = ['easy'];
        if (!unlockedLevels.includes('easy')) unlockedLevels.push('easy');
        
        let frameCount = 0;
        let enemies = [];
        let particles = [];
        let animationId;
        
        // Dimensions & Assets
        let w, h, cx, cy;
        let scaleFactor = 1;
        const turtleImg = new Image();
        turtleImg.src = "<?php echo e(asset('img/hawksbill.png')); ?>";
        
        let rays = [];
        let bubbles = [];

        // Level Configuration
        const levelSettings = {
            'easy': { baseSpeed: 2.2, spawnRate: 60, label: 'EASY', img: "<?php echo e(asset('img/olive.png')); ?>", target: 50 },
            'medium': { baseSpeed: 3.5, spawnRate: 45, label: 'MEDIUM', img: "<?php echo e(asset('img/green.png')); ?>", target: 50 },
            'hard': { baseSpeed: 6.0, spawnRate: 25, label: 'HARD', img: "<?php echo e(asset('img/hawksbill.png')); ?>", target: 50 }
        };

        // Functions must be defined before use if locally scoped, but var is functional.
        // Let's rely on hoisting for functions, but data must be ready.

        function initBg() {
            rays = [];
            for(let i=0; i<6; i++) rays.push({
                x: Math.random() * w, width: 50+Math.random()*150, 
                speed: 0.001+Math.random()*0.002, angle: Math.random()*0.2-0.1, offset: Math.random()*Math.PI*2
            });
            bubbles = [];
            for(let i=0; i<25; i++) bubbles.push({
                x: Math.random()*w, y: Math.random()*h, 
                radius: 1+Math.random()*4, speed: 0.5+Math.random()*1.5
            });
        }

        // Initialize Buttons (Both Start Screen & HUD)
        function updateButtons() {
            const levels = ['easy', 'medium', 'hard'];
            levels.forEach(lvl => {
                // HUD Buttons
                const hudBtn = document.getElementById('hud-btn-' + lvl);
                
                // Start Screen Buttons (Moved or Removed in new UI, so check existence)
                const btn = document.getElementById('btn-' + lvl);
                const lock = document.getElementById('lock-' + lvl);
                
                const isUnlocked = unlockedLevels.includes(lvl);
                
                // Update Start Screen Buttons (if they exist)
                if(btn && lvl !== 'easy') {
                    if(isUnlocked) {
                        btn.disabled = false;
                        btn.classList.remove('grayscale');
                        if(lock) lock.style.display = 'none';
                    } else {
                        btn.disabled = true;
                        btn.classList.add('grayscale');
                        if(lock) lock.style.display = 'inline';
                    }
                }

                // Update HUD
                if (hudBtn) {
                     if (isUnlocked) {
                        hudBtn.disabled = false;
                        hudBtn.classList.remove('cursor-not-allowed', 'bg-transparent', 'text-white/50', 'border-white/5');
                        hudBtn.innerHTML = lvl.toUpperCase();
                        
                        // Apply specific colors based on level type if unlocked but inactive
                        if (currentLevel === lvl) {
                            applyActiveStyle(hudBtn, lvl);
                        } else {
                            applyInactiveStyle(hudBtn, lvl);
                        }
                    } else {
                        hudBtn.disabled = true;
                        hudBtn.className = "px-3 py-1 md:px-4 md:py-1.5 rounded-lg text-[10px] md:text-xs font-bold font-poppins transition-all bg-transparent text-white/50 border border-white/5 cursor-not-allowed flex items-center gap-1";
                        hudBtn.innerHTML = lvl.toUpperCase() + ' <span>🔒</span>';
                    }
                }
            });
        }

        function applyActiveStyle(btn, lvl) {
            btn.className = "px-3 py-1 md:px-4 md:py-1.5 rounded-lg text-[10px] md:text-xs font-bold font-poppins transition-all border shadow-[0_0_15px_rgba(72,187,120,0.4)] bg-green-600 text-white border-green-400";
        }

        function applyInactiveStyle(btn, lvl) {
            btn.className = "px-3 py-1 md:px-4 md:py-1.5 rounded-lg text-[10px] md:text-xs font-bold font-poppins transition-all bg-transparent text-gray-400 border border-white/10 opacity-70 hover:opacity-100 hover:text-white hover:border-white/30";
        }
        
        function resize() {
            w = canvas.width = window.innerWidth;
            h = canvas.height = window.innerHeight;
            cx = w / 2;
            // Shift down slightly on mobile to account for top UI/Stats
            cy = h / 2 + (w < 768 ? 50 : 0);
            scaleFactor = w < 768 ? 0.6 : 1;
            
            if(!gameActive) {
               // Only assume ready if initBg ran once? 
               // InitBg relies on W/H, so we call it here if needed or simpler:
               if(rays.length === 0) initBg(); 
               drawIdle(); 
            }
        }
        window.addEventListener('resize', resize);
        
        turtleImg.onload = () => { if(!gameActive) drawIdle(); };

        // Initial setup calls
        updateButtons();
        resize();
        initBg();

        const trashTypes = ['🥤', '🥡', '🛍️', '🕸️', '🚬', '🍾', '🧴', '🧃', '🛢️', '👟', '🛞', '🥫'];

        // Entities
        class Entity {
            constructor(x, y, dx, dy, type) {
                this.x = x; this.y = y;
                this.dx = dx; this.dy = dy;
                this.type = type;
                this.radius = 45; // Base radius
                this.angle = 0;
                this.spin = (Math.random()-0.5)*0.08;
            }
            update() {
                this.x += this.dx;
                this.y += this.dy;
                // Optional: Gravitate slightly if missed? No, keep simple.
                this.angle += this.spin;
            }
            draw(ctx) {
                ctx.save();
                ctx.translate(this.x, this.y);
                ctx.rotate(this.angle);
                ctx.scale(scaleFactor, scaleFactor);
                
                // Visibility: Solid White Outline + Full Opacity
                ctx.textAlign = "center";
                ctx.textBaseline = "middle";
                ctx.font = "bold 50px Poppins, sans-serif";
                
                // Outline
                ctx.lineWidth = 3;
                ctx.strokeStyle = "white";
                ctx.strokeText(this.type, 0, 5);
                
                // Fill (Original Opacity)
                ctx.fillStyle = "white"; // Emoji color is inherent, but style needed for some browsers
                ctx.fillText(this.type, 0, 5);
                
                ctx.restore();
            }
        }

        // Logic
        function spawnEnemy(overrideEdge = null) {
            // Spawn outside bounds
            let x, y;
            const buffer = 100;
            const edge = overrideEdge !== null ? overrideEdge : Math.floor(Math.random() * 4);
            if(edge === 0) { x = Math.random()*w; y = -buffer; } // Top
            else if(edge === 1) { x = w+buffer; y = Math.random()*h; } // Right
            else if(edge === 2) { x = Math.random()*w; y = h+buffer; } // Bottom
            else { x = -buffer; y = Math.random()*h; } // Left

            const angle = Math.atan2(cy - y, cx - x);
            
            // Speed Calculation: Base + (Ramping * LevelMultiplier)
            const settings = levelSettings[currentLevel];
            const mobileFactor = window.innerWidth < 768 ? 0.8 : 1;
            const ramp = 1 + (difficulty * 0.1); 
            
            const speed = settings.baseSpeed * ramp * mobileFactor;
            
            const dx = Math.cos(angle) * speed;
            const dy = Math.sin(angle) * speed;
            
            const type = trashTypes[Math.floor(Math.random()*trashTypes.length)];
            enemies.push(new Entity(x, y, dx, dy, type));
        }

        // Interaction State
        let isMouseDown = false;
        let pX = 0, pY = 0;

        // Mouse Events
        canvas.addEventListener('mousedown', e => {
            isMouseDown = true;
            pX = e.clientX;
            pY = e.clientY;
            checkHit(pX, pY);
        });
        
        window.addEventListener('mouseup', () => isMouseDown = false);
        
        canvas.addEventListener('mousemove', e => {
            pX = e.clientX;
            pY = e.clientY;
            
            if(gameActive && isMouseDown) {
                checkHit(pX, pY);
            }

            // Hover Cursor Effect
            if(!gameActive) return;
            let hovering = false;
            for(let i = enemies.length-1; i >= 0; i--) {
                const en = enemies[i];
                const dist = Math.hypot(en.x - e.clientX, en.y - e.clientY);
                if(dist < (en.radius * scaleFactor) + 30) {
                    hovering = true;
                    en.hovered = true;
                    break;
                } else {
                    en.hovered = false;
                }
            }
            canvas.style.cursor = hovering ? 'pointer' : 'crosshair';
        });

        // Touch Events
        canvas.addEventListener('touchstart', e => {
            e.preventDefault();
            isMouseDown = true;
            for(let i=0; i<e.touches.length; i++) {
                checkHit(e.touches[i].clientX, e.touches[i].clientY);
            }
        }, {passive: false});

        canvas.addEventListener('touchmove', e => {
            e.preventDefault();
            if(!gameActive) return;
            for(let i=0; i<e.touches.length; i++) {
                checkHit(e.touches[i].clientX, e.touches[i].clientY);
            }
        }, {passive: false});

        window.addEventListener('touchend', () => isMouseDown = false);

        function checkHit(inputX, inputY) {
            if(!gameActive) return;
            for(let i = enemies.length-1; i >= 0; i--) {
                const e = enemies[i];
                const dist = Math.hypot(e.x - inputX, e.y - inputY);
                if(dist < (e.radius * scaleFactor) + 30) {
                    createParticles(e.x, e.y, 12, '#cbd5e1');
                    enemies.splice(i, 1);
                    score++;
                    scoreDisplay.textContent = score + '/50';
                    playCorrectSound();
                    if(score % 10 === 0) difficulty++;
                    
                    // Win Condition
                    if(score >= levelSettings[currentLevel].target) {
                        levelComplete();
                    }
                    return; // Hit one at a time per check
                }
            }
        }

        function gameLoop() {
            if(!gameActive) return;
            ctx.clearRect(0,0,w,h); // Clear canvas (transparent)

            // Continuous Hit Check (for holding mouse still)
            if(isMouseDown) {
                checkHit(pX, pY);
            }

            drawBackground(ctx); // Rays/Bubbles overlay

            drawTurtle(ctx);     // Center Character

            // Spawn
            frameCount++;
            // Non-stop intensity with side-by-side clusters
            const currentSpawnRate = Math.max(12, levelSettings[currentLevel].spawnRate - (difficulty * 2));
            if(frameCount % currentSpawnRate === 0) {
                // Spawn a pair (side by side) from a random edge
                const edge = Math.floor(Math.random() * 4);
                spawnEnemy(edge);
                spawnEnemy(edge);
            }

            // Update
            for(let i=0; i<enemies.length; i++) {
                const e = enemies[i];
                e.update();
                e.draw(ctx);
                
                // Hit Center
                if(Math.hypot(e.x - cx, e.y - cy) < 90 * scaleFactor) {
                    health -= 20;
                    healthDisplay.textContent = health;
                    enemies.splice(i, 1);
                    i--;
                    createParticles(cx, cy, 20, '#ef4444');
                    playWrongSound();
                    // Critical hit shake could go here
                    if(health <= 0) endGame();
                }
            }
            updateParticles(ctx);
            animationId = requestAnimationFrame(gameLoop);
        }

        function drawBackground(ctx) {
            // Draw Rays
            ctx.save();
            ctx.globalCompositeOperation = 'overlay';
            for(let ray of rays) {
                let targetAngle = Math.sin(frameCount * ray.speed + ray.offset) * 0.1;
                let rayGrd = ctx.createLinearGradient(ray.x, 0, ray.x + Math.tan(targetAngle)*h, h);
                rayGrd.addColorStop(0, "rgba(255, 255, 255, 0.1)");
                rayGrd.addColorStop(1, "rgba(255, 255, 255, 0)");
                
                ctx.fillStyle = rayGrd;
                ctx.beginPath();
                ctx.moveTo(ray.x - ray.width/2, 0);
                ctx.lineTo(ray.x + ray.width/2, 0);
                ctx.lineTo(ray.x + Math.tan(targetAngle)*h*1.5 + ray.width, h);
                ctx.lineTo(ray.x + Math.tan(targetAngle)*h*1.5 - ray.width, h);
                ctx.fill();
            }
            ctx.restore();
            
            // Bubbles
            ctx.fillStyle = "rgba(255, 255, 255, 0.1)";
            for(let b of bubbles) {
                b.y -= b.speed;
                if(b.y < -10) { b.y = h+10; b.x = Math.random()*w; }
                ctx.beginPath(); ctx.arc(b.x, b.y, b.radius, 0, Math.PI*2); ctx.fill();
            }
        }

        function createParticles(x,y,c,col) {
            for(let i=0;i<c;i++) particles.push({x,y,vx:(Math.random()-.5)*6,vy:(Math.random()-.5)*6,life:1,color:col});
        }
        function updateParticles(ctx) {
            for(let i=0;i<particles.length;i++) {
                let p=particles[i]; p.x+=p.vx; p.y+=p.vy; p.life-=0.03;
                ctx.globalAlpha=p.life; ctx.fillStyle=p.color; ctx.fillRect(p.x,p.y,4,4);
                ctx.globalAlpha=1;
                if(p.life<=0){particles.splice(i,1);i--;}
            }
        }

        function drawTurtle(ctx) {
            ctx.save();
            ctx.translate(cx, cy);
            
            // Scale everything based on mobile factor
            ctx.scale(scaleFactor, scaleFactor);
            
            const glowSize = 90 + Math.sin(frameCount*0.05)*10;
            // Shield Color: White/Green Logic
            // High health = Green/White, Low Health = Fade out or slight tint
            // Let's keep it simple green intensity
            const opacity = 0.1 + (health/100)*0.3;
            const healthColor = `rgba(74, 222, 128, ${opacity})`; // Green-400ish
            
            let grd = ctx.createRadialGradient(0,0,50,0,0,glowSize);
            grd.addColorStop(0, "rgba(255,255,255,0)");
            grd.addColorStop(0.6, healthColor);
            grd.addColorStop(1, "rgba(255,255,255,0)");
            ctx.fillStyle = grd;
            ctx.beginPath(); ctx.arc(0,0,glowSize,0,Math.PI*2); ctx.fill();

            // Image
            const scale = 1 + Math.sin(frameCount*0.04)*0.02;
            ctx.scale(scale, scale);
            if(turtleImg.complete) ctx.drawImage(turtleImg, -80, -80, 160, 160);
            else { ctx.fillStyle='#22c55e'; ctx.beginPath(); ctx.arc(0,0,60,0,Math.PI*2); ctx.fill(); }
            
            ctx.restore();
        }

        function drawIdle() {
            if(gameActive) return;
            ctx.clearRect(0,0,w,h);
            drawBackground(ctx);
            // drawTurtle(ctx); // Hidden until start
            frameCount++; // Keep animations alive (breathing/glow)
            requestAnimationFrame(drawIdle);
        }

        window.startGame = function(level) {
            console.log('Starting game level:', level);
            
            // Failsafe: Always allow easy
            if (level === 'easy') {
                if (!Array.isArray(unlockedLevels)) unlockedLevels = ['easy'];
                if (!unlockedLevels.includes('easy')) unlockedLevels.push('easy');
            }

            if(!unlockedLevels.includes(level)) {
                console.warn('Level locked:', level);
                return; 
            }
            
            if(level) {
                currentLevel = level;
                // Update Turtle Image for Level
                if (levelSettings[level]) {
                    turtleImg.src = levelSettings[level].img;
                    if(levelDisplay) levelDisplay.textContent = levelSettings[level].label; 
                }
                updateButtons(); // Refresh HUD states
            }
            
            if(mainStartContainer) mainStartContainer.classList.add('hidden');
            if(gameOverScreen) gameOverScreen.classList.add('hidden');
            
            const hud = document.getElementById('gameHUD');
            if(hud) {
                hud.classList.remove('hidden');
                hud.style.display = ''; // Clear inline style
            }
            
            
            if(!gameActive) {
                gameActive = true;
                score=0; health=100; difficulty=1; enemies=[];
                scoreDisplay.textContent='0/50'; healthDisplay.textContent='100';
                if(saveStatus) saveStatus.innerHTML = ''; // Clear status
                resize(); initBg();
                
                // Start Timer
                startTime = Date.now();
                elapsedSeconds = 0;
                timerDisplay.textContent = "00:00.00";
                clearInterval(timerInterval);
                timerInterval = setInterval(updateTimer, 10); // Update frequently for ms
                
                gameLoop();
                
                // Start background music (if not already playing)
                if (bgMusic && bgMusic.paused) {
                    bgMusic.play().then(() => {
                        isMusicPlaying = true;
                        updateMusicIcon();
                    }).catch(e => console.log('Background music autoplay prevented:', e));
                }
            }
        }
        
        function updateTimer() {
            if(!gameActive) return;
            const now = Date.now();
            const diffInMs = now - startTime;
            elapsedSeconds = diffInMs / 1000;
            
            const m = Math.floor(elapsedSeconds / 60);
            const s = Math.floor(elapsedSeconds % 60);
            const ms = Math.floor((elapsedSeconds - Math.floor(elapsedSeconds)) * 100);
            
            timerDisplay.textContent = 
                (m < 10 ? '0' + m : m) + ':' + 
                (s < 10 ? '0' + s : s) + '.' + 
                (ms < 10 ? '0' + ms : ms);
        }

        function levelComplete() {
            gameActive = false;
            cancelAnimationFrame(animationId);
            clearInterval(timerInterval);
            
            // Unlock Next
            let nextLevel = '';
            if(currentLevel === 'easy') nextLevel = 'medium';
            else if(currentLevel === 'medium') nextLevel = 'hard';
            
            if(nextLevel && !unlockedLevels.includes(nextLevel)) {
                unlockedLevels.push(nextLevel);
                if(isLoggedIn) {
                    localStorage.setItem('ocean_guardian_progress_v2', JSON.stringify(unlockedLevels));
                }
            }
            
            // Stop background music
            if (bgMusic) {
                bgMusic.pause();
                isMusicPlaying = false;
                updateMusicIcon();
            }
            
            // Show Success Screen
            finalScore.textContent = score + '/50';
            document.getElementById('finalTime').textContent = timerDisplay.textContent;
            difficultyLabel.textContent = "COMPLETED: " + levelSettings[currentLevel].label;
            
            const title = document.getElementById('resultTitle');
            const icon = document.getElementById('resultIcon');
            const btn = document.getElementById('actionBtn');
            
            title.textContent = "Congratulations!";
            title.className = "text-xl font-bold text-green-400 mb-2 font-poppins tracking-wider uppercase drop-shadow-md";
            
            icon.textContent = "🛡️";
            btn.textContent = nextLevel ? "Next Level" : "Play Again";
            btn.className = "w-full py-3 bg-green-600 hover:bg-green-500 text-white rounded-xl font-bold font-poppins transition-all shadow-lg hover:shadow-green-500/25 border border-white/10";
            btn.onclick = () => {
                updateButtons();
                if(nextLevel) startGame(nextLevel);
                else startGame('hard');
            };

            gameOverScreen.classList.remove('hidden');
            
            // Play congratulations sound
            playCongratsSound();
            

            saveGame(elapsedSeconds);
        }

        function endGame() {
            gameActive = false;
            cancelAnimationFrame(animationId);
            
            // Stop background music
            if (bgMusic) {
                bgMusic.pause();
                isMusicPlaying = false;
                updateMusicIcon();
            }
            finalScore.textContent = score + '/50';
            document.getElementById('finalTime').textContent = timerDisplay.textContent;
            difficultyLabel.textContent = "LEVEL: " + levelSettings[currentLevel].label;
            
            // Clear previous save status so "Game Saved" doesn't show on failure
            if(saveStatus) saveStatus.innerHTML = '';

            const title = document.getElementById('resultTitle');
            const icon = document.getElementById('resultIcon');
            const btn = document.getElementById('actionBtn');
            
            title.textContent = "Mission Failed";
            title.className = "text-xl font-bold text-white/80 mb-2 font-poppins tracking-wider uppercase drop-shadow-md";
            
            icon.textContent = "💔";
            btn.textContent = "Try Again";
            btn.className = "w-full py-3 bg-white/10 hover:bg-white/20 text-white rounded-xl font-bold font-poppins transition-all shadow-lg border border-white/10";
            btn.onclick = () => {
                startGame(currentLevel); // Immediately restart
            };

            gameOverScreen.classList.remove('hidden');
            mainStartContainer.classList.add('hidden'); // Ensure Start button stays hidden
            
            // Play game over sound
            playWrongSound();
            

            // saveGame(score); // Don't save failed attempts to time-based leaderboard
        }

        function saveGame(v) {
            <?php if(auth()->guard()->check()): ?>
            saveStatus.innerHTML = '<span class="animate-pulse text-yellow-300">Syncing...</span>';
            
            window.gameActivity.recordFindThePawikan(v, currentLevel)
            .then(d => {
                if(d && d.success) {
                    saveStatus.innerHTML = `
                        <p class="text-green-400 text-sm font-poppins flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Game saved successfully!
                        </p>
                    `;
                    // Trigger global update events
                    window.dispatchEvent(new CustomEvent('gameCompleted', {
                        detail: { gameType: 'find-the-pawikan', timeSpent: v, completed: true }
                    }));
                } else {
                    saveStatus.innerHTML = `
                        <p class="text-red-400 text-sm font-poppins flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Error saving game
                        </p>
                    `;
                }
            })
            .catch(e => {
                console.error(e);
                saveStatus.innerHTML='<span class="text-red-300">Offline</span>';
            });
            <?php else: ?>
            saveStatus.innerHTML = 'Login to rank up!';
            <?php endif; ?>
        }


        // Stop music when navigating away via Turbo
        const stopMusic = () => {
            if (bgMusic) {
                bgMusic.pause();
                isMusicPlaying = false;
            }
            document.removeEventListener('turbo:before-visit', stopMusic);
            document.removeEventListener('turbo:before-render', stopMusic);
            window.removeEventListener('beforeunload', stopMusic);
        };

        document.addEventListener('turbo:before-visit', stopMusic);
        document.addEventListener('turbo:before-render', stopMusic);
        window.addEventListener('beforeunload', stopMusic);

        // Guest Modal Animation & Sound
        <?php if(auth()->guard()->guest()): ?>
        document.addEventListener('turbo:load', function() {
            const guestModal = document.getElementById('guest-modal');
            const guestModalContent = document.getElementById('guest-modal-content');
            const warningAudio = document.getElementById('warning-audio');
            
            if (guestModal && guestModalContent) {
                guestModal.classList.remove('hidden'); // Make sure it's displayable first
                
                setTimeout(() => {
                    // Animate the content
                    guestModalContent.classList.remove('scale-75', 'opacity-0');
                    guestModalContent.classList.add('scale-100', 'opacity-100');
                    
                    // Play warning sound (matching Memory Match)
                    if (warningAudio) {
                        setTimeout(() => {
                            warningAudio.currentTime = 0;
                            warningAudio.play().catch(e => console.log('Warning audio autoplay prevented:', e));
                        }, 300);
                    }
                }, 100);
            }
        });

        window.closeGuestModal = function() {
            const guestModal = document.getElementById('guest-modal');
            const guestModalContent = document.getElementById('guest-modal-content');
            const warningAudio = document.getElementById('warning-audio');
            
            if (warningAudio) {
                warningAudio.pause();
                warningAudio.currentTime = 0;
            }
            
            if (guestModalContent) {
                guestModalContent.classList.remove('scale-100', 'opacity-100');
                guestModalContent.classList.add('scale-75', 'opacity-0');
            }
            
            if (guestModal) {
                guestModal.classList.remove('bg-black/90', 'backdrop-blur-md');
                guestModal.classList.add('bg-black/0', 'backdrop-blur-0');
                
                setTimeout(() => {
                    guestModal.remove();
                }, 700);
            }
        }
        <?php endif; ?>
    })();
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .animate-float { animation: float 6s ease-in-out infinite; }
    @keyframes float { 0%,100%{transform:translateY(0);} 50%{transform:translateY(-20px);} }
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rayver\Desktop\my_app\resources\views/games/find-the-pawikan.blade.php ENDPATH**/ ?>
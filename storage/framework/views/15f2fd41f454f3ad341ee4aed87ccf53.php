

<?php $__env->startSection('title', 'Pawikan Quiz - The Voyager Journey'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .journey-container {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        background: #0a0e27;
        height: calc(100vh - 80px);
        width: 100vw;
        overflow: hidden;
        position: relative;
        margin-top: 80px;
        color: white;
    }

    /* Animated Gradient Background */
    .journey-container::before {
        content: '';
        position: absolute;
        inset: 0;
        background: 
            radial-gradient(circle at 20% 50%, rgba(99, 102, 241, 0.15) 0%, transparent 50%),
            radial-gradient(circle at 80% 50%, rgba(168, 85, 247, 0.15) 0%, transparent 50%);
        animation: gradientShift 10s ease infinite;
        z-index: 1;
    }

    @keyframes gradientShift {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }

    /* Floating Orbs */
    .orb {
        position: absolute;
        border-radius: 50%;
        filter: blur(60px);
        opacity: 0.3;
        animation: float 20s infinite ease-in-out;
        z-index: 2;
    }

    .orb-1 {
        width: 400px;
        height: 400px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        top: -200px;
        left: -200px;
        animation-delay: 0s;
    }

    .orb-2 {
        width: 300px;
        height: 300px;
        background: linear-gradient(135deg, #ec4899, #8b5cf6);
        bottom: -150px;
        right: -150px;
        animation-delay: -10s;
    }

    @keyframes float {
        0%, 100% { transform: translate(0, 0) scale(1); }
        33% { transform: translate(30px, -30px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
    }

    /* Minimal HUD - Top Right Corner */
    .hud-minimal {
        position: fixed;
        top: 110px;
        right: 30px;
        display: flex;
        gap: 12px;
        z-index: 100;
    }

    .hud-item {
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(20px);
        padding: 12px 20px;
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        font-size: 0.875rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .hud-item:hover {
        background: rgba(15, 23, 42, 0.8);
        border-color: rgba(99, 102, 241, 0.5);
    }

    /* Progress Dots - Bottom Center */
    .progress-dots {
        position: fixed;
        bottom: 40px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 8px;
        z-index: 100;
    }

    .progress-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
    }

    .progress-dot.active {
        background: #6366f1;
        width: 24px;
        border-radius: 4px;
    }

    .progress-dot.completed {
        background: #10b981;
    }

    /* Main Card Container */
    .card-container {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 90%;
        max-width: 700px;
        z-index: 10;
        perspective: 1500px;
    }

    /* Quiz Card - Elegant & Minimal */
    .quiz-card-elegant {
        background: rgba(15, 23, 42, 0.4);
        backdrop-filter: blur(40px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 24px;
        padding: 50px 60px;
        box-shadow: 
            0 20px 60px rgba(0, 0, 0, 0.3),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
        transition: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
        position: relative;
        overflow: hidden;
    }

    /* Question Number Badge */
    .question-badge {
        display: inline-block;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 1px;
        margin-bottom: 24px;
        text-transform: uppercase;
    }

    /* Question Text - Large & Bold */
    .question-text {
        font-size: 2rem;
        font-weight: 700;
        line-height: 1.3;
        margin-bottom: 40px;
        color: #ffffff;
        letter-spacing: -0.02em;
        animation: slideInUp 0.6s ease-out;
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Answer Options - 2x2 Grid */
    .answers-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        margin-bottom: 0;
        transition: opacity 0.5s ease;
    }

    .answer-card {
        background: rgba(30, 41, 59, 0.4);
        border: 2px solid rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        padding: 28px 24px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        position: relative;
        overflow: hidden;
        min-height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .answer-card::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.1));
        opacity: 0;
        transition: opacity 0.3s;
    }

    .answer-card:hover:not(.disabled)::before {
        opacity: 1;
    }

    .answer-card:hover:not(.disabled) {
        transform: translateY(-4px) scale(1.02);
        border-color: rgba(99, 102, 241, 0.5);
        box-shadow: 0 12px 24px rgba(99, 102, 241, 0.2);
    }

    .answer-card.correct {
        background: rgba(16, 185, 129, 0.2);
        border-color: #10b981;
        animation: correctPulse 0.6s ease;
    }

    .answer-card.wrong {
        background: rgba(239, 68, 68, 0.2);
        border-color: #ef4444;
        animation: wrongShake 0.5s ease;
    }

    @keyframes correctPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    @keyframes wrongShake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-8px); }
        75% { transform: translateX(8px); }
    }

    .answer-text {
        font-size: 1.05rem;
        font-weight: 500;
        color: #e2e8f0;
        position: relative;
        z-index: 1;
    }

    /* Explanation Panel - Slides from bottom */
    .explanation-panel {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(15, 23, 42, 0.98), rgba(15, 23, 42, 0.95));
        backdrop-filter: blur(20px);
        padding: 32px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        transform: translateY(100%);
        transition: transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        border-radius: 0 0 24px 24px;
    }

    .explanation-panel.show {
        transform: translateY(0);
    }

    .explanation-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 16px;
    }

    .explanation-icon.correct {
        background: rgba(16, 185, 129, 0.2);
    }

    .explanation-icon.wrong {
        background: rgba(239, 68, 68, 0.2);
    }

    .explanation-title {
        font-size: 1.125rem;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .explanation-text {
        font-size: 0.9375rem;
        color: #94a3b8;
        line-height: 1.6;
        margin-bottom: 20px;
    }

    .next-btn {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: white;
        border: none;
        padding: 14px 32px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.9375rem;
        cursor: pointer;
        transition: all 0.3s ease;
        letter-spacing: 0.5px;
    }

    .next-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(99, 102, 241, 0.4);
    }

    /* Start Screen */
    .start-screen {
        text-align: center;
        animation: fadeIn 1s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .start-title {
        font-size: 4rem;
        font-weight: 900;
        margin-bottom: 16px;
        background: linear-gradient(135deg, #fff, #a5b4fc);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        letter-spacing: -0.03em;
    }

    .start-subtitle {
        font-size: 1.25rem;
        color: #94a3b8;
        margin-bottom: 48px;
        font-weight: 400;
    }

    .start-btn-elegant {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: white;
        border: none;
        padding: 18px 48px;
        border-radius: 14px;
        font-weight: 700;
        font-size: 1.125rem;
        cursor: pointer;
        transition: all 0.3s ease;
        letter-spacing: 0.5px;
        box-shadow: 0 12px 32px rgba(99, 102, 241, 0.3);
    }

    .start-btn-elegant:hover {
        transform: translateY(-3px);
        box-shadow: 0 16px 40px rgba(99, 102, 241, 0.4);
    }

    /* Result Screen */
    .result-screen {
        text-align: center;
    }

    .result-score {
        font-size: 5rem;
        font-weight: 900;
        background: linear-gradient(135deg, #10b981, #34d399);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 8px;
    }

    .result-max {
        font-size: 1.25rem;
        color: #64748b;
        margin-bottom: 16px;
        font-weight: 600;
    }

    .result-rank {
        font-size: 1.5rem;
        color: #94a3b8;
        margin-bottom: 40px;
    }

    /* Particles */
    .particle {
        position: fixed;
        pointer-events: none;
        z-index: 1000;
    }

    .particle.correct {
        animation: particleExplode 1s ease-out forwards;
    }

    @keyframes particleExplode {
        to {
            transform: translate(var(--tx), var(--ty)) scale(0);
            opacity: 0;
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .quiz-card-elegant {
            padding: 32px 24px;
        }
        .question-text {
            font-size: 1.5rem;
            margin-bottom: 32px;
        }
        .answers-grid {
            grid-template-columns: 1fr;
            gap: 12px;
        }
        .answer-card {
            padding: 20px;
            min-height: 80px;
        }
        .hud-minimal {
            top: 20px;
            right: 20px;
            gap: 8px;
        }
        .hud-item {
            padding: 8px 14px;
            font-size: 0.75rem;
        }
        .start-title {
            font-size: 2.5rem;
        }
        .result-score {
            font-size: 4rem;
        }
    }

    /* Fun Logo Animation */
    @keyframes swim-float {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        25% { transform: translateY(-15px) rotate(-5deg); }
        75% { transform: translateY(10px) rotate(5deg); }
    }

    @keyframes bubble-rise {
        0% { transform: translateY(20px) scale(0); opacity: 0; }
        50% { opacity: 0.8; }
        100% { transform: translateY(-100px) scale(1.5); opacity: 0; }
    }

    .fun-logo-container {
        position: relative;
        display: inline-block;
        width: 160px;
        height: 160px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }

    .fun-logo {
        font-size: 8rem;
        display: inline-block;
        animation: swim-float 4s ease-in-out infinite;
        filter: drop-shadow(0 20px 30px rgba(99, 102, 241, 0.4));
        position: relative;
        z-index: 10;
        cursor: default;
    }

    .fun-bubble {
        position: absolute;
        background: radial-gradient(circle at 30% 30%, rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.4));
        border-radius: 50%;
        pointer-events: none;
        box-shadow: 0 4px 10px rgba(255, 255, 255, 0.2);
    }
    
    .b1 { width: 15px; height: 15px; top: 20%; right: 10%; animation: bubble-rise 3s infinite 0.2s; }
    .b2 { width: 25px; height: 25px; top: 40%; left: 0%; animation: bubble-rise 4s infinite 1.5s; }
    .b3 { width: 10px; height: 10px; top: 0%; left: 20%; animation: bubble-rise 2.5s infinite 2.8s; }

</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <?php if(auth()->guard()->guest()): ?>
    <!-- Warning Audio -->
    <audio id="warning-audio">
        <source src="<?php echo e(asset('audio/warning.mp3')); ?>" type="audio/mpeg">
    </audio>
    
    <div id="guest-modal" class="fixed inset-0 z-[200] flex items-center justify-center bg-transparent backdrop-blur-0 transition-all duration-700 ease-out hidden">
        <div class="bg-[#0f172a] border border-red-500/30 p-8 rounded-2xl max-w-md w-full text-center shadow-2xl relative transform scale-75 opacity-0 transition-all duration-700 ease-out" id="guest-modal-content">
            <button onclick="window.location.href = '<?php echo e(route('games.index')); ?>'" class="absolute top-4 right-4 text-gray-400 hover:text-white transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <div class="text-5xl mb-4">⚠️</div>
            <h2 class="text-2xl font-bold text-white mb-2">
                Guest Mode
            </h2>
            <p class="text-gray-300 mb-8 font-poppins">
                If you do not login, your quiz score will not be recorded.
            </p>
            <div class="flex flex-col gap-3">
                <a href="#" onclick="event.preventDefault(); openAuthModal('login')" class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-3 px-6 rounded-xl transition-colors font-poppins w-full">
                    Login Now
                </a>
                <button onclick="closeGuestModal()" class="bg-transparent border border-gray-600 text-gray-400 hover:text-white hover:border-white font-bold py-3 px-6 rounded-xl transition-colors font-poppins w-full">
                    Play as Guest
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('turbo:load', function() {
            const warningAudio = document.getElementById('warning-audio');
            const guestModal = document.getElementById('guest-modal');
            const guestModalContent = document.getElementById('guest-modal-content');
            
            // Only run if we are actually on the quiz page (check for unique element)
            if (guestModal && guestModalContent && document.querySelector('.journey-container')) {
                guestModal.classList.remove('hidden');
                setTimeout(() => {
                    if (!document.body.contains(guestModal)) return;

                    guestModal.classList.remove('bg-transparent', 'backdrop-blur-0');
                    guestModal.classList.add('bg-black/90', 'backdrop-blur-md');
                    
                    guestModalContent.classList.remove('scale-75', 'opacity-0');
                    guestModalContent.classList.add('scale-100', 'opacity-100');
                    
                    if (warningAudio && document.body.contains(warningAudio)) {
                        setTimeout(() => {
                            if (document.body.contains(warningAudio)) {
                                warningAudio.volume = 0.5;
                                // Attempt play, handle potential autoplay restrictions
                                const playPromise = warningAudio.play();
                                if (playPromise !== undefined) {
                                    playPromise.catch(error => {
                                        console.log('Warning audio autoplay prevented:', error);
                                    });
                                }
                            }
                        }, 300);
                    }
                }, 100);
            }
        });
        
        // Clean up audio when navigating away
        document.addEventListener('turbo:before-visit', function() {
            const warningAudio = document.getElementById('warning-audio');
            if (warningAudio) {
                warningAudio.pause();
                warningAudio.currentTime = 0;
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
            
            if (guestModal) {
                guestModal.classList.remove('bg-black/90', 'backdrop-blur-md');
                guestModal.classList.add('bg-black/0', 'backdrop-blur-0');
                
                setTimeout(() => {
                    if (document.body.contains(guestModal)) {
                        guestModal.remove();
                        // Automatically show instructions after guest modal is closed
                        if (window.openInstructions) window.openInstructions();
                    }
                }, 700);
            }
        };
    </script>
    <?php endif; ?>

<div class="journey-container">
    <!-- Animated Background Orbs -->
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>

    <!-- Back Button & Instructions -->
    <div id="game-nav-container" style="position: fixed; top: 120px; left: 30px; z-index: 100; display: flex; gap: 12px; align-items: center;">
        <a href="<?php echo e(route('games.index')); ?>" onclick="window.showPageLoader()" 
           class="flex items-center gap-2 bg-black/20 backdrop-blur-md px-4 py-2 rounded-xl border border-white/10 text-white/70 hover:text-white hover:border-white/30 transition-all h-10">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span class="font-semibold text-sm">Back</span>
        </a>
        
        <button id="btn-how-to-play" onclick="openInstructions()" 
           class="flex items-center gap-2 bg-black/20 backdrop-blur-md px-4 py-2 rounded-xl border border-white/10 text-white/70 hover:text-white hover:border-white/30 transition-all h-10">
            <span class="text-lg leading-none">📜</span>
            <span class="font-semibold text-sm">How to Play</span>
        </button>
    </div>

    <!-- View Previous Results Button (Top Right) -->
    <?php if(auth()->guard()->check()): ?>
        <?php if(isset($lastQuiz) && $lastQuiz->metadata): ?>
            <div id="prev-results-btn" style="position: fixed; top: 110px; right: 30px; z-index: 100;">
                <button onclick="showHistory()" 
                   class="flex items-center gap-2 bg-gradient-to-r from-indigo-600/20 to-purple-600/20 backdrop-blur-md px-4 py-2 rounded-xl border border-indigo-500/30 text-indigo-300 hover:text-indigo-200 hover:border-indigo-400/50 transition-all shadow-lg hover:shadow-indigo-500/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="font-semibold text-sm">Previous Results</span>
                </button>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Minimal HUD -->
    <div class="hud-minimal" id="game-hud" style="display: none;">
        <div class="hud-item">
            <span>Question</span>
            <span id="idx-text" class="font-bold text-indigo-400">1</span>
            <span class="text-white/40">/</span>
            <span class="text-white/40">15</span>
        </div>
        <div class="hud-item">
            <span>🔥</span>
            <span id="streak-text" class="font-bold text-yellow-400">0</span>
        </div>
        <div class="hud-item" id="timer-badge">
            <span>⏱</span>
            <span id="clock-text" class="font-mono font-bold">10</span>
        </div>
    </div>

    <!-- Progress Dots -->
    <div class="progress-dots" id="progress-dots" style="display: none;"></div>

    <!-- Main Card Container -->
    <div class="card-container">
        
        <!-- START SCREEN -->
        <div id="start-view" class="start-screen">
            <div class="mb-12 fun-logo-container">
                <div class="fun-bubble b1"></div>
                <div class="fun-bubble b2"></div>
                <div class="fun-bubble b3"></div>
                <div class="fun-logo">🐢</div>
            </div>
            <h1 class="start-title">Pawikan Quiz</h1>
            <p class="start-subtitle">Test your knowledge about sea turtles</p>
            <div class="mb-6">
                <span class="inline-block bg-indigo-600/30 border border-indigo-500/50 px-6 py-2 rounded-full text-sm font-bold text-indigo-300">15 Questions • 10 Points Each</span>
            </div>

            <button onclick="beginVoyage()" class="start-btn-elegant">Start Quiz</button>
        </div>

        <!-- Instructions Modal -->
        <div id="instructions-modal" class="fixed inset-0 z-[150] flex items-center justify-center backdrop-blur-sm hidden">
            <div class="bg-gray-900 border border-indigo-500/30 p-8 rounded-2xl max-w-lg w-full text-center shadow-2xl relative transform scale-100 transition-all mx-4">
                <button onclick="document.getElementById('instructions-modal').classList.add('hidden'); window.speechSynthesis.cancel();" class="absolute top-4 right-4 text-gray-400 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                
                <div class="w-16 h-16 bg-indigo-500/20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="text-3xl">📜</span>
                </div>

                <div class="flex items-center justify-center gap-3 mb-6">
                    <h3 class="text-2xl font-bold text-white font-poppins">How to Play</h3>
                    <button onclick="readInstructions()" class="w-8 h-8 rounded-full bg-indigo-500/20 flex items-center justify-center text-indigo-400 hover:bg-indigo-500 hover:text-white transition-all transform hover:scale-110" title="Listen to Instructions">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                        </svg>
                    </button>
                </div>

                <div class="space-y-4 text-left bg-gray-800/50 p-6 rounded-xl border border-white/5">
                    <div class="flex items-start gap-4">
                        <div class="bg-indigo-500/20 text-indigo-300 rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold mt-0.5 flex-shrink-0">1</div>
                        <p class="text-gray-300 text-sm font-poppins leading-relaxed">Answer <strong>15 multiple-choice questions</strong> about sea turtle conservation.</p>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="bg-indigo-500/20 text-indigo-300 rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold mt-0.5 flex-shrink-0">2</div>
                        <p class="text-gray-300 text-sm font-poppins leading-relaxed">You have <strong>10 seconds</strong> per question. Speed matters!</p>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="bg-indigo-500/20 text-indigo-300 rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold mt-0.5 flex-shrink-0">3</div>
                        <p class="text-gray-300 text-sm font-poppins leading-relaxed">Select the correct answer to maintain your streak and earn points.</p>
                    </div>
                </div>

                <div class="mt-8">
                    <button onclick="document.getElementById('instructions-modal').classList.add('hidden'); window.speechSynthesis.cancel(); beginVoyage()" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-4 rounded-xl transition-all shadow-lg hover:shadow-indigo-500/30 transform hover:-translate-y-1 font-poppins">
                        Got it, Let's Start!
                    </button>
                </div>
            </div>
        </div>

        <!-- QUIZ SCREEN -->
        <div id="quiz-view" style="display: none;">
            <div class="quiz-card-elegant">
                <div class="question-badge" id="question-badge">Question 1</div>
                <h2 class="question-text" id="q-text">Loading question...</h2>
                
                <div class="answers-grid" id="opt-container">
                    <!-- Options injected here -->
                </div>

                <!-- Explanation Panel -->
                <div id="feedback-panel" class="explanation-panel">
                    <div id="feedback-icon-container"></div>
                    <h4 id="feedback-title" class="explanation-title">Did you know?</h4>
                    <div id="fact-text" class="explanation-text">Explanation goes here...</div>
                    <button onclick="nextStep()" class="next-btn">Continue →</button>
                </div>
            </div>
        </div>

        <!-- RESULT SCREEN -->
        <div id="result-view" class="result-screen" style="display: none;">
            <div class="quiz-card-elegant">
                <div class="result-score" id="final-pct">0 pts</div>
                <div class="result-max">out of 150 points</div>

                
                <div id="save-status" class="mb-6 text-emerald-400 font-semibold"></div>
                
                <div class="flex flex-col gap-3 items-center">
                    <button onclick="beginVoyage()" class="start-btn-elegant">Try Again</button>
                    <button onclick="openReview()" class="text-indigo-400 hover:text-indigo-300 transition font-medium">Review Answers</button>
                    <a href="<?php echo e(route('games.index')); ?>" class="text-gray-500 hover:text-white transition mt-2">Exit Quiz</a>
                </div>
            </div>
        </div>

        <!-- REVIEW SCREEN -->
        <div id="review-view" style="display: none;">
            <div class="quiz-card-elegant" style="max-height: 80vh; overflow-y: auto;">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-2xl font-bold">Review Answers</h2>
                    <button onclick="exitReview()" class="text-indigo-400 hover:text-indigo-300 transition font-semibold">Close</button>
                </div>
                <div id="logs-con" class="flex flex-col gap-4">
                    <!-- Logs injected here -->
                </div>
            </div>
        </div>

    </div>

    <!-- AUDIO -->
    <audio id="click-sfx" src="<?php echo e(asset('audio/click sa puzzle ug matching.mp3')); ?>" preload="auto"></audio>
    <audio id="success-sfx" src="<?php echo e(asset('audio/correct.mp3')); ?>" preload="auto"></audio>
    <audio id="error-sfx" src="<?php echo e(asset('audio/wrong.mp3')); ?>" preload="auto"></audio>
    <audio id="saved-sfx" src="<?php echo e(asset('audio/game-saved.mp3')); ?>" preload="auto"></audio>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('js/game-activity.js')); ?>"></script>
<script>
    // --- DATABASE ---
    const QUESTIONS = [
        { q: "How many sea turtle species are found in the Philippines?", o: ["Two", "Three", "Five", "Seven"], a: 2, e: "The Philippines is home to 5 of the 7 sea turtle species in the world." },
        { q: "Which turtle grazes on seagrass?", o: ["Green Sea Turtle", "Hawksbill", "Olive Ridley", "Leatherback"], a: 0, e: "Green Sea Turtles are vegetarians that love seagrass!" },
        { q: "Which species has a hawk-like beak?", o: ["Green Sea Turtle", "Hawksbill", "Loggerhead", "Flatback"], a: 1, e: "The Hawksbill is named for its sharp, curved beak." },
        { q: "Which species is famous for 'Arribada'?", o: ["Green Sea Turtle", "Hawksbill", "Olive Ridley", "Leatherback"], a: 2, e: "Olive Ridleys nest in massive synchronized groups!" },
        { q: "What is the primary reason sea turtles come ashore?", o: ["To sunbathe", "To lay eggs", "To find food", "To rest"], a: 1, e: "Female sea turtles come ashore only to lay their eggs in the sand." },
        { q: "How long is the incubation period?", o: ["20-30 days", "45-70 days", "90-100 days", "10-15 days"], a: 1, e: "Eggs incubate in the sand for about 2 months." },
        { q: "What determines a hatchling's gender?", o: ["Genetics", "Sand Temp", "Humidity", "Tides"], a: 1, e: "Hot chicks, cool dudes! Temperature controls sex." },
        { q: "When do hatchlings usually emerge?", o: ["Noon", "Morning", "Night", "Rain"], a: 2, e: "They emerge at night to avoid heat and predators." },
        { q: "What are the 'Lost Years'?", o: ["Old Age", "Ocean Drifting", "Hibernation", "Nesting"], a: 1, e: "Young turtles drift in the open ocean for years." },
        { q: "How long do 'Lost Years' last?", o: ["1-10 Years", "20-30 Years", "1 Month", "6 Months"], a: 0, e: "This drifting phase can last up to a decade." },
        { q: "Age of sea turtle adulthood?", o: ["5-10 yrs", "15-20 yrs", "20-50 yrs", "100 yrs"], a: 2, e: "They take a very long time to grow up!" },
        { q: "What looks like a jellyfish to turtles?", o: ["Seaweed", "Plastic Bags", "Fish", "Coral"], a: 1, e: "Plastic bags floating in water look exactly like jellies." },
        { q: "How do sea turtles navigate back to their birth beach?", o: ["Using landmarks", "Memory of smells", "Magnetic Field", "Following others"], a: 2, e: "Sea turtles use the Earth's magnetic field like a built-in compass." },
        { q: "Hatching success in protected nests?", o: ["20%", "40%", "80-90%", "100%"], a: 2, e: "Protection from predators and poachers boosts survival rates massively!" },
        { q: "Hatchlings per nest?", o: ["10-20", "50-200", "500+", "2-5"], a: 1, e: "A single nest can hold up to 200 eggs." }
    ];

    // --- LOGIC ---
    let currentPool = [];
    let curIdx = 0;
    let score = 0;
    let streak = 0;
    let logs = [];
    let timerInt;
    let timeRem = 10;
    let quizStart;
    let isHistReview = false;

    function play(id) {
        const el = document.getElementById(id);
        if(el) { el.currentTime=0; el.play().catch(()=>{}); }
    }

    // Particle Effects
    function createParticles(x, y, isCorrect) {
        const colors = isCorrect 
            ? ['#10b981', '#34d399', '#6ee7b7']
            : ['#ef4444', '#f87171', '#fca5a5'];
        
        for (let i = 0; i < 20; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle correct';
            particle.style.cssText = `
                left: ${x}px;
                top: ${y}px;
                width: ${Math.random() * 8 + 4}px;
                height: ${Math.random() * 8 + 4}px;
                background: ${colors[Math.floor(Math.random() * colors.length)]};
                border-radius: 50%;
                --tx: ${(Math.random() - 0.5) * 200}px;
                --ty: ${(Math.random() - 0.5) * 200}px;
            `;
            document.body.appendChild(particle);
            setTimeout(() => particle.remove(), 1000);
        }
    }

    // Update Progress Dots
    function updateProgressDots() {
        const dotsContainer = document.getElementById('progress-dots');
        dotsContainer.innerHTML = '';
        for (let i = 0; i < 15; i++) {
            const dot = document.createElement('div');
            dot.className = 'progress-dot';
            if (i < curIdx) dot.classList.add('completed');
            if (i === curIdx) dot.classList.add('active');
            dotsContainer.appendChild(dot);
        }
    }

    // -- Game Actions --
    function readInstructions() {
        if ('speechSynthesis' in window) {
            try {
                window.speechSynthesis.cancel(); // Stop any current speech

                const text = "Welcome to Pawikan Quiz! Here is how to play. You will answer 15 multiple choice questions about sea turtle conservation. You have 10 seconds to answer each question. Speed matters! Select the correct answer to maintain your streak and earn points. Good luck!";
                const utterance = new SpeechSynthesisUtterance(text);
                
                const triggerSpeech = () => {
                    // Try to find a male voice
                    const voices = window.speechSynthesis.getVoices();
                    const maleVoice = voices.find(voice => 
                        voice.name.includes('Male') || 
                        voice.name.includes('David') || 
                        voice.name.includes('Google US English')
                    );
                    
                    if (maleVoice) {
                        utterance.voice = maleVoice;
                    }
                    
                    utterance.rate = 1.0;
                    utterance.pitch = 1.0;
                    window.speechSynthesis.speak(utterance);
                };

                if (window.speechSynthesis.getVoices().length > 0) {
                    triggerSpeech();
                } else {
                    window.speechSynthesis.onvoiceschanged = triggerSpeech;
                }
            } catch (e) {
                console.error('Speech synthesis error:', e);
            }
        }
    }

    function beginVoyage() {
        window.speechSynthesis.cancel(); // Stop instructions if playing
        play('click-sfx');
        currentPool = [...QUESTIONS].sort(() => 0.5 - Math.random());
        curIdx = 0; score = 0; streak = 0; logs = [];
        quizStart = Date.now();
        isHistReview = false;

        document.getElementById('start-view').style.display = 'none';
        document.getElementById('result-view').style.display = 'none';
        document.getElementById('btn-how-to-play').style.display = 'none';
        
        // Hide previous results button if it exists
        const prevBtn = document.getElementById('prev-results-btn');
        if(prevBtn) prevBtn.style.display = 'none';
        
        document.getElementById('game-hud').style.display = 'flex';
        document.getElementById('progress-dots').style.display = 'flex';
        document.getElementById('quiz-view').style.display = 'block';
        
        loadInquiry();
    }

    function loadInquiry() {
        clearInterval(timerInt);
        timeRem = 10;
        document.getElementById('clock-text').textContent = timeRem;
        document.getElementById('feedback-panel').classList.remove('show');
        document.getElementById('opt-container').style.opacity = '1';
        document.getElementById('opt-container').style.pointerEvents = 'auto';
        
        const q = currentPool[curIdx];
        document.getElementById('idx-text').textContent = curIdx + 1;
        document.getElementById('streak-text').textContent = streak;
        document.getElementById('question-badge').textContent = `Question ${curIdx + 1}`;
        document.getElementById('q-text').textContent = q.q;

        const con = document.getElementById('opt-container');
        con.innerHTML = '';
        q.o.forEach((opt, i) => {
            const card = document.createElement('div');
            card.className = 'answer-card';
            card.innerHTML = `<div class="answer-text">${opt}</div>`;
            card.onclick = (e) => selectOpt(i, card, e);
            con.appendChild(card);
        });

        updateProgressDots();
        startClock();
    }

    function startClock() {
        timerInt = setInterval(() => {
            timeRem--;
            document.getElementById('clock-text').textContent = timeRem;
            
            const timerBadge = document.getElementById('timer-badge');
            if (timeRem <= 5) {
                timerBadge.style.borderColor = '#ef4444';
            }
            
            if(timeRem <= 0) { 
                clearInterval(timerInt); 
                resolve(false, null, null, -1); 
            }
        }, 1000);
    }

    function selectOpt(idx, card, event) {
        clearInterval(timerInt);
        const q = currentPool[curIdx];
        const ok = idx === q.a;
        
        const rect = card.getBoundingClientRect();
        const x = rect.left + rect.width / 2;
        const y = rect.top + rect.height / 2;
        
        resolve(ok, card, { x, y }, idx);
    }

    function resolve(ok, card, pos, selectedIdx) {
        const q = currentPool[curIdx];
        document.querySelectorAll('.answer-card').forEach(c => c.classList.add('disabled'));
        document.getElementById('opt-container').style.opacity = '0';
        document.getElementById('opt-container').style.pointerEvents = 'none';

        if(ok === true) {
            card.classList.add('correct');
            play('success-sfx');
            score++;
            streak++;
            if (pos) createParticles(pos.x, pos.y, true);
        } else if (ok === false && card) {
            // Selected wrong option
            card.classList.add('wrong');
            play('error-sfx');
            streak = 0;
            document.querySelectorAll('.answer-card')[q.a].classList.add('correct');
            if (pos) createParticles(pos.x, pos.y, false);
        } else {
            // Timeout or other non-selection error
            streak = 0;
            play('error-sfx');
            document.querySelectorAll('.answer-card')[q.a].classList.add('correct');
        }

        // Reset timer styling
        document.getElementById('timer-badge').style.borderColor = 'rgba(255, 255, 255, 0.1)';

        logs.push({
            question: q.q,
            options: q.o,
            correctOption: q.a,
            selectedOption: selectedIdx,
            isCorrect: ok === true,
            explanation: q.e
        });

        // Show feedback
        const panel = document.getElementById('feedback-panel');
        const iconContainer = document.getElementById('feedback-icon-container');
        const factTextEl = document.getElementById('fact-text');
        
        iconContainer.innerHTML = `<div class="explanation-icon ${ok ? 'correct' : 'wrong'}">${ok ? '✨' : '💡'}</div>`;
        document.getElementById('feedback-title').textContent = ok ? 'Correct!' : 'Not quite right!';
        
        if (ok) {
            factTextEl.textContent = q.e;
        } else {
            const correctOptionText = q.o[q.a];
            factTextEl.innerHTML = `<div class="mb-4 p-3 bg-white/5 rounded-lg border-l-4 border-emerald-500">
                <span class="block text-gray-400 text-xs uppercase tracking-wider mb-1">Correct Answer</span>
                <span class="text-white font-bold text-base font-poppins">${correctOptionText}</span>
            </div>
            <div class="text-gray-300">${q.e}</div>`;
        }
        
        panel.classList.add('show');
    }

    function nextStep() {
        play('click-sfx');
        curIdx++;
        if(curIdx < 15) loadInquiry();
        else wrapUp();
    }

    async function wrapUp() {
        const duration = Math.floor((Date.now() - quizStart)/1000);
        document.getElementById('game-hud').style.display = 'none';
        document.getElementById('quiz-view').style.display = 'none';
        document.getElementById('progress-dots').style.display = 'none';
        document.getElementById('result-view').style.display = 'block';
        
        // Show previous results button again if it exists
        const prevBtn = document.getElementById('prev-results-btn');
        if(prevBtn) prevBtn.style.display = 'block';

        const points = score * 10;
        document.getElementById('final-pct').textContent = points + ' pts';



        const status = document.getElementById('save-status');
        <?php if(auth()->guard()->check()): ?>
        if(window.gameActivity) {
            status.textContent = "Saving results...";
            try {
                const res = await window.gameActivity.recordActivity({
                    game_type: 'quiz',
                    score: score,
                    time_spent: duration,
                    metadata: { userAnswers: logs },
                    difficulty: 'normal'
                });
                if(res && res.success) {
                    status.textContent = "Results saved!";
                    play('saved-sfx');
                }
            } catch(e) {}
        }
        <?php endif; ?>
    }

    function openReview() {
        renderLogs(logs);
        document.getElementById('result-view').style.display = 'none';
        document.getElementById('review-view').style.display = 'block';
    }

    function showHistory() {
        const data = <?php echo json_encode($lastQuiz ? $lastQuiz->metadata : null, 15, 512) ?>;
        if(data && data.userAnswers) {
            isHistReview = true;
            renderLogs(data.userAnswers);
            document.getElementById('start-view').style.display = 'none';
            document.getElementById('review-view').style.display = 'block';
        }
    }

    function renderLogs(data) {
        const con = document.getElementById('logs-con');
        con.innerHTML = '';
        data.forEach((item, i) => {
            const div = document.createElement('div');
            div.className = `p-6 rounded-2xl border ${item.isCorrect ? 'border-emerald-500/30 bg-emerald-500/5' : 'border-rose-500/30 bg-rose-500/5'}`;
            div.innerHTML = `
                <div class="flex gap-4 items-start">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-black ${item.isCorrect ? 'bg-emerald-500 text-white' : 'bg-rose-500 text-white'}">${i+1}</div>
                    <div class="flex-1">
                        <h4 class="text-lg font-bold mb-2 text-white">${item.question}</h4>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 mb-3">
                            ${item.options.map((opt, idx) => {
                                let styleClass = "p-3 rounded-lg text-sm border ";
                                let icon = "";
                                if (idx === item.correctOption) {
                                    styleClass += "border-emerald-500/50 bg-emerald-500/10 text-emerald-300 font-semibold";
                                    icon = "✅ ";
                                } else if (idx === item.selectedOption) {
                                    styleClass += "border-rose-500/50 bg-rose-500/10 text-rose-300 font-semibold";
                                    icon = "❌ ";
                                } else {
                                    styleClass += "border-white/10 bg-white/5 text-gray-400";
                                }
                                return `<div class="${styleClass}">${icon}${opt}</div>`;
                            }).join('')}
                        </div>

                        <p class="text-sm text-gray-400 italic border-l-2 border-indigo-500/30 pl-3">"${item.explanation}"</p>
                    </div>
                </div>
            `;
            con.appendChild(div);
        });
    }

    function openInstructions() {
        document.getElementById('instructions-modal').classList.remove('hidden');
        readInstructions();
    }

    function exitReview() {
        if ('speechSynthesis' in window) {
            window.speechSynthesis.cancel();
        }
        document.getElementById('review-view').style.display = 'none';
        if(isHistReview) {
            document.getElementById('start-view').style.display = 'block';
            document.getElementById('btn-how-to-play').style.display = 'flex';
        } else {
            document.getElementById('result-view').style.display = 'block';
        }
    }

    // Cleanup on exit
    document.addEventListener('turbo:before-visit', () => {
        clearInterval(timerInt);
        if ('speechSynthesis' in window) {
            window.speechSynthesis.cancel();
        }
    });

    // Auto-popup instructions
    document.addEventListener('turbo:load', () => {
        setTimeout(() => {
            const guestModal = document.getElementById('guest-modal');
            const isGuestModalVisible = guestModal && !guestModal.classList.contains('hidden');
            
            // Show instructions automatically if guest modal is not showing (e.g. for logged in users)
            if (!isGuestModalVisible && document.querySelector('.journey-container')) {
                if (window.openInstructions) window.openInstructions();
            }
        }, 1000);
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rayver\Desktop\my_app\resources\views/games/quiz.blade.php ENDPATH**/ ?>
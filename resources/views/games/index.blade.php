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
    
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif'],
                    },
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
<body class="bg-gray-800 min-h-screen text-white overflow-x-hidden">

    
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
                        <a href="/games/memory-match" class="play-button memory-start-btn block w-full bg-gradient-to-r from-green-600 to-green-500 hover:from-green-500 hover:to-green-400 text-white font-bold py-5 px-8 rounded-2xl text-center text-lg relative z-10 transform group-hover:scale-105 transition-all duration-300" onclick="playClickSound()">
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
                        <a href="/games/puzzle" class="play-button puzzle-start-btn block w-full bg-gradient-to-r from-green-600 to-green-500 hover:from-green-500 hover:to-green-400 text-white font-bold py-5 px-8 rounded-2xl text-center text-lg relative z-10 transform group-hover:scale-105 transition-all duration-300" onclick="playClickSound()">
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
                        <a href="/games/find-the-pawikan" class="play-button block w-full bg-gradient-to-r from-green-600 to-green-500 hover:from-green-500 hover:to-green-400 text-white font-bold py-5 px-8 rounded-2xl text-center text-lg relative z-10 transform group-hover:scale-105 transition-all duration-300" onclick="playClickSound()">
                            <span class="relative z-10">🛡️ Start Defending</span>
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentication - Pawikan Patrol</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/lg.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/lg.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('img/lg.png') }}">
    <link rel="shortcut icon" href="{{ asset('img/lg.png') }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Cinzel:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Poppins', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        ocean: {
                            50: '#f0fdfa',
                            100: '#ccfbf1',
                            200: '#99f6e4',
                            300: '#5eead4',
                            400: '#2dd4bf',
                            500: '#14b8a6',
                            600: '#0d9488',
                            700: '#0f766e',
                            800: '#115e59',
                            900: '#134e4a',
                        },
                        deep: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            200: '#e2e8f0',
                            300: '#cbd5e1',
                            400: '#94a3b8',
                            500: '#64748b',
                            600: '#475569',
                            700: '#334155',
                            800: '#1e293b',
                            900: '#0f172a',
                        }
                    },
                    animation: {
                        'ocean-wave': 'oceanWave 15s ease-in-out infinite',
                        'float': 'float 20s infinite linear',
                        'swim': 'swim 10s ease-in-out infinite',
                        'glow': 'glow 2s ease-in-out infinite alternate',
                        'fade-up': 'fadeUp 0.8s ease-out forwards',
                        'slide-in': 'slideIn 0.6s ease-out forwards',
                    }
                }
            }
        }
    </script>
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        /* Apply Cinzel font specifically to navigation */
        nav, nav * {
            font-family: 'Cinzel', serif !important;
        }
        
        @keyframes oceanWave {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        @keyframes float {
            from { 
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }
            10% { opacity: 1; }
            90% { opacity: 1; }
            to { 
                transform: translateY(-100vh) rotate(360deg);
                opacity: 0;
            }
        }

        @keyframes swim {
            0%, 100% { transform: translateX(0) rotate(0deg); }
            50% { transform: translateX(-50px) rotate(-5deg); }
        }

        @keyframes glow {
            from { text-shadow: 0 0 20px rgba(20, 184, 166, 0.5); }
            to { text-shadow: 0 0 40px rgba(20, 184, 166, 0.8), 0 0 60px rgba(20, 184, 166, 0.4); }
        }

        @keyframes fadeUp {
            from { 
                opacity: 0; 
                transform: translateY(30px); 
            }
            to { 
                opacity: 1; 
                transform: translateY(0); 
            }
        }

        @keyframes slideIn {
            from { 
                opacity: 0; 
                transform: translateX(-30px); 
            }
            to { 
                opacity: 1; 
                transform: translateX(0); 
            }
        }

        .ocean-bg {
            background: linear-gradient(45deg, #0f4c75, #1b6ec2, #2e8b57, #4682b4);
            background-size: 400% 400%;
            animation: oceanWave 15s ease-in-out infinite;
        }

        .glass {
            background: #111827; /* gray-900 */
            backdrop-filter: blur(10px);
            border: 1px solid rgba(74, 222, 128, 0.3); /* green-400/30 */
        }

        .glass-dark {
            background: #111827; /* gray-900 */
            backdrop-filter: blur(15px);
            border: 1px solid rgba(74, 222, 128, 0.3); /* green-400/30 */
        }

        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 20s infinite linear;
        }

        .form-container {
            position: relative;
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
            z-index: 1;
        }
        
        .form-container.hidden {
            display: none !important;
        }
        
        .form-container.active {
            display: block !important;
        }

        .tab-button {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .tab-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(20, 184, 166, 0.2), transparent);
            transition: left 0.5s;
        }

        .tab-button:hover::before {
            left: 100%;
        }

        .tab-button.active {
            background: linear-gradient(135deg, rgba(20, 184, 166, 0.4), rgba(13, 148, 136, 0.3));
            border: 1px solid rgba(20, 184, 166, 0.6);
            box-shadow: 0 0 20px rgba(20, 184, 166, 0.3);
        }

        .password-strength-bar {
            transition: all 0.3s ease;
        }

        .input-group {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #94a3b8;
            transition: color 0.2s;
            z-index: 10;
        }

        .toggle-password:hover {
            color: #14b8a6;
        }

        .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            transform: translateY(-2px);
        }

        .nav-link.active {
            background: linear-gradient(135deg, rgba(20, 184, 166, 0.2), rgba(13, 148, 136, 0.1));
            color: #14b8a6;
            border: 1px solid rgba(20, 184, 166, 0.3);
        }

        .dropdown-link {
            position: relative;
            overflow: hidden;
        }

        .dropdown-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(20, 184, 166, 0.1), transparent);
            transition: left 0.5s;
        }

        .dropdown-link:hover::before {
            left: 100%;
        }

        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            padding-top: 6rem;
        }

        .auth-card {
            animation: fadeInUp 0.8s ease-out;
        }

        .floating-turtle {
            position: absolute;
            animation: swim 20s ease-in-out infinite;
            opacity: 0.3;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes swim {
            0%, 100% { transform: translateX(-50px) translateY(0) rotate(-5deg); }
            50% { transform: translateX(50px) translateY(-20px) rotate(5deg); }
        }
    </style>
</head>
<body class="bg-gray-800 min-h-screen text-white overflow-x-hidden scroll-smooth">
    <!-- Animated Background -->
    <!-- Animated Background -->
    <div class="fixed inset-0 ocean-bg -z-10" id="oceanBackground"></div>
    
    <!-- Floating Particles -->
    <div id="particles" class="fixed inset-0 -z-10 pointer-events-none"></div>

    @include('navigation')




    
    <!-- Hero Section with Auth Form -->
    <!-- Hero Section Content Removed -->
    <div class="min-h-screen flex items-center justify-center relative z-10">
        <!-- The modal will be triggered by URL hash or JS -->
    </div>

            <!-- Auth Modal is now included via navigation -->
    
    <script>
        // Default to opening login modal if visiting the auth page directly
        document.addEventListener('DOMContentLoaded', () => {
            if (!window.location.hash && typeof window.openAuthModal === 'function') {
                window.openAuthModal('login');
            }
        });
        // Interactive Background & Particles
        document.addEventListener('DOMContentLoaded', () => {
            const particleContainer = document.getElementById('particles');
            const particleCount = 20;
            const particles = [];

            // Create particles
            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');
                
                // Random properties
                const size = Math.random() * 5 + 2; // 2-7px
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;
                particle.style.left = `${Math.random() * 100}vw`;
                particle.style.top = `${Math.random() * 100}vh`;
                particle.style.opacity = Math.random() * 0.5 + 0.1;
                
                // Custom animation duration and delay
                particle.style.animationDuration = `${Math.random() * 10 + 10}s`;
                particle.style.animationDelay = `-${Math.random() * 10}s`;
                
                particleContainer.appendChild(particle);
                
                // Store for interactive movement
                particles.push({
                    element: particle,
                    x: parseFloat(particle.style.left),
                    y: parseFloat(particle.style.top),
                    speedX: (Math.random() - 0.5) * 0.5,
                    speedY: (Math.random() - 0.5) * 0.5
                });
            }

            // Interactive Mouse Movement
            document.addEventListener('mousemove', (e) => {
                const mouseX = e.clientX / window.innerWidth;
                const mouseY = e.clientY / window.innerHeight;

                // Move background slightly
                const oceanBg = document.getElementById('oceanBackground');
                if (oceanBg) {
                    oceanBg.style.transform = `translate(${mouseX * -20}px, ${mouseY * -20}px) scale(1.1)`;
                }

                // Move particles away from mouse
                particles.forEach(p => {
                    const rect = p.element.getBoundingClientRect();
                    const pX = rect.left + rect.width / 2;
                    const pY = rect.top + rect.height / 2;
                    
                    const deltaX = e.clientX - pX;
                    const deltaY = e.clientY - pY;
                    const distance = Math.sqrt(deltaX * deltaX + deltaY * deltaY);
                    
                    if (distance < 200) {
                        const angle = Math.atan2(deltaY, deltaX);
                        const force = (200 - distance) / 200;
                        const moveX = Math.cos(angle) * force * -50; // Move away
                        const moveY = Math.sin(angle) * force * -50;
                        
                        p.element.style.transform = `translate(${moveX}px, ${moveY}px)`;
                    } else {
                        p.element.style.transform = 'translate(0, 0)';
                    }
                });
            });
        });
    </script>
</body>
</html>

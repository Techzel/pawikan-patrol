<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Pawikan Patrol</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            font-family: 'Cinzel', sans-serif;
        }
        
        .ocean-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .turtle-icon {
            animation: float 4s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }
        
        .form-input {
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }
        
        .form-input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }
        
        .password-strength {
            height: 4px;
            border-radius: 2px;
            transition: all 0.3s ease;
        }
        
        .strength-weak { background: #ef4444; width: 25%; }
        .strength-fair { background: #f59e0b; width: 50%; }
        .strength-good { background: #3b82f6; width: 75%; }
        .strength-strong { background: #10b981; width: 100%; }
        
        .bubble {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: bubble-rise 8s infinite ease-in-out;
        }
        
        @keyframes bubble-rise {
            0% { transform: translateY(100vh) scale(0); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-100vh) scale(1); opacity: 0; }
        }
        
        .checkbox-custom {
            appearance: none;
            width: 20px;
            height: 20px;
            border: 2px solid #fff;
            border-radius: 4px;
            background: transparent;
            position: relative;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .checkbox-custom:checked {
            background: #667eea;
            border-color: #667eea;
        }
        
        .checkbox-custom:checked::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 12px;
        }
    </style>
</head>
<body class="ocean-gradient min-h-screen flex flex-col items-center justify-center p-4 relative overflow-hidden">
    <!-- Animated Background Bubbles -->
    <div class="bubble" style="left: 5%; width: 60px; height: 60px; animation-delay: 0s;"></div>
    <div class="bubble" style="left: 15%; width: 80px; height: 80px; animation-delay: 1.5s;"></div>
    <div class="bubble" style="left: 25%; width: 40px; height: 40px; animation-delay: 3s;"></div>
    <div class="bubble" style="left: 40%; width: 90px; height: 90px; animation-delay: 2s;"></div>
    <div class="bubble" style="left: 55%; width: 50px; height: 50px; animation-delay: 4s;"></div>
    <div class="bubble" style="left: 70%; width: 70px; height: 70px; animation-delay: 1s;"></div>
    <div class="bubble" style="left: 85%; width: 45px; height: 45px; animation-delay: 3.5s;"></div>
    <div class="bubble" style="left: 95%; width: 65px; height: 65px; animation-delay: 2.5s;"></div>
    
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 glass-dark border-b border-ocean-500/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="/" class="flex items-center gap-3 hover:opacity-80 transition-opacity">
                        <img src="img/web_lg.png" alt="Pawikan Patrol Logo" class="w-16 h-16 rounded-full">
                        <div>
                            <span class="text-xl font-bold bg-gradient-to-r from-ocean-400 to-ocean-300 bg-clip-text text-transparent">
                               Dahican Pawikan Patrol
                            </span>
                            <div class="text-xs text-black mt-1">City of Mati – Dahican, est. 2004</div>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8 ">
                    <!-- Home with Dropdown -->
                    <div class="relative group">
                        <a href="/" class="nav-link flex items-center gap-2 text-white hover:text-ocean-400 transition-colors px-3 py-2 rounded-lg hover:bg-ocean-600/20">
                            <span class="text-lg">🏠</span>
                            <span>Home</span>
                            <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </a>
                        
                        <!-- Dropdown Menu -->
                        <div class="absolute top-full left-0 mt-2 w-64 bg-gradient-to-br from-deep-800/95 to-deep-900/95 backdrop-blur-lg border border-ocean-500/20 rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                            <div class="p-4 space-y-2">
                                <a href="/" class="dropdown-link flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors w-full text-left">
                                    <span class="text-xl">🐢</span>
                                    <span>Species Guide</span>
                                </a>
                                <a href="/" class="dropdown-link flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors w-full text-left">
                                    <span class="text-xl">🌟</span>
                                    <span>Vision & Mission</span>
                                </a>
                                <a href="/" class="dropdown-link flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors w-full text-left">
                                    <span class="text-xl">🌊</span>
                                    <span>Life Cycle</span>
                                </a>
                                <a href="/" class="dropdown-link flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors w-full text-left">
                                    <span class="text-xl">⚠️</span>
                                    <span>Threats</span>
                                </a>
                                <a href="/" class="dropdown-link flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors w-full text-left">
                                    <span class="text-xl">📋</span>
                                    <span>Guidelines</span>
                                </a>
                                <a href="/" class="dropdown-link flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors w-full text-left">
                                    <span class="text-lg">🤝</span>
                                    <span>How to Help</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- 3D Explorer -->
                    <a href="/3d-explorer" class="nav-link flex items-center gap-2 text-white hover:text-ocean-400 transition-colors py-2 rounded-lg hover:bg-ocean-600/20">
                        <span class="text-lg">🌐</span>
                        <span>3D Explorer</span>
                    </a>

                    <!-- Patrol Map -->
                    <a href="/patrol-map" class="nav-link flex items-center gap-2 text-white hover:text-ocean-400 transition-colors  py-2 rounded-lg hover:bg-ocean-600/20">
                        <span class="text-lg">🗺️</span>
                        <span>Patrol Map</span>
                    </a>

                    <!-- Games -->
                    <a href="/games" class="nav-link flex items-center gap-2 text-white hover:text-ocean-400 transition-colors py-2 rounded-lg hover:bg-ocean-600/20">
                        <span class="text-lg">🎮</span>
                        <span>Games</span>
                    </a>

                    <!-- Account Dropdown -->
                    <div class="relative group">
                        <button class="flex items-center gap-2 text-white hover:text-ocean-400 transition-colors py-2 rounded-lg hover:bg-ocean-600/20">
                            <span class="text-lg">👤</span>
                            <span>Account</span>
                            <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <!-- Account Dropdown Menu -->
                        <div class="absolute top-full right-0 mt-2 w-48 bg-gradient-to-br from-deep-800/95 to-deep-900/95 backdrop-blur-lg border border-ocean-500/20 rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                            <div class="p-2 space-y-1">
                                <a href="/auth#login" class="flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors">
                                    <span class="text-lg">🔑</span>
                                    <span>Login</span>
                                </a>
                                <a href="/register" class="flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors active">
                                    <span class="text-lg">📝</span>
                                    <span>Register</span>
                                </a>
                            </div>
                        </div>
                    </div>
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
                    <a href="/" class="mobile-nav-link flex items-center gap-3 text-white hover:text-ocean-400 hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                        <span class="text-lg">🏠</span>
                        <span>Home</span>
                    </a>
                    
                    <!-- Home Sub-items -->
                    <div class="ml-8 space-y-1">
                        <a href="/" class="mobile-nav-link flex items-center gap-3 text-gray-300 hover:text-white hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                            <span class="text-lg">🐢</span>
                            <span>Species Guide</span>
                        </a>
                        <a href="/" class="mobile-nav-link flex items-center gap-3 text-gray-300 hover:text-white hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                            <span class="text-lg">🌟</span>
                            <span>Vision & Mission</span>
                        </a>
                        <a href="/" class="mobile-nav-link flex items-center gap-3 text-gray-300 hover:text-white hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                            <span class="text-lg">🌊</span>
                            <span>Life Cycle</span>
                        </a>
                        <a href="/" class="mobile-nav-link flex items-center gap-3 text-gray-300 hover:text-white hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                            <span class="text-lg">⚠️</span>
                            <span>Threats</span>
                        </a>
                        <a href="/" class="mobile-nav-link flex items-center gap-3 text-gray-300 hover:text-white hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                            <span class="text-lg">📋</span>
                            <span>Guidelines</span>
                        </a>
                        <a href="/" class="mobile-nav-link flex items-center gap-3 text-gray-300 hover:text-white hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
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
                
                <a href="/patrol-map" class="mobile-nav-link flex items-center gap-3 text-white hover:text-ocean-400 hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                    <span class="text-lg">🗺️</span>
                    <span>Patrol Map</span>
                </a>
                
                <a href="/games" class="mobile-nav-link flex items-center gap-3 text-white hover:text-ocean-400 hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                    <span class="text-lg">🎮</span>
                    <span>Games</span>
                </a>
                
                <!-- Account Section -->
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
                        <a href="/auth#login" class="mobile-nav-link flex items-center gap-3 text-gray-300 hover:text-white hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                            <span class="text-lg">🔑</span>
                            <span>Login</span>
                        </a>
                        <a href="/register" class="mobile-nav-link flex items-center gap-3 text-gray-300 hover:text-white hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                            <span class="text-lg">📝</span>
                            <span>Register</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Registration Container -->
    <div class="glass-effect rounded-2xl p-8 w-full max-w-lg shadow-2xl relative z-10 my-8">
        <!-- Logo and Title -->
        <div class="text-center mb-8">
            <div class="turtle-icon text-6xl mb-4">🐢</div>
            <h1 class="text-3xl font-bold text-white mb-2">Join Pawikan Patrol</h1>
            <p class="text-blue-100 text-sm">Become a Guardian of the Sea</p>
        </div>

        <!-- Success/Error Messages -->
        <?php if(session('success')): ?>
            <div class="bg-green-500 bg-opacity-20 border border-green-400 text-green-100 px-4 py-3 rounded-lg mb-6">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span><?php echo e(session('success')); ?></span>
                </div>
            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="bg-red-500 bg-opacity-20 border border-red-400 text-red-100 px-4 py-3 rounded-lg mb-6">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <span><?php echo e($errors->first()); ?></span>
                </div>
            </div>
        <?php endif; ?>

        <!-- Registration Form -->
        <form method="POST" action="<?php echo e(route('register.post')); ?>" class="space-y-5" id="registrationForm">
            <?php echo csrf_field(); ?>
            
            <!-- Full Name Field -->
            <div>
                <label for="name" class="block text-white text-sm font-medium mb-2">
                    <i class="fas fa-user mr-2"></i>Full Name
                </label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="<?php echo e(old('name')); ?>"
                    class="form-input w-full px-4 py-3 rounded-lg text-gray-800 placeholder-gray-500 focus:outline-none"
                    placeholder="Enter your full name"
                    required
                    maxlength="255"
                >
                <?php if($errors->has('name')): ?>
                    <p class="text-red-200 text-xs mt-1"><?php echo e($errors->first('name')); ?></p>
                <?php endif; ?>
            </div>

            <!-- Username Field -->
            <div>
                <label for="username" class="block text-white text-sm font-medium mb-2">
                    <i class="fas fa-user mr-2"></i>Username
                </label>
                <input 
                    type="text" 
                    id="username" 
                    name="username" 
                    value="<?php echo e(old('username')); ?>"
                    class="form-input w-full px-4 py-3 rounded-lg text-gray-800 placeholder-gray-500 focus:outline-none"
                    placeholder="Choose a username"
                    required
                    maxlength="255"
                >
                <?php if($errors->has('username')): ?>
                    <p class="text-red-200 text-xs mt-1"><?php echo e($errors->first('username')); ?></p>
                <?php endif; ?>
            </div>

            <!-- Email Field -->
            <div>
                <label for="email" class="block text-white text-sm font-medium mb-2">
                    <i class="fas fa-envelope mr-2"></i>Email Address
                </label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="<?php echo e(old('email')); ?>"
                    class="form-input w-full px-4 py-3 rounded-lg text-gray-800 placeholder-gray-500 focus:outline-none"
                    placeholder="Enter your email address"
                    required
                    maxlength="255"
                >
                <?php if($errors->has('email')): ?>
                    <p class="text-red-200 text-xs mt-1"><?php echo e($errors->first('email')); ?></p>
                <?php endif; ?>
            </div>

            <!-- Password Field -->
            <div>
                <label for="password" class="block text-white text-sm font-medium mb-2">
                    <i class="fas fa-lock mr-2"></i>Password
                </label>
                <div class="relative">
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-input w-full px-4 py-3 rounded-lg text-gray-800 placeholder-gray-500 focus:outline-none pr-12"
                        placeholder="Min 8 chars, 1 Upper, 1 Lower, 1 Number, 1 Special (@$!%*?&)"
                        required
                        minlength="8"
                    >
                    <button 
                        type="button" 
                        id="togglePassword" 
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-blue-600 hover:text-blue-800 focus:outline-none"
                        title="Show/Hide Password"
                    >
                        <i class="fas fa-eye text-xl" id="eyeIcon"></i>
                    </button>
                </div>
                <!-- Password Strength Indicator -->
                <div class="mt-2">
                    <div class="password-strength" id="passwordStrength"></div>
                    <p class="text-blue-100 text-xs mt-1" id="passwordStrengthText">Password strength: None</p>
                </div>
                <div class="text-blue-100 text-xs mt-2">
                    <p>Password must contain:</p>
                    <ul class="list-disc list-inside space-y-1 mt-1">
                        <li>At least 8 characters</li>
                        <li>One uppercase letter</li>
                        <li>One lowercase letter</li>
                        <li>One number</li>
                        <li>One special character (@$!%*?&)</li>
                    </ul>
                </div>
                <?php if($errors->has('password')): ?>
                    <p class="text-red-200 text-xs mt-1"><?php echo e($errors->first('password')); ?></p>
                <?php endif; ?>
            </div>

            <!-- Confirm Password Field -->
            <div>
                <label for="password_confirmation" class="block text-white text-sm font-medium mb-2">
                    <i class="fas fa-lock mr-2"></i>Confirm Password
                </label>
                <div class="relative">
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        class="form-input w-full px-4 py-3 rounded-lg text-gray-800 placeholder-gray-500 focus:outline-none pr-12"
                        placeholder="Min 8 chars, 1 Upper, 1 Lower, 1 Number, 1 Special (@$!%*?&)"
                        required
                    >
                    <button 
                        type="button" 
                        id="toggleConfirmPassword" 
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-blue-600 hover:text-blue-800 focus:outline-none"
                        title="Show/Hide Password"
                    >
                        <i class="fas fa-eye text-xl" id="eyeIconConfirm"></i>
                    </button>
                </div>
                <?php if($errors->has('password_confirmation')): ?>
                    <p class="text-red-200 text-xs mt-1"><?php echo e($errors->first('password_confirmation')); ?></p>
                <?php endif; ?>
            </div>

            <!-- Terms and Conditions -->
            <div>
                <label class="flex items-start text-white text-sm">
                    <input 
                        type="checkbox" 
                        name="terms" 
                        class="checkbox-custom mt-1 mr-3"
                        required
                    >
                    <span class="leading-relaxed">
                        I agree to the 
                        <a href="#" class="text-blue-200 hover:text-white underline">Terms of Service</a> 
                        and 
                        <a href="#" class="text-blue-200 hover:text-white underline">Privacy Policy</a>
                    </span>
                </label>
                <?php if($errors->has('terms')): ?>
                    <p class="text-red-200 text-xs mt-1"><?php echo e($errors->first('terms')); ?></p>
                <?php endif; ?>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" class="btn-primary w-full py-4 px-6 rounded-lg text-white font-bold text-lg hover:scale-105 transition-transform duration-300">
                    <i class="fas fa-user-plus mr-2"></i>Register Account
                </button>
            </div>
        </form>
    </div>

    <!-- Footer -->
    <div class="mt-8 text-center text-blue-100 text-sm z-10">
        <p>&copy; 2025 Pawikan Patrol. Protecting our ocean guardians.</p>
    </div>

    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.className = 'fas fa-eye-slash';
            } else {
                passwordInput.type = 'password';
                eyeIcon.className = 'fas fa-eye';
            }
        });

        document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
            const confirmPasswordInput = document.getElementById('password_confirmation');
            const eyeIconConfirm = document.getElementById('eyeIconConfirm');
            
            if (confirmPasswordInput.type === 'password') {
                confirmPasswordInput.type = 'text';
                eyeIconConfirm.className = 'fas fa-eye-slash';
            } else {
                confirmPasswordInput.type = 'password';
                eyeIconConfirm.className = 'fas fa-eye';
            }
        });

        // Password strength checker
        const passwordInput = document.getElementById('password');
        const passwordStrength = document.getElementById('passwordStrength');
        const passwordStrengthText = document.getElementById('passwordStrengthText');

        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            let strengthText = '';

            if (password.length >= 8) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/\d/.test(password)) strength++;
            if (/[@$!%*?&]/.test(password)) strength++;

            // Remove all strength classes
            passwordStrength.className = 'password-strength';

            if (password.length === 0) {
                strengthText = 'Password strength: None';
            } else if (strength <= 2) {
                passwordStrength.classList.add('strength-weak');
                strengthText = 'Password strength: Weak';
            } else if (strength <= 3) {
                passwordStrength.classList.add('strength-fair');
                strengthText = 'Password strength: Fair';
            } else if (strength <= 4) {
                passwordStrength.classList.add('strength-good');
                strengthText = 'Password strength: Good';
            } else {
                passwordStrength.classList.add('strength-strong');
                strengthText = 'Password strength: Strong';
            }

            passwordStrengthText.textContent = strengthText;
        });

        // Real-time password confirmation validation
        const confirmPasswordInput = document.getElementById('password_confirmation');
        const form = document.getElementById('registrationForm');

        confirmPasswordInput.addEventListener('input', function() {
            if (passwordInput.value !== this.value && this.value.length > 0) {
                this.setCustomValidity('Passwords do not match');
            } else {
                this.setCustomValidity('');
            }
        });

        passwordInput.addEventListener('input', function() {
            if (confirmPasswordInput.value.length > 0 && this.value !== confirmPasswordInput.value) {
                confirmPasswordInput.setCustomValidity('Passwords do not match');
            } else {
                confirmPasswordInput.setCustomValidity('');
            }
        });

        // Mobile menu functionality
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });

        // Mobile account toggle functionality
        document.querySelector('.mobile-account-toggle').addEventListener('click', function() {
            const mobileAccountMenu = document.querySelector('.mobile-account-menu');
            mobileAccountMenu.classList.toggle('hidden');
            
            // Toggle the chevron icon
            const chevron = this.querySelector('svg');
            chevron.classList.toggle('rotate-180');
        });
    </script>
</body>
</html>

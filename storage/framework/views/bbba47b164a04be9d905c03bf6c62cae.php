<style>
    /* Minimal Auth Modal Styles */
    .modal-backdrop {
        background-color: rgba(0, 0, 0, 0.85);
        backdrop-filter: blur(8px);
    }

    .glass-dark {
        background: #111827; /* gray-900 */
        border: 1px solid #374151; /* gray-700 */
    }

    .form-container.hidden {
        display: none !important;
    }
    
    .form-container.active {
        display: block !important;
        animation: fadeIn 0.3s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(5px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Simple Tab Styles */
    .tab-container {
        border-bottom: 1px solid #374151;
        margin-bottom: 2rem;
    }

    .tab-button {
        position: relative;
        padding-bottom: 1rem;
        color: #9ca3af; /* gray-400 */
        transition: all 0.2s ease;
        background: transparent;
        border: none;
    }

    .tab-button:hover {
        color: #e5e7eb; /* gray-200 */
    }

    .tab-button.active {
        color: #14b8a6; /* teal-500 */
    }

    .tab-button.active::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        width: 100%;
        height: 2px;
        background-color: #14b8a6;
    }

    /* Form Elements */
    .simple-input {
        background-color: #1f2937; /* gray-800 */
        border: 1px solid #374151; /* gray-700 */
        transition: all 0.2s ease;
    }

    .simple-input:focus {
        border-color: #14b8a6;
        background-color: #111827;
        box-shadow: 0 0 0 1px #14b8a6;
    }

    .toggle-password {
        color: #9ca3af;
        cursor: pointer;
    }

    .toggle-password:hover {
        color: #14b8a6;
    }
    
    /* Force Poppins */
    #authModal * {
        font-family: 'Poppins', sans-serif;
    }
</style>

<!-- Auth Modal -->
<div id="authModal" class="fixed inset-0 z-[100000] flex items-center justify-center bg-black/80 backdrop-blur-sm hidden opacity-0 transition-opacity duration-300 p-4">
    <div class="relative w-full max-w-lg font-poppins" onclick="event.stopPropagation()">
        <div class="auth-card">
            <div class="glass-dark rounded-3xl p-8 shadow-2xl border border-ocean-500/30 max-h-[90vh] overflow-y-auto relative">
                <!-- Close Button -->
                <button onclick="closeAuthModal()" class="absolute top-4 right-4 text-gray-400 hover:text-white transition-colors z-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <!-- Simple Tab Navigation -->
                <div class="flex mb-8 tab-container gap-8 px-2">
                    <button id="loginTab" class="tab-button text-lg font-medium active" onclick="window.showLogin()">
                        Login
                    </button>
                    <button id="registerTab" class="tab-button text-lg font-medium" onclick="window.showRegister()">
                        Register
                    </button>
                </div>
                
                <!-- Forms Container -->
                <div class="relative">
                    <!-- Login Form -->
                    <div id="loginForm" class="form-container active">
                        <?php if(session('error')): ?>
                            <div class="mb-6 p-4 bg-red-500/20 border border-red-500/50 rounded-xl text-red-200 text-sm backdrop-blur-sm flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <?php echo e(session('error')); ?>

                            </div>
                        <?php endif; ?>
                        
                        <?php if(session('registration_success')): ?>
                            <div class="mb-6 p-4 bg-green-500/20 border border-green-500/50 rounded-xl text-green-200 text-sm backdrop-blur-sm flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <?php echo e(session('registration_success')); ?>

                            </div>
                        <?php endif; ?>
                        
                        <!-- Login Error Handling from URL hash redirect often puts errors in bag -->
                        <?php $__errorArgs = ['login'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="mb-6 p-4 bg-red-500/20 border border-red-500/50 rounded-xl text-red-200 text-sm backdrop-blur-sm flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <?php echo e($message); ?>

                            </div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        
                        <form method="POST" action="<?php echo e(route('login')); ?>">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="_form_type" value="login">
                            
                            <div class="mb-6">
                                <label for="loginUsername" class="block text-sm font-medium text-gray-300 mb-2">
                                    Username
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none z-10">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <input type="text" id="loginUsername" name="username" required
                                        class="w-full pl-10 pr-4 py-3 simple-input rounded-lg text-white placeholder-gray-500 focus:outline-none font-poppins <?php echo e($errors->has('username') ? 'border-red-500/50' : ''); ?>"
                                        placeholder="Enter your username">
                                </div>
                                <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="mt-2 text-sm text-red-400">
                                        <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            
                            <div class="mb-6">
                                <label for="loginPassword" class="block text-sm font-medium text-gray-300 mb-2">
                                    Password
                                </label>
                                <div class="input-group relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none z-10">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </div>
                                    <input type="password" id="loginPassword" name="password" required
                                        class="w-full pl-10 pr-12 py-3 simple-input rounded-lg text-white placeholder-gray-500 focus:outline-none font-poppins <?php echo e($errors->has('password') ? 'border-red-500/50' : ''); ?>"
                                        placeholder="Enter your password">
                                    <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center toggle-password text-gray-400 hover:text-white focus:outline-none z-20 cursor-pointer" data-target="loginPassword">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="mt-2 text-sm text-red-400">
                                        <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            
                            <button type="submit" class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-medium py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                </svg>Login to Your Account
                            </button>
                        </form>
                    </div>
                    
                    <!-- Register Form -->
                    <div id="registerForm" class="form-container hidden">
                        <div class="text-center mb-6">
                            <h3 class="text-2xl font-bold text-white font-poppins">Register as a User</h3>
                        </div>
                        <!-- Same session alerts can be reused or duplicated based on preference, here duplicating for clarity inside tab -->
                        <?php if(session('registration_success')): ?>
                            <div class="mb-6 p-4 bg-green-500/20 border border-green-500/50 rounded-xl text-green-200 text-sm backdrop-blur-sm flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <?php echo e(session('registration_success')); ?>

                            </div>
                        <?php endif; ?>
                        
                        <?php if(session('error')): ?>
                            <div class="mb-6 p-4 bg-red-500/20 border border-red-500/50 rounded-xl text-red-200 text-sm backdrop-blur-sm flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <?php echo e(session('error')); ?>

                            </div>
                        <?php endif; ?>
                        
                        <form method="POST" action="<?php echo e(route('register')); ?>">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="_form_type" value="register">
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="registerName" class="block text-sm font-medium text-gray-300 mb-2">
                                        Full Name
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none z-10">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                        <input type="text" id="registerName" name="name" required value="<?php echo e(old('name')); ?>"
                                            class="w-full pl-10 pr-4 py-3 simple-input rounded-lg text-white placeholder-gray-500 focus:outline-none font-poppins <?php echo e($errors->has('name') ? 'border-red-500/50' : ''); ?>"
                                            placeholder="Full Name">
                                    </div>
                                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="mt-2 text-sm text-red-400">
                                            <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                
                                <div>
                                    <label for="registerUsername" class="block text-sm font-medium text-gray-300 mb-2">
                                        Username
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none z-10">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                            </svg>
                                        </div>
                                        <input type="text" id="registerUsername" name="username" required value="<?php echo e(old('username')); ?>"
                                            class="w-full pl-10 pr-4 py-3 simple-input rounded-lg text-white placeholder-gray-500 focus:outline-none font-poppins <?php echo e($errors->has('username') ? 'border-red-500/50' : ''); ?>"
                                            placeholder="Username">
                                    </div>
                                    <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="mt-2 text-sm text-red-400">
                                            <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label for="registerEmail" class="block text-sm font-medium text-gray-300 mb-2">
                                    Email Address
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none z-10">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <input type="email" id="registerEmail" name="email" required value="<?php echo e(old('email')); ?>"
                                        class="w-full pl-10 pr-4 py-3 simple-input rounded-lg text-white placeholder-gray-500 focus:outline-none font-poppins <?php echo e($errors->has('email') ? 'border-red-500/50' : ''); ?>"
                                        placeholder="Enter your email address">
                                </div>
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="mt-2 text-sm text-red-400">
                                        <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

                                    </div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                <div>
                                    <label for="registerPassword" class="block text-sm font-medium text-gray-300 mb-2">
                                        Password
                                    </label>
                                    <div class="input-group relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none z-10">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                            </svg>
                                        </div>
                                        <input type="password" id="registerPassword" name="password" required
                                            class="w-full pl-10 pr-10 py-3 simple-input rounded-lg text-white placeholder-gray-500 focus:outline-none font-poppins <?php echo e($errors->has('password') ? 'border-red-500/50' : ''); ?>"
                                            placeholder="Password">
                                        <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center toggle-password text-gray-400 hover:text-white focus:outline-none z-20 cursor-pointer" data-target="registerPassword">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                    </div>
                                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="mt-2 text-sm text-red-400">
                                            <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <div class="mt-2">
                                        <div class="w-full bg-deep-700 rounded-full h-1.5 mb-1">
                                            <div id="strengthBar" class="password-strength-bar h-1.5 rounded-full bg-red-500" style="width: 0%"></div>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="text-[10px] text-gray-400">Strength</span>
                                            <span id="strengthText" class="text-[10px] font-semibold text-gray-400">Weak</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div>
                                    <label for="registerPasswordConfirmation" class="block text-sm font-medium text-gray-300 mb-2">
                                        Confirm Password
                                    </label>
                                    <div class="input-group relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none z-10">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <input type="password" id="registerPasswordConfirmation" name="password_confirmation" required
                                            class="w-full pl-10 pr-10 py-3 simple-input rounded-lg text-white placeholder-gray-500 focus:outline-none font-poppins"
                                            placeholder="Confirm">
                                        <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center toggle-password text-gray-400 hover:text-white focus:outline-none z-20 cursor-pointer" data-target="registerPasswordConfirmation">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div id="passwordValidation" class="mt-2 text-sm hidden">
                                        <span id="passwordValidationText"></span>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="submit" class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-medium py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>Create Your Account
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Auth Modal Triggers (For Turbo/JS) -->
<div id="authTrigger" class="hidden" 
     data-has-error="<?php echo e(($errors->any() || session('error')) ? 'true' : 'false'); ?>"
     data-has-success="<?php echo e(session('registration_success') ? 'true' : 'false'); ?>"
     data-form-type="<?php echo e(old('_form_type', 'login')); ?>">
</div>

<script>
    /**
     * AUTH MODAL CONTROLLER
     * Optimized for Laravel + Hotwire Turbo
     * Prevents persistent popups while ensuring functional auto-open on redirects
     */
    (function() {
        const getEl = (id) => document.getElementById(id);
        
        // --- GLOBAL FUNCTIONS (Only define once) ---
        if (!window.openAuthModal) {
            window.openAuthModal = function(view = 'login') {
                const modal = getEl('authModal');
                if (!modal) return;
                modal.classList.remove('hidden');
                setTimeout(() => modal.classList.remove('opacity-0'), 10);
                if (view === 'register') window.showRegister();
                else window.showLogin();
            };

            window.closeAuthModal = function() {
                const modal = getEl('authModal');
                if (!modal) return;
                modal.classList.add('opacity-0');
                setTimeout(() => modal.classList.add('hidden'), 300);
            };

            window.showLogin = function() {
                const loginForm = getEl('loginForm'), regForm = getEl('registerForm');
                const loginTab = getEl('loginTab'), regTab = getEl('registerTab');
                if (loginForm) { loginForm.classList.add('active'); loginForm.classList.remove('hidden'); }
                if (regForm) { regForm.classList.add('hidden'); regForm.classList.remove('active'); }
                if (loginTab) loginTab.classList.add('active');
                if (regTab) regTab.classList.remove('active');
            };
            
            window.showRegister = function() {
                const loginForm = getEl('loginForm'), regForm = getEl('registerForm');
                const loginTab = getEl('loginTab'), regTab = getEl('registerTab');
                if (regForm) { regForm.classList.add('active'); regForm.classList.remove('hidden'); }
                if (loginForm) { loginForm.classList.add('hidden'); loginForm.classList.remove('active'); }
                if (regTab) regTab.classList.add('active');
                if (loginTab) loginTab.classList.remove('active');
            };
        }

        // --- INTERNAL LOGIC ---

        const initListeners = () => {
            // Re-bind listeners on every page load (Turbo replaces body/modal)
            const loginTab = getEl('loginTab'), regTab = getEl('registerTab');
            if (loginTab) loginTab.onclick = () => window.showLogin();
            if (regTab) regTab.onclick = () => window.showRegister();

            // Password Match Validation
            const regPwd = getEl('registerPassword');
            const regPwdConf = getEl('registerPasswordConfirmation');
            const pwdValBox = getEl('passwordValidation');
            const pwdValText = getEl('passwordValidationText');
            
            function validateMatch() {
                if (!regPwd || !regPwdConf || !pwdValBox || !pwdValText) return true;
                if (!regPwdConf.value) { pwdValBox.classList.add('hidden'); return true; }
                
                pwdValBox.classList.remove('hidden');
                if (regPwd.value === regPwdConf.value) {
                    pwdValBox.className = 'mt-2 text-sm text-green-400';
                    pwdValText.textContent = 'Passwords match';
                    return true;
                } else {
                    pwdValBox.className = 'mt-2 text-sm text-red-400';
                    pwdValText.textContent = 'Passwords do not match';
                    return false;
                }
            }

            if (regPwd && regPwdConf) {
                regPwd.addEventListener('input', validateMatch);
                regPwdConf.addEventListener('input', validateMatch);
            }

            const regForm = document.querySelector('#registerForm form');
            if (regForm) {
                regForm.onsubmit = function(e) {
                    if (!validateMatch()) {
                        e.preventDefault();
                        alert('Please make sure your passwords match.');
                    }
                };
            }

            // Toggle Password
            document.querySelectorAll('.toggle-password').forEach(btn => {
                btn.onclick = function(e) {
                    e.preventDefault();
                    const input = getEl(this.getAttribute('data-target'));
                    const svg = this.querySelector('svg');
                    if (input) {
                        const type = input.type === 'password' ? 'text' : 'password';
                        input.type = type;
                        svg.innerHTML = type === 'text' 
                            ? `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268-2.943 9.543-7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />`
                            : `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268-2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
                    }
                };
            });

            // Password Strength
            const strengthBar = getEl('strengthBar'), strengthText = getEl('strengthText');
            if (regPwd && strengthBar) {
                regPwd.addEventListener('input', function() {
                    const pwd = this.value;
                    let s = 0;
                    if (pwd.length >= 8) s += 25;
                    if (pwd.length >= 12) s += 25;
                    if (/[a-z]/.test(pwd) && /[A-Z]/.test(pwd)) s += 25;
                    if (/[0-9]/.test(pwd) || /[^A-Za-z0-9]/.test(pwd)) s += 25;
                    let cls = 'bg-red-500', lbl = 'Weak';
                    if (s > 75) { cls = 'bg-green-500'; lbl = 'Strong'; }
                    else if (s > 50) { cls = 'bg-yellow-500'; lbl = 'Good'; }
                    else if (s > 25) { cls = 'bg-orange-500'; lbl = 'Fair'; }
                    strengthBar.style.width = Math.max(s, 10) + '%';
                    strengthBar.className = 'password-strength-bar h-1.5 rounded-full transition-all duration-300 ' + cls;
                    if (strengthText) strengthText.textContent = lbl;
                });
            }
        };

        window.checkAutoOpen = function() {
            <?php if(auth()->guard()->guest()): ?>
            const trigger = getEl('authTrigger');
            const hasError = trigger ? trigger.getAttribute('data-has-error') === 'true' : false;
            const hasSuccess = trigger ? trigger.getAttribute('data-has-success') === 'true' : false;
            const formType = trigger ? trigger.getAttribute('data-form-type') : 'login';

            // 1. Errors and Fresh Registration Success always force open
            if (hasError || hasSuccess) {
                // If we've already shown it for this exact URL/state, don't repeat
                const stateKey = window.location.href + hasError + hasSuccess;
                if (window.lastAutoOpenKey === stateKey) return;

                window.openAuthModal(hasSuccess ? 'login' : formType);
                
                window.lastAutoOpenKey = stateKey;
                window.sessionStorage.setItem('auth_modal_auto_opened', 'true');
                return;
            }

            // 2. Hash-based open (Only once per session)
            const h = window.location.hash;
            if ((h === '#login' || h === '#register') && !window.sessionStorage.getItem('auth_modal_auto_opened')) {
                window.openAuthModal(h.substring(1));
                history.replaceState(null, null, window.location.pathname + window.location.search);
                window.sessionStorage.setItem('auth_modal_auto_opened', 'true');
            }
            <?php else: ?>
                window.sessionStorage.removeItem('auth_modal_auto_opened');
            <?php endif; ?>
        };

        // --- RUN ---
        initListeners();
        window.checkAutoOpen();
        
        // Ensure re-run on Turbo visit
        if (!window.authTurboBound) {
            document.addEventListener('turbo:load', () => {
                initListeners();
                window.checkAutoOpen();
            });
            window.authTurboBound = true;
        }
    })();
</script>
<?php /**PATH C:\Users\Rayver\Desktop\my_app\resources\views/auth/modal.blade.php ENDPATH**/ ?>
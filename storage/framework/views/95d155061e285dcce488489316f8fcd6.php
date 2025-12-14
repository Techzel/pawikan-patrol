<style>
    nav, nav *,
    #mobile-menu, #mobile-menu * {
        font-family: 'Cinzel', serif !important;
    }
    
    nav .text-sm.font-medium,
    #mobile-menu .text-sm.font-medium {
        font-size: 0.82rem !important;
        line-height: 1.2 !important;
        letter-spacing: 0.02em;
    }
</style>

<nav class="fixed top-0 left-0 right-0 z-[9999] bg-slate-800/95 backdrop-blur-lg shadow-lg border-b border-ocean-500/20">
    <div class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="<?php echo e(auth()->check() && auth()->user()->role === 'admin' ? route('admin.dashboard') : (auth()->check() && auth()->user()->role === 'patroller' ? route('patroller.dashboard') : '/')); ?>" class="flex items-center gap-3 hover:opacity-80 transition-opacity">
                    <img src="<?php echo e(asset('img/lg.png')); ?>" alt="Pawikan Patrol Logo" class="w-12 h-12 sm:w-16 sm:h-16 rounded-full">
                    <div class="ml-2 sm:ml-0">
                        <span class="text-lg sm:text-xl font-bold text-white">
                            Dahican Pawikan Patrol
                        </span>
                        <div class="text-[10px] sm:text-xs text-gray-300 mt-0.5">City of Mati – Dahican, est. 2004</div>
                    </div>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-4 lg:space-x-6">
                <!-- Patrol Map with Dropdown -->
                <div class="relative group">
                    <a href="/patrol-map" class="flex items-center gap-1.5 text-white hover:text-ocean-300 transition-colors px-3 py-2 rounded-lg hover:bg-ocean-600/20 <?php echo e(request()->is('patrol-map*') ? 'bg-ocean-600/30' : ''); ?>">
                        <span class="text-base">🗺️</span>
                        <span class="text-sm font-medium">Patrol Map</span>
                        <svg class="w-3.5 h-3.5 mt-0.5 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </a>
                    
                    <!-- Dropdown Menu -->
                    <div class="absolute top-full left-0 mt-2 w-48 bg-gradient-to-br from-deep-800/95 to-deep-900/95 backdrop-blur-lg border border-ocean-500/20 rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                        <div class="p-2 space-y-1">
                            <a href="/patrol-map/gallery" class="dropdown-link flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors w-full text-left">
                                <span class="text-lg">📸</span>
                                <span class="text-sm font-medium">Gallery Report</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Account Dropdown -->
                <?php if(auth()->guard()->check()): ?>
                <div class="relative group">
                    <button class="flex items-center gap-2 text-white hover:text-ocean-400 transition-colors px-3 py-2 rounded-lg hover:bg-ocean-600/20 <?php echo e(request()->is('patroller*') ? 'bg-ocean-600/30' : ''); ?>">
                        <?php if(auth()->user()->profile_picture): ?>
                            <img src="<?php echo e(asset('storage/' . auth()->user()->profile_picture)); ?>" 
                                 alt="Profile Picture" 
                                 class="w-8 h-8 rounded-full object-cover border-2 border-ocean-500/30"
                                 onerror="this.onerror=null; this.outerHTML='<span class=\'text-lg\'>👤</span>';">
                        <?php else: ?>
                            <span class="text-lg">👤</span>
                        <?php endif; ?>
                        <span class="text-sm font-medium"><?php echo e(Auth::user()->name); ?></span>
                        <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <!-- User Dropdown -->
                    <div class="absolute top-full right-0 mt-2 w-48 bg-gradient-to-br from-deep-800/95 to-deep-900/95 backdrop-blur-lg border border-ocean-500/20 rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                        <div class="p-2 space-y-1">
                            <?php if(auth()->user()->role === 'admin'): ?>
                                <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center gap-3 px-3 py-2 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors <?php echo e(request()->is('admin/dashboard') ? '!bg-ocean-600/30 !text-ocean-300' : 'text-gray-300'); ?>" style="<?php echo e(request()->is('admin/dashboard') ? 'background-color: rgba(20, 184, 166, 0.3) !important; color: #5eead4 !important;' : ''); ?>">
                                    <span class="text-lg">📊</span>
                                    <span>Dashboard</span>
                                </a>
                            <?php elseif(auth()->user()->role === 'patroller'): ?>
                                <a href="<?php echo e(route('patroller.dashboard')); ?>" class="flex items-center gap-3 px-3 py-2 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors <?php echo e(request()->is('patroller/dashboard') ? '!bg-ocean-600/30 !text-ocean-300' : 'text-gray-300'); ?>" style="<?php echo e(request()->is('patroller/dashboard') ? 'background-color: rgba(20, 184, 166, 0.3) !important; color: #5eead4 !important;' : ''); ?>">
                                    <span class="text-lg">📊</span>
                                    <span>Dashboard</span>
                                </a>
                            <?php else: ?>
                                <a href="/profile" class="flex items-center gap-3 px-3 py-2 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors <?php echo e(request()->is('profile') ? '!bg-ocean-600/30 !text-ocean-300' : 'text-gray-300'); ?>" style="<?php echo e(request()->is('profile') ? 'background-color: rgba(20, 184, 166, 0.3) !important; color: #5eead4 !important;' : ''); ?>">
                                    <span class="text-lg">👤</span>
                                    <span>Profile</span>
                                </a>
                            <?php endif; ?>
                            <form method="POST" action="/logout" class="w-full">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors w-full text-left">
                                    <span class="text-lg">🚪</span>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <div class="relative group">
                    <button class="flex items-center gap-2 text-white hover:text-ocean-400 transition-colors px-3 py-2 rounded-lg hover:bg-ocean-600/20">
                        <span class="text-lg">👤</span>
                        <span class="text-sm font-medium">Account</span>
                        <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <!-- Guest Dropdown -->
                    <div class="absolute top-full right-0 mt-2 w-48 bg-gradient-to-br from-deep-800/95 to-deep-900/95 backdrop-blur-lg border border-ocean-500/20 rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                        <div class="p-2 space-y-1">
                            <a href="#" onclick="event.preventDefault(); openAuthModal('login')" class="flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors">
                                <span class="text-sm">🔑</span>
                                <span class="text-sm">Login</span>
                            </a>
                            <a href="#" onclick="event.preventDefault(); openAuthModal('register')" class="flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors">
                                <span class="text-sm">📝</span>
                                <span class="text-sm">Register</span>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
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
    <div id="mobile-menu" class="md:hidden hidden bg-slate-800/95 backdrop-blur-lg border-t border-ocean-500/20 max-h-[calc(100vh-5rem)] overflow-y-auto">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <!-- Patrol Map Section -->
            <div class="space-y-1">
                <a href="/patrol-map" class="mobile-nav-link flex items-center gap-3 hover:text-ocean-400 hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left <?php echo e(request()->is('patrol-map*') ? '!bg-ocean-600/30 !text-ocean-300' : 'text-white'); ?>" style="<?php echo e(request()->is('patrol-map*') ? 'background-color: rgba(20, 184, 166, 0.3) !important; color: #5eead4 !important;' : ''); ?>">
                    <span class="text-lg">🗺️</span>
                    <span class="text-sm font-medium">Patrol Map</span>
                </a>
                
                <!-- Patrol Map Sub-items -->
                <div class="ml-8 space-y-1">
                    <a href="/patrol-map/gallery" class="mobile-nav-link flex items-center gap-3 text-gray-300 hover:text-white hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                        <span class="text-lg">📸</span>
                        <span class="text-sm font-medium">Gallery Report</span>
                    </a>
                </div>
            </div>
            
            <!-- Account Section -->
            <?php if(auth()->guard()->check()): ?>
            <div class="space-y-1">
                <button class="mobile-account-toggle flex items-center gap-3 text-white hover:text-ocean-400 hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left <?php echo e(request()->is('patroller*') ? 'bg-ocean-600/30' : ''); ?>">
                    <span class="text-lg">👤</span>
                    <span class="text-sm font-medium"><?php echo e(Auth::user()->name); ?></span>
                    <svg class="w-4 h-4 ml-auto transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <div class="ml-8 space-y-1 mobile-account-menu hidden">
                    <?php if(auth()->user()->role === 'admin'): ?>
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="mobile-nav-link flex items-center gap-3 px-3 py-2 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors <?php echo e(request()->is('admin/dashboard') ? '!bg-ocean-600/30 !text-ocean-300' : 'text-gray-300'); ?>" style="<?php echo e(request()->is('admin/dashboard') ? 'background-color: rgba(20, 184, 166, 0.3) !important; color: #5eead4 !important;' : ''); ?>">
                            <span class="text-lg">📊</span>
                            <span class="text-sm font-medium">Dashboard</span>
                        </a>
                    <?php elseif(auth()->user()->role === 'patroller'): ?>
                        <a href="<?php echo e(route('patroller.dashboard')); ?>" class="mobile-nav-link flex items-center gap-3 px-3 py-2 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors <?php echo e(request()->is('patroller/dashboard') ? '!bg-ocean-600/30 !text-ocean-300' : 'text-gray-300'); ?>" style="<?php echo e(request()->is('patroller/dashboard') ? 'background-color: rgba(20, 184, 166, 0.3) !important; color: #5eead4 !important;' : ''); ?>">
                            <span class="text-lg">📊</span>
                            <span class="text-sm font-medium">Dashboard</span>
                        </a>
                    <?php else: ?>
                        <a href="/profile" class="mobile-nav-link flex items-center gap-3 px-3 py-2 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors <?php echo e(request()->is('profile') ? '!bg-ocean-600/30 !text-ocean-300' : 'text-gray-300'); ?>" style="<?php echo e(request()->is('profile') ? 'background-color: rgba(20, 184, 166, 0.3) !important; color: #5eead4 !important;' : ''); ?>">
                            <span class="text-lg">👤</span>
                            <span class="text-sm font-medium">Profile</span>
                        </a>
                    <?php endif; ?>

                    <form method="POST" action="/logout" class="w-full">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors w-full text-left">
                            <span class="text-lg">🚪</span>
                            <span class="text-sm font-medium">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
            <?php else: ?>
            <div class="space-y-1">
                <button class="mobile-account-toggle flex items-center gap-3 text-white hover:text-ocean-400 hover:bg-ocean-600/20 px-3 py-2 rounded-lg transition-colors w-full text-left">
                    <span class="text-lg">👤</span>
                    <span class="text-sm font-medium">Account</span>
                    <svg class="w-4 h-4 ml-auto transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <div class="ml-8 space-y-1 mobile-account-menu hidden">
                    <a href="#" onclick="event.preventDefault(); openAuthModal('login')" class="mobile-nav-link flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors w-full text-left">
                        <span class="text-lg">🔑</span>
                        <span class="text-sm font-medium">Login</span>
                    </a>
                    <a href="#" onclick="event.preventDefault(); openAuthModal('register')" class="mobile-nav-link flex items-center gap-3 px-3 py-2 text-gray-300 hover:text-white hover:bg-ocean-600/20 rounded-lg transition-colors w-full text-left">
                        <span class="text-lg">📝</span>
                        <span class="text-sm font-medium">Register</span>
                    </a>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</nav>

<script>
(function() {
    'use strict';
    
    let menuOpen = false;
    let clickJustHappened = false;
    
    function init() {
        const menuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        
        if (!menuButton || !mobileMenu) {
            return;
        }
        
        // Toggle menu on button click
        menuButton.onclick = function(e) {
            e.stopPropagation();
            clickJustHappened = true;
            
            menuOpen = !menuOpen;
            
            if (menuOpen) {
                mobileMenu.classList.remove('hidden');
                this.querySelector('svg').innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />';
            } else {
                mobileMenu.classList.add('hidden');
                this.querySelector('svg').innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />';
            }
            
            setTimeout(() => { clickJustHappened = false; }, 100);
        };
        
        // Close menu when clicking nav links
        mobileMenu.addEventListener('click', function(e) {
            if (e.target.closest('.mobile-nav-link')) {
                menuOpen = false;
                mobileMenu.classList.add('hidden');
                menuButton.querySelector('svg').innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />';
            }
        });
        
        // Account dropdown toggle
        mobileMenu.addEventListener('click', function(e) {
            const toggle = e.target.closest('.mobile-account-toggle');
            if (toggle) {
                e.stopPropagation();
                const submenu = toggle.nextElementSibling;
                const arrow = toggle.querySelector('svg');
                
                if (submenu && submenu.classList.contains('mobile-account-menu')) {
                    submenu.classList.toggle('hidden');
                    if (arrow) {
                        arrow.classList.toggle('rotate-180');
                    }
                }
            }
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            if (!clickJustHappened && menuOpen && !mobileMenu.contains(e.target) && !menuButton.contains(e.target)) {
                menuOpen = false;
                mobileMenu.classList.add('hidden');
                menuButton.querySelector('svg').innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />';
            }
        });
        
        // Close on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && menuOpen) {
                menuOpen = false;
                mobileMenu.classList.add('hidden');
                menuButton.querySelector('svg').innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />';
            }
        });
    }
    
    // Initialize when ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
</script>

<?php echo $__env->make('auth.modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php /**PATH C:\Users\Rayver\Desktop\my_app\resources\views/patroller/navigation.blade.php ENDPATH**/ ?>
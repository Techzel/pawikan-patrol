<?php $__env->startSection('content'); ?>
<div class="min-h-screen flex items-center justify-center p-4">
    <div class="glass w-full max-w-md p-8 rounded-2xl shadow-2xl">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-white mb-2">Create Account</h1>
            <p class="text-gray-300">Join our sea turtle conservation community</p>
        </div>

        <form method="POST" action="<?php echo e(route('register')); ?>" class="space-y-6">
            <?php echo csrf_field(); ?>
            
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-300 mb-1">Full Name</label>
                <input id="name" type="text" name="name" value="<?php echo e(old('name')); ?>" required autofocus 
                       class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-white placeholder-gray-400"
                       placeholder="Enter your full name">
                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-400"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-300 mb-1">Email Address</label>
                <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required
                       class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-white placeholder-gray-400"
                       placeholder="Enter your email">
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-400"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-300 mb-1">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                       class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-white placeholder-gray-400"
                       placeholder="Create a password">
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-400"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-1">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                       class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent text-white placeholder-gray-400"
                       placeholder="Confirm your password">
            </div>

            <div class="pt-2">
                <button type="submit" 
                        class="w-full bg-teal-600 hover:bg-teal-700 text-white font-medium py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center">
                    <span>Create Account</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </form>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-400">
                Already have an account?
                <a href="<?php echo e(route('login.redirect')); ?>" class="text-teal-400 hover:text-teal-300 font-medium">
                    Sign in
                </a>
            </p>
        </div>
    </div>
</div>

<!-- Add some ocean-themed decorative elements -->
<div class="ocean-wave"></div>

<style>
    .ocean-wave {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 100px;
        background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%2314b8a6" fill-opacity="0.2" d="M0,192L48,197.3C96,203,192,213,288,229.3C384,245,480,267,576,250.7C672,235,768,181,864,181.3C960,181,1056,235,1152,234.7C1248,235,1344,181,1392,154.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');
        background-size: cover;
        background-repeat: no-repeat;
        z-index: -1;
        animation: wave 15s linear infinite;
    }

    @keyframes wave {
        0% { background-position-x: 0; }
        100% { background-position-x: 100%; }
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rayver\Desktop\pawikan-patrol\my_app\resources\views/auth/register.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title', 'DENR Admin Dashboard'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
        #admin-dashboard,
        #admin-dashboard * {
            font-family: 'Cinzel', serif !important;
            letter-spacing: 0.02em;
        }

        /* Preserve Font Awesome glyphs */
        #admin-dashboard .fa,
        #admin-dashboard .fas,
        #admin-dashboard .far,
        #admin-dashboard .fal,
        #admin-dashboard .fab,
        #admin-dashboard i[class^="fa-"],
        #admin-dashboard i[class*=" fa-"] {
            font-family: "Font Awesome 6 Free", "Font Awesome 6 Pro", "Font Awesome 5 Free", "Font Awesome 5 Pro", sans-serif !important;
            letter-spacing: normal;
            font-weight: 900;
        }

        /* Typography hierarchy */
        .section-heading {
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .section-subheading {
            font-weight: 600;
            letter-spacing: 0.05em;
        }

        .stat-label {
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            font-size: 0.875rem;
        }

        .body-text {
            font-weight: 400;
            letter-spacing: 0.01em;
        }

        .body-muted {
            font-weight: 400;
            letter-spacing: 0.01em;
            opacity: 0.85;
        }
        
        /* Force Poppins font for form elements in admin dashboard */
        #createPatrollerModal input[type="text"],
        #createPatrollerModal input[type="email"],
        #createPatrollerModal input[type="tel"],
        #createPatrollerModal input[type="password"],
        #createPatrollerModal label {
            font-family: 'Poppins', ui-sans-serif, system-ui, sans-serif !important;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <!-- Background Wrapper -->
    <div id="admin-dashboard" class="min-h-screen bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 pt-20">
        <!-- Main Dashboard Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-12 relative z-10">
            <!-- Professional Admin Header -->
            <header class="mb-8 sm:mb-10">
            <!-- Full-width header background -->
            <div class="bg-gradient-to-r from-slate-900/80 via-blue-900/60 to-slate-900/80 border-b border-blue-400/30 backdrop-blur-lg rounded-2xl">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
                    <!-- Header content grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 items-center gap-6">
                        <!-- Left side - Status indicators -->
                        <div class="flex items-center justify-center lg:justify-start gap-3">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                                <span class="text-green-300 text-xs sm:text-sm font-medium body-text">System Active</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 bg-blue-400 rounded-full animate-pulse delay-75"></div>
                                <span class="text-blue-300 text-xs sm:text-sm font-medium body-text">Secure Connection</span>
                            </div>
                        </div>
                        
                        <!-- Center - Main title -->
                        <div class="text-center">
                            <div class="flex flex-col items-center gap-2">
                                <div class="flex items-center gap-3">   
                                    <h1 class="text-xl sm:text-2xl font-bold text-blue-100 tracking-wider uppercase section-heading">Administrative Control Center</h1>
                                </div>
                                <p class="text-gray-300 text-sm sm:text-base font-medium body-text">DENR Pawikan Patrol Management System</p>
                            </div>
                        </div>
                        
                        <!-- Right side - Authority info -->
                        <div class="flex items-center justify-center lg:justify-end gap-3">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-user-shield text-blue-400 text-sm"></i>
                                <span class="text-blue-300 text-xs sm:text-sm font-medium body-text">Authorized Access</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="fas fa-lock text-blue-400 text-sm"></i>
                                <span class="text-blue-300 text-xs sm:text-sm font-medium body-text">Encrypted</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Bottom accent line -->
                    <div class="mt-4 h-px bg-gradient-to-r from-transparent via-blue-400/50 to-transparent"></div>
                </div>
            </div>
        </header>
        <!-- Dashboard Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
            <div class="bg-white/10 backdrop-blur-md rounded-xl p-4 sm:p-6 border border-white/20">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-300 stat-label">Total Patrollers</p>
                        <p class="text-3xl font-bold text-white mt-2"><?php echo e($totalPatrollers); ?></p>
                    </div>
                    <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-users text-blue-400 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white/10 backdrop-blur-md rounded-xl p-4 sm:p-6 border border-white/20">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-300 stat-label">Active Patrollers</p>
                        <p class="text-3xl font-bold text-green-400 mt-2"><?php echo e($totalPatrollers); ?></p>
                    </div>
                    <div class="w-12 h-12 bg-green-500/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user-check text-green-400 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white/10 backdrop-blur-md rounded-xl p-4 sm:p-6 border border-white/20">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-300 stat-label">Accepted Reports</p>
                        <p class="text-3xl font-bold text-purple-400 mt-2"><?php echo e($totalAcceptedReports); ?></p>
                    </div>
                    <div class="w-12 h-12 bg-purple-500/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clipboard-check text-purple-400 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white/10 backdrop-blur-md rounded-xl p-4 sm:p-6 border border-white/20">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-300 stat-label">User Verifications</p>
                        <p class="text-3xl font-bold text-ocean-300 mt-2"><?php echo e($totalVerifiedUsers); ?></p>
                    </div>
                    <div class="w-12 h-12 bg-ocean-500/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-id-card-alt text-ocean-300 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Management Sections -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
            <!-- Patroller Management -->
            <div class="lg:col-span-2">
                <div class="bg-white/10 backdrop-blur-md rounded-xl border border-white/20">
                    <div class="p-4 sm:p-6 border-b border-white/10">
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4">
                            <h2 class="text-lg sm:text-xl font-bold text-white cinzel-subheading section-heading">Patroller Management</h2>
                            <button onclick="openCreatePatrollerModal()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 sm:py-2.5 rounded-lg font-medium transition-colors text-sm sm:text-base w-full sm:w-auto body-text">
                                <i class="fas fa-plus mr-2"></i>Create Patroller
                            </button>
                        </div>
                    </div>
                    <div class="p-4 sm:p-6">
                        <div class="overflow-x-auto">
                            <table class="w-full min-w-[600px]">
                                <thead>
                                    <tr class="text-center text-gray-300 border-b border-white/10">
                                        <th class="pb-3 font-medium text-sm sm:text-base stat-label">Name</th>
                                        <th class="pb-3 font-medium text-sm sm:text-base stat-label">Email</th>
                                        <th class="pb-3 font-medium text-sm sm:text-base stat-label">Status</th>
                                        <th class="pb-3 font-medium text-sm sm:text-base stat-label hidden sm:table-cell">Created By</th>
                                        <th class="pb-3 font-medium text-sm sm:text-base stat-label hidden sm:table-cell">Created</th>
                                        <th class="pb-3 font-medium text-sm sm:text-base stat-label">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="text-white">
                                    <?php $__currentLoopData = $patrollers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patroller): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="border-b border-white/5 hover:bg-white/5">
                                        <td class="py-3 sm:py-4 text-center">
                                            <div class="font-medium section-subheading"><?php echo e($patroller->name); ?></div>
                                            <div class="text-xs sm:text-sm text-gray-400 sm:hidden body-muted"><?php echo e($patroller->email); ?></div>
                                        </td>
                                        <td class="py-3 sm:py-4 hidden sm:table-cell text-center"><?php echo e($patroller->email); ?></td>
                                        <td class="py-3 sm:py-4 text-center">
                                            <span class="px-2 py-1 text-xs rounded-full <?php echo e($patroller->status == 'active' ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400'); ?>">
                                                <?php echo e(ucfirst($patroller->status)); ?>

                                            </span>
                                        </td>
                                        <td class="py-3 sm:py-4 hidden sm:table-cell text-center">
                                            <?php if($patroller->getCreatedByDisplayName() === 'admin'): ?>
                                                <span class="text-blue-300 font-medium body-text">admin</span>
                                            <?php else: ?>
                                                <?php echo e($patroller->getCreatedByDisplayName()); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td class="py-3 sm:py-4 hidden sm:table-cell text-center"><?php echo e($patroller->created_at->format('M d, Y')); ?></td>
                                        <td class="py-3 sm:py-4 text-center">
                                            <div class="flex items-center justify-center space-x-1 sm:space-x-2">
                                                <button onclick="deletePatroller(<?php echo e($patroller->id); ?>)" class="text-red-400 hover:text-red-300 p-1.5 sm:p-2 rounded hover:bg-red-500/20 transition-colors" title="Delete">
                                                    <i class="fas fa-trash text-sm"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="space-y-4 sm:space-y-6">
                <!-- User Verification Management -->
                <div class="bg-white/10 backdrop-blur-md rounded-xl border border-white/20">
                    <div class="p-4 sm:p-6">
                        <h3 class="text-base sm:text-lg font-bold text-white mb-3 sm:mb-4 cinzel-subheading section-heading">User Verification</h3>
                        <div class="space-y-2 sm:space-y-3">
                            <a href="<?php echo e(route('admin.verification.index')); ?>" class="flex items-center justify-between p-3 bg-blue-500/20 rounded-lg hover:bg-blue-500/30 transition-colors">
                                <div class="flex items-center space-x-2 sm:space-x-3">
                                    <i class="fas fa-shield-alt text-blue-400"></i>
                                    <span class="text-white text-sm sm:text-base body-text">Verification Dashboard</span>
                                </div>
                                <i class="fas fa-arrow-right text-blue-400"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Patrol Reports Management -->
                <div class="bg-white/10 backdrop-blur-md rounded-xl border border-white/20">
                    <div class="p-4 sm:p-6">
                        <h3 class="text-base sm:text-lg font-bold text-white mb-3 sm:mb-4 cinzel-subheading section-heading">Patrol Reports</h3>
                        <div class="space-y-2 sm:space-y-3">
                            <a href="<?php echo e(route('admin.patrol-reports.index')); ?>" class="flex items-center justify-between p-3 bg-indigo-500/20 rounded-lg hover:bg-indigo-500/30 transition-colors">
                                <div class="flex items-center space-x-2 sm:space-x-3">
                                    <i class="fas fa-list text-indigo-400"></i>
                                    <span class="text-white text-sm sm:text-base body-text">Manage Reports</span>
                                </div>
                                <i class="fas fa-arrow-right text-indigo-400"></i>
                            </a>
                        </div>
                    </div>
                </div>



            </div>
        </div>
            </main>
        </div>

    <!-- Create Patroller Modal -->
    <div id="createPatrollerModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white/10 backdrop-blur-md rounded-xl border border-white/20 w-full max-w-md sm:max-w-lg mx-auto mt-14 sm:mt-20">
            <div class="p-6 border-b border-white/10">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-bold text-white cinzel-subheading section-heading">Create New Patroller</h3>
                    <button onclick="closeCreatePatrollerModal()" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            
            <form id="createPatrollerForm" action="<?php echo e(route('admin.patrollers.store')); ?>" method="POST" class="p-6 space-y-6">
                <?php echo csrf_field(); ?>
                <div class="space-y-3">
                    <h4 class="text-sm font-semibold text-white uppercase tracking-wide section-heading">Basic Information</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-300 mb-2 body-text">Full Name</label>
                            <input type="text" id="name" name="name" required
                                   class="w-full px-4 py-2 bg-white/10 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Enter full name">
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
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-300 mb-2 body-text">Username</label>
                            <input type="text" id="username" name="username" required
                                   class="w-full px-4 py-2 bg-white/10 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Enter username">
                            <?php $__errorArgs = ['username'];
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
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-300 mb-2 body-text">Email Address</label>
                            <input type="email" id="email" name="email" required
                                   class="w-full px-4 py-2 bg-white/10 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Enter email address">
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
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-300 mb-2 body-text">Phone Number</label>
                            <input type="tel" id="phone" name="phone"
                                   class="w-full px-4 py-2 bg-white/10 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Optional contact number">
                            <?php $__errorArgs = ['phone'];
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
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-300 mb-2 body-text">Password</label>
                            <div class="relative">
                                <input type="password" id="password" name="password" required minlength="8"
                                       class="w-full px-4 py-2 pr-10 bg-white/10 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="Enter password">
                                <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-300 hover:text-white" aria-label="Show password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
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
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-300 mb-2 body-text">Confirm Password</label>
                            <div class="relative">
                                <input type="password" id="password_confirmation" name="password_confirmation" required
                                       class="w-full px-4 py-2 pr-10 bg-white/10 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="Confirm password">
                                <button type="button" id="toggleConfirmPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-300 hover:text-white" aria-label="Show confirm password">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <?php $__errorArgs = ['password_confirmation'];
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
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" onclick="closeCreatePatrollerModal()" 
                            class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg font-medium transition-colors body-text">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors body-text">
                        <i class="fas fa-plus mr-2"></i>Create Patroller
                    </button>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('createPatrollerModal');
    const createPatrollerForm = document.getElementById('createPatrollerForm');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('password_confirmation');
    const togglePasswordBtn = document.getElementById('togglePassword');
    const toggleConfirmPasswordBtn = document.getElementById('toggleConfirmPassword');

    if (!modal || !createPatrollerForm || !passwordInput || !confirmPasswordInput || !togglePasswordBtn || !toggleConfirmPasswordBtn) {
        return;
    }

    const toggleVisibility = (input, button) => {
        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';
        const icon = button.querySelector('i');
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
        button.setAttribute('aria-label', isPassword ? 'Hide password' : 'Show password');
    };

    togglePasswordBtn.addEventListener('click', () => toggleVisibility(passwordInput, togglePasswordBtn));
    toggleConfirmPasswordBtn.addEventListener('click', () => toggleVisibility(confirmPasswordInput, toggleConfirmPasswordBtn));

    const openModal = () => {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    };

    const closeModal = () => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = 'auto';
        createPatrollerForm.reset();
        passwordInput.type = 'password';
        confirmPasswordInput.type = 'password';
        togglePasswordBtn.querySelector('i').classList.remove('fa-eye-slash');
        togglePasswordBtn.querySelector('i').classList.add('fa-eye');
        togglePasswordBtn.setAttribute('aria-label', 'Show password');
        toggleConfirmPasswordBtn.querySelector('i').classList.remove('fa-eye-slash');
        toggleConfirmPasswordBtn.querySelector('i').classList.add('fa-eye');
        toggleConfirmPasswordBtn.setAttribute('aria-label', 'Show confirm password');
    };

    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            closeModal();
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeModal();
        }
    });

    window.openCreatePatrollerModal = openModal;
    window.closeCreatePatrollerModal = closeModal;
});

function deletePatroller(patrollerId) {
    if (confirm('Are you sure you want to delete this patroller? This action cannot be undone.')) {
        // Create form element
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `<?php echo e(route('admin.patrollers.destroy', ':id')); ?>`.replace(':id', patrollerId);
        
        // Add CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (csrfToken) {
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrfToken.getAttribute('content');
            form.appendChild(csrfInput);
        }
        
        // Add DELETE method
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);
        
        // Submit form
        document.body.appendChild(form);
        form.submit();
    }
}
</script>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rayver\Desktop\my_app\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>
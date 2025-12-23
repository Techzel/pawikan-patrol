<?php $__env->startSection('title', 'User Verification Dashboard'); ?>

<?php $__env->startSection('meta'); ?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* Base Styles */
    :root {
        --primary: #10b981;
        --primary-dark: #059669;
        --secondary: #3b82f6;
        --danger: #ef4444;
        --warning: #f59e0b;
        --success: #10b981;
        --info: #3b82f6;
        --dark: #0f172a;
        --light: #f8fafc;
        --glass-bg: rgba(255, 255, 255, 0.03);
        --glass-border: rgba(255, 255, 255, 0.08);
    }

    /* Use Poppins typography */
    #verificationDashboard,
    #verificationDashboard * {
        font-family: 'Poppins', sans-serif !important;
        letter-spacing: 0.01em;
    }

    /* Preserve Font Awesome glyphs */
    #verificationDashboard .fa,
    #verificationDashboard .fas,
    #verificationDashboard .far,
    #verificationDashboard .fal,
    #verificationDashboard .fab,
    #verificationDashboard i[class^="fa-"],
    #verificationDashboard i[class*=" fa-"] {
        font-family: "Font Awesome 6 Free", "Font Awesome 6 Pro", "Font Awesome 5 Free", "Font Awesome 5 Pro", sans-serif !important;
        letter-spacing: normal;
        font-weight: 900;
    }

    /* Glass Card */
    .glass-card {
        background: var(--glass-bg);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid var(--glass-border);
        border-radius: 1rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
        position: relative;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    /* Stats Cards */
    .stat-card {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.75rem;
        font-size: 1.25rem;
        transition: all 0.3s ease;
    }
    
    /* Progress Bars */
    .progress-container {
        height: 6px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 3px;
        overflow: hidden;
    }
    
    .progress-bar {
        height: 100%;
        border-radius: 3px;
        transition: width 1s ease-in-out;
    }

    /* Status Badges */
    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.375rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        gap: 0.5rem;
        border-width: 1px;
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .fade-in {
        animation: fadeIn 0.5s ease-out forwards;
    }

    .animate-spin {
        animation: spin 1s linear infinite;
    }

    /* Layout Utilities */
    .main-container {
        max-width: 1400px;
    }

    .glass-nav {
        background: rgba(15, 23, 42, 0.8);
        backdrop-filter: blur(10px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    /* Custom Scrollbar */
    .mobile-scroll::-webkit-scrollbar {
        height: 4px;
    }

    .mobile-scroll::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.05);
    }

    .mobile-scroll::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 2px;
    }

    /* Action Buttons */
    .action-btn {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.5rem;
        transition: all 0.2s ease;
        border-width: 1px;
    }

    .action-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        pointer-events: none;
    }

    .action-btn:not(:disabled):hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .action-btn i {
        pointer-events: none;
    }

    /* Loading States */
    .loading-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-900 pt-20 pb-16" id="verificationDashboard">
    <!-- Main Dashboard Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-12 relative z-10 main-container">
        <!-- Back Button -->
        <div class="mb-4">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="inline-flex items-center gap-2 text-gray-300 hover:text-white transition-colors group">
                <i class="fas fa-arrow-left text-sm group-hover:-translate-x-1 transition-transform"></i>
                <span class="text-sm font-medium">Back to Dashboard</span>
            </a>
        </div>

        <!-- Verification Dashboard Header -->
        <header class="mb-8 sm:mb-10 relative overflow-hidden rounded-2xl glass-card transform transition-all duration-500 hover:shadow-2xl">
            <!-- Background with animated gradient -->
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-900/80 via-teal-900/70 to-cyan-900/80 backdrop-blur-sm">
                <div class="absolute inset-0 opacity-20" style="background-image: url(&quot;data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M54.627 0l-5.334 5.333-2.94-2.94-1.393 1.393 2.94 2.94-5.334 5.334-2.94-2.94-1.394 1.394 2.94 2.94-5.333 5.333-2.94-2.94-1.394 1.393 2.94 2.94-5.334 5.334-2.94-2.94-1.393 1.394 2.94 2.94-5.333 5.333-2.94-2.94-1.394 1.393 2.94 2.94L0 54.627l2.94 2.94 1.393-1.394-2.94-2.94 5.333-5.333 2.94 2.94 1.394-1.393-2.94-2.94 5.334-5.334 2.94 2.94 1.393-1.393-2.94-2.94 5.333-5.333 2.94 2.94 1.394-1.393-2.94-2.94 5.334-5.334 2.94 2.94 1.393-1.393-2.94-2.94 5.333-5.334 2.94 2.94 1.394-1.393-2.94-2.94L60 5.373 57.06 2.433l-1.393 1.394 2.94 2.94L54.627 0z' fill='%23ffffff' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E&quot;);"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-emerald-500/10 via-transparent to-cyan-500/10"></div>
            </div>
            
            <!-- Main header content -->
            <div class="relative z-10 p-6 sm:p-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <!-- Left side - Title and description -->
                    <div class="text-center md:text-left">
                        <div class="flex items-center justify-center md:justify-start gap-3 mb-2">
                            <div class="p-2 bg-emerald-500/20 rounded-lg border border-emerald-400/30 transition-all duration-300 hover:bg-emerald-500/30">
                                <i class="fas fa-user-shield text-2xl text-emerald-400"></i>
                            </div>
                            <h1 class="text-2xl sm:text-3xl font-bold text-white tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-emerald-300 to-cyan-300 header-title cinzel-heading">
                                User Verification Hub
                            </h1>
                        </div>
                        <p class="text-teal-200 text-sm sm:text-base max-w-2xl">
                            Manage and monitor user verification requests with comprehensive tools and real-time updates
                        </p>
                    </div>
                </div>
                
                <!-- Status bar -->
                <div class="mt-6 pt-4 border-t border-white/10 flex flex-wrap items-center justify-center gap-4 text-xs text-gray-300 status-info">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>System Status: <span class="font-medium text-white">Operational</span></span>
                    </div>
                    <div class="hidden sm:block w-px h-4 bg-white/20"></div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-shield-alt text-amber-400"></i>
                        <span>Security: <span class="font-medium text-white">Verified Secure</span></span>
                    </div>
                    <div class="hidden sm:block w-px h-4 bg-white/20"></div>
                    <div class="flex items-center gap-2" title="Auto-refreshes statistics">
                        <i class="fas fa-sync-alt text-blue-400" id="refreshIcon"></i>
                        <span>Last updated: <span class="font-medium text-white" id="lastUpdated">Just now</span></span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Stats Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 stat-grid">
            <!-- Total Users Card -->
            <div class="glass-card p-6 stat-card hover:shadow-lg transform transition-all duration-300 hover:border-blue-400/50 border border-white/10 rounded-xl backdrop-blur-lg bg-gradient-to-br from-blue-900/30 to-cyan-900/30">
                <div class="flex items-center justify-between">
                    <div class="fade-in">
                        <p class="text-gray-400 text-sm uppercase tracking-wider mb-2 cinzel-text">Total Users</p>
                        <h3 class="text-4xl font-bold text-white mb-1"><?php echo e($totalUsers); ?></h3>
                        <p class="text-xs text-gray-400">Registered accounts</p>
                    </div>
                    <div class="stat-icon bg-gradient-to-br from-blue-500/20 to-blue-600/20 border border-blue-500/30 hover:shadow-lg">
                        <i class="fas fa-users text-blue-400"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center justify-between text-xs text-gray-400 mb-1">
                        <span>Active now</span>
                        <span class="flex items-center">
                            <span class="w-2 h-2 bg-green-400 rounded-full mr-1 animate-pulse"></span>
                            <span><?php echo e($pendingUsers); ?></span>
                        </span>
                    </div>
                    <div class="progress-container">
                        <div class="progress-bar bg-blue-500" style="width: <?php echo e($pendingPercentage); ?>%"></div>
                    </div>
                </div>
            </div>

            <!-- Pending Verifications Card -->
            <div class="glass-card p-6 stat-card hover:shadow-lg transform transition-all duration-300 hover:border-yellow-400/50 border border-white/10 rounded-xl backdrop-blur-lg bg-gradient-to-br from-amber-900/30 to-yellow-900/30">
                <div class="flex items-center justify-between">
                    <div class="fade-in">
                        <p class="text-gray-400 text-sm uppercase tracking-wider mb-2 cinzel-text">Pending</p>
                        <h3 class="text-4xl font-bold text-yellow-400 mb-1"><?php echo e($pendingUsers); ?></h3>
                        <p class="text-xs text-gray-400"><?php echo e($pendingPercentage); ?>% of total</p>
                    </div>
                    <div class="stat-icon bg-gradient-to-br from-yellow-500/20 to-yellow-600/20 border border-yellow-500/30 hover:shadow-lg">
                        <i class="fas fa-clock text-yellow-400"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center justify-between text-xs text-gray-400 mb-1">
                        <span>Verified by DENR</span>
                    </div>
                    <div class="progress-container">
                        <div class="progress-bar bg-gradient-to-r from-yellow-500 to-amber-500" style="width: <?php echo e($pendingPercentage); ?>%"></div>
                    </div>
                </div>
            </div>

            <!-- Verified Users Card -->
            <div class="glass-card p-6 stat-card hover:shadow-lg transform transition-all duration-300 hover:border-green-400/50 border border-white/10 rounded-xl backdrop-blur-lg bg-gradient-to-br from-emerald-900/30 to-green-900/30">
                <div class="flex items-center justify-between">
                    <div class="fade-in">
                        <p class="text-gray-400 text-sm uppercase tracking-wider mb-2 cinzel-text">Verified</p>
                        <h3 class="text-4xl font-bold text-green-400 mb-1"><?php echo e($verifiedUsers); ?></h3>
                        <p class="text-xs text-gray-400"><?php echo e($verifiedPercentage); ?>% of total</p>
                    </div>
                    <div class="stat-icon bg-gradient-to-br from-green-500/20 to-green-600/20 border border-green-500/30 hover:shadow-lg">
                        <i class="fas fa-check-circle text-green-400"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center justify-between text-xs text-gray-400 mb-1">
                        <span>Verified Today</span>
                        <span><?php echo e($verifiedToday); ?></span>
                    </div>
                    <div class="progress-container">
                        <div class="progress-bar bg-gradient-to-r from-green-500 to-emerald-500" style="width: <?php echo e($verifiedPercentage); ?>%"></div>
                    </div>
                </div>
            </div>

            <!-- Rejected Verifications Card -->
            <div class="glass-card p-6 stat-card hover:shadow-lg transform transition-all duration-300 hover:border-red-400/50 border border-white/10 rounded-xl backdrop-blur-lg bg-gradient-to-br from-rose-900/30 to-red-900/30">
                <div class="flex items-center justify-between">
                    <div class="fade-in">
                        <p class="text-gray-400 text-sm uppercase tracking-wider mb-2 cinzel-text">Rejected</p>
                        <h3 class="text-4xl font-bold text-red-400 mb-1"><?php echo e($rejectedUsers); ?></h3>
                        <p class="text-xs text-gray-400"><?php echo e($rejectedPercentage); ?>% of total</p>
                    </div>
                    <div class="stat-icon bg-gradient-to-br from-red-500/20 to-red-600/20 border border-red-500/30 hover:shadow-lg">
                        <i class="fas fa-times-circle text-red-400"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center justify-between text-xs text-gray-400 mb-1">
                        <span>This month</span>
                        <span><?php echo e($rejectedThisMonth); ?></span>
                    </div>
                    <div class="progress-container">
                        <div class="progress-bar bg-gradient-to-r from-red-500 to-rose-500" style="width: <?php echo e($rejectedPercentage); ?>%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity Section -->
        <div class="glass-card rounded-2xl shadow-xl overflow-hidden mt-8">
            <div class="p-6 border-b border-white/10 flex items-center justify-between bg-gradient-to-r from-blue-900/30 to-cyan-900/30">
                <div>
                    <h2 class="text-2xl font-bold text-white cinzel-subheading">Recent Verification Activity</h2>
                    <p class="text-gray-400 text-sm mt-1">Latest user verification requests and updates</p>
                </div>
            </div>
            
            <div class="overflow-x-auto mobile-scroll">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-white/10">
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white/80 uppercase tracking-wider bg-white/5 cinzel-text">User</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white/80 uppercase tracking-wider bg-white/5 cinzel-text">Email</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white/80 uppercase tracking-wider bg-white/5 cinzel-text">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white/80 uppercase tracking-wider bg-white/5 cinzel-text">Verified By</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white/80 uppercase tracking-wider bg-white/5 cinzel-text">Date</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white/80 uppercase tracking-wider bg-white/5 cinzel-text">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $recentActivity; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-white/5 transition-all duration-200 border-b border-white/5 last:border-0">
                                <td class="px-6 py-4 text-white/90">
                                    <div class="flex items-center gap-3">
                                        <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($user->name)); ?>&background=3b82f6&color=fff" 
                                             alt="<?php echo e($user->name); ?>" 
                                             class="w-10 h-10 rounded-full border-2 border-blue-500/30">
                                        <span class="text-white font-medium"><?php echo e($user->name); ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-300"><?php echo e($user->email); ?></td>
                                <td class="px-6 py-4 text-white/90">
                                    <?php if($user->verification_status === 'pending'): ?>
                                        <span class="status-badge bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                            <i class="fas fa-clock text-xs"></i>
                                            Pending
                                        </span>
                                    <?php elseif($user->verification_status === 'verified'): ?>
                                        <span class="status-badge bg-green-500/20 text-green-400 border border-green-500/30">
                                            <i class="fas fa-check text-xs"></i>
                                            Verified
                                        </span>
                                    <?php elseif($user->verification_status === 'rejected'): ?>
                                        <span class="status-badge bg-red-500/20 text-red-400 border border-red-500/30">
                                            <i class="fas fa-times text-xs"></i>
                                            Rejected
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-gray-300">
                                    <?php if($user->verifiedBy): ?>
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-user-shield text-blue-400 text-xs"></i>
                                            <?php echo e($user->verifiedBy->name); ?>

                                        </div>
                                    <?php else: ?>
                                        <span class="text-gray-500">—</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-gray-300">
                                    <div class="flex flex-col">
                                        <span><?php echo e($user->updated_at->format('M d, Y')); ?></span>
                                        <span class="text-xs text-gray-500"><?php echo e($user->updated_at->format('H:i')); ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2 action-buttons">
                                        <!-- View Button -->
                                            <button 
                                                onclick="openUserModal('<?php echo e($user->id); ?>')"
                                                class="action-btn bg-blue-500/20 hover:bg-blue-500/30 text-blue-400 border-blue-500/30 hover:border-blue-400/60"
                                                data-user-id="<?php echo e($user->id); ?>"
                                                id="viewBtn<?php echo e($user->id); ?>"
                                                title="View User Details">
                                                <i class="fas fa-eye text-sm" id="viewIcon<?php echo e($user->id); ?>"></i>
                                            </button>

                                        <?php if($user->verification_status === 'pending'): ?>
                                            <!-- Approve Button -->
                                            <button 
                                                onclick="approveUser('<?php echo e($user->id); ?>')"
                                                class="action-btn bg-green-500/20 hover:bg-green-500/30 text-green-400 border-green-500/30 hover:border-green-400/60"
                                                data-user-id="<?php echo e($user->id); ?>"
                                                id="approveBtn<?php echo e($user->id); ?>"
                                                title="Approve User">
                                                <i class="fas fa-check text-sm" id="approveIcon<?php echo e($user->id); ?>"></i>
                                                <i class="fas fa-spinner fa-spin text-sm hidden" id="approveSpinner<?php echo e($user->id); ?>"></i>
                                            </button>

                                            <!-- Reject Button -->
                                            <button 
                                                onclick="openRejectModal('<?php echo e($user->id); ?>')"
                                                class="action-btn bg-amber-500/20 hover:bg-amber-500/30 text-amber-400 border-amber-500/30 hover:border-amber-400/60"
                                                data-user-id="<?php echo e($user->id); ?>"
                                                id="rejectBtn<?php echo e($user->id); ?>"
                                                title="Reject User">
                                                <i class="fas fa-times text-sm" id="rejectIcon<?php echo e($user->id); ?>"></i>
                                                <i class="fas fa-spinner fa-spin text-sm hidden" id="rejectSpinner<?php echo e($user->id); ?>"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="fas fa-history text-gray-600 text-5xl mb-4"></i>
                                        <p class="text-gray-400 text-lg">No verification activity found</p>
                                        <p class="text-gray-500 text-sm mt-2">New verification requests will appear here</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- User Details Modal -->
    <div id="userDetailsModal" class="fixed inset-0 z-50 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-75" 
                 onclick="closeUserModal()"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block w-full mt-20 overflow-hidden text-left align-bottom transition-all transform rounded-lg shadow-xl bg-slate-800 sm:my-8 sm:align-middle sm:max-w-2xl modal-content">
                <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="w-full mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="mb-4 text-lg font-medium leading-6 text-white cinzel-subheading">
                                User Details
                            </h3>
                            <div class="mt-4 space-y-4" id="userDetailsContent">
                                <!-- User details will be loaded here -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 bg-slate-800/50 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" 
                            onclick="closeUserModal()"
                            class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-300 border border-gray-700 rounded-md shadow-sm bg-slate-800 hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Approve User Confirmation Modal -->
    <div id="approveUserModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white/10 backdrop-blur-md rounded-xl border border-green-500/30 w-full max-w-md mx-auto">
            <form id="approveUserForm" method="POST" action="">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="p-6 border-b border-white/10">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-green-500/20 rounded-full flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-400 text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-white">Approve User</h3>
                            <p class="text-gray-300 mt-2">Are you sure you want to approve this user's verification request?</p>
                        </div>
                    </div>
                </div>
                
                <div class="p-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeApproveModal()" 
                            class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg font-medium transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors">
                        Approve User
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Reject User Modal -->
    <div id="rejectUserModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white/10 backdrop-blur-md rounded-xl border border-red-500/30 w-full max-w-md mx-auto">
            <form id="rejectUserForm" method="POST" action="">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="p-6 border-b border-white/10">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-red-500/20 rounded-full flex items-center justify-center">
                            <i class="fas fa-times-circle text-red-500 text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-white">Reject User</h3>
                            <p class="text-gray-300 mt-2">Please provide a reason for rejecting this user's verification request.</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <label for="rejectReasonInput" class="block text-sm font-medium text-gray-300 mb-2">Reason for Rejection</label>
                        <textarea 
                            id="rejectReasonInput"
                            name="notes"
                            rows="4" 
                            required
                            minlength="10"
                            class="w-full px-4 py-2 bg-white/10 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
                            placeholder="Enter reason (minimum 10 characters)..."
                        ></textarea>
                    </div>
                </div>
                
                <div class="p-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeRejectModal()" 
                            class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg font-medium transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors">
                        Reject User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Vanilla JavaScript Dashboard
let currentUserId = null;

// Initialize dashboard
document.addEventListener('turbo:load', function() {
    console.log('Verification dashboard initialized');
    resetAllLoadingStates();
    updateLastUpdatedTime();
    
    // Check for server-side flash messages
    <?php if(session('success')): ?>
        showNotification('success', '<?php echo addslashes(session('success')); ?>');
    <?php endif; ?>
    
    <?php if(session('error')): ?>
        showNotification('error', '<?php echo addslashes(session('error')); ?>');
    <?php endif; ?>
});

function resetAllLoadingStates() {
    document.querySelectorAll('.action-btn').forEach(btn => {
        btn.disabled = false;
        const spinner = btn.querySelector('.fa-spinner');
        const icon = btn.querySelector('.fa-eye, .fa-check, .fa-times');
        
        if (spinner) spinner.classList.add('hidden');
        if (icon) icon.classList.remove('hidden');
    });
}

// Modal functions
function showUserModal() {
    const modal = document.getElementById('userDetailsModal');
    if (modal) modal.classList.remove('hidden');
}

function closeUserModal() {
    const modal = document.getElementById('userDetailsModal');
    if (modal) modal.classList.add('hidden');
}

// Loading state functions
function setLoadingState(userId, action, isLoading) {
    const icon = document.getElementById(`${action}Icon${userId}`);
    const spinner = document.getElementById(`${action}Spinner${userId}`);
    const button = document.getElementById(`${action}Btn${userId}`);
    
    if (isLoading) {
        if (icon) icon.classList.add('hidden');
        if (spinner) spinner.classList.remove('hidden');
        if (button) button.disabled = true;
    } else {
        if (icon) icon.classList.remove('hidden');
        if (spinner) spinner.classList.add('hidden');
        if (button) button.disabled = false;
    }
}

function updateLastUpdatedTime() {
    const now = new Date();
    const timeString = now.toLocaleTimeString('en-US', { 
        hour: '2-digit', 
        minute: '2-digit' 
    });
    const lastUpdatedElement = document.getElementById('lastUpdated');
    if (lastUpdatedElement) {
        lastUpdatedElement.textContent = timeString;
    }
}

// Main user modal function
async function openUserModal(userId) {
    console.log('Opening user modal for user ID:', userId);
    
    // Show modal immediately with loading state
    const contentDiv = document.getElementById('userDetailsContent');
    if (contentDiv) {
        contentDiv.innerHTML = `
            <div class="flex flex-col items-center justify-center py-12">
                <i class="fas fa-spinner fa-spin text-3xl text-blue-400 mb-3"></i>
                <p class="text-gray-400 animate-pulse">Loading user details...</p>
            </div>
        `;
    }
    showUserModal();
    
    try {
        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), 10000); // 10s timeout

        const response = await fetch(`/api/users/${userId}`, {
            signal: controller.signal,
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            }
        });

        clearTimeout(timeoutId);

        if (!response.ok) {
            throw new Error(`Server returned ${response.status}`);
        }

        const user = await response.json();
        
        const contentDiv = document.getElementById('userDetailsContent');
        if (contentDiv) {
            contentDiv.innerHTML = `
                <div class="p-4 bg-blue-500/20 rounded-xl border border-blue-500/30">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-blue-200 text-xs uppercase tracking-wider mb-1">Name</p>
                            <p class="text-white font-medium text-lg">${escapeHtml(user.name)}</p>
                        </div>
                        <div>
                            <p class="text-blue-200 text-xs uppercase tracking-wider mb-1">Email</p>
                            <p class="text-white">${escapeHtml(user.email)}</p>
                        </div>
                        <div>
                            <p class="text-blue-200 text-xs uppercase tracking-wider mb-1">Username</p>
                            <p class="text-white">${escapeHtml(user.username || 'N/A')}</p>
                        </div>
                        <div>
                            <p class="text-blue-200 text-xs uppercase tracking-wider mb-1">Role</p>
                            <p class="text-white uppercase text-sm">${escapeHtml(user.role)}</p>
                        </div>
                        <div>
                            <p class="text-blue-200 text-xs uppercase tracking-wider mb-1">Verification Status</p>
                            <span class="status-badge bg-blue-500/20 text-blue-400 border-blue-500/30 py-1 px-3">
                                ${escapeHtml(user.verification_status)}
                            </span>
                        </div>
                        <div>
                            <p class="text-blue-200 text-xs uppercase tracking-wider mb-1">Member Since</p>
                            <p class="text-white">${user.created_at}</p>
                        </div>
                    </div>
                    ${user.verification_notes ? `
                    <div class="mt-4 pt-4 border-t border-blue-500/20">
                        <p class="text-blue-200 text-xs uppercase tracking-wider mb-1">Admin Notes</p>
                        <p class="text-gray-300 italic">"${escapeHtml(user.verification_notes)}"</p>
                    </div>
                    ` : ''}
                </div>
            `;
        }
    } catch (error) {
        console.error('Error:', error);
        const contentDiv = document.getElementById('userDetailsContent');
        if (contentDiv) {
            contentDiv.innerHTML = `
                <div class="p-6 bg-red-500/10 rounded-xl border border-red-500/20 text-center">
                    <div class="w-12 h-12 bg-red-500/20 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-exclamation-triangle text-red-400 text-xl"></i>
                    </div>
                    <h4 class="text-white font-medium mb-1">Failed to load user details</h4>
                    <p class="text-red-300 text-sm mb-4">${escapeHtml(error.message)}</p>
                    <button onclick="openUserModal('${userId}')" class="px-4 py-2 bg-red-500/20 hover:bg-red-500/30 text-red-300 rounded-lg text-sm transition-colors border border-red-500/30">
                        <i class="fas fa-redo mr-2"></i>Retry
                    </button>
                </div>
            `;
        }
        showNotification('error', `Failed to load user: ${error.message}`);
    }
}

// Utility functions
function escapeHtml(unsafe) {
    if (!unsafe) return '';
    return unsafe
        .toString()
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

function showNotification(type, message) {
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg backdrop-blur-sm border transform transition-all duration-300 translate-x-full opacity-0 toast-notification`;
    
    if (type === 'success') {
        toast.className += ' bg-green-500/20 border-green-500/30 text-green-100';
        toast.innerHTML = `<div class="flex items-center gap-3"><i class="fas fa-check-circle text-green-400"></i><span>${escapeHtml(message)}</span></div>`;
    } else {
        toast.className += ' bg-red-500/20 border-red-500/30 text-red-100';
        toast.innerHTML = `<div class="flex items-center gap-3"><i class="fas fa-exclamation-circle text-red-400"></i><span>${escapeHtml(message)}</span></div>`;
    }
    
    document.body.appendChild(toast);
    requestAnimationFrame(() => toast.classList.remove('translate-x-full', 'opacity-0'));
    setTimeout(() => {
        toast.classList.add('translate-x-full', 'opacity-0');
        setTimeout(() => toast.remove(), 300);
    }, 5000);
}

// Global modal handling
window.openApproveModal = function(userId) {
    const modal = document.getElementById('approveUserModal');
    const form = document.getElementById('approveUserForm');
    if (!modal || !form) return;
    form.action = "<?php echo e(route('admin.verification.approve', ['id' => ':id'])); ?>".replace(':id', userId);
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

window.closeApproveModal = function() {
    const modal = document.getElementById('approveUserModal');
    if (modal) modal.classList.add('hidden');
}

window.approveUser = function(userId) { openApproveModal(userId); }

window.openRejectModal = function(userId) {
    const modal = document.getElementById('rejectUserModal');
    const form = document.getElementById('rejectUserForm');
    if (!modal || !form) return;
    form.action = "<?php echo e(route('admin.verification.reject', ['id' => ':id'])); ?>".replace(':id', userId);
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

window.closeRejectModal = function() {
    const modal = document.getElementById('rejectUserModal');
    if (modal) modal.classList.add('hidden');
}

// Close modals on Escape
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        closeApproveModal();
        closeRejectModal();
        closeUserModal();
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rayver\Desktop\my_app\resources\views/admin/verification/dashboard.blade.php ENDPATH**/ ?>
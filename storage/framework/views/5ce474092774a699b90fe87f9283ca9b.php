<?php $__env->startSection('title', 'User Verification Dashboard'); ?>

<?php $__env->startSection('meta'); ?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.35.0/dist/apexcharts.min.css">
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
        font-weight: 500;
        gap: 0.375rem;
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }

    @keyframes shimmer {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }

    @keyframes gradient-x {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }
    
    .animate-float {
        animation: float 6s ease-in-out infinite;
    }
    
    .animate-gradient-x {
        animation: gradient-x 15s ease infinite;
        background-size: 200% 200%;
    }
    
    .fade-in {
        animation: fadeIn 0.5s ease-out forwards;
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    ::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    /* Toast Notifications */
    .toast-notification {
        max-width: 90vw;
        word-wrap: break-word;
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

    /* Table Styles */
    .table-container {
        overflow-x: auto;
        border-radius: 0.5rem;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .table {
        min-width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table thead th {
        padding: 1rem 1.5rem;
        text-align: left;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: rgb(209 213 219);
        background-color: rgba(30, 41, 59, 0.5);
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .table tbody tr {
        background-color: rgba(255, 255, 255, 0.025);
        transition: background-color 150ms;
    }

    .table tbody tr:hover {
        background-color: rgba(255, 255, 255, 0.05);
    }

    .table tbody td {
        padding: 1rem 1.5rem;
        white-space: nowrap;
        font-size: 0.875rem;
        color: rgb(209 213 219);
        border-top: 1px solid rgba(255, 255, 255, 0.05);
    }

    /* Action Buttons */
    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem;
        border-radius: 0.375rem;
        border: 1px solid;
        transition: all 200ms;
        position: relative;
        min-width: 2.5rem;
        min-height: 2.5rem;
        cursor: pointer;
        font-size: 0.875rem;
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
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

    .action-btn:focus {
        outline: none;
        ring: 2px;
        ring-offset: 2px;
        ring-blue-500: 1;
    }

    .action-btn i {
        pointer-events: none;
    }

    /* Loading Skeleton */
    .skeleton {
        background: linear-gradient(90deg, rgba(255,255,255,0.05) 25%, rgba(255,255,255,0.1) 50%, rgba(255,255,255,0.05) 75%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
        border-radius: 0.375rem;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .header-stats {
            flex-direction: column;
            gap: 1rem;
        }
        
        .header-stats > div {
            min-width: 100px;
        }
    }
    
    @media (max-width: 768px) {
        .stat-card {
            margin-bottom: 1rem;
        }
        
        .stat-icon {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }
        
        .glass-card {
            border-radius: 0.75rem;
            margin: 0.5rem;
        }
        
        .table th, .table td {
            padding: 0.75rem 0.5rem;
            font-size: 0.8125rem;
        }
        
        .header-content {
            text-align: center;
        }
        
        .header-title {
            font-size: 1.5rem;
        }
        
        .action-buttons {
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .mobile-scroll {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        .status-info {
            flex-wrap: wrap;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .status-info .hidden {
            display: none !important;
        }
    }
    
    @media (max-width: 640px) {
        .main-container {
            padding: 1rem;
        }
        
        .glass-card {
            margin: 0.25rem;
            padding: 1rem;
        }
        
        .stat-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        .table-container {
            border-radius: 0.375rem;
        }
        
        .modal-content {
            margin: 1rem;
            max-width: calc(100vw - 2rem);
        }
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
                    
                    <!-- Right side - Stats summary -->
                    <div class="flex flex-wrap justify-center gap-4 header-stats">
                        <!-- Stats removed as per user request -->
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
                    <div class="flex items-center gap-2">
                        <i class="fas fa-sync-alt text-blue-400" id="refreshIcon"></i>
                        <span>Last updated: <span class="font-medium text-white" id="lastUpdated">Just now</span></span>
                    </div>
                    <div class="hidden sm:block w-px h-4 bg-white/20"></div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-user-tie text-blue-400"></i>
                        <span>Admin: <span class="font-medium text-white"><?php echo e(Auth::user()->name); ?></span></span>
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
                            <span x-text="stats.activeUsers">0</span>
                        </span>
                    </div>
                    <div class="progress-container">
                        <div class="progress-bar bg-blue-500" :style="`width: ${stats.activePercentage}%`"></div>
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
                        <span>Avg. wait time</span>
                        <span x-text="stats.avgWaitTime">--</span>
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
                        <span>Today</span>
                        <span x-text="stats.verifiedToday">0</span>
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
                        <span x-text="stats.rejectedThisMonth">0</span>
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
                <div class="flex gap-2">
                    <!-- 'View All Pending' button removed as per user request -->
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
                                            <i class="fas fa-spinner fa-spin text-sm hidden" id="viewSpinner<?php echo e($user->id); ?>"></i>
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
                                        <i class="fas fa-inbox text-gray-600 text-5xl mb-4"></i>
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
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" 
                 onclick="closeUserModal()"></div>

            <div class="inline-block align-bottom bg-slate-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full modal-content">
                <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-white mb-4 cinzel-subheading">
                                User Details
                            </h3>
                            <div class="mt-4 space-y-4" id="userDetailsContent">
                                <!-- User details will be loaded here -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse bg-slate-800/50">
                    <button type="button" 
                            onclick="closeUserModal()"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-700 shadow-sm px-4 py-2 bg-slate-800 text-base font-medium text-gray-300 hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Reason Modal -->
    <div x-show="modals.rejectReason" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;"
         x-cloak>
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" 
                 @click="modals.rejectReason = false"></div>

            <div x-show="modals.rejectReason"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-slate-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full modal-content">
                <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-white mb-4">
                                Reject User Verification
                            </h3>
                            <div class="mt-4">
                                <label for="rejectReason" class="block text-sm font-medium text-gray-300 mb-2">
                                    Reason for rejection
                                </label>
                                <textarea 
                                    x-model="rejectionReason"
                                    id="rejectReason" 
                                    rows="4" 
                                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-700 rounded-md bg-slate-700 text-white p-3"
                                    placeholder="Please provide a reason for rejecting this verification..."
                                    required
                                ></textarea>
                                <p x-show="rejectionError" class="mt-2 text-sm text-red-500" x-text="rejectionError" x-cloak></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse bg-slate-800/50">
                    <button type="button" 
                            @click="submitRejection()"
                            :disabled="isSubmitting"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50 disabled:cursor-not-allowed">
                        <span x-show="!isSubmitting">Submit Rejection</span>
                        <span x-show="isSubmitting" x-cloak>
                            <i class="fas fa-spinner fa-spin mr-2"></i>Submitting...
                        </span>
                    </button>
                    <button type="button" 
                            @click="closeRejectModal()"
                            :disabled="isSubmitting"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-700 shadow-sm px-4 py-2 bg-slate-800 text-base font-medium text-gray-300 hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50 disabled:cursor-not-allowed">
                        Cancel
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
                            <h3 class="text-xl font-bold text-white" style="font-family: 'Poppins', sans-serif;">Approve User</h3>
                            <p class="text-gray-300 mt-2" style="font-family: 'Poppins', sans-serif;">Are you sure you want to approve this user's verification request?</p>
                            <div class="mt-3 p-3 bg-green-500/10 border border-green-500/20 rounded-lg">
                                <p class="text-sm text-green-300" style="font-family: 'Poppins', sans-serif;">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    The user will be granted verified status.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="p-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeApproveModal()" 
                            class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg font-medium transition-colors" style="font-family: 'Poppins', sans-serif;">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors" style="font-family: 'Poppins', sans-serif;">
                        <i class="fas fa-check mr-2"></i>Approve User
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
                            <i class="fas fa-times-circle text-red-400 text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-white" style="font-family: 'Poppins', sans-serif;">Reject User</h3>
                            <p class="text-gray-300 mt-2" style="font-family: 'Poppins', sans-serif;">Please provide a reason for rejecting this user's verification request.</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <label for="rejectReasonInput" class="block text-sm font-medium text-gray-300 mb-2" style="font-family: 'Poppins', sans-serif;">Reason for Rejection</label>
                        <textarea 
                            id="rejectReasonInput"
                            name="notes"
                            rows="4" 
                            required
                            minlength="10"
                            class="w-full px-4 py-2 bg-white/10 border border-white/20 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent" style="font-family: 'Poppins', sans-serif;"
                            placeholder="Enter reason (minimum 10 characters)..."
                        ></textarea>
                    </div>
                </div>
                
                <div class="p-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeRejectModal()" 
                            class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg font-medium transition-colors" style="font-family: 'Poppins', sans-serif;">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors" style="font-family: 'Poppins', sans-serif;">
                        <i class="fas fa-times mr-2"></i>Reject User
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
let loadingStates = {};
let currentUserId = null;
let rejectionReason = '';
let isSubmitting = false;
let isRefreshing = false;

// Initialize dashboard
document.addEventListener('DOMContentLoaded', function() {
    console.log('Verification dashboard initialized');
    
    loadStats();
    startAutoRefresh();
    updateLastUpdatedTime();
    
    // Modal functionality is ready for user verification actions
    
    // Check for server-side flash messages
    <?php if(session('success')): ?>
        showNotification('success', '<?php echo addslashes(session('success')); ?>');
    <?php endif; ?>
    
    <?php if(session('error')): ?>
        showNotification('error', '<?php echo addslashes(session('error')); ?>');
    <?php endif; ?>
    
    // Note: Mobile menu functionality is handled by the shared navigation system
});

// Modal functions
function showUserModal() {
    document.getElementById('userDetailsModal').classList.remove('hidden');
}

function closeUserModal() {
    document.getElementById('userDetailsModal').classList.add('hidden');
}

// Loading state functions
function setLoadingState(userId, action, isLoading) {
    const icon = document.getElementById(`${action}Icon${userId}`);
    const spinner = document.getElementById(`${action}Spinner${userId}`);
    const button = document.getElementById(`${action}Btn${userId}`);
    
    if (icon && spinner && button) {
        if (isLoading) {
            icon.classList.add('hidden');
            spinner.classList.remove('hidden');
            button.disabled = true;
        } else {
            icon.classList.remove('hidden');
            spinner.classList.add('hidden');
            button.disabled = false;
        }
    }
    console.log(`Loading state for user ${userId} action ${action}: ${isLoading}`);
}

// Stats functions
function loadStats() {
    // Simulate loading stats
    setTimeout(() => {
        console.log('Stats loaded');
    }, 500);
}

function startAutoRefresh() {
    setInterval(() => {
        isRefreshing = true;
        const refreshIcon = document.getElementById('refreshIcon');
        if (refreshIcon) {
            refreshIcon.classList.add('animate-spin');
        }
        
        loadStats();
        updateLastUpdatedTime();
        
        setTimeout(() => {
            isRefreshing = false;
            if (refreshIcon) {
                refreshIcon.classList.remove('animate-spin');
            }
        }, 1000);
    }, 30000);
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
    currentUserId = userId;
    setLoadingState(userId, 'view', true);
    
    try {
        console.log('Fetching user details from API...');
        const response = await fetch(`/api/users/${userId}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        console.log('Response status:', response.status);

        if (!response.ok) {
            const errorText = await response.text();
            console.error('API Error Response:', errorText);
            throw new Error(`Failed to fetch user details: ${response.status} ${response.statusText}`);
        }

        const user = await response.json();
        console.log('User data received:', user);
        
        // Set user details content
        document.getElementById('userDetailsContent').innerHTML = `
            <div class="p-4 bg-blue-500/20 rounded">
                <h3 class="text-white text-lg mb-2">User Details</h3>
                <p class="text-white mb-2"><strong>Name:</strong> ${escapeHtml(user.name)}</p>
                <p class="text-white mb-2"><strong>Email:</strong> ${escapeHtml(user.email)}</p>
                <p class="text-white mb-2"><strong>Username:</strong> ${escapeHtml(user.username || 'N/A')}</p>
                <p class="text-white mb-2"><strong>ID:</strong> ${user.id}</p>
                <p class="text-white mb-2"><strong>Role:</strong> ${escapeHtml(user.role)}</p>
                <p class="text-white mb-2"><strong>Status:</strong> ${escapeHtml(user.verification_status)}</p>
                <p class="text-white mb-2"><strong>Created:</strong> ${user.created_at}</p>
                ${user.verification_notes ? `<p class="text-white mb-2"><strong>Notes:</strong> ${escapeHtml(user.verification_notes)}</p>` : ''}
            </div>
        `;
        
        showUserModal();
        console.log('Modal should now be visible');
    } catch (error) {
        console.error('Error in openUserModal:', error);
        showNotification('error', `Failed to load user details: ${error.message}`);
    } finally {
        setLoadingState(userId, 'view', false);
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

// Notification function
function showNotification(type, message) {
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg backdrop-blur-sm border transform transition-all duration-300 translate-x-full opacity-0 toast-notification`;
    
    if (type === 'success') {
        toast.className += ' bg-green-500/20 border-green-500/30 text-green-100';
        toast.innerHTML = `
            <div class="flex items-center gap-3">
                <i class="fas fa-check-circle text-green-400"></i>
                <span>${escapeHtml(message)}</span>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-2 text-green-300 hover:text-green-100">
                    <i class="fas fa-times"></i>
                </button>
            </div>`;
    } else if (type === 'error') {
        toast.className += ' bg-red-500/20 border-red-500/30 text-red-100';
        toast.innerHTML = `
            <div class="flex items-center gap-3">
                <i class="fas fa-exclamation-circle text-red-400"></i>
                <span>${escapeHtml(message)}</span>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-2 text-red-300 hover:text-red-100">
                    <i class="fas fa-times"></i>
                </button>
            </div>`;
    }
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.classList.remove('translate-x-full', 'opacity-0');
    }, 100);
    
    setTimeout(() => {
        if (toast.parentNode) {
            toast.classList.add('translate-x-full', 'opacity-0');
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 300);
        }
    }, 5000);
}

// Approve user function
// Approve user function
window.openApproveModal = function(userId) {
    const modal = document.getElementById('approveUserModal');
    const form = document.getElementById('approveUserForm');
    // Use route helper for safe URL generation
    const url = "<?php echo e(route('admin.verification.approve', ['id' => ':id'])); ?>";
    form.action = url.replace(':id', userId);
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeApproveModal() {
    const modal = document.getElementById('approveUserModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = 'auto';
}

window.approveUser = async function(userId) {
    console.log('Opening approve modal for user ID:', userId);
    openApproveModal(userId);
}

// Reject user function
// Reject user function
window.openRejectModal = function(userId) {
    const modal = document.getElementById('rejectUserModal');
    const form = document.getElementById('rejectUserForm');
    const reasonInput = document.getElementById('rejectReasonInput');
    
    // Use route helper for safe URL generation
    const url = "<?php echo e(route('admin.verification.reject', ['id' => ':id'])); ?>";
    form.action = url.replace(':id', userId);
    
    reasonInput.value = '';
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeRejectModal() {
    const modal = document.getElementById('rejectUserModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = 'auto';
}

// Close modals on escape key and click outside
document.addEventListener('DOMContentLoaded', () => {
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeApproveModal();
            closeRejectModal();
        }
    });
    
    const approveModal = document.getElementById('approveUserModal');
    const rejectModal = document.getElementById('rejectUserModal');
    
    if (approveModal) {
        approveModal.addEventListener('click', function(e) {
            if (e.target === approveModal) {
                closeApproveModal();
            }
        });
    }
    
    if (rejectModal) {
        rejectModal.addEventListener('click', function(e) {
            if (e.target === rejectModal) {
                closeRejectModal();
            }
        });
    }
});

</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rayver\Desktop\my_app\resources\views/admin/verification/dashboard.blade.php ENDPATH**/ ?>
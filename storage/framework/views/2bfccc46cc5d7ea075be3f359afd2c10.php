<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .stat-card {
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
            <!-- Enhanced Header -->
            <div class="mb-8">
                <div class="glass-dark rounded-2xl p-8 border border-ocean-500/20 bg-gradient-to-r from-ocean-600/20 to-ocean-800/20">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-4xl font-bold text-white mb-3">
                                <svg class="w-10 h-10 inline-block mr-4 text-ocean-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>Patrol Dashboard
                            </h1>
                            <p class="text-xl text-gray-300">Welcome back, <span class="text-ocean-400 font-semibold"><?php echo e($patroller->name); ?></span>!</p>
                            <p class="text-gray-400 mt-2"><?php echo e(now()->format('l, F j, Y')); ?> • <?php echo e(now()->format('g:i A')); ?></p>
                        </div>
                        <div class="hidden md:block">
                            <?php if($patroller->profile_picture): ?>
                                <img src="<?php echo e(Str::startsWith($patroller->profile_picture, 'data:') ? $patroller->profile_picture : asset('storage/' . $patroller->profile_picture)); ?>" class="w-24 h-24 rounded-full object-cover shadow-lg border-2 border-ocean-400">
                            <?php else: ?>
                                <div class="w-24 h-24 bg-gradient-to-br from-ocean-400 to-ocean-600 rounded-full flex items-center justify-center shadow-lg">
                                    <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Success/Error Messages -->
            <?php if(session('success')): ?>
                <div class="mb-6 glass-morphism border-l-4 border-green-500 p-4 rounded">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-green-100"><?php echo e(session('success')); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="mb-6 glass-morphism border-l-4 border-red-500 p-4 rounded">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-red-100"><?php echo e(session('error')); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Enhanced Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Reports -->
                <div class="stat-card glass-dark rounded-2xl p-6 border border-ocean-500/20 bg-gradient-to-br from-blue-500/10 to-blue-600/10 hover:from-blue-500/20 hover:to-blue-600/20 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="text-right">
                            <p class="text-3xl font-bold text-white"><?php echo e($totalReports); ?></p>
                            <p class="text-blue-300 text-sm">Total Reports</p>
                        </div>
                    </div>
                    <div class="w-full bg-blue-500/20 rounded-full h-2">
                        <div class="bg-gradient-to-r from-blue-400 to-blue-600 h-2 rounded-full" style="width: 100%"></div>
                    </div>
                    <p class="text-xs text-gray-400 mt-2">All time submissions</p>
                </div>

                <!-- Pending Reports -->
                <div class="stat-card glass-dark rounded-2xl p-6 border border-yellow-500/20 bg-gradient-to-br from-yellow-500/10 to-yellow-600/10 hover:from-yellow-500/20 hover:to-yellow-600/20 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="text-right">
                            <p class="text-3xl font-bold text-white"><?php echo e($pendingReports); ?></p>
                            <p class="text-yellow-300 text-sm">Pending Review</p>
                        </div>
                    </div>
                    <div class="w-full bg-yellow-500/20 rounded-full h-2">
                        <div class="bg-gradient-to-r from-yellow-400 to-yellow-600 h-2 rounded-full" style="width: <?php echo e($totalReports > 0 ? ($pendingReports / $totalReports) * 100 : 0); ?>%"></div>
                    </div>
                    <p class="text-xs text-gray-400 mt-2">Awaiting admin review</p>
                </div>

                <!-- Resolved Reports -->
                <div class="stat-card glass-dark rounded-2xl p-6 border border-green-500/20 bg-gradient-to-br from-green-500/10 to-green-600/10 hover:from-green-500/20 hover:to-green-600/20 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-green-400 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="text-right">
                            <p class="text-3xl font-bold text-white"><?php echo e($resolvedReports); ?></p>
                            <p class="text-green-300 text-sm">Resolved</p>
                        </div>
                    </div>
                    <div class="w-full bg-green-500/20 rounded-full h-2">
                        <div class="bg-gradient-to-r from-green-400 to-green-600 h-2 rounded-full" style="width: <?php echo e($totalReports > 0 ? ($resolvedReports / $totalReports) * 100 : 0); ?>%"></div>
                    </div>
                    <p class="text-xs text-gray-400 mt-2">Successfully completed</p>
                </div>

                <!-- Critical Reports -->
                <div class="stat-card glass-dark rounded-2xl p-6 border border-red-500/20 bg-gradient-to-br from-red-500/10 to-red-600/10 hover:from-red-500/20 hover:to-red-600/20 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-red-400 to-red-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="text-right">
                            <p class="text-3xl font-bold text-white"><?php echo e($criticalReports); ?></p>
                            <p class="text-red-300 text-sm">Critical Priority</p>
                        </div>
                    </div>
                    <div class="w-full bg-red-500/20 rounded-full h-2">
                        <div class="bg-gradient-to-r from-red-400 to-red-600 h-2 rounded-full" style="width: <?php echo e($totalReports > 0 ? ($criticalReports / $totalReports) * 100 : 0); ?>%"></div>
                    </div>
                    <p class="text-xs text-gray-400 mt-2">High priority issues</p>
                </div>
            </div>

            <!-- Enhanced Quick Actions & Recent Reports -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
                <!-- Quick Actions -->
                <div class="lg:col-span-1 space-y-4">
                    <div class="glass-dark rounded-2xl p-6 border border-ocean-500/20">
                        <h3 class="text-lg font-semibold text-white mb-6">
                            <svg class="w-5 h-5 inline-block mr-2 text-ocean-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                            </svg>Quick Actions
                        </h3>
                        <div class="space-y-4">
                            <a href="<?php echo e(route('patroller.reports.create')); ?>" class="group block w-full bg-gradient-to-r from-ocean-500 to-ocean-600 hover:from-ocean-600 hover:to-ocean-700 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl text-center">
                                <svg class="w-5 h-5 inline-block mr-3 group-hover:animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                                </svg>
                                <span>Submit New Report</span>
                            </a>
                            <a href="<?php echo e(route('patroller.reports.index')); ?>" class="group block w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl text-center">
                                <svg class="w-5 h-5 inline-block mr-3 group-hover:animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <span>View All Reports</span>
                            </a>
                            <a href="<?php echo e(route('patroller.profile')); ?>" class="group block w-full bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl text-center">
                                <svg class="w-5 h-5 inline-block mr-3 group-hover:animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>My Profile</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Recent Reports -->
                <div class="lg:col-span-3">
                    <div class="glass-dark rounded-2xl p-6 border border-ocean-500/20 h-full">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-semibold text-white">
                                <svg class="w-5 h-5 inline-block mr-2 text-ocean-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                </svg>Recent Activity
                            </h3>
                            <a href="<?php echo e(route('patroller.reports.index')); ?>" class="text-ocean-400 hover:text-ocean-300 text-sm transition-colors">
                                View All <svg class="w-4 h-4 inline-block ml-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </a>
                        </div>
                        <div class="space-y-3 max-h-80 overflow-y-auto custom-scrollbar">
                            <?php $__empty_1 = true; $__currentLoopData = $recentReports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="group flex items-center justify-between p-4 bg-white/5 hover:bg-white/10 rounded-xl transition-all duration-300 border border-transparent hover:border-ocean-500/30">
                                    <div class="flex items-center space-x-4 flex-1">
                                        <div class="w-12 h-12 rounded-xl flex items-center justify-center
                                            <?php if($report->report_type == 'emergency'): ?> bg-gradient-to-br from-red-400 to-red-600
                                            <?php elseif($report->report_type == 'incident'): ?> bg-gradient-to-br from-orange-400 to-orange-600
                                            <?php elseif($report->report_type == 'maintenance'): ?> bg-gradient-to-br from-blue-400 to-blue-600
                                            <?php else: ?> bg-gradient-to-br from-ocean-400 to-ocean-600 <?php endif; ?> shadow-lg">
                                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-white font-semibold truncate group-hover:text-ocean-400 transition-colors"><?php echo e($report->title); ?></h4>
                                            <p class="text-gray-400 text-sm"><?php echo e($report->location); ?></p>
                                            <p class="text-gray-500 text-xs"><?php echo e($report->created_at->diffForHumans()); ?></p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-3">
                                        <span class="px-3 py-1 text-xs font-medium rounded-full
                                            <?php if($report->priority === 'critical'): ?> bg-red-500/20 text-red-300 border border-red-500/30
                                            <?php elseif($report->priority === 'high'): ?> bg-orange-500/20 text-orange-300 border border-orange-500/30
                                            <?php elseif($report->priority === 'medium'): ?> bg-yellow-500/20 text-yellow-300 border border-yellow-500/30
                                            <?php else: ?> bg-green-500/20 text-green-300 border border-green-500/30 <?php endif; ?>">
                                            <?php echo e(ucfirst($report->priority)); ?>

                                        </span>
                                        <span class="px-3 py-1 text-xs font-medium rounded-full
                                            <?php if($report->status == 'submitted'): ?> bg-blue-500/20 text-blue-300 border border-blue-500/30
                                            <?php elseif($report->status == 'under_review'): ?> bg-yellow-500/20 text-yellow-300 border border-yellow-500/30
                                            <?php elseif($report->status == 'resolved'): ?> bg-green-500/20 text-green-300 border border-green-500/30
                                            <?php else: ?> bg-gray-500/20 text-gray-300 border border-gray-500/30 <?php endif; ?>">
                                            <?php echo e(ucfirst(str_replace('_', ' ', $report->status))); ?>

                                        </span>
                                        <a href="<?php echo e(route('patroller.reports.show', $report)); ?>" class="w-8 h-8 bg-ocean-500/20 hover:bg-ocean-500/40 text-ocean-400 hover:text-ocean-300 rounded-lg flex items-center justify-center transition-all duration-300 transform hover:scale-110">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="text-center py-12">
                                    <div class="w-20 h-20 bg-gradient-to-br from-ocean-400 to-ocean-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                                        <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <h4 class="text-xl font-semibold text-white mb-2">No Reports Yet</h4>
                                    <p class="text-gray-400 mb-6">Start by submitting your first patrol report</p>
                                    <a href="<?php echo e(route('patroller.reports.create')); ?>" class="bg-gradient-to-r from-ocean-500 to-ocean-600 hover:from-ocean-600 hover:to-ocean-700 text-white px-6 py-3 rounded-lg font-medium transition-all duration-300 transform hover:scale-105 shadow-lg">
                                        <svg class="w-5 h-5 inline-block mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                                        </svg>Create First Report
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.patroller', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rayver\Desktop\my_app\resources\views/patroller/dashboard.blade.php ENDPATH**/ ?>
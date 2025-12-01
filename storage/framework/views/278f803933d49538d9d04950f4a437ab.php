<?php $__env->startSection('title', 'My Profile'); ?>
<?php $__env->startSection('container-class', 'max-w-6xl'); ?>

<?php $__env->startSection('content'); ?>
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-white mb-2 cinzel-heading">
                    <i class="fas fa-user-shield mr-3 text-ocean-400"></i>Patroller Profile
                </h1>
                <p class="text-gray-300 cinzel-text">Your patroller information and performance statistics</p>
            </div>

            <?php if(session('success')): ?>
                <div class="mb-6 bg-green-500/20 border border-green-500/40 text-green-100 px-4 py-3 rounded-lg flex items-center gap-3">
                    <i class="fas fa-check-circle"></i>
                    <span class="cinzel-text"><?php echo e(session('success')); ?></span>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="mb-6 bg-red-500/20 border border-red-500/40 text-red-100 px-4 py-3 rounded-lg flex items-center gap-3">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span class="cinzel-text"><?php echo e(session('error')); ?></span>
                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="mb-6 bg-red-500/10 border border-red-500/30 text-red-100 px-4 py-3 rounded-lg">
                    <p class="font-semibold mb-2 cinzel-text">Please fix the following:</p>
                    <ul class="list-disc list-inside space-y-1 text-sm">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Profile Information -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Basic Info -->
                    <div class="glass-dark rounded-xl p-6 border border-ocean-500/20">
                        <form action="<?php echo e(route('patroller.profile.update')); ?>" method="POST" enctype="multipart/form-data" class="space-y-5">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                            <input type="hidden" name="section" value="basic">

                            <div class="text-center">
                                <div class="w-24 h-24 bg-gradient-to-br from-ocean-400 to-ocean-600 rounded-full mx-auto mb-4 flex items-center justify-center overflow-hidden">
                                    <?php if($patroller->profile_picture): ?>
                                        <img src="<?php echo e(asset('storage/'.$patroller->profile_picture)); ?>" alt="Profile" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <i class="fas fa-user-shield text-3xl text-white"></i>
                                    <?php endif; ?>
                                </div>
                                <label class="inline-flex items-center px-3 py-2 bg-ocean-500/20 text-ocean-100 rounded-lg cursor-pointer hover:bg-ocean-500/30 transition">
                                    <i class="fas fa-camera mr-2"></i>
                                    <span class="cinzel-text text-sm">Update Photo</span>
                                    <input type="file" name="profile_picture" class="hidden" accept="image/*">
                                </label>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="text-sm text-gray-300 cinzel-text">Full Name</label>
                                    <input type="text" name="name" value="<?php echo e(old('name', $patroller->name)); ?>" class="w-full mt-1 bg-white/5 border border-white/10 rounded-lg px-3 py-2 text-white focus:border-ocean-400 focus:ring-1 focus:ring-ocean-400">
                                </div>
                                <div>
                                    <label class="text-sm text-gray-300 cinzel-text">Email Address</label>
                                    <input type="email" name="email" value="<?php echo e(old('email', $patroller->email)); ?>" class="w-full mt-1 bg-white/5 border border-white/10 rounded-lg px-3 py-2 text-white focus:border-ocean-400 focus:ring-1 focus:ring-ocean-400">
                                </div>
                                <div>
                                    <label class="text-sm text-gray-300 cinzel-text">Phone Number</label>
                                    <input type="text" name="phone" value="<?php echo e(old('phone', $patroller->phone)); ?>" class="w-full mt-1 bg-white/5 border border-white/10 rounded-lg px-3 py-2 text-white focus:border-ocean-400 focus:ring-1 focus:ring-ocean-400">
                                </div>
                                <div>
                                    <label class="text-sm text-gray-300 cinzel-text">Username</label>
                                    <input type="text" name="username" value="<?php echo e(old('username', $patroller->username)); ?>" class="w-full mt-1 bg-white/5 border border-white/10 rounded-lg px-3 py-2 text-white focus:border-ocean-400 focus:ring-1 focus:ring-ocean-400">
                                </div>
                                <div>
                                    <label class="text-sm text-gray-300 cinzel-text">New Password</label>
                                    <input type="password" name="password" class="w-full mt-1 bg-white/5 border border-white/10 rounded-lg px-3 py-2 text-white focus:border-ocean-400 focus:ring-1 focus:ring-ocean-400" placeholder="Leave blank to keep current">
                                </div>
                                <div>
                                    <label class="text-sm text-gray-300 cinzel-text">Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="w-full mt-1 bg-white/5 border border-white/10 rounded-lg px-3 py-2 text-white focus:border-ocean-400 focus:ring-1 focus:ring-ocean-400" placeholder="Re-enter password">
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-ocean-500 hover:bg-ocean-600 transition text-white font-semibold py-2 rounded-lg shadow-lg">
                                Save Changes
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Statistics and Performance -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Recent Activity -->
                    <div class="glass-dark rounded-xl p-6 border border-ocean-500/20">
                        <div class="flex items-center justify-between mb-6">
                            <h4 class="text-lg font-semibold text-white cinzel-subheading">
                                <i class="fas fa-clock mr-2 text-ocean-400"></i>Recent Activity
                            </h4>
                            <a href="<?php echo e(route('patroller.reports.index')); ?>" class="text-ocean-400 hover:text-ocean-300 text-sm cinzel-text">
                                View All Reports <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>

                        <?php
                            $recentReports = \App\Models\PatrolReport::where('patroller_id', $patroller->id)
                                ->orderBy('created_at', 'desc')
                                ->take(5)
                                ->get();
                        ?>

                        <?php if($recentReports->count() > 0): ?>
                            <div class="space-y-4">
                                <?php $__currentLoopData = $recentReports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="flex items-center justify-between p-4 bg-white/5 rounded-lg hover:bg-white/10 transition-colors">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-10 h-10 rounded-lg flex items-center justify-center
                                                <?php if($report->report_type == 'emergency'): ?> bg-red-500/20
                                                <?php elseif($report->report_type == 'incident'): ?> bg-orange-500/20
                                                <?php elseif($report->report_type == 'maintenance'): ?> bg-blue-500/20
                                                <?php else: ?> bg-green-500/20 <?php endif; ?>">
                                                <i class="fas fa-file-alt text-sm
                                                    <?php if($report->report_type == 'emergency'): ?> text-red-400
                                                    <?php elseif($report->report_type == 'incident'): ?> text-orange-400
                                                    <?php elseif($report->report_type == 'maintenance'): ?> text-blue-400
                                                    <?php else: ?> text-green-400 <?php endif; ?>"></i>
                                            </div>
                                            <div>
                                                <p class="text-white font-medium cinzel-text"><?php echo e($report->title); ?></p>
                                                <p class="text-gray-400 text-sm cinzel-text"><?php echo e($report->created_at->diffForHumans()); ?></p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-3">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium cinzel-text
                                                <?php if($report->status == 'submitted'): ?> bg-blue-500/20 text-blue-300
                                                <?php elseif($report->status == 'under_review'): ?> bg-yellow-500/20 text-yellow-300
                                                <?php elseif($report->status == 'resolved'): ?> bg-green-500/20 text-green-300
                                                <?php else: ?> bg-gray-500/20 text-gray-300 <?php endif; ?>">
                                                <?php echo e(ucfirst(str_replace('_', ' ', $report->status))); ?>

                                            </span>
                                            <a href="<?php echo e(route('patroller.reports.show', $report)); ?>" class="text-ocean-400 hover:text-ocean-300">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-8">
                                <i class="fas fa-file-alt text-4xl text-gray-500 mb-4"></i>
                                <p class="text-gray-400 cinzel-text">No recent activity</p>
                                <a href="<?php echo e(route('patroller.reports.create')); ?>" class="text-ocean-400 hover:text-ocean-300 cinzel-text">
                                    Submit your first report
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Quick Actions -->
                    <div class="glass-dark rounded-xl p-6 border border-ocean-500/20">
                        <h4 class="text-lg font-semibold text-white mb-6 cinzel-subheading">
                            <i class="fas fa-bolt mr-2 text-ocean-400"></i>Quick Actions
                        </h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <a href="<?php echo e(route('patroller.reports.create')); ?>" class="bg-gradient-to-r from-ocean-500 to-ocean-600 hover:from-ocean-600 hover:to-ocean-700 text-white p-4 rounded-lg text-center transition-all duration-300 transform hover:scale-105 shadow-lg">
                                <i class="fas fa-plus text-2xl mb-2"></i>
                                <p class="font-medium cinzel-text">New Report</p>
                            </a>
                            
                            <a href="<?php echo e(route('patroller.reports.index')); ?>" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white p-4 rounded-lg text-center transition-all duration-300 transform hover:scale-105 shadow-lg">
                                <i class="fas fa-list text-2xl mb-2"></i>
                                <p class="font-medium cinzel-text">View Reports</p>
                            </a>
                            
                            <a href="<?php echo e(route('patroller.dashboard')); ?>" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white p-4 rounded-lg text-center transition-all duration-300 transform hover:scale-105 shadow-lg">
                                <i class="fas fa-tachometer-alt text-2xl mb-2"></i>
                                <p class="font-medium cinzel-text">Dashboard</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.patroller', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rayver\Desktop\my_app\resources\views/patroller/profile.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title', 'My Reports'); ?>

<?php $__env->startSection('content'); ?>
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-white mb-2 cinzel-heading">
                            <i class="fas fa-file-alt mr-3 text-ocean-400"></i>My Reports
                        </h1>
                        <p class="text-gray-300 cinzel-text">Manage and track your patrol reports</p>
                    </div>
                    <a href="<?php echo e(route('patroller.reports.create')); ?>" class="bg-gradient-to-r from-ocean-500 to-ocean-600 hover:from-ocean-600 hover:to-ocean-700 text-white px-6 py-3 rounded-lg font-medium transition-all duration-300 transform hover:scale-105 shadow-lg cinzel-text">
                        <i class="fas fa-plus mr-2"></i>New Report
                    </a>
                </div>
            </div>

            <!-- Filters -->
            <div class="glass-dark rounded-xl p-6 mb-8 border border-ocean-500/20">
                <form method="GET" action="<?php echo e(route('patroller.reports.index')); ?>" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    <!-- Status Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Status</label>
                        <select name="status" class="w-full bg-gray-800 border border-ocean-500/30 rounded-lg px-3 py-2 text-white focus:ring-2 focus:ring-ocean-500 focus:border-transparent cinzel-text">
                            <option value="" selected class="bg-gray-800 text-white">All Status</option>
                            <option value="submitted" <?php echo e(request('status') == 'submitted' ? 'selected' : ''); ?>>Submitted</option>
                            <option value="under_review" <?php echo e(request('status') == 'under_review' ? 'selected' : ''); ?>>Under Review</option>
                            <option value="resolved" <?php echo e(request('status') == 'resolved' ? 'selected' : ''); ?>>Resolved</option>
                            <option value="closed" <?php echo e(request('status') == 'closed' ? 'selected' : ''); ?>>Closed</option>
                        </select>
                    </div>

                    <!-- Priority Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Priority</label>
                        <select name="priority" class="w-full bg-gray-800 border border-ocean-500/30 rounded-lg px-3 py-2 text-white focus:ring-2 focus:ring-ocean-500 focus:border-transparent cinzel-text">
                            <option value="" selected class="bg-gray-800 text-white">All Priorities</option>
                            <option value="low" <?php echo e(request('priority') == 'low' ? 'selected' : ''); ?>>Low</option>
                            <option value="medium" <?php echo e(request('priority') == 'medium' ? 'selected' : ''); ?>>Medium</option>
                            <option value="high" <?php echo e(request('priority') == 'high' ? 'selected' : ''); ?>>High</option>
                            <option value="critical" <?php echo e(request('priority') == 'critical' ? 'selected' : ''); ?>>Critical</option>
                        </select>
                    </div>

                    <!-- Type Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Type</label>
                        <select name="type" class="w-full bg-gray-800 border border-ocean-500/30 rounded-lg px-3 py-2 text-white focus:ring-2 focus:ring-ocean-500 focus:border-transparent cinzel-text">
                            <option value="" selected class="bg-gray-800 text-white">All Types</option>
                            <option value="incident" <?php echo e(request('type') == 'incident' ? 'selected' : ''); ?>>Incident</option>
                            <option value="observation" <?php echo e(request('type') == 'observation' ? 'selected' : ''); ?>>Observation</option>
                            <option value="maintenance" <?php echo e(request('type') == 'maintenance' ? 'selected' : ''); ?>>Maintenance</option>
                            <option value="emergency" <?php echo e(request('type') == 'emergency' ? 'selected' : ''); ?>>Emergency</option>
                        </select>
                    </div>

                    <!-- Date From -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">From Date</label>
                        <input type="date" name="date_from" value="<?php echo e(request('date_from')); ?>" class="w-full bg-gray-800 border border-ocean-500/30 rounded-lg px-3 py-2 text-white focus:ring-2 focus:ring-ocean-500 focus:border-transparent cinzel-text">
                    </div>

                    <!-- Filter Actions -->
                    <div class="flex items-end gap-2">
                        <button type="submit" class="bg-ocean-500 hover:bg-ocean-600 text-white px-4 py-2 rounded-lg transition-colors cinzel-text">
                            <i class="fas fa-filter mr-2"></i>Filter
                        </button>
                        <a href="<?php echo e(route('patroller.reports.index')); ?>" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors cinzel-text">
                            <i class="fas fa-times mr-2"></i>Clear
                        </a>
                    </div>
                </form>
            </div>

            <!-- Reports List -->
            <div class="glass-dark rounded-xl border border-ocean-500/20 overflow-hidden">
                <?php if($reports->count() > 0): ?>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gradient-to-r from-ocean-600/50 to-ocean-700/50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider cinzel-text">Report</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider cinzel-text">Type</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider cinzel-text">Priority</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider cinzel-text">Status</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider cinzel-text">Date</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider cinzel-text">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-ocean-500/20">
                                <?php $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="hover:bg-white/5 transition-colors">
                                        <td class="px-6 py-4">
                                            <div>
                                                <div class="text-sm font-medium text-white cinzel-text"><?php echo e($report->title); ?></div>
                                                <div class="text-sm text-gray-400 cinzel-text"><?php echo e(Str::limit($report->description, 50)); ?></div>
                                                <div class="text-xs text-gray-500 cinzel-text"><?php echo e($report->location); ?></div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium cinzel-text
                                                <?php if($report->report_type == 'emergency'): ?> bg-red-500/20 text-red-300
                                                <?php elseif($report->report_type == 'incident'): ?> bg-orange-500/20 text-orange-300
                                                <?php elseif($report->report_type == 'maintenance'): ?> bg-blue-500/20 text-blue-300
                                                <?php else: ?> bg-green-500/20 text-green-300 <?php endif; ?>">
                                                <?php echo e(ucfirst($report->report_type)); ?>

                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium cinzel-text
                                                <?php if($report->priority == 'critical'): ?> bg-red-500/20 text-red-300
                                                <?php elseif($report->priority == 'high'): ?> bg-orange-500/20 text-orange-300
                                                <?php elseif($report->priority == 'medium'): ?> bg-yellow-500/20 text-yellow-300
                                                <?php else: ?> bg-green-500/20 text-green-300 <?php endif; ?>">
                                                <?php echo e(ucfirst($report->priority)); ?>

                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium cinzel-text
                                                <?php if($report->status == 'submitted'): ?> bg-blue-500/20 text-blue-300
                                                <?php elseif($report->status == 'under_review'): ?> bg-yellow-500/20 text-yellow-300
                                                <?php elseif($report->status == 'resolved' || $report->status == 'accepted'): ?> bg-green-500/20 text-green-300
                                                <?php elseif($report->status == 'rejected'): ?> bg-red-500/20 text-red-300
                                                <?php elseif($report->status == 'needs_correction'): ?> bg-orange-500/20 text-orange-300
                                                <?php else: ?> bg-gray-500/20 text-gray-300 <?php endif; ?>">
                                                <?php echo e(ucfirst(str_replace('_', ' ', $report->status))); ?>

                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-300 cinzel-text">
                                            <?php echo e($report->created_at->format('M d, Y')); ?>

                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium">
                                            <div class="flex items-center space-x-2">
                                                <a href="<?php echo e(route('patroller.reports.show', $report)); ?>" class="text-ocean-400 hover:text-ocean-300 transition-colors">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <?php if(in_array($report->status, ['submitted', 'rejected', 'needs_correction'])): ?>
                                                    <a href="<?php echo e(route('patroller.reports.edit', $report)); ?>" class="text-yellow-400 hover:text-yellow-300 transition-colors" title="Edit Report">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form method="POST" action="<?php echo e(route('patroller.reports.destroy', $report)); ?>" class="inline" onsubmit="return confirm('Are you sure you want to delete this report?')">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="text-red-400 hover:text-red-300 transition-colors" title="Delete Report">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-ocean-500/20">
                        <?php echo e($reports->links()); ?>

                    </div>
                <?php else: ?>
                    <div class="text-center py-12">
                        <i class="fas fa-file-alt text-6xl text-gray-500 mb-4"></i>
                        <h3 class="text-xl font-medium text-white mb-2 cinzel-heading">No Reports Found</h3>
                        <p class="text-gray-400 mb-6 cinzel-text">You haven't submitted any reports yet.</p>
                        <a href="<?php echo e(route('patroller.reports.create')); ?>" class="bg-gradient-to-r from-ocean-500 to-ocean-600 hover:from-ocean-600 hover:to-ocean-700 text-white px-6 py-3 rounded-lg font-medium transition-all duration-300 transform hover:scale-105 shadow-lg cinzel-text">
                            <i class="fas fa-plus mr-2"></i>Create Your First Report
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->startSection('styles'); ?>
<style>
    /* Style the dropdown options */
    select option {
        background-color: #1f2937; /* bg-gray-800 */
        color: white;
        padding: 8px 12px;
    }
    
    /* Style the date picker */
    input[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(1);
        opacity: 0.8;
    }
    
    input[type="date"]::-webkit-datetime-edit-fields-wrapper {
        color: white;
    }
    
    /* Ensure dropdown text is visible on hover */
    select option:hover {
        background-color: #3b82f6; /* bg-blue-500 */
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.patroller', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rayver\Desktop\my_app\resources\views/patroller/reports/index.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title', 'Patrol Report Details - DENR Admin'); ?>

<?php $__env->startSection('content'); ?>
<div id="patrolReportShow" class="min-h-screen bg-gray-900">
    <!-- Back Button -->
    <div class="pt-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="<?php echo e(route('admin.patrol-reports.index')); ?>" class="inline-flex items-center gap-2 text-gray-300 hover:text-white transition-colors group">
            <i class="fas fa-arrow-left text-sm group-hover:-translate-x-1 transition-transform"></i>
            <span class="text-sm font-medium">Back to Manage Reports</span>
        </a>
    </div>

    <!-- Success/Error Messages -->
    <?php if(session('success')): ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-500/20 border border-green-500/30 rounded-lg p-4">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-check-circle text-green-400"></i>
                    <p class="text-green-300 cinzel-text"><?php echo e(session('success')); ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-500/20 border border-red-500/30 rounded-lg p-4">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-exclamation-circle text-red-400"></i>
                    <p class="text-red-300 cinzel-text"><?php echo e(session('error')); ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Report Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-2 pb-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Report Header -->
                <div class="glass-dark rounded-xl p-6 border border-ocean-500/20">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <div class="flex items-center space-x-3 mb-2">
                                <h2 class="text-2xl font-bold text-white cinzel-heading"><?php echo e($patrolReport->title ?? 'Untitled Report'); ?></h2>
                                <span class="px-2 py-1 text-xs rounded-full cinzel-text
                                    <?php if($patrolReport->priority == 'critical'): ?> bg-red-500/20 text-red-300
                                    <?php elseif($patrolReport->priority == 'high'): ?> bg-orange-500/20 text-orange-300
                                    <?php elseif($patrolReport->priority == 'medium'): ?> bg-yellow-500/20 text-yellow-300
                                    <?php elseif($patrolReport->priority == 'low'): ?> bg-green-500/20 text-green-300
                                    <?php else: ?> bg-gray-500/20 text-gray-300 <?php endif; ?>">
                                    <?php echo e(ucfirst($patrolReport->priority)); ?> Priority
                                </span>
                                <span class="px-2 py-1 text-xs rounded-full cinzel-text
                                    <?php if($patrolReport->report_type == 'emergency'): ?> bg-red-500/20 text-red-300
                                    <?php elseif($patrolReport->report_type == 'incident'): ?> bg-orange-500/20 text-orange-300
                                    <?php elseif($patrolReport->report_type == 'maintenance'): ?> bg-blue-500/20 text-blue-300
                                    <?php else: ?> bg-green-500/20 text-green-300 <?php endif; ?>">
                                    <?php echo e(ucfirst($patrolReport->report_type)); ?>

                                </span>
                            </div>
                            <p class="text-gray-300 cinzel-text"><?php echo e($patrolReport->description ?? 'No description provided'); ?></p>
                        </div>
                    </div>

                    <!-- Report Details -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
                        <div class="text-center">
                            <div class="text-sm text-gray-400 cinzel-text">Location</div>
                            <div class="text-white font-medium cinzel-text"><?php echo e($patrolReport->location ?? 'No location specified'); ?></div>
                        </div>
                        <div class="text-center">
                            <div class="text-sm text-gray-400 cinzel-text">Submitted</div>
                            <div class="text-white font-medium cinzel-text"><?php echo e($patrolReport->created_at ? $patrolReport->created_at->format('M d, Y') : 'N/A'); ?></div>
                            <div class="text-xs text-gray-500 cinzel-text"><?php echo e($patrolReport->created_at ? $patrolReport->created_at->format('g:i A') : ''); ?></div>
                        </div>
                        <?php if($patrolReport->latitude && $patrolReport->longitude): ?>
                        <div class="text-center">
                            <div class="text-sm text-gray-400 cinzel-text">Coordinates</div>
                            <div class="text-white font-medium cinzel-text font-mono text-xs">
                                <?php echo e($patrolReport->latitude); ?>, <?php echo e($patrolReport->longitude); ?>

                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if($patrolReport->reviewed_at): ?>
                        <div class="text-center">
                            <div class="text-sm text-gray-400 cinzel-text">Last Updated</div>
                            <div class="text-white font-medium cinzel-text"><?php echo e($patrolReport->reviewed_at->format('M d, Y')); ?></div>
                            <div class="text-xs text-gray-500 cinzel-text"><?php echo e($patrolReport->reviewed_at->diffForHumans()); ?></div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if($patrolReport->turtle_count || $patrolReport->turtle_species || $patrolReport->turtle_condition || $patrolReport->gender || $patrolReport->egg_count): ?>
                <div class="glass-dark rounded-xl p-6 border border-ocean-500/20">
                    <h3 class="text-lg font-bold text-white mb-4 cinzel-heading">
                        <i class="fas fa-turtle mr-2 text-ocean-400"></i>Turtle Information
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-sm text-gray-300">
                        <?php if($patrolReport->turtle_species): ?>
                            <div>
                                <div class="text-gray-400 text-xs uppercase tracking-wide">Species</div>
                                <div class="text-white font-medium cinzel-text"><?php echo e($patrolReport->turtle_species); ?></div>
                            </div>
                        <?php endif; ?>
                        <?php if($patrolReport->turtle_count): ?>
                            <div>
                                <div class="text-gray-400 text-xs uppercase tracking-wide">Count</div>
                                <div class="text-white font-medium cinzel-text"><?php echo e($patrolReport->turtle_count); ?></div>
                            </div>
                        <?php endif; ?>
                        <?php if($patrolReport->turtle_condition): ?>
                            <div>
                                <div class="text-gray-400 text-xs uppercase tracking-wide">Condition</div>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold cinzel-text
                                    <?php if($patrolReport->turtle_condition === 'healthy'): ?> bg-green-500/20 text-green-300
                                    <?php elseif($patrolReport->turtle_condition === 'injured'): ?> bg-yellow-500/20 text-yellow-300
                                    <?php elseif($patrolReport->turtle_condition === 'dead'): ?> bg-red-500/20 text-red-300
                                    <?php else: ?> bg-gray-500/20 text-gray-300 <?php endif; ?>">
                                    <?php echo e(ucfirst($patrolReport->turtle_condition)); ?>

                                </span>
                            </div>
                        <?php endif; ?>
                        <?php if($patrolReport->gender): ?>
                            <div>
                                <div class="text-gray-400 text-xs uppercase tracking-wide">Gender</div>
                                <div class="text-white font-medium cinzel-text"><?php echo e(ucfirst($patrolReport->gender)); ?></div>
                            </div>
                        <?php endif; ?>
                        <?php if($patrolReport->egg_count !== null): ?>
                            <div>
                                <div class="text-gray-400 text-xs uppercase tracking-wide">Egg Count</div>
                                <div class="text-white font-medium cinzel-text"><?php echo e(number_format($patrolReport->egg_count)); ?></div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Report Content -->
                <?php if($patrolReport->content): ?>
                <div class="glass-dark rounded-xl p-6 border border-ocean-500/20">
                    <h3 class="text-lg font-bold text-white mb-4 cinzel-heading">
                        <i class="fas fa-file-alt mr-2 text-ocean-400"></i>Report Details
                    </h3>
                    <div class="text-gray-300 cinzel-text whitespace-pre-line">
                        <?php echo e($patrolReport->content); ?>

                    </div>
                </div>
                <?php endif; ?>

                <!-- Images -->
                <?php if($patrolReport->images && count($patrolReport->images) > 0): ?>
                <div class="glass-dark rounded-xl p-6 border border-ocean-500/20">
                    <h3 class="text-lg font-bold text-white mb-4 cinzel-heading">
                        <i class="fas fa-images mr-2 text-ocean-400"></i>Attached Images
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <?php $__currentLoopData = $patrolReport->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="bg-gray-700 rounded-lg overflow-hidden">
                                <img src="<?php echo e(Str::startsWith($image, 'data:') ? $image : asset('storage/' . $image)); ?>" alt="Report image" class="w-full h-48 object-cover hover:scale-105 transition-transform cursor-pointer" onclick="openImageModal('<?php echo e(Str::startsWith($image, 'data:') ? $image : asset('storage/' . $image)); ?>')">
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Admin Notes -->
                <?php if($patrolReport->admin_notes): ?>
                <div class="glass-dark rounded-xl p-6 border border-ocean-500/20">
                    <h3 class="text-lg font-bold text-white mb-4 cinzel-heading">
                        <i class="fas fa-sticky-note mr-2 text-yellow-400"></i>Admin Notes
                    </h3>
                    <div class="bg-gray-800/50 rounded-lg p-4">
                        <p class="text-gray-300 cinzel-text"><?php echo e($patrolReport->admin_notes); ?></p>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Patroller Info -->
                <div class="glass-dark rounded-xl p-6  border border-ocean-500/20">
                    <h3 class="text-lg font-bold text-white mb-4 cinzel-heading">
                        <i class="fas fa-user mr-2 text-ocean-400"></i>Patroller Information
                    </h3>
                    <div class="space-y-3">
                        <div>
                            <div class="text-sm text-gray-400 cinzel-text">Name</div>
                            <div class="text-white font-medium cinzel-text"><?php echo e($patrolReport->patroller ? $patrolReport->patroller->name : 'Unknown Patroller'); ?></div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-400 cinzel-text">Patroller ID</div>
                            <div class="text-white font-medium cinzel-text"><?php echo e($patrolReport->patroller ? ($patrolReport->patroller->patroller_id ?? 'N/A') : 'N/A'); ?></div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-400 cinzel-text">Email</div>
                            <div class="text-white font-medium cinzel-text"><?php echo e($patrolReport->patroller ? $patrolReport->patroller->email : 'N/A'); ?></div>
                        </div>
                        <?php if($patrolReport->patroller && $patrolReport->patroller->phone): ?>
                        <div>
                            <div class="text-sm text-gray-400 cinzel-text">Phone</div>
                            <div class="text-white font-medium cinzel-text"><?php echo e($patrolReport->patroller->phone); ?></div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Review History -->
                <?php if($patrolReport->reviewed_at): ?>
                    <div class="glass-dark rounded-xl p-6 border border-ocean-500/20">
                        <h3 class="text-lg font-bold text-white mb-4 cinzel-heading">
                            <i class="fas fa-history mr-2 text-purple-400"></i>Review History
                        </h3>
                        <div class="space-y-3">
                            <div>
                                <div class="text-sm text-gray-400 cinzel-text">Last Reviewed By</div>
                                <div class="text-white font-medium cinzel-text"><?php echo e($patrolReport->reviewer ? $patrolReport->reviewer->name : ( $patrolReport->verifier ? $patrolReport->verifier->name : 'N/A' )); ?></div>
                            </div>
                            <div>
                                <div class="text-sm text-gray-400 cinzel-text">Review Date</div>
                                <div class="text-white font-medium cinzel-text"><?php echo e($patrolReport->reviewed_at ? $patrolReport->reviewed_at->format('M d, Y \a\t g:i A') : 'N/A'); ?></div>
                            </div>
                            <div>
                                <div class="text-sm text-gray-400 cinzel-text">Time Since Review</div>
                                <div class="text-gray-300 cinzel-text"><?php echo e($patrolReport->reviewed_at ? $patrolReport->reviewed_at->diffForHumans() : 'Never reviewed'); ?></div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Report Actions -->
                <div class="glass-dark rounded-xl p-6 border border-ocean-500/20">
                    <h3 class="text-lg font-bold text-white mb-4 cinzel-heading">
                        <i class="fas fa-tasks mr-2 text-ocean-400"></i>Report Actions
                    </h3>
                    <div class="space-y-3">
                        <?php if($patrolReport->status == 'pending' || $patrolReport->status == 'submitted' || $patrolReport->status == 'under_review' || $patrolReport->status == 'pending_review' || $patrolReport->status == 'reviewing'): ?>
                            <div class="grid grid-cols-1 gap-3">
                                <button onclick="validateReport('validated', 'validate')" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-3 px-4 rounded-lg font-medium transition-all cinzel-text text-sm shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center justify-center gap-2">
                                    <i class="fas fa-check-circle text-lg"></i> Validate & Accept
                                </button>

                                <button onclick="validateReport('rejected', 'validate')" class="w-full bg-red-600/20 hover:bg-red-600 text-red-400 hover:text-white py-3 px-4 rounded-lg font-medium transition-all cinzel-text text-sm border border-red-500/30 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center justify-center gap-2">
                                    <i class="fas fa-times-circle text-lg"></i> Reject Report
                                </button>

                                <button onclick="validateReport('under_review', 'validate')" class="w-full bg-ocean-600/20 hover:bg-ocean-600 text-ocean-400 hover:text-white py-3 px-4 rounded-lg font-medium transition-all cinzel-text text-sm border border-ocean-500/30 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center justify-center gap-2">
                                    <i class="fas fa-search text-lg"></i> Mark Under Review
                                </button>
                            </div>
                        <?php else: ?>
                            <div class="p-4 rounded-lg <?php if($patrolReport->status == 'accepted' || $patrolReport->status == 'validated' || $patrolReport->status == 'verified'): ?> bg-emerald-500/10 border border-emerald-500/30 <?php else: ?> bg-red-500/10 border border-red-500/30 <?php endif; ?>">
                                <div class="flex items-center space-x-3">
                                    <i class="fas <?php if($patrolReport->status == 'accepted' || $patrolReport->status == 'validated' || $patrolReport->status == 'verified'): ?> fa-check-circle text-emerald-400 <?php else: ?> fa-times-circle text-red-400 <?php endif; ?>"></i>
                                    <div>
                                        <h4 class="<?php if($patrolReport->status == 'accepted' || $patrolReport->status == 'validated' || $patrolReport->status == 'verified'): ?> text-emerald-300 <?php else: ?> text-red-300 <?php endif; ?> font-medium cinzel-text">
                                            Report <?php echo e(ucfirst(str_replace('_', ' ', $patrolReport->status))); ?>

                                        </h4>
                                        <p class="<?php if($patrolReport->status == 'accepted' || $patrolReport->status == 'validated' || $patrolReport->status == 'verified'): ?> text-emerald-200/70 <?php else: ?> text-red-200/70 <?php endif; ?> text-xs cinzel-text mt-1">
                                            This report has already been processed.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Danger Zone -->
                <div class="glass-dark rounded-xl p-6 border border-red-500/20">
                    <h3 class="text-lg font-bold text-red-400 mb-4 cinzel-heading">
                        <i class="fas fa-exclamation-triangle mr-2"></i>Danger Zone
                    </h3>
                    <button onclick="handleDelete()" class="w-full bg-red-600/10 hover:bg-red-600 text-red-500 hover:text-white py-3 px-4 rounded-lg font-medium transition-all cinzel-text text-sm border border-red-500/20 group flex items-center justify-center gap-2">
                        <i class="fas fa-trash-alt group-hover:animate-pulse"></i> Delete Report Permanently
                    </button>
                    <p class="text-[10px] text-red-500/60 mt-3 cinzel-text italic text-center">
                        * Irreversible action. All data and photos will be lost.
                    </p>
                </div>
            </div>
        </div>
    </main>

    <!-- Delete Form -->
    <form id="deleteForm" action="<?php echo e(route('admin.patrol-reports.destroy', $patrolReport)); ?>" method="POST" style="display: none;">
        <?php echo csrf_field(); ?>
        <?php echo method_field('DELETE'); ?>
    </form>

    <!-- Status Update Form -->
    <form id="statusForm" action="<?php echo e(route('admin.patrol-reports.update-status', $patrolReport)); ?>" method="POST" style="display: none;">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PATCH'); ?>
        <input type="hidden" name="status" id="status">
    </form>

    <!-- Custom Confirmation Modal -->
    <div id="confirmModal" class="fixed inset-0 z-[9999] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeConfirmModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-ocean-500/30">
                <div class="px-6 pt-6 pb-4">
                    <div class="sm:flex sm:items-start">
                        <div id="modalIconContainer" class="mx-auto flex-shrink-0 flex items-center justify-center h-14 w-14 rounded-full bg-green-500/20 sm:mx-0 sm:h-12 sm:w-12">
                            <svg id="modalIcon" class="h-7 w-7 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left flex-1">
                            <h3 class="text-xl font-bold text-white mb-2 cinzel-heading" id="modal-title">Confirm Action</h3>
                            <div class="mt-2 text-sm text-gray-300 cinzel-text" id="modalMessage">
                                Are you sure you want to proceed?
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-800/50 px-6 py-4 sm:flex sm:flex-row-reverse gap-3">
                    <button type="button" id="confirmButton" onclick="confirmModalAction()" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-base font-medium text-white hover:from-green-700 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-200 transform hover:scale-105 cinzel-text">
                        OK
                    </button>
                    <button type="button" onclick="closeConfirmModal()" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-600 shadow-sm px-6 py-3 bg-gray-700 text-base font-medium text-gray-200 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:w-auto sm:text-sm transition-all duration-200 cinzel-text">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
                </div>


            </div>
        </div>
    </main>
    
    <!-- Status Update Form -->
    <form id="statusForm" action="<?php echo e(route('admin.patrol-reports.update-status', $patrolReport)); ?>" method="POST" style="display: none;">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PATCH'); ?>
        <input type="hidden" name="status" id="status">
    </form>
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm hidden items-center justify-center z-50">
    <div class="relative max-w-4xl max-h-screen p-4">
        <button onclick="closeImageModal()" class="absolute top-2 right-2 text-white bg-black/50 hover:bg-black/70 rounded-full w-10 h-10 flex items-center justify-center transition-colors">
            <i class="fas fa-times"></i>
        </button>
        <img id="modalImage" src="" alt="Report image" class="max-w-full max-h-full object-contain rounded-lg">
    </div>
</div>

<!-- Toast Notification -->
<div id="toast" class="fixed top-4 right-4 z-50 hidden">
    <div class="bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg flex items-center space-x-3">
        <i class="fas fa-check-circle"></i>
        <span id="toastMessage">Success!</span>
    </div>
</div>

<script>
let confirmModalCallback = null;

function showConfirmModal(message, title = 'Confirm Action', type = 'success') {
    return new Promise((resolve) => {
        const modal = document.getElementById('confirmModal');
        const modalTitle = document.getElementById('modal-title');
        const modalMessage = document.getElementById('modalMessage');
        const modalIcon = document.getElementById('modalIcon');
        const modalIconContainer = document.getElementById('modalIconContainer');
        const confirmButton = document.getElementById('confirmButton');
        
        modalTitle.textContent = title;
        modalMessage.textContent = message;
        
        if (type === 'danger') {
            modalIconContainer.className = 'mx-auto flex-shrink-0 flex items-center justify-center h-14 w-14 rounded-full bg-red-500/20 sm:mx-0 sm:h-12 sm:w-12';
            modalIcon.className = 'h-7 w-7 text-red-400';
            modalIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>';
            confirmButton.className = 'w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-base font-medium text-white hover:from-red-700 hover:to-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-200 transform hover:scale-105 cinzel-text';
        } else if (type === 'warning') {
            modalIconContainer.className = 'mx-auto flex-shrink-0 flex items-center justify-center h-14 w-14 rounded-full bg-yellow-500/20 sm:mx-0 sm:h-12 sm:w-12';
            modalIcon.className = 'h-7 w-7 text-yellow-400';
            modalIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>';
            confirmButton.className = 'w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-3 bg-gradient-to-r from-yellow-600 to-yellow-700 text-base font-medium text-white hover:from-yellow-700 hover:to-yellow-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-200 transform hover:scale-105 cinzel-text';
        } else {
            modalIconContainer.className = 'mx-auto flex-shrink-0 flex items-center justify-center h-14 w-14 rounded-full bg-green-500/20 sm:mx-0 sm:h-12 sm:w-12';
            modalIcon.className = 'h-7 w-7 text-green-400';
            modalIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>';
            confirmButton.className = 'w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-base font-medium text-white hover:from-green-700 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-200 transform hover:scale-105 cinzel-text';
        }
        
        confirmModalCallback = resolve;
        modal.classList.remove('hidden');
    });
}

function closeConfirmModal() {
    document.getElementById('confirmModal').classList.add('hidden');
    if (confirmModalCallback) { confirmModalCallback(false); confirmModalCallback = null; }
}

function confirmModalAction() {
    document.getElementById('confirmModal').classList.add('hidden');
    if (confirmModalCallback) { confirmModalCallback(true); confirmModalCallback = null; }
}

async function validateReport(status, action) {
    const messages = {
        'validated': { title: 'Validate & Accept', message: 'Mark this report as officially validated? This action is public and will appear on the conservation map.', type: 'success' },
        'rejected': { title: 'Reject Report', message: 'Are you sure you want to reject this report? This will notify the patroller.', type: 'danger' },
        'under_review': { title: 'Mark Under Review', message: 'Set this report to "Under Review" status for further investigation?', type: 'warning' }
    };

    const config = messages[status] || { title: 'Confirm Status Change', message: 'Are you sure you want to change the status of this report?', type: 'warning' };
    
    if (await showConfirmModal(config.message, config.title, config.type)) {
        document.getElementById('status').value = status;
        document.getElementById('statusForm').submit();
    }
}

async function handleDelete() {
    if (await showConfirmModal('CRITICAL: This will permanently delete the report and all its associated data (photos, history, etc.). This action CANNOT be undone.', 'Delete Report Permanently?', 'danger')) {
        document.getElementById('deleteForm').submit();
    }
}

// Image modal functions
function openImageModal(imageSrc) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('imageModal').classList.remove('hidden');
    document.getElementById('imageModal').classList.add('flex');
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
    document.getElementById('imageModal').classList.remove('flex');
}

// Toast notification function
function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    const toastMessage = document.getElementById('toastMessage');

    toastMessage.textContent = message;

    // Update toast styling based on type
    const toastDiv = toast.querySelector('div');
    if (type === 'success') {
        toastDiv.className = 'bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg flex items-center space-x-3';
        toastDiv.querySelector('i').className = 'fas fa-check-circle';
    } else if (type === 'error') {
        toastDiv.className = 'bg-red-600 text-white px-6 py-3 rounded-lg shadow-lg flex items-center space-x-3';
        toastDiv.querySelector('i').className = 'fas fa-exclamation-circle';
    }

    // Show toast
    toast.classList.remove('hidden');

    // Auto hide after 3 seconds
    setTimeout(() => {
        toast.classList.add('hidden');
    }, 3000);
}

// Close modal on background click
const imageModal = document.getElementById('imageModal');
if (imageModal) {
    imageModal.addEventListener('click', function(e) {
        if (e.target === this) {
            closeImageModal();
        }
    });
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rayver\Desktop\my_app\resources\views/admin/patrol-reports/show.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title', 'Ecological Submissions Review - DENR Admin'); ?>

<?php
    // Optimize database queries by counting once
    $pendingCount = App\Models\EcologicalSubmission::where('status', 'pending')->count();
    $approvedCount = App\Models\EcologicalSubmission::where('status', 'approved')->count();
    $rejectedCount = App\Models\EcologicalSubmission::where('status', 'rejected')->count();
?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-blue-900 to-gray-900">
    <!-- Admin Header -->
    <header class="bg-white/10 backdrop-blur-md border-b border-white/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-4">
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="text-blue-400 hover:text-blue-300">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div>
                        <h1 class="text-xl font-bold text-white cinzel-heading">Ecological Submissions Review</h1>
                        <p class="text-sm text-gray-300">Review and manage turtle sightings and nesting reports</p>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <div class="flex space-x-2">
                        <a href="<?php echo e(route('admin.submissions.pending')); ?>" class="px-3 py-1 rounded-lg text-sm font-medium <?php echo e($status == 'pending' ? 'bg-yellow-500 text-white' : 'bg-gray-700 text-gray-300 hover:bg-gray-600'); ?>">
                            Pending (<?php echo e($pendingCount); ?>)
                        </a>
                        <a href="<?php echo e(route('admin.submissions.approved')); ?>" class="px-3 py-1 rounded-lg text-sm font-medium <?php echo e($status == 'approved' ? 'bg-green-500 text-white' : 'bg-gray-700 text-gray-300 hover:bg-gray-600'); ?>">
                            Approved (<?php echo e($approvedCount); ?>)
                        </a>
                        <a href="<?php echo e(route('admin.submissions.rejected')); ?>" class="px-3 py-1 rounded-lg text-sm font-medium <?php echo e($status == 'rejected' ? 'bg-red-500 text-white' : 'bg-gray-700 text-gray-300 hover:bg-gray-600'); ?>">
                            Rejected (<?php echo e($rejectedCount); ?>)
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Submissions List -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <?php if($submissions->count() === 0): ?>
            <div class="text-center py-12">
                <i class="fas fa-inbox text-6xl text-gray-500 mb-4"></i>
                <h3 class="text-xl font-semibold text-white mb-2">No <?php echo e(ucfirst($status)); ?> Submissions</h3>
                <p class="text-gray-400">There are currently no <?php echo e($status); ?> ecological submissions to review.</p>
            </div>
        <?php else: ?>
            <div class="grid gap-6">
                <?php $__currentLoopData = $submissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white/10 backdrop-blur-md rounded-xl border border-white/20">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3 mb-2">
                                        <h3 class="text-lg font-bold text-white"><?php echo e($submission->title); ?></h3>
                                        <span class="px-2 py-1 text-xs rounded-full bg-blue-500/20 text-blue-400">
                                            <?php echo e(ucfirst(str_replace('_', ' ', $submission->type))); ?>

                                        </span>
                                        <span class="px-2 py-1 text-xs rounded-full <?php echo e($submission->status == 'pending' ? 'bg-yellow-500/20 text-yellow-400' : ($submission->status == 'approved' ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400')); ?>">
                                            <?php echo e(ucfirst($submission->status)); ?>

                                        </span>
                                    </div>
                                    
                                    <p class="text-gray-300 mb-3"><?php echo e($submission->description); ?></p>
                                    
                                    <div class="flex flex-wrap gap-4 text-sm text-gray-400">
                                        <div class="flex items-center space-x-2">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <span><?php echo e($submission->location); ?></span>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <i class="fas fa-user"></i>
                                            <span><?php echo e($submission->user->name); ?></span>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <i class="fas fa-calendar"></i>
                                            <span><?php echo e($submission->created_at->format('M d, Y - g:i A')); ?></span>
                                        </div>
                                        <?php if($submission->latitude && $submission->longitude): ?>
                                            <div class="flex items-center space-x-2">
                                                <i class="fas fa-crosshairs"></i>
                                                <span><?php echo e($submission->latitude); ?>, <?php echo e($submission->longitude); ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <?php if($submission->status == 'pending'): ?>
                                    <div class="flex space-x-2 ml-4">
                                        <button onclick="openReviewModal(<?php echo e($submission->id); ?>, 'approve')" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                            <i class="fas fa-check mr-2"></i>Approve
                                        </button>
                                        <button onclick="openReviewModal(<?php echo e($submission->id); ?>, 'reject')" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                            <i class="fas fa-times mr-2"></i>Reject
                                        </button>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <?php if($submission->images && count($submission->images) > 0): ?>
                                <div class="mt-4">
                                    <h4 class="text-sm font-medium text-gray-300 mb-2">Attached Images:</h4>
                                    <div class="flex space-x-2">
                                        <?php $__currentLoopData = $submission->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="w-20 h-20 bg-gray-700 rounded-lg overflow-hidden">
                                                <img src="<?php echo e(asset('storage/' . $image)); ?>" alt="Submission image" class="w-full h-full object-cover">
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <?php if($submission->admin_notes): ?>
                                <div class="mt-4 p-3 bg-gray-800/50 rounded-lg">
                                    <h4 class="text-sm font-medium text-gray-300 mb-1">Admin Notes:</h4>
                                    <p class="text-sm text-gray-400"><?php echo e($submission->admin_notes); ?></p>
                                </div>
                            <?php endif; ?>
                            
                            <?php if($submission->reviewed_at): ?>
                                <div class="mt-4 text-xs text-gray-500">
                                    Reviewed by <?php echo e($submission->reviewer->name); ?> on <?php echo e($submission->reviewed_at->format('M d, Y - g:i A')); ?>

                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </main>
</div>

<!-- Toast Notification -->
<div id="toast" class="fixed top-4 right-4 z-50 hidden">
    <div class="bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg flex items-center space-x-3">
        <i class="fas fa-check-circle"></i>
        <span id="toastMessage">Success!</span>
    </div>
</div>

<!-- Review Modal -->
<div id="reviewModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50">
    <div class="bg-gray-800 rounded-xl max-w-lg w-full mx-4">
        <div class="p-6">
            <h3 id="reviewModalTitle" class="text-xl font-bold text-white mb-4">Review Submission</h3>
            <form id="reviewForm" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <input type="hidden" id="submissionId" name="submission_id">
                <input type="hidden" id="reviewStatus" name="status">
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Admin Notes (Optional)</label>
                        <textarea name="admin_notes" rows="4" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Add any notes about this decision..."></textarea>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeReviewModal()" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        Cancel
                    </button>
                    <button id="reviewSubmitBtn" type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        Submit Review
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openReviewModal(submissionId, action) {
    document.getElementById('submissionId').value = submissionId;
    document.getElementById('reviewStatus').value = action === 'approve' ? 'approved' : 'rejected';
    
    const title = action === 'approve' ? 'Approve Submission' : 'Reject Submission';
    document.getElementById('reviewModalTitle').textContent = title;
    
    const submitBtn = document.getElementById('reviewSubmitBtn');
    submitBtn.textContent = action === 'approve' ? 'Approve' : 'Reject';
    submitBtn.className = action === 'approve' 
        ? 'bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors'
        : 'bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors';
    
    document.getElementById('reviewModal').classList.remove('hidden');
    document.getElementById('reviewModal').classList.add('flex');
}

function closeReviewModal() {
    document.getElementById('reviewModal').classList.add('hidden');
    document.getElementById('reviewModal').classList.remove('flex');
    document.getElementById('reviewForm').reset();
}

// Handle form submission
document.getElementById('reviewForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submissionId = document.getElementById('submissionId').value;
    const formData = new FormData(this);
    
    fetch(`/admin/submissions/${submissionId}/status`, {
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Submission reviewed successfully!', 'success');
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            showToast('Error: ' + data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('An error occurred while reviewing the submission.', 'error');
    });
});

// Close modal on background click
document.getElementById('reviewModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeReviewModal();
    }
});

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
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rayver\Desktop\pawikan-patrol\my_app\resources\views/admin/submissions.blade.php ENDPATH**/ ?>
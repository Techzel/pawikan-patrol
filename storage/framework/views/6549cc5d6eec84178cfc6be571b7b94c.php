<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-6">
    <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Validate Patrol Report</h2>
            <a href="<?php echo e(route('admin.patrol-reports.show', $report->id)); ?>" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                &larr; Back to Report
            </a>
        </div>

        <!-- Report Summary -->
        <div class="mb-8 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Report Details</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-300">Report ID</p>
                    <p class="font-medium text-gray-900 dark:text-white">#<?php echo e($report->id); ?></p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-300">Submitted By</p>
                    <p class="font-medium text-gray-900 dark:text-white"><?php echo e($report->patroller->name ?? 'N/A'); ?></p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-300">Report Type</p>
                    <p class="font-medium text-gray-900 dark:text-white"><?php echo e(ucfirst(str_replace('_', ' ', $report->report_type))); ?></p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-300">Status</p>
                    <span class="px-2 py-1 text-xs rounded-full <?php echo e($report->status === 'validated' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 
                        ($report->status === 'rejected' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : 
                        'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200')); ?>">
                        <?php echo e(ucfirst(str_replace('_', ' ', $report->status))); ?>

                    </span>
                </div>
            </div>
        </div>

        <!-- Validation Form -->
        <form action="<?php echo e(route('admin.patrol-reports.validate', $report->id)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="space-y-6">
                <!-- Validation Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Validation Status</label>
                    <select id="status" name="status" required 
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md dark:bg-gray-700 dark:text-white">
                        <option value="" disabled selected>Select validation status</option>
                        <option value="validated" <?php echo e(old('status', $report->status) === 'validated' ? 'selected' : ''); ?>>Validate Report</option>
                        <option value="needs_correction" <?php echo e(old('status', $report->status) === 'needs_correction' ? 'selected' : ''); ?>>Needs Correction</option>
                        <option value="rejected" <?php echo e(old('status', $report->status) === 'rejected' ? 'selected' : ''); ?>>Reject Report</option>
                    </select>
                    <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Validation Notes -->
                <div>
                    <label for="validation_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Validation Notes
                        <span class="text-gray-500 text-xs">(Required for 'Needs Correction' or 'Reject')</span>
                    </label>
                    <textarea id="validation_notes" name="validation_notes" rows="4" 
                              class="mt-1 block w-full shadow-sm sm:text-sm border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white"
                              placeholder="Provide details about your validation decision. If corrections are needed, be specific about what needs to be fixed."><?php echo e(old('validation_notes', $report->validation_notes)); ?></textarea>
                    <?php $__errorArgs = ['validation_notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Evidence Check -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                    <div class="flex items-center">
                        <input id="evidence_verified" name="evidence_verified" type="checkbox" 
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600"
                               <?php echo e(old('evidence_verified', $report->evidence_verified) ? 'checked' : ''); ?>>
                        <label for="evidence_verified" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                            I have verified all attached evidence (photos, documents, etc.)
                        </label>
                    </div>
                    <?php $__errorArgs = ['evidence_verified'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Location Verification -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                    <div class="flex items-center">
                        <input id="location_verified" name="location_verified" type="checkbox" 
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600"
                               <?php echo e(old('location_verified', $report->location_verified) ? 'checked' : ''); ?>>
                        <label for="location_verified" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                            The reported location has been verified
                        </label>
                    </div>
                    <?php $__errorArgs = ['location_verified'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Priority Level -->
                <div>
                    <label for="priority" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Priority Level</label>
                    <select id="priority" name="priority" required
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md dark:bg-gray-700 dark:text-white">
                        <option value="low" <?php echo e(old('priority', $report->priority) === 'low' ? 'selected' : ''); ?>>Low</option>
                        <option value="medium" <?php echo e(old('priority', $report->priority) === 'medium' ? 'selected' : ''); ?>>Medium</option>
                        <option value="high" <?php echo e(old('priority', $report->priority) === 'high' ? 'selected' : ''); ?>>High</option>
                        <option value="critical" <?php echo e(old('priority', $report->priority) === 'critical' ? 'selected' : ''); ?>>Critical</option>
                    </select>
                    <?php $__errorArgs = ['priority'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Follow-up Required -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                    <div class="flex items-center">
                        <input id="needs_followup" name="needs_followup" type="checkbox" 
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600"
                               <?php echo e(old('needs_followup', $report->needs_followup) ? 'checked' : ''); ?>>
                        <label for="needs_followup" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                            This report requires follow-up action
                        </label>
                    </div>
                    <?php $__errorArgs = ['needs_followup'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Follow-up Notes (Conditional) -->
                <div id="followupNotesContainer" class="hidden">
                    <label for="followup_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Follow-up Instructions
                    </label>
                    <textarea id="followup_notes" name="followup_notes" rows="3" 
                              class="mt-1 block w-full shadow-sm sm:text-sm border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white"
                              placeholder="Provide specific instructions for the follow-up action."><?php echo e(old('followup_notes', $report->followup_notes)); ?></textarea>
                    <?php $__errorArgs = ['followup_notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Submit Button -->
                <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Submit Validation
                    </button>
                    <a href="<?php echo e(route('admin.patrol-reports.show', $report->id)); ?>" class="ml-2 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    // Show/hide follow-up notes based on checkbox
    const needsFollowup = document.getElementById('needs_followup');
    const followupNotesContainer = document.getElementById('followupNotesContainer');
    const followupNotes = document.getElementById('followup_notes');

    function toggleFollowupNotes() {
        if (needsFollowup.checked) {
            followupNotesContainer.classList.remove('hidden');
            followupNotes.required = true;
        } else {
            followupNotesContainer.classList.add('hidden');
            followupNotes.required = false;
        }
    }

    // Initial check
    toggleFollowupNotes();
    
    // Add event listener
    needsFollowup.addEventListener('change', toggleFollowupNotes);

    // Add validation for notes when status is needs_correction or rejected
    const form = document.querySelector('form');
    const statusSelect = document.getElementById('status');
    const validationNotes = document.getElementById('validation_notes');

    form.addEventListener('submit', function(e) {
        const status = statusSelect.value;
        const notes = validationNotes.value.trim();
        
        if ((status === 'needs_correction' || status === 'rejected') && notes === '') {
            e.preventDefault();
            alert('Validation notes are required when status is "Needs Correction" or "Reject".');
            validationNotes.focus();
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rayver\Desktop\pawikan-patrol\my_app\resources\views/admin/patrol-reports/validate.blade.php ENDPATH**/ ?>
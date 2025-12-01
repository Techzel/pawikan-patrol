<?php $__env->startSection('title', 'Patrol Reports Management - DENR Admin'); ?>

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
                        <h1 class="text-xl font-bold text-white cinzel-heading">Patrol Reports Management</h1>
                        <p class="text-sm text-gray-300">Review and manage all patrol reports</p>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <!-- Quick Actions -->
                    <div class="flex items-center space-x-2">
                        <button onclick="bulkStatusUpdate('accepted')" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-lg text-sm font-medium transition-colors cinzel-text" title="Accept Selected Reports">
                            <i class="fas fa-check-circle mr-1"></i>Accept Selected
                        </button>
                        <button onclick="bulkStatusUpdate('reject')" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg text-sm font-medium transition-colors cinzel-text" title="Reject Selected Reports">
                            <i class="fas fa-times-circle mr-1"></i>Reject Selected
                        </button>
                        <button onclick="exportReports('excel')" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg text-sm font-medium transition-colors cinzel-text" title="Export to Excel">
                            <i class="fas fa-download mr-1"></i>Export
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Filters -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Quick Status Overview -->
        <div class="grid grid-cols-3 gap-4 mb-6">
            <div class="bg-green-500/10 border border-green-500/20 rounded-lg p-3 text-center">
                <div class="text-2xl font-bold text-green-400"><?php echo e($reports->whereIn('status', ['accepted', 'validated'])->count()); ?></div>
                <div class="text-xs text-green-300">Accepted/Validated</div>
            </div>
            <div class="bg-red-500/10 border border-red-500/20 rounded-lg p-3 text-center">
                <div class="text-2xl font-bold text-red-400"><?php echo e($reports->whereIn('status', ['reject', 'rejected'])->count()); ?></div>
                <div class="text-xs text-red-300">Rejected</div>
            </div>
            <div class="bg-blue-500/10 border border-blue-500/20 rounded-lg p-3 text-center">
                <div class="text-2xl font-bold text-blue-400"><?php echo e($reports->whereIn('status', ['pending_review', 'pending', 'submitted'])->count()); ?></div>
                <div class="text-xs text-blue-300">Pending</div>
            </div>
        </div>

        <div class="glass-dark rounded-xl p-6 border border-ocean-500/20">
            <form method="GET" action="<?php echo e(route('admin.patrol-reports.index')); ?>" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 items-end">
                <!-- Status Filter -->
                <div class="relative">
                    <label class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Status</label>
                    <select name="status" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-white focus:ring-2 focus:ring-ocean-500 focus:border-transparent cinzel-text transition-all hover:bg-white/10 cursor-pointer">
                        <option value="" class="bg-gray-900 text-gray-300">All Status</option>
                        <option value="pending" class="bg-gray-900 text-white" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                        <option value="accepted" class="bg-gray-900 text-white" <?php echo e(request('status') == 'accepted' ? 'selected' : ''); ?>>Accepted</option>
                        <option value="rejected" class="bg-gray-900 text-white" <?php echo e(request('status') == 'rejected' ? 'selected' : ''); ?>>Rejected</option>
                    </select>
                </div>

                <!-- Priority Filter -->
                <div class="relative">
                    <label class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Priority</label>
                    <select name="priority" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-white focus:ring-2 focus:ring-ocean-500 focus:border-transparent cinzel-text transition-all hover:bg-white/10 cursor-pointer">
                        <option value="" class="bg-gray-900 text-gray-300">All Priorities</option>
                        <option value="low" class="bg-gray-900 text-white" <?php echo e(request('priority') == 'low' ? 'selected' : ''); ?>>Low</option>
                        <option value="medium" class="bg-gray-900 text-white" <?php echo e(request('priority') == 'medium' ? 'selected' : ''); ?>>Medium</option>
                        <option value="high" class="bg-gray-900 text-white" <?php echo e(request('priority') == 'high' ? 'selected' : ''); ?>>High</option>
                        <option value="critical" class="bg-gray-900 text-white" <?php echo e(request('priority') == 'critical' ? 'selected' : ''); ?>>Critical</option>
                    </select>
                </div>

                <!-- Type Filter -->
                <div class="relative">
                    <label class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Type</label>
                    <select name="report_type" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-white focus:ring-2 focus:ring-ocean-500 focus:border-transparent cinzel-text transition-all hover:bg-white/10 cursor-pointer">
                        <option value="" class="bg-gray-900 text-gray-300">All Types</option>
                        <option value="rescue" class="bg-gray-900 text-white" <?php echo e(request('report_type') == 'rescue' ? 'selected' : ''); ?>>Rescue</option>
                        <option value="stranding" class="bg-gray-900 text-white" <?php echo e(request('report_type') == 'stranding' ? 'selected' : ''); ?>>Stranding</option>
                        <option value="nesting" class="bg-gray-900 text-white" <?php echo e(request('report_type') == 'nesting' ? 'selected' : ''); ?>>Nesting</option>
                    </select>
                </div>

                <!-- Patroller Filter -->
                <div class="relative">
                    <label class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Patroller</label>
                    <select name="patroller" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-white focus:ring-2 focus:ring-ocean-500 focus:border-transparent cinzel-text transition-all hover:bg-white/10 cursor-pointer">
                        <option value="" class="bg-gray-900 text-gray-300">All Patrollers</option>
                        <?php $__currentLoopData = $patrollers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patroller): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($patroller->id); ?>" class="bg-gray-900 text-white" <?php echo e(request('patroller') == $patroller->id ? 'selected' : ''); ?>>
                                <?php echo e($patroller->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <!-- Filter Actions -->
                <div class="flex items-center gap-2">
                    <button type="submit" class="flex-1 bg-ocean-600 hover:bg-ocean-500 text-white px-4 py-2.5 rounded-xl transition-all shadow-lg shadow-ocean-500/20 cinzel-text font-medium">
                        <i class="fas fa-filter mr-2"></i>Filter
                    </button>
                    <a href="<?php echo e(route('admin.patrol-reports.index')); ?>" class="px-4 py-2.5 rounded-xl border border-white/10 text-gray-300 hover:bg-white/5 hover:text-white transition-colors cinzel-text" title="Clear Filters">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </form>
        </div>

        <!-- Reports Table -->
    </div>

    <!-- Reports List -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-8">
        <div class="glass-dark rounded-xl border border-ocean-500/20 overflow-hidden">
            <?php if($reports->count() > 0): ?>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gradient-to-r from-ocean-600/50 to-ocean-700/50">
                            <tr>
                                <th class="px-6 py-3 text-left">
                                    <input type="checkbox" id="selectAll" onchange="toggleSelectAll()" class="rounded border-ocean-500/30 text-ocean-600 focus:ring-ocean-500">
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider cinzel-text">Report</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider cinzel-text hidden sm:table-cell">Patroller</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider cinzel-text">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider cinzel-text">Priority</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider cinzel-text">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider cinzel-text hidden sm:table-cell">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider cinzel-text">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-ocean-500/20">
                            <?php $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-white/5 transition-colors <?php echo e($report->status === 'rejected' ? 'bg-red-500/5' : ($report->status === 'accepted' ? 'bg-green-500/5' : '')); ?>">
                                    <td class="px-6 py-3">
                                        <input type="checkbox" name="report_ids[]" value="<?php echo e($report->id); ?>" class="rounded border-ocean-500/30 text-ocean-600 focus:ring-ocean-500">
                                    </td>
                                    <td class="px-6 py-3">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-ocean-500/20 flex items-center justify-center">
                                                <i class="fas fa-file-alt text-ocean-400"></i>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-white"><?php echo e($report->title); ?></div>
                                                <div class="text-xs text-gray-400"><?php echo e(Str::limit($report->description, 50)); ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-300 cinzel-text">
                                        <?php echo e($report->patroller->name ?? 'N/A'); ?>

                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium cinzel-text
                                            <?php if($report->report_type == 'rescue'): ?> bg-blue-500/20 text-blue-300
                                            <?php elseif($report->report_type == 'stranding'): ?> bg-orange-500/20 text-orange-300
                                            <?php elseif($report->report_type == 'nesting'): ?> bg-green-500/20 text-green-300
                                            <?php else: ?> bg-gray-500/20 text-gray-300 <?php endif; ?>">
                                            <?php echo e(ucfirst($report->report_type)); ?>

                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium cinzel-text
                                            <?php if($report->priority == 'critical'): ?> bg-red-500/20 text-red-300
                                            <?php elseif($report->priority == 'high'): ?> bg-orange-500/20 text-orange-300
                                            <?php elseif($report->priority == 'medium'): ?> bg-yellow-500/20 text-yellow-300
                                            <?php elseif($report->priority == 'low'): ?> bg-green-500/20 text-green-300
                                            <?php else: ?> bg-gray-500/20 text-gray-300 <?php endif; ?>">
                                            <?php echo e(ucfirst($report->priority)); ?>

                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php
                                            $statusClasses = [
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'submitted' => 'bg-blue-100 text-blue-800',
                                                'accepted' => 'bg-green-100 text-green-800',
                                                'rejected' => 'bg-red-100 text-red-800',
                                                'needs_correction' => 'bg-orange-100 text-orange-800',
                                                'resolved' => 'bg-purple-100 text-purple-800',
                                                'closed' => 'bg-gray-100 text-gray-800',
                                            ][$report->status] ?? 'bg-gray-100 text-gray-800';
                                        ?>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo e($statusClasses); ?>">
                                            <?php echo e(ucfirst(str_replace('_', ' ', $report->status))); ?>

                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-300 cinzel-text">
                                        <?php echo e($report->created_at ? $report->created_at->format('M d, Y') : 'N/A'); ?>

                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            <a href="<?php echo e(route('admin.patrol-reports.show', $report)); ?>" class="text-ocean-400 hover:text-ocean-300 transition-colors" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <?php if($report->status === 'pending' || $report->status === 'submitted'): ?>
                                                <button onclick="quickApprove(<?php echo e($report->id); ?>)" class="text-green-400 hover:text-green-300 transition-colors" title="Quick Approve">
                                                    <i class="fas fa-check-circle"></i>
                                                </button>
                                            <?php endif; ?>
                                            <?php if($report->status === 'needs_correction'): ?>
                                                <a href="<?php echo e(route('admin.patrol-reports.edit', $report)); ?>" class="text-yellow-400 hover:text-yellow-300 transition-colors" title="Edit Report">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            <?php endif; ?>
                                            <?php if($report->status !== 'rejected'): ?>
                                                <button onclick="showDeleteModal(<?php echo e($report->id); ?>)" class="text-red-400 hover:text-red-300 transition-colors" title="Reject Report">
                                                    <i class="fas fa-times-circle"></i>
                                                </button>
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
                    <p class="text-gray-400 mb-6 cinzel-text">
                        <?php if(request()->hasAny(['status', 'priority', 'type', 'patroller'])): ?>
                            No reports match your current filters.
                        <?php else: ?>
                            No patrol reports have been submitted yet.
                        <?php endif; ?>
                    </p>
                    <?php if(request()->hasAny(['status', 'priority', 'type', 'patroller'])): ?>
                        <a href="<?php echo e(route('admin.patrol-reports.index')); ?>" class="bg-ocean-500 hover:bg-ocean-600 text-white px-6 py-3 rounded-lg font-medium transition-all duration-300 transform hover:scale-105 shadow-lg cinzel-text">
                            <i class="fas fa-times mr-2"></i>Clear Filters
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
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
// Toast notification function
function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    const toastMessage = document.getElementById('toastMessage');
    const toastContainer = toast.querySelector('div');
    
    // Set message
    toastMessage.textContent = message;
    
    // Set colors based on type
    if (type === 'success') {
        toastContainer.className = 'bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg flex items-center space-x-3';
        toastContainer.querySelector('i').className = 'fas fa-check-circle';
    } else if (type === 'error') {
        toastContainer.className = 'bg-red-600 text-white px-6 py-3 rounded-lg shadow-lg flex items-center space-x-3';
        toastContainer.querySelector('i').className = 'fas fa-exclamation-circle';
    } else if (type === 'info') {
        toastContainer.className = 'bg-blue-600 text-white px-6 py-3 rounded-lg shadow-lg flex items-center space-x-3';
        toastContainer.querySelector('i').className = 'fas fa-info-circle';
    }
    
    // Show toast
    toast.classList.remove('hidden');
    
    // Hide after 3 seconds
    setTimeout(() => {
        toast.classList.add('hidden');
    }, 3000);
}

// Quick action function for table actions
function quickAction(reportId, status) {
    const statusText = {
        'reviewing': 'start reviewing',
        'accepted': 'accept',
        'reject': 'reject',
        'resolved': 'mark as resolved',
        'closed': 'close'
    }[status] || status.replace('_', ' ');

    if (!confirm(`Are you sure you want to ${statusText} this report?`)) {
        return;
    }

    fetch(`/admin/patrol-reports/${reportId}/status`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        },
        body: JSON.stringify({
            status: status
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Report status updated successfully!', 'success');
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            showToast('Error: ' + (data.message || 'Failed to update report'), 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('An error occurred while updating the report.', 'error');
    });
}

// Bulk selection functions
function toggleSelectAll() {
    const selectAllCheckbox = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('input[name="report_ids[]"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAllCheckbox.checked;
    });
    updateSelectedCount();
}

function updateSelectedCount() {
    const selected = document.querySelectorAll('input[name="report_ids[]"]:checked').length;
    // Update UI to show selected count if needed
    console.log(`${selected} reports selected`);
}

// Bulk status update
function bulkStatusUpdate(status) {
    const selectedReports = document.querySelectorAll('input[name="report_ids[]"]:checked');
    if (selectedReports.length === 0) {
        showToast('Please select at least one report.', 'error');
        return;
    }

    const statusText = {
        'accepted': 'validate and approve',
        'reject': 'reject',
        'reviewing': 'mark for review'
    }[status] || status.replace('_', ' ');

    let confirmMessage = `Are you sure you want to ${statusText} ${selectedReports.length} selected report(s)?`;
    if (status === 'accepted') {
        confirmMessage += '\n\nNote: Reports will be validated. You can add GPS coordinates individually later for map display.';
    }

    if (!confirm(confirmMessage)) {
        return;
    }

    const reportIds = Array.from(selectedReports).map(cb => cb.value);
    
    // Convert 'accepted' to 'validated' for proper validation
    const actualStatus = status === 'accepted' ? 'validated' : status;

    fetch('/admin/patrol-reports/bulk-status-update', {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        },
        body: JSON.stringify({
            report_ids: reportIds,
            status: actualStatus
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const action = status === 'accepted' ? 'validated' : statusText;
            showToast(`Successfully ${action} ${reportIds.length} report(s)!`, 'success');
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            showToast('Error: ' + (data.message || 'Failed to update reports'), 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('An error occurred while updating the reports.', 'error');
    });
}

// Export functions
function exportReports(format) {
    const url = new URL(window.location);
    url.searchParams.set('export', format);
    window.open(url.toString(), '_blank');
    showToast(`Exporting reports as ${format.toUpperCase()}...`, 'success');
}

function generateReport() {
    showToast('Generating comprehensive report...', 'success');
    // This would typically call a backend endpoint to generate a report
    setTimeout(() => {
        showToast('Report generated successfully! Check your downloads.', 'success');
    }, 2000);
}

function sendBulkNotification() {
    const selectedReports = document.querySelectorAll('input[name="report_ids[]"]:checked');
    if (selectedReports.length === 0) {
        showToast('Please select reports to notify patrollers.', 'error');
        return;
    }

    showToast('Sending notifications to selected patrollers...', 'success');
    setTimeout(() => {
        showToast('Notifications sent successfully!', 'success');
    }, 1500);
}

function sendFeedback() {
    const selectedReports = document.querySelectorAll('input[name="report_ids[]"]:checked');
    if (selectedReports.length === 0) {
        showToast('Please select reports to send feedback.', 'error');
        return;
    }

    // Open a modal or prompt for feedback
    const feedback = prompt('Enter feedback message to send to selected patrollers:');
    if (feedback) {
        showToast('Sending feedback to selected patrollers...', 'success');
        setTimeout(() => {
            showToast('Feedback sent successfully!', 'success');
        }, 1500);
    }
}

function scheduleFollowup() {
    const selectedReports = document.querySelectorAll('input[name="report_ids[]"]:checked');
    if (selectedReports.length === 0) {
        showToast('Please select reports to schedule follow-up.', 'error');
        return;
    }

    showToast('Scheduling follow-up for selected reports...', 'success');
    setTimeout(() => {
        showToast('Follow-up scheduled successfully!', 'success');
    }, 1500);
}

// Quick approve functionality - Validates the report
function quickApprove(reportId) {
    // Show confirmation dialog
    const confirmed = confirm('Are you sure you want to validate and approve this report?');
    
    if (!confirmed) {
        console.log('Quick approve cancelled by user');
        return;
    }
    
    console.log('Quick approving report #' + reportId);
    
    fetch(`/admin/patrol-reports/${reportId}/status`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            status: 'validated',
            validation_notes: 'Quick validated by admin',
            evidence_verified: true,
            location_verified: true
        })
    })
    .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            showToast('Report validated successfully', 'success');
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            showToast(data.message || 'Failed to validate report', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('An error occurred while validating the report', 'error');
    });
}

// Delete modal and functionality
let deleteReportId = null;

function showDeleteModal(reportId) {
    deleteReportId = reportId;
    
    // Show simple confirmation dialog
    const confirmed = confirm('Are you sure you want to reject this patrol report? The report will be marked as rejected and will not be deleted.');
    
    if (!confirmed) {
        console.log('Reject cancelled by user');
        return;
    }
    
    rejectReport(reportId);
}

function rejectReport(reportId) {
    console.log('Rejecting report #' + reportId);
    showToast('Rejecting report...', 'info');
    
    fetch(`/admin/patrol-reports/${reportId}/status`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            status: 'rejected',
            validation_notes: 'Report rejected by admin'
        })
    })
    .then(response => {
        console.log('Reject response status:', response.status);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log('Reject response data:', data);
        if (data.success || data.message) {
            showToast('Report rejected successfully', 'success');
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            showToast('Failed to reject report', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('An error occurred while rejecting the report', 'error');
    });
}

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rayver\Desktop\my_app\resources\views/admin/patrol-reports/index.blade.php ENDPATH**/ ?>
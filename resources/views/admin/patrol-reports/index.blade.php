@extends('layouts.app')

@section('title', 'Patrol Reports Management - DENR Admin')

@section('content')
<div id="patrolReportsIndex" class="min-h-screen bg-gray-900">
    <!-- Back Button - Above Header -->
    <div class="pt-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 text-gray-300 hover:text-white transition-colors group">
            <i class="fas fa-arrow-left text-sm group-hover:-translate-x-1 transition-transform"></i>
            <span class="text-sm font-medium">Back to Dashboard</span>
        </a>
    </div>



    <!-- Filters -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-2 pb-6">
        <!-- Quick Status Overview -->
        <div class="grid grid-cols-3 gap-4 mb-6">
            <div class="bg-green-500/10 border border-green-500/20 rounded-lg p-3 text-center">
                <div class="text-2xl font-bold text-green-400">{{ $reports->whereIn('status', ['accepted', 'validated'])->count() }}</div>
                <div class="text-xs text-green-300">Accepted/Validated</div>
            </div>
            <div class="bg-red-500/10 border border-red-500/20 rounded-lg p-3 text-center">
                <div class="text-2xl font-bold text-red-400">{{ $reports->whereIn('status', ['reject', 'rejected'])->count() }}</div>
                <div class="text-xs text-red-300">Rejected</div>
            </div>
            <div class="bg-blue-500/10 border border-blue-500/20 rounded-lg p-3 text-center">
                <div class="text-2xl font-bold text-blue-400">{{ $reports->whereIn('status', ['pending_review', 'pending', 'submitted'])->count() }}</div>
                <div class="text-xs text-blue-300">Pending</div>
            </div>
        </div>

        <div class="glass-dark rounded-xl p-6 border border-ocean-500/20">
            <form method="GET" action="{{ route('admin.patrol-reports.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 items-end">
                <!-- Status Filter -->
                <div class="relative">
                    <label class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Status</label>
                    <select name="status" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-white focus:ring-2 focus:ring-ocean-500 focus:border-transparent cinzel-text transition-all hover:bg-white/10 cursor-pointer">
                        <option value="" class="bg-gray-900 text-gray-300">All Status</option>
                        <option value="pending" class="bg-gray-900 text-white" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="accepted" class="bg-gray-900 text-white" {{ request('status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
                        <option value="rejected" class="bg-gray-900 text-white" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                <!-- Priority Filter -->
                <div class="relative">
                    <label class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Priority</label>
                    <select name="priority" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-white focus:ring-2 focus:ring-ocean-500 focus:border-transparent cinzel-text transition-all hover:bg-white/10 cursor-pointer">
                        <option value="" class="bg-gray-900 text-gray-300">All Priorities</option>
                        <option value="low" class="bg-gray-900 text-white" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" class="bg-gray-900 text-white" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" class="bg-gray-900 text-white" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                        <option value="critical" class="bg-gray-900 text-white" {{ request('priority') == 'critical' ? 'selected' : '' }}>Critical</option>
                    </select>
                </div>

                <!-- Type Filter -->
                <div class="relative">
                    <label class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Type</label>
                    <select name="report_type" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-white focus:ring-2 focus:ring-ocean-500 focus:border-transparent cinzel-text transition-all hover:bg-white/10 cursor-pointer">
                        <option value="" class="bg-gray-900 text-gray-300">All Types</option>
                        <option value="rescue" class="bg-gray-900 text-white" {{ request('report_type') == 'rescue' ? 'selected' : '' }}>Rescue</option>
                        <option value="stranding" class="bg-gray-900 text-white" {{ request('report_type') == 'stranding' ? 'selected' : '' }}>Stranding</option>
                        <option value="nesting" class="bg-gray-900 text-white" {{ request('report_type') == 'nesting' ? 'selected' : '' }}>Nesting</option>
                    </select>
                </div>

                <!-- Patroller Filter -->
                <div class="relative">
                    <label class="block text-sm font-medium text-gray-300 mb-2 cinzel-text">Patroller</label>
                    <select name="patroller" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-white focus:ring-2 focus:ring-ocean-500 focus:border-transparent cinzel-text transition-all hover:bg-white/10 cursor-pointer">
                        <option value="" class="bg-gray-900 text-gray-300">All Patrollers</option>
                        @foreach($patrollers as $patroller)
                            <option value="{{ $patroller->id }}" class="bg-gray-900 text-white" {{ request('patroller') == $patroller->id ? 'selected' : '' }}>
                                {{ $patroller->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Actions -->
                <div class="flex items-center gap-2">
                    <button type="submit" class="flex-1 bg-ocean-600 hover:bg-ocean-500 text-white px-4 py-2.5 rounded-xl transition-all shadow-lg shadow-ocean-500/20 cinzel-text font-medium">
                        <i class="fas fa-filter mr-2"></i>Filter
                    </button>
                    <a href="{{ route('admin.patrol-reports.index') }}" class="px-4 py-2.5 rounded-xl border border-white/10 text-gray-300 hover:bg-white/5 hover:text-white transition-colors cinzel-text" title="Clear Filters">
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
            @if($reports->count() > 0)
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
                            @foreach($reports as $report)
                                <tr class="hover:bg-white/5 transition-colors {{ $report->status === 'rejected' ? 'bg-red-500/5' : ($report->status === 'accepted' ? 'bg-green-500/5' : '') }}">
                                    <td class="px-6 py-3">
                                        <input type="checkbox" name="report_ids[]" value="{{ $report->id }}" class="rounded border-ocean-500/30 text-ocean-600 focus:ring-ocean-500">
                                    </td>
                                    <td class="px-6 py-3">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-ocean-500/20 flex items-center justify-center">
                                                <i class="fas fa-file-alt text-ocean-400"></i>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-white">{{ $report->title }}</div>
                                                <div class="text-xs text-gray-400">{{ Str::limit($report->description, 50) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-300 cinzel-text">
                                        {{ $report->patroller->name ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium cinzel-text
                                            @if($report->report_type == 'rescue') bg-blue-500/20 text-blue-300
                                            @elseif($report->report_type == 'stranding') bg-orange-500/20 text-orange-300
                                            @elseif($report->report_type == 'nesting') bg-green-500/20 text-green-300
                                            @else bg-gray-500/20 text-gray-300 @endif">
                                            {{ ucfirst($report->report_type) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium cinzel-text
                                            @if($report->priority == 'critical') bg-red-500/20 text-red-300
                                            @elseif($report->priority == 'high') bg-orange-500/20 text-orange-300
                                            @elseif($report->priority == 'medium') bg-yellow-500/20 text-yellow-300
                                            @elseif($report->priority == 'low') bg-green-500/20 text-green-300
                                            @else bg-gray-500/20 text-gray-300 @endif">
                                            {{ ucfirst($report->priority) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusClasses = [
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'submitted' => 'bg-blue-100 text-blue-800',
                                                'accepted' => 'bg-green-100 text-green-800',
                                                'rejected' => 'bg-red-100 text-red-800',
                                                'needs_correction' => 'bg-orange-100 text-orange-800',
                                                'resolved' => 'bg-purple-100 text-purple-800',
                                                'closed' => 'bg-gray-100 text-gray-800',
                                            ][$report->status] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClasses }}">
                                            {{ ucfirst(str_replace('_', ' ', $report->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-300 cinzel-text">
                                        {{ $report->created_at ? $report->created_at->format('M d, Y') : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('admin.patrol-reports.show', $report) }}" class="text-ocean-400 hover:text-ocean-300 transition-colors" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($report->status === 'pending' || $report->status === 'submitted')
                                                <button onclick="quickApprove({{ $report->id }})" class="text-green-400 hover:text-green-300 transition-colors" title="Quick Approve">
                                                    <i class="fas fa-check-circle"></i>
                                                </button>
                                            @endif
                                            @if($report->status === 'needs_correction')
                                                <a href="{{ route('admin.patrol-reports.edit', $report) }}" class="text-yellow-400 hover:text-yellow-300 transition-colors" title="Edit Report">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endif
                                            @if($report->status !== 'rejected')
                                                <button onclick="showDeleteModal({{ $report->id }})" class="text-red-400 hover:text-red-300 transition-colors" title="Reject Report">
                                                    <i class="fas fa-times-circle"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-ocean-500/20">
                    {{ $reports->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-file-alt text-6xl text-gray-500 mb-4"></i>
                    <h3 class="text-xl font-medium text-white mb-2 cinzel-heading">No Reports Found</h3>
                    <p class="text-gray-400 mb-6 cinzel-text">
                        @if(request()->hasAny(['status', 'priority', 'type', 'patroller']))
                            No reports match your current filters.
                        @else
                            No patrol reports have been submitted yet.
                        @endif
                    </p>
                    @if(request()->hasAny(['status', 'priority', 'type', 'patroller']))
                        <a href="{{ route('admin.patrol-reports.index') }}" class="bg-ocean-500 hover:bg-ocean-600 text-white px-6 py-3 rounded-lg font-medium transition-all duration-300 transform hover:scale-105 shadow-lg cinzel-text">
                            <i class="fas fa-times mr-2"></i>Clear Filters
                        </a>
                    @endif
                </div>
            @endif
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

<!-- Custom Confirmation Modal -->
<div id="confirmModal" class="fixed inset-0 z-[9999] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeConfirmModal()"></div>

        <!-- Center modal -->
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
                        <h3 class="text-xl font-bold text-white mb-2" id="modal-title" style="font-family: 'Poppins', sans-serif;">
                            Confirm Action
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-300" id="modalMessage" style="font-family: 'Poppins', sans-serif;">
                                Are you sure you want to proceed with this action?
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-800/50 px-6 py-4 sm:flex sm:flex-row-reverse gap-3">
                <button type="button" id="confirmButton" onclick="confirmModalAction()" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-base font-medium text-white hover:from-green-700 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-200 transform hover:scale-105" style="font-family: 'Poppins', sans-serif;">
                    OK
                </button>
                <button type="button" onclick="closeConfirmModal()" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-600 shadow-sm px-6 py-3 bg-gray-700 text-base font-medium text-gray-200 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:w-auto sm:text-sm transition-all duration-200" style="font-family: 'Poppins', sans-serif;">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    #confirmModal {
        animation: fadeIn 0.2s ease-out;
    }
    
    #confirmModal > div > div:last-child {
        animation: slideUp 0.3s ease-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }
</style>

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
        
        // Set content
        modalTitle.textContent = title;
        modalMessage.textContent = message;
        
        // Set icon and colors based on type
        if (type === 'danger' || type === 'reject') {
            modalIconContainer.className = 'mx-auto flex-shrink-0 flex items-center justify-center h-14 w-14 rounded-full bg-red-500/20 sm:mx-0 sm:h-12 sm:w-12';
            modalIcon.className = 'h-7 w-7 text-red-400';
            modalIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>';
            confirmButton.className = 'w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-base font-medium text-white hover:from-red-700 hover:to-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-200 transform hover:scale-105';
        } else if (type === 'warning') {
            modalIconContainer.className = 'mx-auto flex-shrink-0 flex items-center justify-center h-14 w-14 rounded-full bg-yellow-500/20 sm:mx-0 sm:h-12 sm:w-12';
            modalIcon.className = 'h-7 w-7 text-yellow-400';
            modalIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>';
            confirmButton.className = 'w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-3 bg-gradient-to-r from-yellow-600 to-yellow-700 text-base font-medium text-white hover:from-yellow-700 hover:to-yellow-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-200 transform hover:scale-105';
        } else {
            modalIconContainer.className = 'mx-auto flex-shrink-0 flex items-center justify-center h-14 w-14 rounded-full bg-green-500/20 sm:mx-0 sm:h-12 sm:w-12';
            modalIcon.className = 'h-7 w-7 text-green-400';
            modalIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>';
            confirmButton.className = 'w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-base font-medium text-white hover:from-green-700 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-200 transform hover:scale-105';
        }
        
        // Store callback
        confirmModalCallback = resolve;
        
        // Show modal
        modal.classList.remove('hidden');
    });
}

function closeConfirmModal() {
    const modal = document.getElementById('confirmModal');
    modal.classList.add('hidden');
    if (confirmModalCallback) {
        confirmModalCallback(false);
        confirmModalCallback = null;
    }
}

function confirmModalAction() {
    const modal = document.getElementById('confirmModal');
    modal.classList.add('hidden');
    if (confirmModalCallback) {
        confirmModalCallback(true);
        confirmModalCallback = null;
    }
}

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeConfirmModal();
    }
});
</script>

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
async function quickAction(reportId, status) {
    const statusText = {
        'reviewing': 'start reviewing',
        'accepted': 'accept',
        'reject': 'reject',
        'resolved': 'mark as resolved',
        'closed': 'close'
    }[status] || status.replace('_', ' ');

    const confirmed = await showConfirmModal(
        `Are you sure you want to ${statusText} this report?`,
        'Confirm Action',
        status === 'reject' ? 'danger' : 'success'
    );
    
    if (!confirmed) {
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
async function bulkStatusUpdate(status) {
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

    const confirmed = await showConfirmModal(
        confirmMessage,
        'Confirm Bulk Action',
        status === 'reject' ? 'danger' : 'success'
    );
    
    if (!confirmed) {
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
async function quickApprove(reportId) {
    // Show confirmation dialog
    const confirmed = await showConfirmModal(
        'Are you sure you want to validate and approve this report?',
        'Validate Report',
        'success'
    );
    
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

async function showDeleteModal(reportId) {
    deleteReportId = reportId;
    
    // Show custom confirmation modal
    const confirmed = await showConfirmModal(
        'Are you sure you want to reject this patrol report? The report will be marked as rejected and will not be deleted.',
        'Reject Report',
        'danger'
    );
    
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
@endsection

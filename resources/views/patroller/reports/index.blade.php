@extends('layouts.patroller')

@section('title', 'My Reports')

@section('content')
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-white mb-2 " style="font-family: 'Poppins', sans-serif;">
                            <i class="fas fa-file-alt mr-3 text-green-400"></i>My Reports
                        </h1>
                        <p class="text-gray-300 " style="font-family: 'Poppins', sans-serif;">Manage and track your patrol reports</p>
                    </div>
                    <a href="{{ route('patroller.reports.create') }}" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-6 py-3 rounded-lg font-medium transition-all duration-300 transform hover:scale-105 shadow-lg " style="font-family: 'Poppins', sans-serif;">
                        <i class="fas fa-plus mr-2"></i>New Report
                    </a>
                </div>
            </div>

            <!-- Filters -->
            <div class="glass-dark rounded-xl p-6 mb-8 border border-green-500/20">
                <form method="GET" action="{{ route('patroller.reports.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    <!-- Status Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2 " style="font-family: 'Poppins', sans-serif;">Status</label>
                        <select name="status" class="w-full bg-gray-800 border border-green-500/30 rounded-lg px-3 py-2 text-white focus:ring-2 focus:ring-green-400 focus:border-transparent " style="font-family: 'Poppins', sans-serif;">
                            <option value="" selected class="bg-gray-800 text-white">All Status</option>
                            <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>Submitted</option>
                            <option value="under_review" {{ request('status') == 'under_review' ? 'selected' : '' }}>Under Review</option>
                            <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                            <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                    </div>

                    <!-- Priority Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2 " style="font-family: 'Poppins', sans-serif;">Priority</label>
                        <select name="priority" class="w-full bg-gray-800 border border-green-500/30 rounded-lg px-3 py-2 text-white focus:ring-2 focus:ring-green-400 focus:border-transparent " style="font-family: 'Poppins', sans-serif;">
                            <option value="" selected class="bg-gray-800 text-white">All Priorities</option>
                            <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                            <option value="critical" {{ request('priority') == 'critical' ? 'selected' : '' }}>Critical</option>
                        </select>
                    </div>

                    <!-- Type Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2 " style="font-family: 'Poppins', sans-serif;">Type</label>
                        <select name="type" class="w-full bg-gray-800 border border-green-500/30 rounded-lg px-3 py-2 text-white focus:ring-2 focus:ring-green-400 focus:border-transparent " style="font-family: 'Poppins', sans-serif;">
                            <option value="" selected class="bg-gray-800 text-white">All Types</option>
                            <option value="incident" {{ request('type') == 'incident' ? 'selected' : '' }}>Incident</option>
                            <option value="observation" {{ request('type') == 'observation' ? 'selected' : '' }}>Observation</option>
                            <option value="maintenance" {{ request('type') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                            <option value="emergency" {{ request('type') == 'emergency' ? 'selected' : '' }}>Emergency</option>
                        </select>
                    </div>

                    <!-- Date From -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2 " style="font-family: 'Poppins', sans-serif;">From Date</label>
                        <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full bg-gray-800 border border-green-500/30 rounded-lg px-3 py-2 text-white focus:ring-2 focus:ring-green-400 focus:border-transparent " style="font-family: 'Poppins', sans-serif;">
                    </div>

                    <!-- Filter Actions -->
                    <div class="flex items-end gap-2">
                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition-colors " style="font-family: 'Poppins', sans-serif;">
                            <i class="fas fa-filter mr-2"></i>Filter
                        </button>
                        <a href="{{ route('patroller.reports.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors " style="font-family: 'Poppins', sans-serif;">
                            <i class="fas fa-times mr-2"></i>Clear
                        </a>
                    </div>
                </form>
            </div>

            <!-- Reports List -->
            <div class="glass-dark rounded-xl border border-green-500/20 overflow-hidden">
                @if($reports->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gradient-to-r from-green-600/50 to-green-700/50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider " style="font-family: 'Poppins', sans-serif;">Report</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider " style="font-family: 'Poppins', sans-serif;">Type</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider " style="font-family: 'Poppins', sans-serif;">Priority</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider " style="font-family: 'Poppins', sans-serif;">Status</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider " style="font-family: 'Poppins', sans-serif;">Date</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-300 uppercase tracking-wider " style="font-family: 'Poppins', sans-serif;">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-green-500/20">
                                @foreach($reports as $report)
                                    <tr class="hover:bg-white/5 transition-colors">
                                        <td class="px-6 py-4">
                                            <div>
                                                <div class="text-sm font-medium text-white " style="font-family: 'Poppins', sans-serif;">{{ $report->title }}</div>
                                                <div class="text-sm text-gray-400 " style="font-family: 'Poppins', sans-serif;">{{ Str::limit($report->description, 50) }}</div>
                                                <div class="text-xs text-gray-500 " style="font-family: 'Poppins', sans-serif;">{{ $report->location }}</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                @if($report->report_type == 'emergency') bg-red-500/20 text-red-300
                                                @elseif($report->report_type == 'incident') bg-orange-500/20 text-orange-300
                                                @elseif($report->report_type == 'maintenance') bg-blue-500/20 text-blue-300
                                                @else bg-green-500/20 text-green-300 @endif" style="font-family: 'Poppins', sans-serif;">
                                                {{ ucfirst($report->report_type) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                @if($report->priority == 'critical') bg-red-500/20 text-red-300
                                                @elseif($report->priority == 'high') bg-orange-500/20 text-orange-300
                                                @elseif($report->priority == 'medium') bg-yellow-500/20 text-yellow-300
                                                @else bg-green-500/20 text-green-300 @endif" style="font-family: 'Poppins', sans-serif;">
                                                {{ ucfirst($report->priority) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                @if($report->status == 'submitted') bg-blue-500/20 text-blue-300
                                                @elseif($report->status == 'under_review') bg-yellow-500/20 text-yellow-300
                                                @elseif($report->status == 'resolved' || $report->status == 'accepted') bg-green-500/20 text-green-300
                                                @elseif($report->status == 'rejected') bg-red-500/20 text-red-300
                                                @elseif($report->status == 'needs_correction') bg-orange-500/20 text-orange-300
                                                @else bg-gray-500/20 text-gray-300 @endif" style="font-family: 'Poppins', sans-serif;">
                                                {{ ucfirst(str_replace('_', ' ', $report->status)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-300 " style="font-family: 'Poppins', sans-serif;">
                                            {{ $report->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium">
                                            <div class="flex items-center space-x-2">
                                                <a href="{{ route('patroller.reports.show', $report) }}" class="text-green-400 hover:text-green-300 transition-colors">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if(in_array($report->status, ['submitted', 'rejected', 'needs_correction']))
                                                    <a href="{{ route('patroller.reports.edit', $report) }}" class="text-yellow-400 hover:text-yellow-300 transition-colors" title="Edit Report">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form method="POST" action="{{ route('patroller.reports.destroy', $report) }}" class="inline" onsubmit="return showDeleteConfirmation(this)">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-400 hover:text-red-300 transition-colors" title="Delete Report">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-green-500/20">
                        {{ $reports->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-file-alt text-6xl text-gray-500 mb-4"></i>
                        <h3 class="text-xl font-medium text-white mb-2 " style="font-family: 'Poppins', sans-serif;">No Reports Found</h3>
                        <p class="text-gray-400 mb-6 " style="font-family: 'Poppins', sans-serif;">You haven't submitted any reports yet.</p>
                        <a href="{{ route('patroller.reports.create') }}" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-6 py-3 rounded-lg font-medium transition-all duration-300 transform hover:scale-105 shadow-lg " style="font-family: 'Poppins', sans-serif;">
                            <i class="fas fa-plus mr-2"></i>Create Your First Report
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Custom Confirmation Modal -->
<div id="confirmModal" class="fixed inset-0 z-[9999] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeConfirmModal()"></div>

        <!-- Center modal -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-green-500/30">
            <div class="px-6 pt-6 pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-14 w-14 rounded-full bg-red-500/20 sm:mx-0 sm:h-12 sm:w-12">
                        <svg class="h-7 w-7 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left flex-1">
                        <h3 class="text-xl font-bold text-white mb-2" id="modal-title" style="font-family: 'Poppins', sans-serif;">
                            Delete Report
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-300" id="modalMessage" style="font-family: 'Poppins', sans-serif;">
                                Are you sure you want to delete this report? This action cannot be undone.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-800/50 px-6 py-4 sm:flex sm:flex-row-reverse gap-3">
                <button type="button" id="confirmDeleteButton" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-base font-medium text-white hover:from-red-700 hover:to-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-200 transform hover:scale-105" style="font-family: 'Poppins', sans-serif;">
                    Delete
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
let deleteFormToSubmit = null;

function showDeleteConfirmation(form) {
    deleteFormToSubmit = form;
    const modal = document.getElementById('confirmModal');
    modal.classList.remove('hidden');
    return false; // Prevent form submission
}

function closeConfirmModal() {
    const modal = document.getElementById('confirmModal');
    modal.classList.add('hidden');
    deleteFormToSubmit = null;
}

document.getElementById('confirmDeleteButton').addEventListener('click', function() {
    if (deleteFormToSubmit) {
        deleteFormToSubmit.submit();
    }
    closeConfirmModal();
});

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeConfirmModal();
    }
});
</script>

@section('styles')
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
@endsection

@endsection

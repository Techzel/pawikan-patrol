@extends('layouts.patroller')

@section('title', 'View Report')
@section('container-class', 'max-w-4xl')

@section('content')
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-white mb-2 " style="font-family: 'Poppins', sans-serif;">
                            <i class="fas fa-file-alt mr-3 text-green-400"></i>Report Details
                        </h1>
                        <p class="text-gray-300 " style="font-family: 'Poppins', sans-serif;">Report #{{ $report->id }} - {{ $report->title }}</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        @if(in_array($report->status, ['submitted', 'rejected', 'needs_correction']))
                            <a href="{{ route('patroller.reports.edit', $report) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg font-medium transition-colors " style="font-family: 'Poppins', sans-serif;">
                                <i class="fas fa-edit mr-2"></i>Edit
                            </a>
                        @endif
                        <a href="{{ route('patroller.reports.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors " style="font-family: 'Poppins', sans-serif;">
                            <i class="fas fa-arrow-left mr-2"></i>Back to Reports
                        </a>
                    </div>
                </div>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mb-6 glass-dark border-l-4 border-green-500 p-4 rounded">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-green-100 " style="font-family: 'Poppins', sans-serif;">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 glass-dark border-l-4 border-red-500 p-4 rounded">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-red-100 " style="font-family: 'Poppins', sans-serif;">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Report Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Basic Information -->
                    <div class="glass-dark rounded-xl p-6 border border-green-500/20">
                        <h3 class="text-lg font-semibold text-white mb-4 " style="font-family: 'Poppins', sans-serif;">
                            <i class="fas fa-info-circle mr-2 text-green-400"></i>Basic Information
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1 " style="font-family: 'Poppins', sans-serif;">Report Type</label>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                    @if($report->report_type == 'emergency') bg-red-500/20 text-red-300
                                    @elseif($report->report_type == 'incident') bg-orange-500/20 text-orange-300
                                    @elseif($report->report_type == 'maintenance') bg-blue-500/20 text-blue-300
                                    @else bg-green-500/20 text-green-300 @endif" style="font-family: 'Poppins', sans-serif;">
                                    {{ ucfirst($report->report_type) }}
                                </span>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1 " style="font-family: 'Poppins', sans-serif;">Priority</label>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                    @if($report->priority == 'critical') bg-red-500/20 text-red-300
                                    @elseif($report->priority == 'high') bg-orange-500/20 text-orange-300
                                    @elseif($report->priority == 'medium') bg-yellow-500/20 text-yellow-300
                                    @else bg-green-500/20 text-green-300 @endif" style="font-family: 'Poppins', sans-serif;">
                                    {{ ucfirst($report->priority) }}
                                </span>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1 " style="font-family: 'Poppins', sans-serif;">Status</label>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                    @if($report->status == 'submitted') bg-blue-500/20 text-blue-300
                                    @elseif($report->status == 'under_review') bg-yellow-500/20 text-yellow-300
                                    @elseif($report->status == 'resolved' || $report->status == 'accepted') bg-green-500/20 text-green-300
                                    @elseif($report->status == 'rejected') bg-red-500/20 text-red-300
                                    @elseif($report->status == 'needs_correction') bg-orange-500/20 text-orange-300
                                    @else bg-gray-500/20 text-gray-300 @endif" style="font-family: 'Poppins', sans-serif;">
                                    {{ ucfirst(str_replace('_', ' ', $report->status)) }}
                                </span>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1 " style="font-family: 'Poppins', sans-serif;">Submitted</label>
                                <p class="text-white " style="font-family: 'Poppins', sans-serif;">{{ $report->created_at->format('M d, Y g:i A') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="glass-dark rounded-xl p-6 border border-green-500/20">
                        <h3 class="text-lg font-semibold text-white mb-4 " style="font-family: 'Poppins', sans-serif;">
                            <i class="fas fa-align-left mr-2 text-green-400"></i>Description
                        </h3>
                        <p class="text-gray-300 leading-relaxed " style="font-family: 'Poppins', sans-serif;">{{ $report->description }}</p>
                    </div>

                    <!-- Location Information -->
                    <div class="glass-dark rounded-xl p-6 border border-green-500/20">
                        <h3 class="text-lg font-semibold text-white mb-4 " style="font-family: 'Poppins', sans-serif;">
                            <i class="fas fa-map-marker-alt mr-2 text-green-400"></i>Location Information
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1 " style="font-family: 'Poppins', sans-serif;">Location</label>
                                <p class="text-white " style="font-family: 'Poppins', sans-serif;">{{ $report->location }}</p>
                            </div>
                            @if($report->latitude && $report->longitude)
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-1 " style="font-family: 'Poppins', sans-serif;">Coordinates</label>
                                    <p class="text-white " style="font-family: 'Poppins', sans-serif;">{{ number_format($report->latitude, 6) }}, {{ number_format($report->longitude, 6) }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Turtle Information -->
                    @if($report->turtle_count || $report->turtle_species || $report->turtle_condition || $report->gender || $report->egg_count)
                        <div class="glass-dark rounded-xl p-6 border border-green-500/20">
                            <h3 class="text-lg font-semibold text-white mb-4 " style="font-family: 'Poppins', sans-serif;">
                                <i class="fas fa-turtle mr-2 text-green-400"></i>Turtle Information
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                @if($report->turtle_count)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-1 " style="font-family: 'Poppins', sans-serif;">Count</label>
                                        <p class="text-white " style="font-family: 'Poppins', sans-serif;">{{ $report->turtle_count }}</p>
                                    </div>
                                @endif
                                @if($report->turtle_species)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-1 " style="font-family: 'Poppins', sans-serif;">Species</label>
                                        <p class="text-white " style="font-family: 'Poppins', sans-serif;">{{ $report->turtle_species }}</p>
                                    </div>
                                @endif
                                @if($report->turtle_condition)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-1 " style="font-family: 'Poppins', sans-serif;">Condition</label>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                            @if($report->turtle_condition == 'healthy') bg-green-500/20 text-green-300
                                            @elseif($report->turtle_condition == 'injured') bg-yellow-500/20 text-yellow-300
                                            @elseif($report->turtle_condition == 'dead') bg-red-500/20 text-red-300
                                            @else bg-gray-500/20 text-gray-300 @endif" style="font-family: 'Poppins', sans-serif;">
                                            {{ ucfirst($report->turtle_condition) }}
                                        </span>
                                    </div>
                                @endif
                                @if($report->gender)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-1 " style="font-family: 'Poppins', sans-serif;">Gender</label>
                                        <p class="text-white " style="font-family: 'Poppins', sans-serif;">{{ ucfirst($report->gender) }}</p>
                                    </div>
                                @endif
                                @if($report->egg_count !== null)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-1 " style="font-family: 'Poppins', sans-serif;">Egg Count</label>
                                        <p class="text-white " style="font-family: 'Poppins', sans-serif;">{{ number_format($report->egg_count) }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Additional Information -->
                    @if($report->weather_conditions || $report->immediate_actions || $report->recommendations)
                        <div class="glass-dark rounded-xl p-6 border border-green-500/20">
                            <h3 class="text-lg font-semibold text-white mb-4 " style="font-family: 'Poppins', sans-serif;">
                                <i class="fas fa-clipboard-list mr-2 text-green-400"></i>Additional Information
                            </h3>
                            @if($report->weather_conditions)
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-300 mb-1 " style="font-family: 'Poppins', sans-serif;">Weather Conditions</label>
                                    <p class="text-white " style="font-family: 'Poppins', sans-serif;">{{ $report->weather_conditions }}</p>
                                </div>
                            @endif
                            @if($report->immediate_actions)
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-300 mb-1 " style="font-family: 'Poppins', sans-serif;">Immediate Actions Taken</label>
                                    <p class="text-white " style="font-family: 'Poppins', sans-serif;">{{ $report->immediate_actions }}</p>
                                </div>
                            @endif
                            @if($report->recommendations)
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-1 " style="font-family: 'Poppins', sans-serif;">Recommendations</label>
                                    <p class="text-white " style="font-family: 'Poppins', sans-serif;">{{ $report->recommendations }}</p>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Images -->
                    @if($report->images && count($report->images) > 0)
                        <div class="glass-dark rounded-xl p-6 border border-green-500/20">
                            <h3 class="text-lg font-semibold text-white mb-4 " style="font-family: 'Poppins', sans-serif;">
                                <i class="fas fa-images mr-2 text-green-400"></i>Images
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($report->images as $image)
                                    <div class="relative group">
                                        <img src="{{ asset('storage/' . $image) }}" alt="Report Image" class="w-full h-48 object-cover rounded-lg">
                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-300 rounded-lg flex items-center justify-center">
                                            <a href="{{ asset('storage/' . $image) }}" target="_blank" class="text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                                <i class="fas fa-expand text-2xl"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Report Status -->
                    <div class="glass-dark rounded-xl p-6 border border-green-500/20">
                        <h3 class="text-lg font-semibold text-white mb-4 " style="font-family: 'Poppins', sans-serif;">
                            <i class="fas fa-chart-line mr-2 text-green-400"></i>Report Status
                        </h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-300 " style="font-family: 'Poppins', sans-serif;">Current Status</span>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                    @if($report->status == 'submitted') bg-blue-500/20 text-blue-300
                                    @elseif($report->status == 'under_review') bg-yellow-500/20 text-yellow-300
                                    @elseif($report->status == 'resolved' || $report->status == 'accepted') bg-green-500/20 text-green-300
                                    @elseif($report->status == 'rejected') bg-red-500/20 text-red-300
                                    @elseif($report->status == 'needs_correction') bg-orange-500/20 text-orange-300
                                    @else bg-gray-500/20 text-gray-300 @endif" style="font-family: 'Poppins', sans-serif;">
                                    {{ ucfirst(str_replace('_', ' ', $report->status)) }}
                                </span>
                            </div>
                            @if($report->reviewed_by)
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-300 " style="font-family: 'Poppins', sans-serif;">Reviewed By</span>
                                    <span class="text-white " style="font-family: 'Poppins', sans-serif;">{{ $report->reviewer->name }}</span>
                                </div>
                            @endif
                            @if($report->reviewed_at)
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-300 " style="font-family: 'Poppins', sans-serif;">Reviewed At</span>
                                    <span class="text-white " style="font-family: 'Poppins', sans-serif;">{{ $report->reviewed_at->format('M d, Y') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Admin Notes -->
                    @if($report->admin_notes)
                        <div class="glass-dark rounded-xl p-6 border border-green-500/20">
                            <h3 class="text-lg font-semibold text-white mb-4 " style="font-family: 'Poppins', sans-serif;">
                                <i class="fas fa-sticky-note mr-2 text-green-400"></i>Admin Notes
                            </h3>
                            <p class="text-gray-300 " style="font-family: 'Poppins', sans-serif;">{{ $report->admin_notes }}</p>
                        </div>
                    @endif

                    <!-- Actions -->
                    @if(in_array($report->status, ['submitted', 'rejected', 'needs_correction']))
                        <div class="glass-dark rounded-xl p-6 border border-green-500/20">
                            <h3 class="text-lg font-semibold text-white mb-4 " style="font-family: 'Poppins', sans-serif;">
                                <i class="fas fa-cogs mr-2 text-green-400"></i>Actions
                            </h3>
                            <div class="space-y-3">
                                <a href="{{ route('patroller.reports.edit', $report) }}" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg font-medium transition-colors text-center block " style="font-family: 'Poppins', sans-serif;">
                                    <i class="fas fa-edit mr-2"></i>Edit Report
                                </a>
                                <form method="POST" action="{{ route('patroller.reports.destroy', $report) }}" onsubmit="return showDeleteConfirmation(this)">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-medium transition-colors " style="font-family: 'Poppins', sans-serif;">
                                        <i class="fas fa-trash mr-2"></i>Delete Report
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom Confirmation Modal -->
<div id="confirmModal" class="fixed inset-0 z-[9999] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeConfirmModal()"></div>
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
                        <h3 class="text-xl font-bold text-white mb-2" style="font-family: 'Poppins', sans-serif;">
                            Delete Report
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-300" style="font-family: 'Poppins', sans-serif;">
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
    return false;
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

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeConfirmModal();
    }
});
</script>

@endsection

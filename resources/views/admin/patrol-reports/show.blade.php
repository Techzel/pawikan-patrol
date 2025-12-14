@extends('layouts.app')

@section('title', 'Patrol Report Details - DENR Admin')

@section('content')
<div id="patrolReportShow" class="min-h-screen bg-gray-900">
    <!-- Back Button -->
    <div class="pt-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('admin.patrol-reports.index') }}" class="inline-flex items-center gap-2 text-gray-300 hover:text-white transition-colors group">
            <i class="fas fa-arrow-left text-sm group-hover:-translate-x-1 transition-transform"></i>
            <span class="text-sm font-medium">Back to Manage Reports</span>
        </a>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-500/20 border border-green-500/30 rounded-lg p-4">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-check-circle text-green-400"></i>
                    <p class="text-green-300 cinzel-text">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-500/20 border border-red-500/30 rounded-lg p-4">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-exclamation-circle text-red-400"></i>
                    <p class="text-red-300 cinzel-text">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

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
                                <h2 class="text-2xl font-bold text-white cinzel-heading">{{ $patrolReport->title ?? 'Untitled Report' }}</h2>
                                <span class="px-2 py-1 text-xs rounded-full cinzel-text
                                    @if($patrolReport->priority == 'critical') bg-red-500/20 text-red-300
                                    @elseif($patrolReport->priority == 'high') bg-orange-500/20 text-orange-300
                                    @elseif($patrolReport->priority == 'medium') bg-yellow-500/20 text-yellow-300
                                    @elseif($patrolReport->priority == 'low') bg-green-500/20 text-green-300
                                    @else bg-gray-500/20 text-gray-300 @endif">
                                    {{ ucfirst($patrolReport->priority) }} Priority
                                </span>
                                <span class="px-2 py-1 text-xs rounded-full cinzel-text
                                    @if($patrolReport->report_type == 'emergency') bg-red-500/20 text-red-300
                                    @elseif($patrolReport->report_type == 'incident') bg-orange-500/20 text-orange-300
                                    @elseif($patrolReport->report_type == 'maintenance') bg-blue-500/20 text-blue-300
                                    @else bg-green-500/20 text-green-300 @endif">
                                    {{ ucfirst($patrolReport->report_type) }}
                                </span>
                            </div>
                            <p class="text-gray-300 cinzel-text">{{ $patrolReport->description ?? 'No description provided' }}</p>
                        </div>
                    </div>

                    <!-- Report Details -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
                        <div class="text-center">
                            <div class="text-sm text-gray-400 cinzel-text">Location</div>
                            <div class="text-white font-medium cinzel-text">{{ $patrolReport->location ?? 'No location specified' }}</div>
                        </div>
                        <div class="text-center">
                            <div class="text-sm text-gray-400 cinzel-text">Submitted</div>
                            <div class="text-white font-medium cinzel-text">{{ $patrolReport->created_at ? $patrolReport->created_at->format('M d, Y') : 'N/A' }}</div>
                            <div class="text-xs text-gray-500 cinzel-text">{{ $patrolReport->created_at ? $patrolReport->created_at->format('g:i A') : '' }}</div>
                        </div>
                        @if($patrolReport->latitude && $patrolReport->longitude)
                        <div class="text-center">
                            <div class="text-sm text-gray-400 cinzel-text">Coordinates</div>
                            <div class="text-white font-medium cinzel-text font-mono text-xs">
                                {{ $patrolReport->latitude }}, {{ $patrolReport->longitude }}
                            </div>
                        </div>
                        @endif
                        @if($patrolReport->reviewed_at)
                        <div class="text-center">
                            <div class="text-sm text-gray-400 cinzel-text">Last Updated</div>
                            <div class="text-white font-medium cinzel-text">{{ $patrolReport->reviewed_at->format('M d, Y') }}</div>
                            <div class="text-xs text-gray-500 cinzel-text">{{ $patrolReport->reviewed_at->diffForHumans() }}</div>
                        </div>
                        @endif
                    </div>
                </div>

                @if($patrolReport->turtle_count || $patrolReport->turtle_species || $patrolReport->turtle_condition || $patrolReport->gender || $patrolReport->egg_count)
                <div class="glass-dark rounded-xl p-6 border border-ocean-500/20">
                    <h3 class="text-lg font-bold text-white mb-4 cinzel-heading">
                        <i class="fas fa-turtle mr-2 text-ocean-400"></i>Turtle Information
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-sm text-gray-300">
                        @if($patrolReport->turtle_species)
                            <div>
                                <div class="text-gray-400 text-xs uppercase tracking-wide">Species</div>
                                <div class="text-white font-medium cinzel-text">{{ $patrolReport->turtle_species }}</div>
                            </div>
                        @endif
                        @if($patrolReport->turtle_count)
                            <div>
                                <div class="text-gray-400 text-xs uppercase tracking-wide">Count</div>
                                <div class="text-white font-medium cinzel-text">{{ $patrolReport->turtle_count }}</div>
                            </div>
                        @endif
                        @if($patrolReport->turtle_condition)
                            <div>
                                <div class="text-gray-400 text-xs uppercase tracking-wide">Condition</div>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold cinzel-text
                                    @if($patrolReport->turtle_condition === 'healthy') bg-green-500/20 text-green-300
                                    @elseif($patrolReport->turtle_condition === 'injured') bg-yellow-500/20 text-yellow-300
                                    @elseif($patrolReport->turtle_condition === 'dead') bg-red-500/20 text-red-300
                                    @else bg-gray-500/20 text-gray-300 @endif">
                                    {{ ucfirst($patrolReport->turtle_condition) }}
                                </span>
                            </div>
                        @endif
                        @if($patrolReport->gender)
                            <div>
                                <div class="text-gray-400 text-xs uppercase tracking-wide">Gender</div>
                                <div class="text-white font-medium cinzel-text">{{ ucfirst($patrolReport->gender) }}</div>
                            </div>
                        @endif
                        @if($patrolReport->egg_count !== null)
                            <div>
                                <div class="text-gray-400 text-xs uppercase tracking-wide">Egg Count</div>
                                <div class="text-white font-medium cinzel-text">{{ number_format($patrolReport->egg_count) }}</div>
                            </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Report Content -->
                @if($patrolReport->content)
                <div class="glass-dark rounded-xl p-6 border border-ocean-500/20">
                    <h3 class="text-lg font-bold text-white mb-4 cinzel-heading">
                        <i class="fas fa-file-alt mr-2 text-ocean-400"></i>Report Details
                    </h3>
                    <div class="text-gray-300 cinzel-text whitespace-pre-line">
                        {{ $patrolReport->content }}
                    </div>
                </div>
                @endif

                <!-- Images -->
                @if($patrolReport->images && count($patrolReport->images) > 0)
                <div class="glass-dark rounded-xl p-6 border border-ocean-500/20">
                    <h3 class="text-lg font-bold text-white mb-4 cinzel-heading">
                        <i class="fas fa-images mr-2 text-ocean-400"></i>Attached Images
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($patrolReport->images as $image)
                            <div class="bg-gray-700 rounded-lg overflow-hidden">
                                <img src="{{ asset('storage/' . $image) }}" alt="Report image" class="w-full h-48 object-cover hover:scale-105 transition-transform cursor-pointer" onclick="openImageModal('{{ asset('storage/' . $image) }}')">
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Admin Notes -->
                @if($patrolReport->admin_notes)
                <div class="glass-dark rounded-xl p-6 border border-ocean-500/20">
                    <h3 class="text-lg font-bold text-white mb-4 cinzel-heading">
                        <i class="fas fa-sticky-note mr-2 text-yellow-400"></i>Admin Notes
                    </h3>
                    <div class="bg-gray-800/50 rounded-lg p-4">
                        <p class="text-gray-300 cinzel-text">{{ $patrolReport->admin_notes }}</p>
                    </div>
                </div>
                @endif
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
                            <div class="text-white font-medium cinzel-text">{{ $patrolReport->patroller ? $patrolReport->patroller->name : 'Unknown Patroller' }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-400 cinzel-text">Patroller ID</div>
                            <div class="text-white font-medium cinzel-text">{{ $patrolReport->patroller ? ($patrolReport->patroller->patroller_id ?? 'N/A') : 'N/A' }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-400 cinzel-text">Email</div>
                            <div class="text-white font-medium cinzel-text">{{ $patrolReport->patroller ? $patrolReport->patroller->email : 'N/A' }}</div>
                        </div>
                        @if($patrolReport->patroller && $patrolReport->patroller->phone)
                        <div>
                            <div class="text-sm text-gray-400 cinzel-text">Phone</div>
                            <div class="text-white font-medium cinzel-text">{{ $patrolReport->patroller->phone }}</div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Review History -->
                @if($patrolReport->reviewed_at)
                <div class="glass-dark rounded-xl p-6 border border-ocean-500/20 mt-12">
                    <h3 class="text-lg font-bold text-white mb-4 cinzel-heading">
                        <i class="fas fa-history mr-2 text-purple-400"></i>Review History
                    </h3>
                            <div class="space-y-3">
                                <div>
                                    <div class="text-sm text-gray-400 cinzel-text">Last Reviewed By</div>
                                    <div class="text-white font-medium cinzel-text">{{ $patrolReport->reviewer ? $patrolReport->reviewer->name : 'N/A' }}</div>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-400 cinzel-text">Review Date</div>
                                    <div class="text-white font-medium cinzel-text">{{ $patrolReport->reviewed_at ? $patrolReport->reviewed_at->format('M d, Y \a\t g:i A') : 'N/A' }}</div>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-400 cinzel-text">Time Since Review</div>
                                    <div class="text-gray-300 cinzel-text">{{ $patrolReport->reviewed_at ? $patrolReport->reviewed_at->diffForHumans() : 'Never reviewed' }}</div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                    <div class="space-y-3">
                        @if($patrolReport->status == 'pending_review' || $patrolReport->status == 'reviewing')
                            <div class="grid grid-cols-1 gap-3">
                                <button onclick="validateReport('accepted', 'validate')" class="w-full bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-lg font-medium transition-colors cinzel-text text-sm shadow-lg hover:shadow-xl transform hover:scale-105">
                                    <i class="fas fa-check-circle mr-2 text-lg"></i>✓ Validate & Accept Report
                                </button>

                                <button onclick="validateReport('reject', 'validate')" class="w-full bg-red-600 hover:bg-red-700 text-white py-3 px-4 rounded-lg font-medium transition-colors cinzel-text text-sm shadow-lg hover:shadow-xl transform hover:scale-105">
                                    <i class="fas fa-times-circle mr-2 text-lg"></i>✗ Validate & Reject Report
                                </button>

                                <button onclick="validateReport('reviewing', 'validate')" class="w-full bg-yellow-600 hover:bg-yellow-700 text-white py-3 px-4 rounded-lg font-medium transition-colors cinzel-text text-sm shadow-lg hover:shadow-xl transform hover:scale-105">
                                    <i class="fas fa-search mr-2 text-lg"></i>🔍 Mark as Under Review
                                </button>
                            </div>

                            <div class="mt-4 p-4 bg-blue-500/10 border border-blue-500/30 rounded-lg">
                                <div class="flex items-start space-x-3">
                                    <i class="fas fa-info-circle text-blue-400 mt-1"></i>
                                    <div>
                                        <h4 class="text-blue-300 font-medium cinzel-text">Validation Guidelines</h4>
                                        <ul class="text-blue-200 text-sm cinzel-text mt-2 space-y-1">
                                            <li>• Check report completeness and accuracy</li>
                                            <li>• Verify location and coordinates</li>
                                            <li>• Review attached images and evidence</li>
                                            <li>• Ensure report follows submission guidelines</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @elseif($patrolReport->status == 'accepted')
                            <div class="p-4 bg-green-500/10 border border-green-500/30 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-check-circle text-green-400"></i>
                                    <div>
                                        <h4 class="text-green-300 font-medium cinzel-text">Report Validated</h4>
                                        <p class="text-green-200 text-sm cinzel-text">This report has been successfully validated and accepted.</p>
                                    </div>
                                </div>
                            </div>
                        @elseif($patrolReport->status == 'reject')
                            <div class="p-4 bg-red-500/10 border border-red-500/30 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-times-circle text-red-400"></i>
                                    <div>
                                        <h4 class="text-red-300 font-medium cinzel-text">Report Rejected</h4>
                                        <p class="text-red-200 text-sm cinzel-text">This report has been reviewed and rejected during validation.</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>


            </div>
        </div>
    </main>
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
// Quick status update function
function quickStatusUpdate(status) {
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

    // Update form and submit
    document.getElementById('status').value = status;
    document.getElementById('statusForm').submit();
}

// Validation report function
function validateReport(status, action) {
    const validationMessages = {
        'accepted': {
            title: 'Validate & Accept Report',
            message: 'Are you sure you want to validate and accept this report? This will mark it as officially approved.',
            confirmText: 'Yes, Validate & Accept'
        },
        'reject': {
            title: 'Validate & Reject Report',
            message: 'Are you sure you want to validate and reject this report? Please ensure you have provided proper reasoning.',
            confirmText: 'Yes, Validate & Reject'
        },
        'reviewing': {
            title: 'Mark as Under Review',
            message: 'Are you sure you want to mark this report as under review for further validation?',
            confirmText: 'Yes, Mark as Under Review'
        }
    };

    const config = validationMessages[status];

    // Create custom confirmation dialog
    const confirmed = confirm(`${config.title}\n\n${config.message}\n\nClick OK to proceed with validation.`);
    
    if (!confirmed) {
        return;
    }

    // Update form and submit
    document.getElementById('status').value = status;
    document.getElementById('statusForm').submit();
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
document.getElementById('imageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeImageModal();
    }
});
</script>
@endsection

@extends('layouts.patroller')

@section('title', 'View Report')
@section('container-class', 'max-w-4xl')

@section('content')
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-white mb-2 cinzel-heading">
                            <i class="fas fa-file-alt mr-3 text-ocean-400"></i>Report Details
                        </h1>
                        <p class="text-gray-300 cinzel-text">Report #{{ $report->id }} - {{ $report->title }}</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        @if(in_array($report->status, ['submitted', 'rejected', 'needs_correction']))
                            <a href="{{ route('patroller.reports.edit', $report) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg font-medium transition-colors cinzel-text">
                                <i class="fas fa-edit mr-2"></i>Edit
                            </a>
                        @endif
                        <a href="{{ route('patroller.reports.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors cinzel-text">
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
                            <p class="text-green-100 cinzel-text">{{ session('success') }}</p>
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
                            <p class="text-red-100 cinzel-text">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Report Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Basic Information -->
                    <div class="glass-dark rounded-xl p-6 border border-ocean-500/20">
                        <h3 class="text-lg font-semibold text-white mb-4 cinzel-subheading">
                            <i class="fas fa-info-circle mr-2 text-ocean-400"></i>Basic Information
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1 cinzel-text">Report Type</label>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium cinzel-text
                                    @if($report->report_type == 'emergency') bg-red-500/20 text-red-300
                                    @elseif($report->report_type == 'incident') bg-orange-500/20 text-orange-300
                                    @elseif($report->report_type == 'maintenance') bg-blue-500/20 text-blue-300
                                    @else bg-green-500/20 text-green-300 @endif">
                                    {{ ucfirst($report->report_type) }}
                                </span>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1 cinzel-text">Priority</label>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium cinzel-text
                                    @if($report->priority == 'critical') bg-red-500/20 text-red-300
                                    @elseif($report->priority == 'high') bg-orange-500/20 text-orange-300
                                    @elseif($report->priority == 'medium') bg-yellow-500/20 text-yellow-300
                                    @else bg-green-500/20 text-green-300 @endif">
                                    {{ ucfirst($report->priority) }}
                                </span>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1 cinzel-text">Status</label>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium cinzel-text
                                    @if($report->status == 'submitted') bg-blue-500/20 text-blue-300
                                    @elseif($report->status == 'under_review') bg-yellow-500/20 text-yellow-300
                                    @elseif($report->status == 'resolved' || $report->status == 'accepted') bg-green-500/20 text-green-300
                                    @elseif($report->status == 'rejected') bg-red-500/20 text-red-300
                                    @elseif($report->status == 'needs_correction') bg-orange-500/20 text-orange-300
                                    @else bg-gray-500/20 text-gray-300 @endif">
                                    {{ ucfirst(str_replace('_', ' ', $report->status)) }}
                                </span>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1 cinzel-text">Submitted</label>
                                <p class="text-white cinzel-text">{{ $report->created_at->format('M d, Y g:i A') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="glass-dark rounded-xl p-6 border border-ocean-500/20">
                        <h3 class="text-lg font-semibold text-white mb-4 cinzel-subheading">
                            <i class="fas fa-align-left mr-2 text-ocean-400"></i>Description
                        </h3>
                        <p class="text-gray-300 leading-relaxed cinzel-text">{{ $report->description }}</p>
                    </div>

                    <!-- Location Information -->
                    <div class="glass-dark rounded-xl p-6 border border-ocean-500/20">
                        <h3 class="text-lg font-semibold text-white mb-4 cinzel-subheading">
                            <i class="fas fa-map-marker-alt mr-2 text-ocean-400"></i>Location Information
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1 cinzel-text">Location</label>
                                <p class="text-white cinzel-text">{{ $report->location }}</p>
                            </div>
                            @if($report->latitude && $report->longitude)
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-1 cinzel-text">Coordinates</label>
                                    <p class="text-white cinzel-text">{{ number_format($report->latitude, 6) }}, {{ number_format($report->longitude, 6) }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Turtle Information -->
                    @if($report->turtle_count || $report->turtle_species || $report->turtle_condition || $report->gender || $report->egg_count)
                        <div class="glass-dark rounded-xl p-6 border border-ocean-500/20">
                            <h3 class="text-lg font-semibold text-white mb-4 cinzel-subheading">
                                <i class="fas fa-turtle mr-2 text-ocean-400"></i>Turtle Information
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                @if($report->turtle_count)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-1 cinzel-text">Count</label>
                                        <p class="text-white cinzel-text">{{ $report->turtle_count }}</p>
                                    </div>
                                @endif
                                @if($report->turtle_species)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-1 cinzel-text">Species</label>
                                        <p class="text-white cinzel-text">{{ $report->turtle_species }}</p>
                                    </div>
                                @endif
                                @if($report->turtle_condition)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-1 cinzel-text">Condition</label>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium cinzel-text
                                            @if($report->turtle_condition == 'healthy') bg-green-500/20 text-green-300
                                            @elseif($report->turtle_condition == 'injured') bg-yellow-500/20 text-yellow-300
                                            @elseif($report->turtle_condition == 'dead') bg-red-500/20 text-red-300
                                            @else bg-gray-500/20 text-gray-300 @endif">
                                            {{ ucfirst($report->turtle_condition) }}
                                        </span>
                                    </div>
                                @endif
                                @if($report->gender)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-1 cinzel-text">Gender</label>
                                        <p class="text-white cinzel-text">{{ ucfirst($report->gender) }}</p>
                                    </div>
                                @endif
                                @if($report->egg_count !== null)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-1 cinzel-text">Egg Count</label>
                                        <p class="text-white cinzel-text">{{ number_format($report->egg_count) }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Additional Information -->
                    @if($report->weather_conditions || $report->immediate_actions || $report->recommendations)
                        <div class="glass-dark rounded-xl p-6 border border-ocean-500/20">
                            <h3 class="text-lg font-semibold text-white mb-4 cinzel-subheading">
                                <i class="fas fa-clipboard-list mr-2 text-ocean-400"></i>Additional Information
                            </h3>
                            @if($report->weather_conditions)
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-300 mb-1 cinzel-text">Weather Conditions</label>
                                    <p class="text-white cinzel-text">{{ $report->weather_conditions }}</p>
                                </div>
                            @endif
                            @if($report->immediate_actions)
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-300 mb-1 cinzel-text">Immediate Actions Taken</label>
                                    <p class="text-white cinzel-text">{{ $report->immediate_actions }}</p>
                                </div>
                            @endif
                            @if($report->recommendations)
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-1 cinzel-text">Recommendations</label>
                                    <p class="text-white cinzel-text">{{ $report->recommendations }}</p>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Images -->
                    @if($report->images && count($report->images) > 0)
                        <div class="glass-dark rounded-xl p-6 border border-ocean-500/20">
                            <h3 class="text-lg font-semibold text-white mb-4 cinzel-subheading">
                                <i class="fas fa-images mr-2 text-ocean-400"></i>Images
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
                    <div class="glass-dark rounded-xl p-6 border border-ocean-500/20">
                        <h3 class="text-lg font-semibold text-white mb-4 cinzel-subheading">
                            <i class="fas fa-chart-line mr-2 text-ocean-400"></i>Report Status
                        </h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-300 cinzel-text">Current Status</span>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium cinzel-text
                                    @if($report->status == 'submitted') bg-blue-500/20 text-blue-300
                                    @elseif($report->status == 'under_review') bg-yellow-500/20 text-yellow-300
                                    @elseif($report->status == 'resolved' || $report->status == 'accepted') bg-green-500/20 text-green-300
                                    @elseif($report->status == 'rejected') bg-red-500/20 text-red-300
                                    @elseif($report->status == 'needs_correction') bg-orange-500/20 text-orange-300
                                    @else bg-gray-500/20 text-gray-300 @endif">
                                    {{ ucfirst(str_replace('_', ' ', $report->status)) }}
                                </span>
                            </div>
                            @if($report->reviewed_by)
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-300 cinzel-text">Reviewed By</span>
                                    <span class="text-white cinzel-text">{{ $report->reviewer->name }}</span>
                                </div>
                            @endif
                            @if($report->reviewed_at)
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-300 cinzel-text">Reviewed At</span>
                                    <span class="text-white cinzel-text">{{ $report->reviewed_at->format('M d, Y') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Admin Notes -->
                    @if($report->admin_notes)
                        <div class="glass-dark rounded-xl p-6 border border-ocean-500/20">
                            <h3 class="text-lg font-semibold text-white mb-4 cinzel-subheading">
                                <i class="fas fa-sticky-note mr-2 text-ocean-400"></i>Admin Notes
                            </h3>
                            <p class="text-gray-300 cinzel-text">{{ $report->admin_notes }}</p>
                        </div>
                    @endif

                    <!-- Actions -->
                    @if(in_array($report->status, ['submitted', 'rejected', 'needs_correction']))
                        <div class="glass-dark rounded-xl p-6 border border-ocean-500/20">
                            <h3 class="text-lg font-semibold text-white mb-4 cinzel-subheading">
                                <i class="fas fa-cogs mr-2 text-ocean-400"></i>Actions
                            </h3>
                            <div class="space-y-3">
                                <a href="{{ route('patroller.reports.edit', $report) }}" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg font-medium transition-colors text-center block cinzel-text">
                                    <i class="fas fa-edit mr-2"></i>Edit Report
                                </a>
                                <form method="POST" action="{{ route('patroller.reports.destroy', $report) }}" onsubmit="return confirm('Are you sure you want to delete this report? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-medium transition-colors cinzel-text">
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
@endsection

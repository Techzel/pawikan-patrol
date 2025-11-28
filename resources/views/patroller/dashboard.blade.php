@extends('layouts.patroller')

@section('title', 'Dashboard')

@push('styles')
<style>
    .stat-card {
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    }
</style>
@endpush

@section('content')
            <!-- Enhanced Header -->
            <div class="mb-8">
                <div class="glass-dark rounded-2xl p-8 border border-ocean-500/20 bg-gradient-to-r from-ocean-600/20 to-ocean-800/20">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-4xl font-bold text-white mb-3 cinzel-heading">
                                <i class="fas fa-shield-alt mr-4 text-ocean-400"></i>Patrol Dashboard
                            </h1>
                            <p class="text-xl text-gray-300 cinzel-text">Welcome back, <span class="text-ocean-300 font-semibold">{{ $patroller->name }}</span>!</p>
                            <p class="text-gray-400 mt-2 cinzel-text">{{ now()->format('l, F j, Y') }} • {{ now()->format('g:i A') }}</p>
                        </div>
                        <div class="hidden md:block">
                            <div class="w-24 h-24 bg-gradient-to-br from-ocean-400 to-ocean-600 rounded-full flex items-center justify-center shadow-lg">
                                <i class="fas fa-user-shield text-3xl text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mb-6 glass-morphism border-l-4 border-green-500 p-4 rounded">
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
                <div class="mb-6 glass-morphism border-l-4 border-red-500 p-4 rounded">
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

            <!-- Enhanced Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Reports -->
                <div class="stat-card glass-dark rounded-2xl p-6 border border-ocean-500/20 bg-gradient-to-br from-blue-500/10 to-blue-600/10 hover:from-blue-500/20 hover:to-blue-600/20 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-file-alt text-2xl text-white"></i>
                        </div>
                        <div class="text-right">
                            <p class="text-3xl font-bold text-white cinzel-heading">{{ $totalReports }}</p>
                            <p class="text-blue-300 text-sm cinzel-text">Total Reports</p>
                        </div>
                    </div>
                    <div class="w-full bg-blue-500/20 rounded-full h-2">
                        <div class="bg-gradient-to-r from-blue-400 to-blue-600 h-2 rounded-full" style="width: 100%"></div>
                    </div>
                    <p class="text-xs text-gray-400 mt-2 cinzel-text">All time submissions</p>
                </div>

                <!-- Pending Reports -->
                <div class="stat-card glass-dark rounded-2xl p-6 border border-ocean-500/20 bg-gradient-to-br from-yellow-500/10 to-yellow-600/10 hover:from-yellow-500/20 hover:to-yellow-600/20 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-clock text-2xl text-white"></i>
                        </div>
                        <div class="text-right">
                            <p class="text-3xl font-bold text-white cinzel-heading">{{ $pendingReports }}</p>
                            <p class="text-yellow-300 text-sm cinzel-text">Pending Review</p>
                        </div>
                    </div>
                    <div class="w-full bg-yellow-500/20 rounded-full h-2">
                        <div class="bg-gradient-to-r from-yellow-400 to-yellow-600 h-2 rounded-full" style="width: {{ $totalReports > 0 ? ($pendingReports / $totalReports) * 100 : 0 }}%"></div>
                    </div>
                    <p class="text-xs text-gray-400 mt-2 cinzel-text">Awaiting admin review</p>
                </div>

                <!-- Resolved Reports -->
                <div class="stat-card glass-dark rounded-2xl p-6 border border-ocean-500/20 bg-gradient-to-br from-green-500/10 to-green-600/10 hover:from-green-500/20 hover:to-green-600/20 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-green-400 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-check-circle text-2xl text-white"></i>
                        </div>
                        <div class="text-right">
                            <p class="text-3xl font-bold text-white cinzel-heading">{{ $resolvedReports }}</p>
                            <p class="text-green-300 text-sm cinzel-text">Resolved</p>
                        </div>
                    </div>
                    <div class="w-full bg-green-500/20 rounded-full h-2">
                        <div class="bg-gradient-to-r from-green-400 to-green-600 h-2 rounded-full" style="width: {{ $totalReports > 0 ? ($resolvedReports / $totalReports) * 100 : 0 }}%"></div>
                    </div>
                    <p class="text-xs text-gray-400 mt-2 cinzel-text">Successfully completed</p>
                </div>

                <!-- Critical Reports -->
                <div class="stat-card glass-dark rounded-2xl p-6 border border-ocean-500/20 bg-gradient-to-br from-red-500/10 to-red-600/10 hover:from-red-500/20 hover:to-red-600/20 transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-red-400 to-red-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-exclamation-triangle text-2xl text-white"></i>
                        </div>
                        <div class="text-right">
                            <p class="text-3xl font-bold text-white cinzel-heading">{{ $criticalReports }}</p>
                            <p class="text-red-300 text-sm cinzel-text">Critical Priority</p>
                        </div>
                    </div>
                    <div class="w-full bg-red-500/20 rounded-full h-2">
                        <div class="bg-gradient-to-r from-red-400 to-red-600 h-2 rounded-full" style="width: {{ $totalReports > 0 ? ($criticalReports / $totalReports) * 100 : 0 }}%"></div>
                    </div>
                    <p class="text-xs text-gray-400 mt-2 cinzel-text">High priority issues</p>
                </div>
            </div>

            <!-- Enhanced Quick Actions & Recent Reports -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
                <!-- Quick Actions -->
                <div class="lg:col-span-1 space-y-4">
                    <div class="glass-dark rounded-2xl p-6 border border-ocean-500/20">
                        <h3 class="text-lg font-semibold text-white mb-6 cinzel-subheading">
                            <i class="fas fa-bolt mr-2 text-ocean-400"></i>Quick Actions
                        </h3>
                        <div class="space-y-4">
                            <a href="{{ route('patroller.reports.create') }}" class="group block w-full bg-gradient-to-r from-ocean-500 to-ocean-600 hover:from-ocean-600 hover:to-ocean-700 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl text-center cinzel-text">
                                <i class="fas fa-file-plus mr-3 text-lg group-hover:animate-pulse"></i>
                                <span>Submit New Report</span>
                            </a>
                            <a href="{{ route('patroller.reports.index') }}" class="group block w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl text-center cinzel-text">
                                <i class="fas fa-list mr-3 text-lg group-hover:animate-pulse"></i>
                                <span>View All Reports</span>
                            </a>
                            <a href="{{ route('patroller.profile') }}" class="group block w-full bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl text-center cinzel-text">
                                <i class="fas fa-user-shield mr-3 text-lg group-hover:animate-pulse"></i>
                                <span>My Profile</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Recent Reports -->
                <div class="lg:col-span-3">
                    <div class="glass-dark rounded-2xl p-6 border border-ocean-500/20 h-full">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-semibold text-white cinzel-subheading">
                                <i class="fas fa-clock mr-2 text-ocean-400"></i>Recent Activity
                            </h3>
                            <a href="{{ route('patroller.reports.index') }}" class="text-ocean-400 hover:text-ocean-300 text-sm cinzel-text transition-colors">
                                View All <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                        <div class="space-y-3 max-h-80 overflow-y-auto custom-scrollbar">
                            @forelse($recentReports as $report)
                                <div class="group flex items-center justify-between p-4 bg-white/5 hover:bg-white/10 rounded-xl transition-all duration-300 border border-transparent hover:border-ocean-500/30">
                                    <div class="flex items-center space-x-4 flex-1">
                                        <div class="w-12 h-12 rounded-xl flex items-center justify-center
                                            @if($report->report_type == 'emergency') bg-gradient-to-br from-red-400 to-red-600
                                            @elseif($report->report_type == 'incident') bg-gradient-to-br from-orange-400 to-orange-600
                                            @elseif($report->report_type == 'maintenance') bg-gradient-to-br from-blue-400 to-blue-600
                                            @else bg-gradient-to-br from-green-400 to-green-600 @endif shadow-lg">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-white font-semibold cinzel-text truncate group-hover:text-ocean-300 transition-colors">{{ $report->title }}</h4>
                                            <p class="text-gray-400 text-sm cinzel-text">{{ $report->location }}</p>
                                            <p class="text-gray-500 text-xs cinzel-text">{{ $report->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-3">
                                        <span class="px-3 py-1 text-xs font-medium rounded-full cinzel-text
                                            @if($report->priority === 'critical') bg-red-500/20 text-red-300 border border-red-500/30
                                            @elseif($report->priority === 'high') bg-orange-500/20 text-orange-300 border border-orange-500/30
                                            @elseif($report->priority === 'medium') bg-yellow-500/20 text-yellow-300 border border-yellow-500/30
                                            @else bg-green-500/20 text-green-300 border border-green-500/30 @endif">
                                            {{ ucfirst($report->priority) }}
                                        </span>
                                        <span class="px-3 py-1 text-xs font-medium rounded-full cinzel-text
                                            @if($report->status == 'submitted') bg-blue-500/20 text-blue-300 border border-blue-500/30
                                            @elseif($report->status == 'under_review') bg-yellow-500/20 text-yellow-300 border border-yellow-500/30
                                            @elseif($report->status == 'resolved') bg-green-500/20 text-green-300 border border-green-500/30
                                            @else bg-gray-500/20 text-gray-300 border border-gray-500/30 @endif">
                                            {{ ucfirst(str_replace('_', ' ', $report->status)) }}
                                        </span>
                                        <a href="{{ route('patroller.reports.show', $report) }}" class="w-8 h-8 bg-ocean-500/20 hover:bg-ocean-500/40 text-ocean-400 hover:text-ocean-300 rounded-lg flex items-center justify-center transition-all duration-300 transform hover:scale-110">
                                            <i class="fas fa-eye text-sm"></i>
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-12">
                                    <div class="w-20 h-20 bg-gradient-to-br from-ocean-400 to-ocean-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                                        <i class="fas fa-file-alt text-2xl text-white"></i>
                                    </div>
                                    <h4 class="text-xl font-semibold text-white mb-2 cinzel-heading">No Reports Yet</h4>
                                    <p class="text-gray-400 mb-6 cinzel-text">Start by submitting your first patrol report</p>
                                    <a href="{{ route('patroller.reports.create') }}" class="bg-gradient-to-r from-ocean-500 to-ocean-600 hover:from-ocean-600 hover:to-ocean-700 text-white px-6 py-3 rounded-lg font-medium transition-all duration-300 transform hover:scale-105 shadow-lg cinzel-text">
                                        <i class="fas fa-plus mr-2"></i>Create First Report
                                    </a>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
@endsection

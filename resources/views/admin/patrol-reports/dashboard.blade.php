@extends('layouts.app')

@section('title', 'Patrol Reports Dashboard')

@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* Base Styles */
    :root {
        --primary: #10b981;
        --primary-dark: #059669;
        --secondary: #3b82f6;
        --danger: #ef4444;
        --warning: #f59e0b;
        --success: #10b981;
        --info: #3b82f6;
        --dark: #0f172a;
        --light: #f8fafc;
        --glass-bg: rgba(255, 255, 255, 0.03);
        --glass-border: rgba(255, 255, 255, 0.08);
    }

    /* Restore Cinzel typography */
    #patrolReportsDashboard,
    #patrolReportsDashboard * {
        font-family: 'Cinzel', serif !important;
        letter-spacing: 0.02em;
    }

    .section-heading {
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .section-subheading {
        font-weight: 600;
        letter-spacing: 0.05em;
    }

    .stat-label {
        font-weight: 600;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        font-size: 0.75rem;
    }

    .body-text {
        font-weight: 400;
        letter-spacing: 0.01em;
    }

    .body-muted {
        font-weight: 400;
        letter-spacing: 0.01em;
        color: rgba(226, 232, 240, 0.85);
    }

    /* Glass Card */
    .glass-card {
        background: var(--glass-bg);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid var(--glass-border);
        border-radius: 1rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
        position: relative;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .glass-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        border-color: rgba(255, 255, 255, 0.2);
    }

    /* Stats Cards */
    .stat-card {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.75rem;
        font-size: 1.25rem;
        transition: all 0.3s ease;
    }

    .stat-card:hover .stat-icon {
        transform: scale(1.1) rotate(5deg);
    }

    /* Progress Bars */
    .progress-container {
        height: 6px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 3px;
        overflow: hidden;
    }

    .progress-bar {
        height: 100%;
        border-radius: 3px;
        transition: width 1s ease-in-out;
    }

    /* Status Badges */
    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.375rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
        gap: 0.375rem;
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .fade-in {
        animation: fadeIn 0.5s ease-out;
    }

    /* Table Styles */
    .table-container {
        overflow-x: auto;
        border-radius: 0.5rem;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .table {
        min-width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table thead th {
        padding: 1rem 1.5rem;
        text-align: left;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: rgb(209 213 219);
        background-color: rgba(30, 41, 59, 0.5);
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .table tbody tr {
        background-color: rgba(255, 255, 255, 0.025);
        transition: background-color 150ms;
    }

    .table tbody tr:hover {
        background-color: rgba(255, 255, 255, 0.05);
    }

    .table tbody td {
        padding: 1rem 1.5rem;
        white-space: nowrap;
        font-size: 0.875rem;
        color: rgb(209 213 219);
        border-top: 1px solid rgba(255, 255, 255, 0.05);
    }

    /* Action Buttons */
    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem;
        border-radius: 0.375rem;
        border: 1px solid;
        transition: all 200ms;
        position: relative;
        min-width: 2.5rem;
        min-height: 2.5rem;
        cursor: pointer;
        font-size: 0.875rem;
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
    }

    .action-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        pointer-events: none;
    }

    .action-btn:not(:disabled):hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .action-btn:focus {
        outline: none;
        ring: 2px;
        ring-offset: 2px;
        ring-blue-500: 1;
    }

    .action-btn i {
        pointer-events: none;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .header-stats {
            flex-direction: column;
            gap: 1rem;
        }

        .header-stats > div {
            min-width: 100px;
        }
    }

    @media (max-width: 768px) {
        .stat-card {
            margin-bottom: 1rem;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }

        .glass-card {
            border-radius: 0.75rem;
            margin: 0.5rem;
        }

        .table th, .table td {
            padding: 0.75rem 0.5rem;
            font-size: 0.8125rem;
        }

        .header-content {
            text-align: center;
        }

        .header-title {
            font-size: 1.5rem;
        }

        .action-buttons {
            flex-direction: column;
            gap: 0.5rem;
        }

        .mobile-scroll {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .status-info {
            flex-wrap: wrap;
            justify-content: center;
            gap: 0.5rem;
        }

        .status-info .hidden {
            display: none !important;
        }
    }

    @media (max-width: 640px) {
        .main-container {
            padding: 1rem;
        }

        .glass-card {
            margin: 0.25rem;
            padding: 1rem;
        }

        .stat-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .table-container {
            border-radius: 0.375rem;
        }

        .modal-content {
            margin: 1rem;
            max-width: calc(100vw - 2rem);
        }
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 pt-20 pb-16" id="patrolReportsDashboard">
    <!-- Main Dashboard Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-12 relative z-10 main-container">
        <!-- Patrol Reports Dashboard Header -->
        <header class="mb-8 sm:mb-10 relative overflow-hidden rounded-2xl glass-card transform transition-all duration-500 hover:shadow-2xl">
            <!-- Background with animated gradient -->
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-900/80 via-purple-900/70 to-cyan-900/80 backdrop-blur-sm">
                <div class="absolute inset-0 opacity-20" style="background-image: url(&quot;data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M54.627 0l-5.334 5.333-2.94-2.94-1.393 1.393 2.94 2.94-5.334 5.334-2.94-2.94-1.394 1.394 2.94 2.94-5.333 5.333-2.94-2.94-1.394 1.393 2.94 2.94-5.334 5.334-2.94-2.94-1.393 1.394 2.94 2.94L0 54.627l2.94 2.94 1.393-1.394-2.94-2.94 5.333-5.333 2.94 2.94 1.394-1.393-2.94-2.94 5.334-5.334 2.94 2.94 1.393-1.393-2.94-2.94 5.333-5.333 2.94 2.94 1.394-1.393-2.94-2.94 5.334-5.334 2.94 2.94 1.393-1.393-2.94-2.94 5.333-5.334 2.94 2.94 1.394-1.393-2.94-2.94L60 5.373 57.06 2.433l-1.393 1.394 2.94 2.94L54.627 0z' fill='%23ffffff' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E&quot;);"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-indigo-500/10 via-transparent to-purple-500/10 animate-gradient-x"></div>
            </div>

            <!-- Main header content -->
            <div class="relative z-10 p-6 sm:p-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <!-- Left side - Title and description -->
                    <div class="text-center md:text-left">
                        <div class="flex items-center justify-center md:justify-start gap-3 mb-2">
                            <div class="p-2 bg-indigo-500/20 rounded-lg border border-indigo-400/30 transition-all duration-300 hover:bg-indigo-500/30">
                                <i class="fas fa-file-alt text-2xl text-indigo-400"></i>
                            </div>
                            <h1 class="text-2xl sm:text-3xl font-bold text-white tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-indigo-300 to-purple-300 header-title cinzel-heading section-heading">
                                Patrol Reports Hub
                            </h1>
                        </div>
                        <p class="text-purple-200 text-sm sm:text-base max-w-2xl body-text">
                            Monitor and manage patroller reports with comprehensive oversight and approval workflows
                        </p>
                    </div>

                    <!-- Right side - Stats summary -->
                    <div class="flex flex-wrap justify-center gap-4 header-stats">
                        <!-- Quick Stats -->
                        <div class="text-center">
                            <div class="text-2xl font-bold text-indigo-400">
                                {{ $totalReports }}
                            </div>
                            <div class="text-xs text-gray-400 cinzel-text stat-label">Total Reports</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-yellow-400">
                                {{ $pendingReports }}
                            </div>
                            <div class="text-xs text-gray-400 cinzel-text stat-label">Pending</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-400">
                                {{ $approvedReports }}
                            </div>
                            <div class="text-xs text-gray-400 cinzel-text stat-label">Approved</div>
                        </div>
                    </div>
                </div>

                <!-- Status bar -->
                <div class="mt-6 pt-4 border-t border-white/10hi flex flex-wrap items-center justify-center gap-4 text-xs text-gray-300 status-info body-text">
                    <div class="flex items-center gap-2 body-text">
                        <span class="w-2 h-2 rounded-full bg-indigo-400 animate-pulse"></span>
                        <span>System Status: <span class="font-medium text-white">Operational</span></span>
                    </div>
                    <div class="hidden sm:block w-px h-4 bg-white/20"></div>
                    <div class="flex items-center gap-2 body-text">
                        <i class="fas fa-shield-alt text-purple-400"></i>
                        <span>Reports: <span class="font-medium text-white">{{ $pendingReports }} Pending</span></span>
                    </div>
                    <div class="hidden sm:block w-px h-4 bg-white/20"></div>
                    <div class="flex items-center gap-2 body-text">
                        <i class="fas fa-user-tie text-indigo-400"></i>
                        <span>Admin: <span class="font-medium text-white">{{ Auth::user()->name }}</span></span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Stats Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 stat-grid">
            <!-- Total Reports Card -->
            <div class="glass-card p-6 stat-card hover:shadow-lg transform transition-all duration-300 hover:border-indigo-400/50 border border-white/10 rounded-xl backdrop-blur-lg bg-gradient-to-br from-indigo-900/30 to-purple-900/30">
                <div class="flex items-center justify-between">
                    <div class="fade-in">
                        <p class="text-gray-400 text-sm uppercase tracking-wider mb-2 cinzel-text stat-label">Total Reports</p>
                        <h3 class="text-4xl font-bold text-white mb-1 section-subheading">{{ $totalReports }}</h3>
                        <p class="text-xs text-gray-400 body-muted">All patrol submissions</p>
                    </div>
                    <div class="stat-icon bg-gradient-to-br from-indigo-500/20 to-indigo-600/20 border border-indigo-500/30 hover:shadow-lg">
                        <i class="fas fa-file-alt text-indigo-400"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center justify-between text-xs text-gray-400 mb-1 body-text">
                        <span>Active reports</span>
                        <span class="flex items-center">
                            <span class="w-2 h-2 bg-green-400 rounded-full mr-1 animate-pulse"></span>
                            <span>{{ $totalReports }}</span>
                        </span>
                    </div>
                    <div class="progress-container">
                        <div class="progress-bar bg-indigo-500" style="width: 100%"></div>
                    </div>
                </div>
            </div>

            <!-- Pending Reports Card -->
            <div class="glass-card p-6 stat-card hover:shadow-lg transform transition-all duration-300 hover:border-yellow-400/50 border border-white/10 rounded-xl backdrop-blur-lg bg-gradient-to-br from-amber-900/30 to-yellow-900/30">
                <div class="flex items-center justify-between">
                    <div class="fade-in">
                        <p class="text-gray-400 text-sm uppercase tracking-wider mb-2 cinzel-text stat-label">Pending Review</p>
                        <h3 class="text-4xl font-bold text-yellow-400 mb-1 section-subheading">{{ $pendingReports }}</h3>
                        <p class="text-xs text-gray-400 body-muted">{{ $pendingPercentage }}% of total</p>
                    </div>
                    <div class="stat-icon bg-gradient-to-br from-yellow-500/20 to-yellow-600/20 border border-yellow-500/30 hover:shadow-lg">
                        <i class="fas fa-clock text-yellow-400"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center justify-between text-xs text-gray-400 mb-1 body-text">
                        <span>Requires action</span>
                        <span class="flex items-center">
                            <span class="w-2 h-2 bg-yellow-400 rounded-full mr-1 animate-pulse"></span>
                            <span>{{ $pendingReports }}</span>
                        </span>
                    </div>
                    <div class="progress-container">
                        <div class="progress-bar bg-gradient-to-r from-yellow-500 to-amber-500" style="width: {{ $pendingPercentage }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Approved Reports Card -->
            <div class="glass-card p-6 stat-card hover:shadow-lg transform transition-all duration-300 hover:border-green-400/50 border border-white/10 rounded-xl backdrop-blur-lg bg-gradient-to-br from-emerald-900/30 to-green-900/30">
                <div class="flex items-center justify-between">
                    <div class="fade-in">
                        <p class="text-gray-400 text-sm uppercase tracking-wider mb-2 cinzel-text stat-label">Approved</p>
                        <h3 class="text-4xl font-bold text-green-400 mb-1 section-subheading">{{ $approvedReports }}</h3>
                        <p class="text-xs text-gray-400 body-muted">{{ $approvedPercentage }}% of total</p>
                    </div>
                    <div class="stat-icon bg-gradient-to-br from-green-500/20 to-green-600/20 border border-green-500/30 hover:shadow-lg">
                        <i class="fas fa-check-circle text-green-400"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center justify-between text-xs text-gray-400 mb-1 body-text">
                        <span>This month</span>
                        <span>{{ $approvedReports }}</span>
                    </div>
                    <div class="progress-container">
                        <div class="progress-bar bg-gradient-to-r from-green-500 to-emerald-500" style="width: {{ $approvedPercentage }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Rejected Reports Card -->
            <div class="glass-card p-6 stat-card hover:shadow-lg transform transition-all duration-300 hover:border-red-400/50 border border-white/10 rounded-xl backdrop-blur-lg bg-gradient-to-br from-rose-900/30 to-red-900/30">
                <div class="flex items-center justify-between">
                    <div class="fade-in">
                        <p class="text-gray-400 text-sm uppercase tracking-wider mb-2 cinzel-text stat-label">Rejected</p>
                        <h3 class="text-4xl font-bold text-red-400 mb-1 section-subheading">{{ $rejectedReports }}</h3>
                        <p class="text-xs text-gray-400 body-muted">{{ $rejectedPercentage }}% of total</p>
                    </div>
                    <div class="stat-icon bg-gradient-to-br from-red-500/20 to-red-600/20 border border-red-500/30 hover:shadow-lg">
                        <i class="fas fa-times-circle text-red-400"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center justify-between text-xs text-gray-400 mb-1">
                        <span>This month</span>
                        <span>{{ $rejectedReports }}</span>
                    </div>
                    <div class="progress-container">
                        <div class="progress-bar bg-gradient-to-r from-red-500 to-rose-500" style="width: {{ $rejectedPercentage }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Reports Section -->
        <div class="glass-card rounded-2xl shadow-xl overflow-hidden mt-8">
            <div class="p-6 border-b border-white/10 flex items-center justify-between bg-gradient-to-r from-indigo-900/30 to-purple-900/30">
                <div>
                    <h2 class="text-2xl font-bold text-white cinzel-subheading section-heading">Recent Patrol Reports</h2>
                    <p class="text-gray-400 text-sm mt-1 body-muted">Latest patrol submissions and their status</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.patrol-reports.index') }}" class="px-4 py-2 bg-indigo-500/20 hover:bg-indigo-500/30 text-indigo-400 border border-indigo-500/30 rounded-lg transition-colors text-sm font-medium">
                        View All Reports
                    </a>
                </div>
            </div>

            <div class="overflow-x-auto mobile-scroll">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-white/10">
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white/80 uppercase tracking-wider bg-white/5 cinzel-text stat-label">Patroller</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white/80 uppercase tracking-wider bg-white/5 cinzel-text stat-label">Report Title</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white/80 uppercase tracking-wider bg-white/5 cinzel-text stat-label">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white/80 uppercase tracking-wider bg-white/5 cinzel-text stat-label">Priority</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-white/80 uppercase tracking-wider bg-white/5 cinzel-text stat-label">Date</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-white/80 uppercase tracking-wider bg-white/5 cinzel-text stat-label">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentReports as $report)
                            <tr class="hover:bg-white/5 transition-all duration-200 border-b border-white/5 last:border-0">
                                <td class="px-6 py-4 text-white/90">
                                    <div class="flex items-center gap-3">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($report->patroller->name) }}&background=6366f1&color=fff"
                                             alt="{{ $report->patroller->name }}"
                                             class="w-10 h-10 rounded-full border-2 border-indigo-500/30">
                                        <div>
                                            <span class="text-white font-medium section-subheading">{{ $report->patroller->name }}</span>
                                            <div class="text-xs text-gray-400 body-muted">{{ $report->patroller->patroller_id ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-300">
                                    <div>
                                        <div class="font-medium text-white section-subheading">{{ $report->title }}</div>
                                        <div class="text-sm text-gray-400 body-muted">{{ Str::limit($report->description, 40) }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-white/90">
                                    @if($report->status == 'pending_review')
                                        <span class="status-badge bg-blue-500/20 text-blue-400 border border-blue-500/30">
                                            <i class="fas fa-clock text-xs"></i>
                                            Pending Review
                                        </span>
                                    @elseif($report->status == 'under_review')
                                        <span class="status-badge bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                            <i class="fas fa-search text-xs"></i>
                                            Under Review
                                        </span>
                                    @elseif($report->status == 'approved')
                                        <span class="status-badge bg-green-500/20 text-green-400 border border-green-500/30">
                                            <i class="fas fa-check text-xs"></i>
                                            Approved
                                        </span>
                                    @elseif($report->status == 'rejected')
                                        <span class="status-badge bg-red-500/20 text-red-400 border border-red-500/30">
                                            <i class="fas fa-times text-xs"></i>
                                            Rejected
                                        </span>
                                    @elseif($report->status == 'resolved')
                                        <span class="status-badge bg-purple-500/20 text-purple-400 border border-purple-500/30">
                                            <i class="fas fa-check-double text-xs"></i>
                                            Resolved
                                        </span>
                                    @else
                                        <span class="status-badge bg-gray-500/20 text-gray-400 border border-gray-500/30">
                                            <i class="fas fa-archive text-xs"></i>
                                            {{ ucfirst(str_replace('_', ' ', $report->status)) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-white/90">
                                    @if($report->priority == 'critical')
                                        <span class="status-badge bg-red-500/20 text-red-400 border border-red-500/30">
                                            <i class="fas fa-exclamation-triangle text-xs"></i>
                                            Critical
                                        </span>
                                    @elseif($report->priority == 'high')
                                        <span class="status-badge bg-orange-500/20 text-orange-400 border border-orange-500/30">
                                            <i class="fas fa-arrow-up text-xs"></i>
                                            High
                                        </span>
                                    @elseif($report->priority == 'medium')
                                        <span class="status-badge bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                            <i class="fas fa-minus text-xs"></i>
                                            Medium
                                        </span>
                                    @else
                                        <span class="status-badge bg-green-500/20 text-green-400 border border-green-500/30">
                                            <i class="fas fa-arrow-down text-xs"></i>
                                            Low
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-300">
                                    <div class="flex flex-col body-text">
                                        <span class="section-subheading">{{ $report->created_at->format('M d, Y') }}</span>
                                        <span class="text-xs text-gray-500 body-muted">{{ $report->created_at->format('H:i') }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2 action-buttons">
                                        <a href="{{ route('admin.patrol-reports.show', $report) }}"
                                           class="action-btn bg-blue-500/20 hover:bg-blue-500/30 text-blue-400 border-blue-500/30 hover:border-blue-400/60"
                                           title="View Report Details">
                                            <i class="fas fa-eye text-sm"></i>
                                        </a>

                                        @if($report->status == 'pending_review')
                                            <button onclick="quickAction({{ $report->id }}, 'under_review')"
                                                    class="action-btn bg-yellow-500/20 hover:bg-yellow-500/30 text-yellow-400 border-yellow-500/30 hover:border-yellow-400/60"
                                                    title="Start Review">
                                                <i class="fas fa-play text-sm"></i>
                                            </button>
                                        @elseif($report->status == 'under_review')
                                            <button onclick="quickAction({{ $report->id }}, 'approved')"
                                                    class="action-btn bg-green-500/20 hover:bg-green-500/30 text-green-400 border-green-500/30 hover:border-green-400/60"
                                                    title="Approve Report">
                                                <i class="fas fa-check text-sm"></i>
                                            </button>
                                            <button onclick="quickAction({{ $report->id }}, 'rejected')"
                                                    class="action-btn bg-red-500/20 hover:bg-red-500/30 text-red-400 border-red-500/30 hover:border-red-400/60"
                                                    title="Reject Report">
                                                <i class="fas fa-times text-sm"></i>
                                            </button>
                                            <button onclick="quickAction({{ $report->id }}, 'resolved')"
                                                    class="action-btn bg-purple-500/20 hover:bg-purple-500/30 text-purple-400 border-purple-500/30 hover:border-purple-400/60"
                                                    title="Mark Resolved">
                                                <i class="fas fa-check-circle text-sm"></i>
                                            </button>
                                            <button onclick="quickAction({{ $report->id }}, 'closed')"
                                                    class="action-btn bg-gray-500/20 hover:bg-gray-500/30 text-gray-400 border-gray-500/30 hover:border-gray-400/60"
                                                    title="Close Report">
                                                <i class="fas fa-archive text-sm"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="fas fa-file-alt text-gray-600 text-5xl mb-4"></i>
                                        <p class="text-gray-400 text-lg section-subheading">No patrol reports found</p>
                                        <p class="text-gray-500 text-sm mt-2 body-muted">New reports will appear here when submitted</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<!-- Toast Notification -->
<div id="toast" class="fixed top-4 right-4 z-50 hidden">
    <div class="bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg flex items-center space-x-3">
        <i class="fas fa-check-circle"></i>
        <span id="toastMessage">Success!</span>
    </div>
</div>

<script>
// Quick action function for dashboard actions
function quickAction(reportId, status) {
    const statusText = {
        'under_review': 'start reviewing',
        'approved': 'approve',
        'rejected': 'reject',
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
@endsection

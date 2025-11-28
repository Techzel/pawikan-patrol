@extends('layouts.patroller')

@section('title', 'My Profile')
@section('container-class', 'max-w-6xl')

@section('content')
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-white mb-2 cinzel-heading">
                    <i class="fas fa-user-shield mr-3 text-ocean-400"></i>Patroller Profile
                </h1>
                <p class="text-gray-300 cinzel-text">Your patroller information and performance statistics</p>
            </div>

            @if(session('success'))
                <div class="mb-6 bg-green-500/20 border border-green-500/40 text-green-100 px-4 py-3 rounded-lg flex items-center gap-3">
                    <i class="fas fa-check-circle"></i>
                    <span class="cinzel-text">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-500/20 border border-red-500/40 text-red-100 px-4 py-3 rounded-lg flex items-center gap-3">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span class="cinzel-text">{{ session('error') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 bg-red-500/10 border border-red-500/30 text-red-100 px-4 py-3 rounded-lg">
                    <p class="font-semibold mb-2 cinzel-text">Please fix the following:</p>
                    <ul class="list-disc list-inside space-y-1 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Profile Information -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Basic Info -->
                    <div class="glass-dark rounded-xl p-6 border border-ocean-500/20">
                        <form action="{{ route('patroller.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="section" value="basic">

                            <div class="text-center">
                                <div class="w-24 h-24 bg-gradient-to-br from-ocean-400 to-ocean-600 rounded-full mx-auto mb-4 flex items-center justify-center overflow-hidden">
                                    @if($patroller->profile_picture)
                                        <img src="{{ asset('storage/'.$patroller->profile_picture) }}" alt="Profile" class="w-full h-full object-cover">
                                    @else
                                        <i class="fas fa-user-shield text-3xl text-white"></i>
                                    @endif
                                </div>
                                <label class="inline-flex items-center px-3 py-2 bg-ocean-500/20 text-ocean-100 rounded-lg cursor-pointer hover:bg-ocean-500/30 transition">
                                    <i class="fas fa-camera mr-2"></i>
                                    <span class="cinzel-text text-sm">Update Photo</span>
                                    <input type="file" name="profile_picture" class="hidden" accept="image/*">
                                </label>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="text-sm text-gray-300 cinzel-text">Full Name</label>
                                    <input type="text" name="name" value="{{ old('name', $patroller->name) }}" class="w-full mt-1 bg-white/5 border border-white/10 rounded-lg px-3 py-2 text-white focus:border-ocean-400 focus:ring-1 focus:ring-ocean-400">
                                </div>
                                <div>
                                    <label class="text-sm text-gray-300 cinzel-text">Email Address</label>
                                    <input type="email" name="email" value="{{ old('email', $patroller->email) }}" class="w-full mt-1 bg-white/5 border border-white/10 rounded-lg px-3 py-2 text-white focus:border-ocean-400 focus:ring-1 focus:ring-ocean-400">
                                </div>
                                <div>
                                    <label class="text-sm text-gray-300 cinzel-text">Phone Number</label>
                                    <input type="text" name="phone" value="{{ old('phone', $patroller->phone) }}" class="w-full mt-1 bg-white/5 border border-white/10 rounded-lg px-3 py-2 text-white focus:border-ocean-400 focus:ring-1 focus:ring-ocean-400">
                                </div>
                                <div>
                                    <label class="text-sm text-gray-300 cinzel-text">Username</label>
                                    <input type="text" name="username" value="{{ old('username', $patroller->username) }}" class="w-full mt-1 bg-white/5 border border-white/10 rounded-lg px-3 py-2 text-white focus:border-ocean-400 focus:ring-1 focus:ring-ocean-400">
                                </div>
                                <div>
                                    <label class="text-sm text-gray-300 cinzel-text">New Password</label>
                                    <input type="password" name="password" class="w-full mt-1 bg-white/5 border border-white/10 rounded-lg px-3 py-2 text-white focus:border-ocean-400 focus:ring-1 focus:ring-ocean-400" placeholder="Leave blank to keep current">
                                </div>
                                <div>
                                    <label class="text-sm text-gray-300 cinzel-text">Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="w-full mt-1 bg-white/5 border border-white/10 rounded-lg px-3 py-2 text-white focus:border-ocean-400 focus:ring-1 focus:ring-ocean-400" placeholder="Re-enter password">
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-ocean-500 hover:bg-ocean-600 transition text-white font-semibold py-2 rounded-lg shadow-lg">
                                Save Changes
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Statistics and Performance -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Recent Activity -->
                    <div class="glass-dark rounded-xl p-6 border border-ocean-500/20">
                        <div class="flex items-center justify-between mb-6">
                            <h4 class="text-lg font-semibold text-white cinzel-subheading">
                                <i class="fas fa-clock mr-2 text-ocean-400"></i>Recent Activity
                            </h4>
                            <a href="{{ route('patroller.reports.index') }}" class="text-ocean-400 hover:text-ocean-300 text-sm cinzel-text">
                                View All Reports <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>

                        @php
                            $recentReports = \App\Models\PatrolReport::where('patroller_id', $patroller->id)
                                ->orderBy('created_at', 'desc')
                                ->take(5)
                                ->get();
                        @endphp

                        @if($recentReports->count() > 0)
                            <div class="space-y-4">
                                @foreach($recentReports as $report)
                                    <div class="flex items-center justify-between p-4 bg-white/5 rounded-lg hover:bg-white/10 transition-colors">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-10 h-10 rounded-lg flex items-center justify-center
                                                @if($report->report_type == 'emergency') bg-red-500/20
                                                @elseif($report->report_type == 'incident') bg-orange-500/20
                                                @elseif($report->report_type == 'maintenance') bg-blue-500/20
                                                @else bg-green-500/20 @endif">
                                                <i class="fas fa-file-alt text-sm
                                                    @if($report->report_type == 'emergency') text-red-400
                                                    @elseif($report->report_type == 'incident') text-orange-400
                                                    @elseif($report->report_type == 'maintenance') text-blue-400
                                                    @else text-green-400 @endif"></i>
                                            </div>
                                            <div>
                                                <p class="text-white font-medium cinzel-text">{{ $report->title }}</p>
                                                <p class="text-gray-400 text-sm cinzel-text">{{ $report->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-3">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium cinzel-text
                                                @if($report->status == 'submitted') bg-blue-500/20 text-blue-300
                                                @elseif($report->status == 'under_review') bg-yellow-500/20 text-yellow-300
                                                @elseif($report->status == 'resolved') bg-green-500/20 text-green-300
                                                @else bg-gray-500/20 text-gray-300 @endif">
                                                {{ ucfirst(str_replace('_', ' ', $report->status)) }}
                                            </span>
                                            <a href="{{ route('patroller.reports.show', $report) }}" class="text-ocean-400 hover:text-ocean-300">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <i class="fas fa-file-alt text-4xl text-gray-500 mb-4"></i>
                                <p class="text-gray-400 cinzel-text">No recent activity</p>
                                <a href="{{ route('patroller.reports.create') }}" class="text-ocean-400 hover:text-ocean-300 cinzel-text">
                                    Submit your first report
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Quick Actions -->
                    <div class="glass-dark rounded-xl p-6 border border-ocean-500/20">
                        <h4 class="text-lg font-semibold text-white mb-6 cinzel-subheading">
                            <i class="fas fa-bolt mr-2 text-ocean-400"></i>Quick Actions
                        </h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <a href="{{ route('patroller.reports.create') }}" class="bg-gradient-to-r from-ocean-500 to-ocean-600 hover:from-ocean-600 hover:to-ocean-700 text-white p-4 rounded-lg text-center transition-all duration-300 transform hover:scale-105 shadow-lg">
                                <i class="fas fa-plus text-2xl mb-2"></i>
                                <p class="font-medium cinzel-text">New Report</p>
                            </a>
                            
                            <a href="{{ route('patroller.reports.index') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white p-4 rounded-lg text-center transition-all duration-300 transform hover:scale-105 shadow-lg">
                                <i class="fas fa-list text-2xl mb-2"></i>
                                <p class="font-medium cinzel-text">View Reports</p>
                            </a>
                            
                            <a href="{{ route('patroller.dashboard') }}" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white p-4 rounded-lg text-center transition-all duration-300 transform hover:scale-105 shadow-lg">
                                <i class="fas fa-tachometer-alt text-2xl mb-2"></i>
                                <p class="font-medium cinzel-text">Dashboard</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

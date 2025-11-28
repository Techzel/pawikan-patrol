@extends('layouts.app')

@section('title', 'Patroller Profile - ' . $patroller->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Patroller Profile</h1>
                <p class="text-gray-600">View and manage patroller details</p>
            </div>
            <div class="flex space-x-4">
                <a href="{{ route('admin.patrollers.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Patrollers
                </a>
                <a href="{{ route('admin.patrollers.edit', $patroller->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Profile
                </a>
            </div>
        </div>
    </div>

    <!-- Profile Overview -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <!-- Basic Info Card -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-center">
                    <img class="mx-auto h-32 w-32 rounded-full" src="{{ $patroller->profile_photo_url ?: 'https://ui-avatars.com/api/?name=' . urlencode($patroller->name) . '&color=7C3AED&background=F3E8FF&size=128' }}" alt="{{ $patroller->name }}">
                    <h2 class="mt-4 text-xl font-semibold text-gray-900">{{ $patroller->name }}</h2>
                    <p class="text-gray-600">{{ $patroller->email }}</p>
                    
                    @if ($patroller->is_active)
                        <span class="mt-2 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Active
                        </span>
                    @else
                        <span class="mt-2 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            Inactive
                        </span>
                    @endif
                </div>

                <div class="mt-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Username</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $patroller->username }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Badge Number</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $patroller->badge_number ?: 'Not Assigned' }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Phone</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $patroller->phone ?: 'Not Provided' }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Member Since</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $patroller->created_at->format('M d, Y') }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Patroller Since</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $patroller->patroller_since ? $patroller->patroller_since->format('M d, Y') : 'Not Activated' }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Last Login</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $patroller->last_login_at ? $patroller->last_login_at->diffForHumans() : 'Never' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Performance Statistics -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Performance Statistics</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-600">{{ $patroller->total_patrols }}</div>
                        <div class="text-sm text-gray-600">Total Patrols</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600">{{ $patroller->turtles_saved }}</div>
                        <div class="text-sm text-gray-600">Turtles Saved</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-yellow-600">{{ $patroller->nests_protected }}</div>
                        <div class="text-sm text-gray-600">Nests Protected</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-purple-600">{{ $patroller->total_conservation_impact }}</div>
                        <div class="text-sm text-gray-600">Total Impact</div>
                    </div>
                </div>
                
                <div class="mt-6">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700">Patroller Rank</span>
                        <span class="text-sm font-semibold text-gray-900">{{ $patroller->patroller_rank }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ min(($patroller->total_conservation_impact / 1000) * 100, 100) }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Professional Information -->
            @if ($patroller->patrollerProfile)
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Professional Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Department</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $patroller->patrollerProfile->department }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <p class="mt-1">{{ $patroller->patrollerProfile->status_badge }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Performance Rating</label>
                            <p class="mt-1 text-sm text-gray-900">
                                @if ($patroller->patrollerProfile->performance_rating)
                                    {{ number_format($patroller->patrollerProfile->performance_rating, 1) }}/5.0 ({{ $patroller->patrollerProfile->performance_level }})
                                @else
                                    Not Rated
                                @endif
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Last Performance Review</label>
                            <p class="mt-1 text-sm text-gray-900">
                                {{ $patroller->patrollerProfile->last_performance_review ? $patroller->patrollerProfile->last_performance_review->format('M d, Y') : 'No review yet' }}
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Emergency Contact</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $patroller->patrollerProfile->emergency_contact }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Emergency Phone</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $patroller->patrollerProfile->emergency_phone }}</p>
                        </div>
                    </div>
                    
                    @if ($patroller->patrollerProfile->certifications)
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Certifications</label>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($patroller->patrollerProfile->certifications as $certification)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $certification }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    
                    @if ($patroller->patrollerProfile->specializations)
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Specializations</label>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($patroller->patrollerProfile->specializations as $specialization)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ $specialization }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    
                    @if ($patroller->patrollerProfile->notes)
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                            <p class="text-sm text-gray-900">{{ $patroller->patrollerProfile->notes }}</p>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Patrol Areas -->
            @if ($patroller->patrol_areas)
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Patrol Areas</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($patroller->patrol_areas as $area)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ $area }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Bio -->
            @if ($patroller->bio)
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Bio</h3>
                    <p class="text-gray-900">{{ $patroller->bio }}</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mt-8 flex space-x-4">
        @if ($patroller->is_active)
            <form action="{{ route('admin.patrollers.deactivate', $patroller->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to deactivate this patroller?')">
                @csrf
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Deactivate Account
                </button>
            </form>
        @else
            <form action="{{ route('admin.patrollers.activate', $patroller->id) }}" method="POST">
                @csrf
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Activate Account
                </button>
            </form>
        @endif
        
        <a href="{{ route('admin.patrollers.reports', $patroller->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            View Reports
        </a>
    </div>
</div>
@endsection

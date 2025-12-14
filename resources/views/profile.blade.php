@extends('layouts.app')

@php
// Helper function to get rank badge information
function getRankBadge($rank) {
    if (!$rank) return null;
    
    if ($rank == 1) {
        return [
            'title' => 'Champion',
            'icon' => '👑',
            'class' => 'bg-gradient-to-r from-yellow-500/30 to-yellow-600/30 border-2 border-yellow-500/50 text-yellow-400',
            'text_class' => 'text-yellow-400',
            'description' => 'The ultimate champion!'
        ];
    } elseif ($rank <= 3) {
        return [
            'title' => 'Elite',
            'icon' => '🥈',
            'class' => 'bg-gradient-to-r from-gray-300/30 to-gray-400/30 border-2 border-gray-400/50 text-gray-300',
            'text_class' => 'text-gray-300',
            'description' => 'Among the elite players!'
        ];
    } elseif ($rank <= 10) {
        return [
            'title' => 'Master',
            'icon' => '🥉',
            'class' => 'bg-gradient-to-r from-orange-600/30 to-orange-700/30 border-2 border-orange-600/50 text-orange-400',
            'text_class' => 'text-orange-400',
            'description' => 'Master player status!'
        ];
    } elseif ($rank <= 25) {
        return [
            'title' => 'Expert',
            'icon' => '⭐',
            'class' => 'bg-gradient-to-r from-blue-500/30 to-blue-600/30 border-2 border-blue-500/50 text-blue-400',
            'text_class' => 'text-blue-400',
            'description' => 'Expert level achieved!'
        ];
    } elseif ($rank <= 50) {
        return [
            'title' => 'Advanced',
            'icon' => '🎯',
            'class' => 'bg-gradient-to-r from-green-500/30 to-green-600/30 border-2 border-green-500/50 text-green-400',
            'text_class' => 'text-green-400',
            'description' => 'Advanced player!'
        ];
    } elseif ($rank <= 100) {
        return [
            'title' => 'Skilled',
            'icon' => '🔥',
            'class' => 'bg-gradient-to-r from-purple-500/30 to-purple-600/30 border-2 border-purple-500/50 text-purple-400',
            'text_class' => 'text-purple-400',
            'description' => 'Skilled performer!'
        ];
    } elseif ($rank <= 250) {
        return [
            'title' => 'Rising',
            'icon' => '💪',
            'class' => 'bg-gradient-to-r from-cyan-500/30 to-cyan-600/30 border-2 border-cyan-500/50 text-cyan-400',
            'text_class' => 'text-cyan-400',
            'description' => 'Rising star!'
        ];
    } else {
        return [
            'title' => 'Player',
            'icon' => '🌟',
            'class' => 'bg-gradient-to-r from-indigo-500/30 to-indigo-600/30 border-2 border-indigo-500/50 text-indigo-400',
            'text_class' => 'text-indigo-400',
            'description' => 'Keep playing and climbing!'
        ];
    }
}
@endphp

@section('title', 'My Profile - Pawikan Patrol')

@section('content')
<div class="min-h-screen py-24 px-4 bg-gray-900 font-poppins">
    <div class="max-w-6xl mx-auto">
        <!-- Header Section -->
        <div class="glass-dark rounded-2xl p-8 mb-8 border border-green-500/30 shadow-xl">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-green-400 mb-2 font-poppins">
                    My Profile
                </h1>
                <p class="text-gray-300 text-lg">Manage your account and track your conservation journey</p>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-500/20 border border-green-500/50 rounded-xl text-green-100 text-sm backdrop-blur-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-500/20 border border-red-500/50 rounded-xl text-red-100 text-sm backdrop-blur-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                {{ session('error') }}
            </div>
        @endif

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Sidebar - Profile Card & Quick Stats -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Profile Card -->
                <div class="glass-dark rounded-2xl p-6 border border-green-500/30">
                    <div class="text-center">
                        <div class="relative inline-block mb-4">
                            <div class="relative">
                                @if(auth()->user()->profile_picture)
                                    <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" 
                                         alt="Profile Picture" 
                                         class="w-24 h-24 rounded-full object-cover shadow-lg border-4 border-ocean-500/30 mx-auto"
                                         onerror="this.onerror=null; this.src='{{ asset('images/default-avatar.png') }}';">
                                @else
                                    <div class="w-24 h-24 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center text-3xl font-bold text-white shadow-lg mx-auto">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Upload Button Overlay -->
                            <div class="absolute inset-0 bg-black/30 rounded-full opacity-0 hover:opacity-100 transition-all duration-300 flex items-center justify-center cursor-pointer backdrop-blur-sm" onclick="document.getElementById('profilePictureInput').click()">
                                <div class="text-center">
                                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center mb-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <div class="text-white text-xs font-medium">Upload</div>
                                </div>
                            </div>
                            
                            <!-- Hidden File Input -->
                            <form id="profilePictureForm" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="hidden">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="profile_picture_only" value="1">
                                <input type="hidden" name="name" value="{{ auth()->user()->name }}">
                                <input type="hidden" name="username" value="{{ auth()->user()->username }}">
                                <input type="file" 
                                       id="profilePictureInput" 
                                       name="profile_picture" 
                                       accept="image/*" 
                                       class="hidden" 
                                       onchange="submitProfilePictureForm(this)">
                            </form>
                            
                            <!-- Loading Indicator -->
                            <div id="profilePictureLoading" class="absolute inset-0 bg-black/50 rounded-full flex items-center justify-center" style="display: none;">
                                <div class="text-white text-center">
                                    <svg class="animate-spin h-5 w-5 text-white mx-auto mb-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <div class="text-xs">Uploading...</div>
                                </div>
                            </div>
                        </div>
                        
                        <h2 class="text-xl font-bold text-white mb-1">{{ auth()->user()->name }}</h2>
                        <p class="text-gray-400 text-sm mb-4">{{ auth()->user()->email }}</p>
                        
                        @php
                            // Get rank for each game
                            $memoryRank = auth()->user()->getGameRank('memory-match');
                            $puzzleRank = auth()->user()->getGameRank('puzzle');
                            $findPawikanRank = auth()->user()->getGameRank('find-the-pawikan');
                            
                            $badges = [];
                            if ($memoryRank && $memoryRank <= 10) {
                                $badges[] = [
                                    'game' => 'Memory Match',
                                    'icon' => '🧠',
                                    'rank' => $memoryRank,
                                    'gradient' => 'from-purple-500 to-purple-600',
                                    'border' => 'border-purple-500/50',
                                    'bg' => 'bg-purple-500/10'
                                ];
                            }
                            if ($puzzleRank && $puzzleRank <= 10) {
                                $badges[] = [
                                    'game' => 'Pawikan Puzzle',
                                    'icon' => '🧩',
                                    'rank' => $puzzleRank,
                                    'gradient' => 'from-orange-500 to-orange-600',
                                    'border' => 'border-orange-500/50',
                                    'bg' => 'bg-orange-500/10'
                                ];
                            }
                            if ($findPawikanRank && $findPawikanRank <= 10) {
                                $badges[] = [
                                    'game' => 'Find the Pawikan',
                                    'icon' => '🐢',
                                    'rank' => $findPawikanRank,
                                    'gradient' => 'from-teal-500 to-teal-600',
                                    'border' => 'border-teal-500/50',
                                    'bg' => 'bg-teal-500/10'
                                ];
                            }
                        @endphp
                        
                        <!-- Champion Badges Section -->
                        @if(count($badges) > 0)
                            <div class="mb-4">
                                <div class="space-y-2">
                                    @foreach($badges as $badge)
                                        <div class="group {{ $badge['bg'] }} border {{ $badge['border'] }} rounded-lg p-2 hover:scale-105 transition-all duration-300">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center gap-2">
                                                    <div class="w-8 h-8 bg-gradient-to-br {{ $badge['gradient'] }} rounded-lg flex items-center justify-center shadow-lg">
                                                        <span class="text-lg">{{ $badge['icon'] }}</span>
                                                    </div>
                                                    <div class="text-left">
                                                        <div class="text-white font-semibold text-xs">{{ $badge['game'] }}</div>
                                                        <div class="text-gray-400 text-[10px]">Rank #{{ $badge['rank'] }}</div>
                                                    </div>
                                                </div>
                                                <div class="text-yellow-400">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif                        
                        <div class="flex justify-center gap-2 mb-3">
                            {!! auth()->user()->getVerificationStatusBadge() !!}
                            <span class="px-2 py-1 bg-green-500/20 text-green-400 rounded-full text-xs border border-green-500/30">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 mr-1 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                </svg>
                                Conservationist
                            </span>
                        </div>
                        
                        <div class="text-xs text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 mr-1 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Member since {{ auth()->user()->created_at->format('M j, Y') }}
                        </div>
                    </div>
                </div>


                <!-- Recent Activity -->
                <div class="glass-dark rounded-2xl p-6 border border-green-500/30">
                    <h3 class="text-lg font-bold text-green-400 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 inline text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Recent Activity
                    </h3>
                    <div class="space-y-2" id="recent-activities">
                        @php
                            $recentActivities = auth()->user()->getRecentActivities(5);
                        @endphp
                        
                        @if($recentActivities->count() > 0)
                            @foreach($recentActivities as $activity)
                                <div class="flex items-center gap-2 text-xs">
                                    <div class="w-1.5 h-1.5 {{ 
                                        $activity->game_type === 'quiz' ? 'bg-blue-400' : 
                                        ($activity->game_type === 'word_scramble' ? 'bg-green-400' : 
                                        ($activity->game_type === 'memory-match' ? 'bg-purple-400' : 
                                        ($activity->game_type === 'puzzle' ? 'bg-orange-400' : 
                                        ($activity->game_type === 'find-the-pawikan' ? 'bg-teal-400' : 'bg-gray-400')))) 
                                    }} rounded-full"></div>
                                    <span class="text-gray-300 truncate">
                                        @if($activity->game_type === 'quiz')
                                            Turtle Quiz
                                        @elseif($activity->game_type === 'word_scramble')
                                            Word Scramble
                                        @elseif($activity->game_type === 'memory-match')
                                            Memory Match
                                        @elseif($activity->game_type === 'puzzle')
                                            Pawikan Puzzle
                                        @elseif($activity->game_type === 'find-the-pawikan')
                                            Find the Pawikan
                                        @else
                                            {{ ucwords(str_replace(['-', '_'], ' ', $activity->game_type)) }}
                                        @endif
                                        ({{ $activity->score }} pts)
                                    </span>
                                    <span class="text-gray-500 ml-auto whitespace-nowrap">{{ $activity->created_at->diffForHumans() }}</span>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-3">
                                <div class="text-gray-300 text-xs">No activities yet. Start playing!</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Content - Main Dashboard -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Account Information -->
                <div class="glass-dark rounded-2xl p-6 border border-green-500/30">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold text-green-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 inline text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Account Information
                        </h3>
                        <button id="editProfileBtn" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1.5 rounded-lg text-sm transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit
                        </button>
                    </div>

                    <!-- Profile Display Mode -->
                    <div id="profileDisplay" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-300 mb-1">Full Name</label>
                            <div class="bg-deep-800/50 rounded-lg px-3 py-2 text-white text-sm border border-deep-700">
                                {{ auth()->user()->name }}
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-300 mb-1">Email Address</label>
                            <div class="bg-deep-800/50 rounded-lg px-3 py-2 text-white text-sm border border-deep-700">
                                {{ auth()->user()->email }}
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-300 mb-1">Username</label>
                            <div class="bg-deep-800/50 rounded-lg px-3 py-2 text-white text-sm border border-deep-700">
                                {{ auth()->user()->username ?? 'Not set' }}
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-300 mb-1">Member Since</label>
                            <div class="bg-deep-800/50 rounded-lg px-3 py-2 text-white text-sm border border-deep-700">
                                {{ auth()->user()->created_at->format('M j, Y') }}
                            </div>
                        </div>
                    </div>

                    <!-- Profile Edit Mode -->
                    <form id="profileEditForm" method="POST" action="{{ route('profile.update') }}" style="display: none;">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="name" class="block text-xs font-medium text-gray-300 mb-1">Full Name</label>
                                <input type="text" id="name" name="name" value="{{ auth()->user()->name }}" 
                                       class="w-full bg-deep-800/50 border border-deep-700 rounded-lg px-3 py-2 text-white text-sm focus:border-green-500 focus:outline-none transition-colors">
                            </div>
                            <div>
                                <label for="email" class="block text-xs font-medium text-gray-300 mb-1">Email Address</label>
                                <input type="email" id="email" name="email" value="{{ auth()->user()->email }}" 
                                       class="w-full bg-deep-800/50 border border-deep-700 rounded-lg px-3 py-2 text-white text-sm focus:border-ocean-500 focus:outline-none transition-colors">
                            </div>
                            <div>
                                <label for="username" class="block text-xs font-medium text-gray-300 mb-1">Username</label>
                                <input type="text" id="username" name="username" value="{{ auth()->user()->username ?? '' }}" 
                                       class="w-full bg-deep-800/50 border border-deep-700 rounded-lg px-3 py-2 text-white text-sm focus:border-ocean-500 focus:outline-none transition-colors">
                            </div>
                            <div>
                                <label for="password" class="block text-xs font-medium text-gray-300 mb-1">New Password (Optional)</label>
                                <div class="relative">
                                    <input type="password" id="password" name="password" placeholder="Leave blank to keep current"
                                           class="w-full bg-deep-800/50 border border-deep-700 rounded-lg px-3 py-2 text-white text-sm focus:border-ocean-500 focus:outline-none transition-colors pr-10">
                                    <button type="button" onclick="togglePassword('password')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" id="password-eye">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-3 mt-4">
                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                </svg>
                                Save Changes
                            </button>
                            <button type="button" id="cancelEditBtn" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Gaming Dashboard -->
                <div class="glass-dark rounded-2xl p-6 border border-green-500/30">
                    <h3 class="text-xl font-bold text-green-400 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 inline text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Gaming Dashboard
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        
                        <!-- Memory Match Progress -->
                        <div class="bg-gradient-to-br from-purple-500/10 to-purple-600/10 rounded-xl p-4 border border-purple-500/20">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 bg-purple-500/20 rounded-lg flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-white font-semibold text-sm">Memory Match</h4>
                                        <p class="text-gray-300 text-xs">Match the pairs</p>
                                    </div>
                                </div>

                            </div>
                            
                            @php
                                $memoryActivities = auth()->user()->gameActivities()->byGameType('memory-match')->completed();
                                $memoryGamesPlayed = $memoryActivities->count();
                                $avgMoves = $memoryActivities->avg('moves') ?? 0;
                            @endphp
                            
                            <div class="grid grid-cols-2 gap-2 mb-3">
                                <div class="text-center">
                                    <div class="text-lg font-bold text-white" data-stat="memory-games">{{ $memoryGamesPlayed }}</div>
                                    <div class="text-xs text-gray-300">Games Played</div>
                                </div>
                                    @php
                                        $memoryBestTime = $memoryActivities->min('time_spent') ?? 0;
                                    @endphp
                                <div class="text-center">
                                    <div class="text-lg font-bold text-purple-400" data-stat="memory-best-time">{{ $memoryBestTime > 0 ? sprintf('%02d:%02d.%02d', floor($memoryBestTime / 60), $memoryBestTime % 60, ($memoryBestTime - floor($memoryBestTime)) * 100) : '--' }}</div>
                                    <div class="text-xs text-gray-300">Best Time</div>
                                </div>
                            </div>
                            
                            <a href="{{ route('games.memory-match') }}" class="block w-full bg-purple-500/20 hover:bg-purple-500/30 text-purple-300 text-center py-2 rounded-lg text-xs font-medium transition-colors">
                                Play Now
                            </a>
                        </div>
                        
                        <!-- Puzzle Progress -->
                        <div class="bg-gradient-to-br from-orange-500/10 to-orange-600/10 rounded-xl p-4 border border-orange-500/20">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 bg-orange-500/20 rounded-lg flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-white font-semibold text-sm">Pawikan Puzzle</h4>
                                        <p class="text-gray-300 text-xs">Solve the puzzle</p>
                                    </div>
                                </div>

                            </div>
                            
                            @php
                                $puzzleActivities = auth()->user()->gameActivities()->byGameType('puzzle')->completed();
                                $puzzleGamesPlayed = $puzzleActivities->count();
                                $avgTime = $puzzleActivities->avg('time_spent') ?? 0;
                            @endphp
                            
                            <div class="grid grid-cols-2 gap-2 mb-3">
                                <div class="text-center">
                                    <div class="text-lg font-bold text-white" data-stat="puzzle-games">{{ $puzzleGamesPlayed }}</div>
                                    <div class="text-xs text-gray-300">Games Played</div>
                                </div>
                                    @php
                                        $puzzleBestTime = $puzzleActivities->min('time_spent') ?? 0;
                                    @endphp
                                <div class="text-center">
                                    <div class="text-lg font-bold text-orange-400" data-stat="puzzle-best-time">{{ $puzzleBestTime > 0 ? sprintf('%02d:%02d.%02d', floor($puzzleBestTime / 60), $puzzleBestTime % 60, ($puzzleBestTime - floor($puzzleBestTime)) * 100) : '--' }}</div>
                                    <div class="text-xs text-gray-300">Best Time</div>
                                </div>
                            </div>
                            
                            <a href="{{ route('games.puzzle') }}" class="block w-full bg-orange-500/20 hover:bg-orange-500/30 text-orange-300 text-center py-2 rounded-lg text-xs font-medium transition-colors">
                                Play Now
                            </a>
                        </div>

                        <!-- Find the Pawikan Progress -->
                        <div class="bg-gradient-to-br from-teal-500/10 to-teal-600/10 rounded-xl p-4 border border-teal-500/20">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 bg-teal-500/20 rounded-lg flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-white font-semibold text-sm">Find the Pawikan</h4>
                                        <p class="text-gray-300 text-xs">Spot the turtles</p>
                                    </div>
                                </div>

                            </div>
                            
                            @php
                                $findActivities = auth()->user()->gameActivities()->byGameType('find-the-pawikan')->completed();
                                $findGamesPlayed = $findActivities->count();
                                $bestTime = $findActivities->min('time_spent') ?? 0;
                            @endphp
                            
                            <div class="grid grid-cols-2 gap-2 mb-3">
                                <div class="text-center">
                                    <div class="text-lg font-bold text-white" data-stat="find-games">{{ $findGamesPlayed }}</div>
                                    <div class="text-xs text-gray-300">Games Played</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-lg font-bold text-teal-400" data-stat="find-best-time">{{ $bestTime > 0 ? sprintf('%02d:%02d.%02d', floor($bestTime / 60), $bestTime % 60, ($bestTime - floor($bestTime)) * 100) : '--' }}</div>
                                    <div class="text-xs text-gray-300">Best Time</div>
                                </div>
                            </div>
                            
                            <a href="{{ route('games.find-the-pawikan') }}" class="block w-full bg-teal-500/20 hover:bg-teal-500/30 text-teal-300 text-center py-2 rounded-lg text-xs font-medium transition-colors">
                                Play Now
                            </a>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <a href="/games" class="flex-1 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-300 text-center text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            View All Games
                        </a>
                    </div>
                </div>

                <!-- Recent Game Sessions -->
                <div class="glass-dark rounded-2xl p-6 border border-green-500/30">
                    <h3 class="text-xl font-bold text-green-400 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 inline text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Recent Game Sessions
                    </h3>
                    
                    <div class="space-y-2">
                        @php
                            $recentSessions = auth()->user()->gameActivities()->orderBy('played_at', 'desc')->limit(5)->get();
                        @endphp
                        
                        @if($recentSessions->count() > 0)
                            @foreach($recentSessions as $session)
                                <div class="flex items-center justify-between p-3 bg-deep-800/30 rounded-lg">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-green-500/20 flex items-center justify-center">
                                            @if($session->game_type === 'quiz')
                                                <i class="fas fa-brain text-blue-400 text-sm"></i>
                                            @elseif($session->game_type === 'word_scramble')
                                                <i class="fas fa-spell-check text-green-400 text-sm"></i>
                                            @elseif($session->game_type === 'memory-match')
                                                <i class="fas fa-clone text-purple-400 text-sm"></i>
                                            @elseif($session->game_type === 'puzzle')
                                                <i class="fas fa-puzzle-piece text-orange-400 text-sm"></i>
                                            @elseif($session->game_type === 'find-the-pawikan')
                                                <i class="fas fa-search text-teal-400 text-sm"></i>
                                            @else
                                                <i class="fas fa-gamepad text-gray-400 text-sm"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="text-white font-medium text-sm">
                                                @if($session->game_type === 'quiz')
                                                    Turtle Quiz
                                                @elseif($session->game_type === 'word_scramble')
                                                    Word Scramble
                                                @elseif($session->game_type === 'memory-match')
                                                    Memory Match
                                                @elseif($session->game_type === 'puzzle')
                                                    Pawikan Puzzle
                                                @elseif($session->game_type === 'find-the-pawikan')
                                                    Find the Pawikan
                                                @else
                                                    {{ ucwords(str_replace(['-', '_'], ' ', $session->game_type)) }}
                                                @endif
                                            </div>
                                            <div class="text-gray-300 text-xs">{{ $session->played_at->format('M j, g:i A') }}</div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-green-400 font-bold text-sm">{{ $session->score }} pts</div>
                                        <div class="text-gray-300 text-xs">{{ sprintf('%02d:%02d.%02d', floor($session->time_spent / 60), $session->time_spent % 60, ($session->time_spent - floor($session->time_spent)) * 100) }}</div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-4">
                                <div class="text-gray-300 text-sm">No game sessions yet. Start playing to build your history!</div>
                            </div>
                        @endif
                    </div>
                </div>



                <!-- Account Benefits -->
                <div class="glass-dark rounded-2xl p-6 border border-green-500/30">
                    <h3 class="text-xl font-bold text-green-400 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 inline text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                        Account Benefits
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-green-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-white font-semibold mb-1 text-sm">Mini-Games Access</h4>
                                <p class="text-gray-300 text-xs">Play educational turtle conservation games</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-green-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-white font-semibold mb-1 text-sm">Progress Saving</h4>
                                <p class="text-gray-300 text-xs">Save your progress and continue learning</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-yellow-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-white font-semibold mb-1 text-sm">Personalized Dashboard</h4>
                                <p class="text-gray-300 text-xs">View detailed analytics of your journey</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-purple-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-white font-semibold mb-1 text-sm">Scoreboards & Rankings</h4>
                                <p class="text-gray-300 text-xs">Compete with other conservationists</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Profile edit toggle functionality
document.getElementById('editProfileBtn').addEventListener('click', function() {
    document.getElementById('profileDisplay').style.display = 'none';
    document.getElementById('profileEditForm').style.display = 'block';
    this.style.display = 'none';
});

document.getElementById('cancelEditBtn').addEventListener('click', function() {
    document.getElementById('profileDisplay').style.display = 'grid';
    document.getElementById('profileEditForm').style.display = 'none';
    document.getElementById('editProfileBtn').style.display = 'inline-block';
});

// Profile picture upload
function submitProfilePictureForm(input) {
    if (input.files && input.files[0]) {
        document.getElementById('profilePictureLoading').style.display = 'flex';
        document.getElementById('profilePictureForm').submit();
    }
}

// Password visibility toggle
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const eye = document.getElementById(fieldId + '-eye');
    
    if (field.type === 'password') {
        field.type = 'text';
        eye.classList.remove('fa-eye');
        eye.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        eye.classList.remove('fa-eye-slash');
        eye.classList.add('fa-eye');
    }
}

// Function to update user statistics display
function updateUserStats(stats) {
    if (!stats || typeof stats !== 'object') return;
    
    // Update total score

    
    // Update total games played
    const totalGamesElements = document.querySelectorAll('[data-stat="total-games"]');
    totalGamesElements.forEach(element => {
        element.textContent = stats.total_games || 0;
    });

    // Update Memory Match stats
    if (stats.memory_match) {
        document.querySelectorAll('[data-stat="memory-games"]').forEach(el => {
            el.textContent = stats.memory_match.games;
        });
        document.querySelectorAll('[data-stat="memory-best-time"]').forEach(el => {
            const time = stats.memory_match.best_time;
            if (time > 0) {
                const minutes = Math.floor(time / 60).toString().padStart(2, '0');
                const seconds = (Math.round(time) % 60).toString().padStart(2, '0');
                el.textContent = `${minutes}:${seconds}`;
            } else {
                el.textContent = '--';
            }
        });
    }

    // Update Puzzle stats
    if (stats.puzzle) {
        document.querySelectorAll('[data-stat="puzzle-games"]').forEach(el => {
            el.textContent = stats.puzzle.games;
        });
        document.querySelectorAll('[data-stat="puzzle-best-time"]').forEach(el => {
            const time = stats.puzzle.best_time;
            if (time > 0) {
                const minutes = Math.floor(time / 60).toString().padStart(2, '0');
                const seconds = (Math.round(time) % 60).toString().padStart(2, '0');
                el.textContent = `${minutes}:${seconds}`;
            } else {
                el.textContent = '--';
            }
        });
    }

    // Update Find the Pawikan stats
    if (stats.find_the_pawikan) {
        document.querySelectorAll('[data-stat="find-games"]').forEach(el => {
            el.textContent = stats.find_the_pawikan.games;
        });
        document.querySelectorAll('[data-stat="find-best-time"]').forEach(el => {
            const time = stats.find_the_pawikan.best_time;
            if (time > 0) {
                const minutes = Math.floor(time / 60).toString().padStart(2, '0');
                const seconds = (Math.round(time) % 60).toString().padStart(2, '0');
                el.textContent = `${minutes}:${seconds}`;
            } else {
                el.textContent = '--';
            }
        });
    }
}

// Listen for custom events from game activity updates
document.addEventListener('userStatsUpdated', function(event) {
    updateUserStats(event.detail);
});

// Listen for game completion events to update stats immediately
window.addEventListener('gameCompleted', async function(event) {
    console.log('Game completed, refreshing stats...', event.detail);
    
    // Fetch fresh statistics from the server
    try {
        const response = await fetch('/game-activities/statistics', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            }
        });
        
        if (response.ok) {
            const stats = await response.json();
            updateUserStats(stats);
            
            // Show a subtle notification
            const notification = document.createElement('div');
            notification.className = 'fixed bottom-4 right-4 bg-green-500/20 text-green-400 px-4 py-3 rounded-lg border border-green-500/30 z-50 flex items-center gap-2 shadow-lg animate-fade-in';
            notification.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-sm font-medium">Profile updated!</span>
            `;
            
            document.body.appendChild(notification);
            
            // Remove notification after 3 seconds
            setTimeout(() => {
                notification.style.opacity = '0';
                notification.style.transform = 'translateY(20px)';
                notification.style.transition = 'all 0.3s ease';
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.parentNode.removeChild(notification);
                    }
                }, 300);
            }, 3000);
        }
    } catch (error) {
        console.error('Error fetching updated stats:', error);
    }
});

// Auto-refresh statistics every 30 seconds
setInterval(async function() {
    try {
        // Check if gameActivity is available and DOM elements exist
        if (typeof gameActivity !== 'undefined' && 
            document.querySelector('[data-stat="total-score"]') && 
            document.querySelector('[data-stat="total-games"]')) {
            const stats = await gameActivity.getStatistics();
            if (stats.success && stats.data) {
                updateUserStats(stats.data);
            }
        }
    } catch (error) {
        console.log('Auto-refresh stats failed:', error);
    }
}, 30000);

// Leaderboard tab switching functionality
function showLeaderboardTab(tabName) {
    // Hide all leaderboard content
    document.querySelectorAll('.leaderboard-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remove active class from all tabs
    document.querySelectorAll('.leaderboard-tab').forEach(tab => {
        tab.classList.remove('active', 'bg-ocean-500/20', 'text-ocean-400');
        tab.classList.add('text-gray-400', 'hover:text-white');
    });
    
    // Show selected leaderboard content
    document.getElementById(tabName + '-leaderboard').classList.remove('hidden');
    
    // Add active class to selected tab
    const activeTab = document.getElementById(tabName + '-tab');
    activeTab.classList.add('active', 'bg-ocean-500/20', 'text-ocean-400');
    activeTab.classList.remove('text-gray-400', 'hover:text-white');
    
    // Add animation effect
    const leaderboardContent = document.getElementById(tabName + '-leaderboard');
    leaderboardContent.style.opacity = '0';
    leaderboardContent.style.transform = 'translateY(10px)';
    
    setTimeout(() => {
        leaderboardContent.style.transition = 'all 0.3s ease';
        leaderboardContent.style.opacity = '1';
        leaderboardContent.style.transform = 'translateY(0)';
    }, 50);
}

// Initialize leaderboard tabs styling
document.addEventListener('DOMContentLoaded', function() {
    // Set initial styles for all tabs
    document.querySelectorAll('.leaderboard-tab').forEach(tab => {
        if (!tab.classList.contains('active')) {
            tab.classList.add('text-gray-400', 'hover:text-white');
        } else {
            tab.classList.add('bg-ocean-500/20', 'text-ocean-400');
        }
    });
});

// Leaderboard filtering and sorting functions
function applyLeaderboardFilter() {
    const filter = document.getElementById('leaderboard-filter').value;
    const activeTab = document.querySelector('.leaderboard-tab.active').id.replace('-tab', '');
    
    // Show loading state
    showLeaderboardLoading(activeTab);
    
    // Simulate filtering (in real app, this would be an API call)
    setTimeout(() => {
        console.log('Applying filter:', filter, 'for tab:', activeTab);
        hideLeaderboardLoading(activeTab);
        showNotification('Filter applied: ' + getFilterLabel(filter), 'info');
    }, 500);
}

function applyLeaderboardSort() {
    const sort = document.getElementById('leaderboard-sort').value;
    const activeTab = document.querySelector('.leaderboard-tab.active').id.replace('-tab', '');
    
    // Show loading state
    showLeaderboardLoading(activeTab);
    
    // Simulate sorting (in real app, this would be an API call)
    setTimeout(() => {
        console.log('Applying sort:', sort, 'for tab:', activeTab);
        hideLeaderboardLoading(activeTab);
        showNotification('Sorted by: ' + getSortLabel(sort), 'info');
    }, 500);
}

function applyLeaderboardTimeFilter() {
    const time = document.getElementById('leaderboard-time').value;
    const activeTab = document.querySelector('.leaderboard-tab.active').id.replace('-tab', '');
    
    // Show loading state
    showLeaderboardLoading(activeTab);
    
    // Simulate time filtering (in real app, this would be an API call)
    setTimeout(() => {
        console.log('Applying time filter:', time, 'for tab:', activeTab);
        hideLeaderboardLoading(activeTab);
        showNotification('Time filter: ' + getTimeLabel(time), 'info');
    }, 500);
}

function refreshLeaderboard() {
    const activeTab = document.querySelector('.leaderboard-tab.active').id.replace('-tab', '');
    const refreshButton = document.querySelector('button[onclick="refreshLeaderboard()"]');
    const refreshIcon = refreshButton.querySelector('i');
    
    // Show loading state
    refreshIcon.classList.add('animate-spin');
    refreshButton.disabled = true;
    showLeaderboardLoading(activeTab);
    
    // Simulate refresh (in real app, this would be an API call)
    setTimeout(() => {
        refreshIcon.classList.remove('animate-spin');
        refreshButton.disabled = false;
        hideLeaderboardLoading(activeTab);
        showNotification('Leaderboard refreshed successfully!', 'success');
        
        // Add a subtle animation to indicate refresh
        const leaderboardContent = document.getElementById(activeTab + '-leaderboard');
        leaderboardContent.style.transform = 'scale(0.98)';
        setTimeout(() => {
            leaderboardContent.style.transform = 'scale(1)';
        }, 200);
    }, 1000);
}

function showLeaderboardLoading(tabName) {
    const leaderboardContent = document.getElementById(tabName + '-leaderboard');
    const existingOverlay = leaderboardContent.querySelector('.loading-overlay');
    
    if (!existingOverlay) {
        const overlay = document.createElement('div');
        overlay.className = 'loading-overlay absolute inset-0 bg-deep-900/50 flex items-center justify-center rounded-lg z-10';
        overlay.innerHTML = `
            <div class="flex items-center gap-3 text-white">
                <i class="fas fa-spinner animate-spin text-xl"></i>
                <span class="text-sm font-medium">Loading...</span>
            </div>
        `;
        leaderboardContent.style.position = 'relative';
        leaderboardContent.appendChild(overlay);
    }
}

function hideLeaderboardLoading(tabName) {
    const leaderboardContent = document.getElementById(tabName + '-leaderboard');
    const overlay = leaderboardContent.querySelector('.loading-overlay');
    
    if (overlay) {
        overlay.remove();
    }
}

function getFilterLabel(filter) {
    const labels = {
        'all': 'All Players',
        'friends': 'Friends',
        'recent': 'Recent Players'
    };
    return labels[filter] || filter;
}

function getSortLabel(sort) {
    const labels = {
        'score': 'Score',
        'accuracy': 'Accuracy',
        'games': 'Games Played',
        'recent': 'Most Recent'
    };
    return labels[sort] || sort;
}

function getTimeLabel(time) {
    const labels = {
        'all': 'All Time',
        'month': 'This Month',
        'week': 'This Week',
        'today': 'Today'
    };
    return labels[time] || time;
}

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    const bgColor = type === 'success' ? 'bg-green-500/20' : type === 'error' ? 'bg-red-500/20' : 'bg-ocean-500/20';
    const textColor = type === 'success' ? 'text-green-400' : type === 'error' ? 'text-red-400' : 'text-ocean-400';
    const icon = type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle';
    
    notification.className = `fixed top-4 right-4 ${bgColor} ${textColor} px-4 py-3 rounded-lg border border-current/30 z-50 flex items-center gap-2 shadow-lg`;
    notification.innerHTML = `
        <i class="fas ${icon}"></i>
        <span class="text-sm font-medium">${message}</span>
    `;
    
    document.body.appendChild(notification);
    
    // Animate in
    notification.style.transform = 'translateX(100%)';
    notification.style.transition = 'transform 0.3s ease';
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 10);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 3000);
}

// Real-time leaderboard updates
let leaderboardUpdateInterval;
let currentLeaderboardData = {
    overall: [],
    quiz: [],
    word_scramble: []
};

// Initialize real-time updates
function initializeRealTimeUpdates() {
    // Update leaderboards every 30 seconds
    leaderboardUpdateInterval = setInterval(() => {
        updateAllLeaderboards();
    }, 30000);
    
    // Initial update
    updateAllLeaderboards();
    
    // Add visibility change listener to pause updates when tab is not visible
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
            clearInterval(leaderboardUpdateInterval);
        } else {
            initializeRealTimeUpdates();
        }
    });
}

// Update all leaderboards with real-time data
function updateAllLeaderboards() {
    const activeTab = document.querySelector('.leaderboard-tab.active').id.replace('-tab', '');
    
    // Simulate API calls to get updated leaderboard data
    ['overall', 'quiz', 'word_scramble'].forEach(type => {
        simulateLeaderboardUpdate(type);
    });
}

// Simulate leaderboard update (in real app, this would fetch from API)
function simulateLeaderboardUpdate(type) {
    // Show subtle loading indicator
    const liveIndicator = document.querySelector('.fa-sync-alt.animate-spin');
    if (liveIndicator) {
        liveIndicator.style.opacity = '0.7';
    }
    
    setTimeout(() => {
        // Simulate data changes
        const leaderboardElement = document.getElementById(`${type}-leaderboard-list`);
        if (leaderboardElement) {
            // Add subtle animation to indicate update
            leaderboardElement.style.transition = 'opacity 0.3s ease';
            leaderboardElement.style.opacity = '0.8';
            
            setTimeout(() => {
                leaderboardElement.style.opacity = '1';
                
                // Add rank change animations if positions changed
                animateRankChanges(type);
            }, 300);
        }
        
        if (liveIndicator) {
            liveIndicator.style.opacity = '1';
        }
    }, 1000);
}

// Animate rank changes in leaderboards
function animateRankChanges(type) {
    const leaderboardItems = document.querySelectorAll(`#${type}-leaderboard .leaderboard-content > div:last-child > div`);
    
    leaderboardItems.forEach((item, index) => {
        // Add subtle pulse animation to rank badges
        const rankBadge = item.querySelector('.rounded-full');
        if (rankBadge && Math.random() > 0.7) { // Random chance for animation
            rankBadge.style.transition = 'transform 0.5s ease';
            rankBadge.style.transform = 'scale(1.1)';
            setTimeout(() => {
                rankBadge.style.transform = 'scale(1)';
            }, 500);
        }
        
        // Add score update animation
        const scoreElement = item.querySelector('.text-green-400');
        if (scoreElement && Math.random() > 0.8) { // Random chance for animation
            const originalScore = scoreElement.textContent;
            scoreElement.style.transition = 'color 0.3s ease';
            scoreElement.style.color = '#fbbf24'; // Yellow for update
            setTimeout(() => {
                scoreElement.style.color = '#4ade80'; // Back to green
            }, 1000);
        }
    });
}

// Enhanced leaderboard entry animations
function animateLeaderboardEntry(entry, delay = 0) {
    entry.style.opacity = '0';
    entry.style.transform = 'translateX(-20px)';
    entry.style.transition = 'all 0.4s ease';
    
    setTimeout(() => {
        entry.style.opacity = '1';
        entry.style.transform = 'translateX(0)';
    }, delay);
}

// Add hover effects and micro-interactions
function enhanceLeaderboardInteractions() {
    const leaderboardEntries = document.querySelectorAll('.leaderboard-content > div:last-child > div');
    
    leaderboardEntries.forEach((entry, index) => {
        // Add staggered entrance animation
        animateLeaderboardEntry(entry, index * 50);
        
        // Enhanced hover effects
        entry.addEventListener('mouseenter', () => {
            entry.style.transform = 'translateX(4px)';
            entry.style.boxShadow = '0 4px 12px rgba(59, 130, 246, 0.2)';
        });
        
        entry.addEventListener('mouseleave', () => {
            entry.style.transform = 'translateX(0)';
            entry.style.boxShadow = 'none';
        });
        
        // Add click ripple effect
        entry.addEventListener('click', (e) => {
            const ripple = document.createElement('div');
            ripple.className = 'absolute inset-0 bg-white/10 rounded-lg pointer-events-none';
            ripple.style.opacity = '0';
            ripple.style.transform = 'scale(0.8)';
            ripple.style.transition = 'all 0.3s ease';
            
            entry.style.position = 'relative';
            entry.appendChild(ripple);
            
            setTimeout(() => {
                ripple.style.opacity = '1';
                ripple.style.transform = 'scale(1)';
            }, 10);
            
            setTimeout(() => {
                ripple.style.opacity = '0';
                ripple.style.transform = 'scale(1.1)';
                setTimeout(() => {
                    if (ripple.parentNode) {
                        ripple.parentNode.removeChild(ripple);
                    }
                }, 300);
            }, 200);
        });
    });
}

// Initialize enhanced interactions when tabs are switched
function initializeEnhancedInteractions() {
    // Initialize for active tab
    const activeTab = document.querySelector('.leaderboard-tab.active');
    if (activeTab) {
        const tabName = activeTab.id.replace('-tab', '');
        setTimeout(() => {
            enhanceLeaderboardInteractions();
        }, 100);
    }
}

// Modify the existing showLeaderboardTab function to include enhanced interactions
const originalShowLeaderboardTab = showLeaderboardTab;
showLeaderboardTab = function(tabName) {
    // Call original function
    originalShowLeaderboardTab(tabName);
    
    // Add enhanced interactions after tab switch
    setTimeout(() => {
        enhanceLeaderboardInteractions();
    }, 350);
};

// Initialize everything when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Set initial styles for all tabs
    document.querySelectorAll('.leaderboard-tab').forEach(tab => {
        if (!tab.classList.contains('active')) {
            tab.classList.add('text-gray-400', 'hover:text-white');
        } else {
            tab.classList.add('bg-ocean-500/20', 'text-ocean-400');
        }
    });
    
    // Initialize real-time updates
    initializeRealTimeUpdates();
    
    // Initialize enhanced interactions
    initializeEnhancedInteractions();
    
    // Add periodic pulse animation to live indicator
    const liveIndicator = document.querySelector('.fa-sync-alt.animate-spin');
    if (liveIndicator) {
        setInterval(() => {
            liveIndicator.style.transform = 'scale(1.2)';
            setTimeout(() => {
                liveIndicator.style.transform = 'scale(1)';
            }, 500);
        }, 5000);
    }
});
</script>
@endsection

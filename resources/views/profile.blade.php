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
<div class="min-h-screen py-24 px-4">
    <div class="max-w-6xl mx-auto">
        <!-- Header Section -->
        <div class="glass-dark rounded-2xl p-8 mb-8 border border-ocean-500/30 shadow-xl">
            <div class="text-center">
                <h1 class="text-4xl font-bold bg-gradient-to-r from-ocean-400 via-ocean-300 to-teal-400 bg-clip-text text-transparent mb-2 cinzel-heading">
                    My Profile
                </h1>
                <p class="text-gray-300 text-lg cinzel-body">Manage your account and track your conservation journey</p>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-500/20 border border-green-500/50 rounded-xl text-green-100 text-sm backdrop-blur-sm">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-500/20 border border-red-500/50 rounded-xl text-red-100 text-sm backdrop-blur-sm">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                {{ session('error') }}
            </div>
        @endif

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Sidebar - Profile Card & Quick Stats -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Profile Card -->
                <div class="glass-dark rounded-2xl p-6 border border-ocean-500/30">
                    <div class="text-center">
                        <div class="relative inline-block mb-4">
                            <div class="relative">
                                @if(auth()->user()->profile_picture)
                                    <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" 
                                         alt="Profile Picture" 
                                         class="w-24 h-24 rounded-full object-cover shadow-lg border-4 border-ocean-500/30 mx-auto"
                                         onerror="this.onerror=null; this.src='{{ asset('images/default-avatar.png') }}';">
                                @else
                                    <div class="w-24 h-24 bg-gradient-to-br from-ocean-400 to-ocean-600 rounded-full flex items-center justify-center text-3xl font-bold text-white shadow-lg mx-auto">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            
@php
    $overallRank = auth()->user()->getOverallRank();
    $userBadge = getRankBadge($overallRank);
@endphp
                            <!-- Enhanced Rank Badge -->
                            @if($userBadge)
                                <div class="absolute -bottom-1 -right-1 group">
                                    <!-- Badge with pulse animation -->
                                    <div class="relative">
                                        <!-- Outer glow effect -->
                                        <div class="absolute inset-0 {{ str_replace(['border-2', 'bg-gradient-to-r'], ['border-4', 'bg-gradient-to-r'], $userBadge['class']) }} rounded-full animate-pulse opacity-60"></div>
                                        <!-- Main badge -->
                                        <div class="relative w-10 h-10 rounded-full {{ $userBadge['class'] }} border-4 border-deep-900 flex items-center justify-center shadow-lg transform transition-all duration-300 group-hover:scale-110 group-hover:shadow-xl">
                                            <span class="text-sm font-bold drop-shadow-lg">{{ $userBadge['icon'] }}</span>
                                        </div>
                                        <!-- Rank tooltip -->
                                        <div class="absolute bottom-full right-0 mb-2 px-2 py-1 bg-deep-800 text-white text-xs rounded-lg border border-white/20 whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                                            <div class="font-semibold">{{ $userBadge['title'] }}</div>
                                            <div class="text-gray-400">Rank #{{ $overallRank }}</div>
                                            <!-- Tooltip arrow -->
                                            <div class="absolute top-full right-2 w-0 h-0 border-l-4 border-r-4 border-t-4 border-l-transparent border-r-transparent border-t-deep-800"></div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <!-- Verification Badge -->
                                <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-green-500 rounded-full border-4 border-deep-900 flex items-center justify-center">
                                    <i class="fas fa-check text-white text-xs"></i>
                                </div>
                            @endif
                            
                            <!-- Upload Button Overlay -->
                            <div class="absolute inset-0 bg-black/30 rounded-full opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-center justify-center cursor-pointer backdrop-blur-sm" onclick="document.getElementById('profilePictureInput').click()">
                                <div class="text-center">
                                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center mb-1">
                                        <i class="fas fa-camera text-white"></i>
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
                                    <i class="fas fa-spinner fa-spin text-xl mb-1"></i>
                                    <div class="text-xs">Uploading...</div>
                                </div>
                            </div>
                        </div>
                        
                        <h2 class="text-xl font-bold text-white mb-1 cinzel-subheading">{{ auth()->user()->name }}</h2>
                        <p class="text-gray-400 text-sm mb-3 cinzel-text">{{ auth()->user()->email }}</p>
                        
                        <div class="flex justify-center gap-2 mb-3">
                            {!! auth()->user()->getVerificationStatusBadge() !!}
                            <span class="px-2 py-1 bg-green-500/20 text-green-400 rounded-full text-xs border border-green-500/30">
                                <i class="fas fa-leaf mr-1"></i>
                                Conservationist
                            </span>
                        </div>
                        
                        <div class="text-xs text-gray-400 cinzel-text">
                            <i class="fas fa-calendar-alt mr-1"></i>
                            Member since {{ auth()->user()->created_at->format('M j, Y') }}
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="glass-dark rounded-2xl p-6 border border-ocean-500/30">
                    <h3 class="text-lg font-bold text-white mb-4 cinzel-subheading">
                        <i class="fas fa-chart-line mr-2 text-ocean-400"></i>
                        Quick Stats
                    </h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-sm cinzel-text">Games Played</span>
                            <span class="text-xl font-bold text-ocean-400" data-stat="total-games">{{ auth()->user()->total_games_played ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-sm cinzel-text">Total Score</span>
                            <span class="text-xl font-bold text-green-400" data-stat="total-score">{{ auth()->user()->total_score ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-sm cinzel-text">Achievements</span>
                            <span class="text-xl font-bold text-yellow-400">{{ auth()->user()->achievements_count ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-sm cinzel-text">Learning Streak</span>
                            <span class="text-xl font-bold text-orange-400">{{ auth()->user()->learning_streak ?? 0 }} days</span>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="glass-dark rounded-2xl p-6 border border-ocean-500/30">
                    <h3 class="text-lg font-bold text-white mb-4 cinzel-subheading">
                        <i class="fas fa-history mr-2 text-ocean-400"></i>
                        Recent Activity
                    </h3>
                    <div class="space-y-2" id="recent-activities">
                        @php
                            $recentActivities = auth()->user()->getRecentActivities(5);
                        @endphp
                        
                        @if($recentActivities->count() > 0)
                            @foreach($recentActivities as $activity)
                                <div class="flex items-center gap-2 text-xs">
                                    <div class="w-1.5 h-1.5 {{ $activity->game_type === 'quiz' ? 'bg-blue-400' : ($activity->game_type === 'word_scramble' ? 'bg-green-400' : 'bg-purple-400') }} rounded-full"></div>
                                    <span class="text-gray-400 truncate">
                                        @if($activity->game_type === 'quiz')
                                            Turtle Quiz
                                        @elseif($activity->game_type === 'word_scramble')
                                            Word Scramble
                                        @else
                                            {{ $activity->game_name }}
                                        @endif
                                        ({{ $activity->score }} pts)
                                    </span>
                                    <span class="text-gray-500 ml-auto whitespace-nowrap">{{ $activity->created_at->diffForHumans() }}</span>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-3">
                                <div class="text-gray-400 text-xs">No activities yet. Start playing!</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Content - Main Dashboard -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Account Information -->
                <div class="glass-dark rounded-2xl p-6 border border-ocean-500/30">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold text-white">
                            <i class="fas fa-user-edit mr-2 text-ocean-400"></i>
                            Account Information
                        </h3>
                        <button id="editProfileBtn" class="bg-ocean-500 hover:bg-ocean-600 text-white px-3 py-1.5 rounded-lg text-sm transition-colors">
                            <i class="fas fa-edit mr-1"></i>
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
                                       class="w-full bg-deep-800/50 border border-deep-700 rounded-lg px-3 py-2 text-white text-sm focus:border-ocean-500 focus:outline-none transition-colors">
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
                                        <i class="fas fa-eye text-xs" id="password-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-3 mt-4">
                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                                <i class="fas fa-save mr-1"></i>
                                Save Changes
                            </button>
                            <button type="button" id="cancelEditBtn" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                                <i class="fas fa-times mr-1"></i>
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Gaming Dashboard -->
                <div class="glass-dark rounded-2xl p-6 border border-ocean-500/30">
                    <h3 class="text-xl font-bold text-white mb-4">
                        <i class="fas fa-gamepad mr-2 text-ocean-400"></i>
                        Gaming Dashboard
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <!-- Turtle Quiz Progress -->
                        <div class="bg-gradient-to-br from-blue-500/10 to-blue-600/10 rounded-xl p-4 border border-blue-500/20">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-brain text-blue-400"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-white font-semibold text-sm">Turtle Quiz</h4>
                                        <p class="text-gray-300 text-xs">Test your knowledge</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-xl font-bold text-blue-400">{{ auth()->user()->getBestScoreForGame('quiz') }}</div>
                                    <div class="text-xs text-gray-300">best score</div>
                                </div>
                            </div>
                            
                            @php
                                $quizActivities = auth()->user()->gameActivities()->byGameType('quiz')->completed();
                                $quizGamesPlayed = $quizActivities->count();
                                $quizAccuracy = $quizActivities->avg('accuracy') ?? 0;
                            @endphp
                            
                            <div class="grid grid-cols-3 gap-2 mb-3">
                                <div class="text-center">
                                    <div class="text-lg font-bold text-white">{{ $quizGamesPlayed }}</div>
                                    <div class="text-xs text-gray-300">Games</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-lg font-bold text-green-400">{{ $quizActivities->sum('correct_answers') }}</div>
                                    <div class="text-xs text-gray-300">Correct</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-lg font-bold text-yellow-400">{{ number_format($quizAccuracy, 0) }}%</div>
                                    <div class="text-xs text-gray-300">Accuracy</div>
                                </div>
                            </div>
                            
                            <div class="w-full bg-deep-800/50 rounded-full h-2">
                                <div class="bg-gradient-to-r from-blue-400 to-blue-600 h-2 rounded-full transition-all duration-300" style="width: {{ min($quizAccuracy, 100) }}%"></div>
                            </div>
                        </div>
                        
                        <!-- Word Scramble Progress -->
                        <div class="bg-gradient-to-br from-green-500/10 to-green-600/10 rounded-xl p-4 border border-green-500/20">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 bg-green-500/20 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-spell-check text-green-400"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-white font-semibold text-sm">Word Scramble</h4>
                                        <p class="text-gray-300 text-xs">Unscramble words</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-xl font-bold text-green-400">{{ auth()->user()->getBestScoreForGame('word_scramble') }}</div>
                                    <div class="text-xs text-gray-300">best score</div>
                                </div>
                            </div>
                            
                            @php
                                $wordScrambleActivities = auth()->user()->gameActivities()->byGameType('word_scramble')->completed();
                                $wordScrambleGamesPlayed = $wordScrambleActivities->count();
                                $wordScrambleAccuracy = $wordScrambleActivities->avg('accuracy') ?? 0;
                            @endphp
                            
                            <div class="grid grid-cols-3 gap-2 mb-3">
                                <div class="text-center">
                                    <div class="text-lg font-bold text-white">{{ $wordScrambleGamesPlayed }}</div>
                                    <div class="text-xs text-gray-300">Games</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-lg font-bold text-green-400">{{ $wordScrambleActivities->sum('correct_answers') }}</div>
                                    <div class="text-xs text-gray-300">Correct</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-lg font-bold text-yellow-400">{{ number_format($wordScrambleAccuracy, 0) }}%</div>
                                    <div class="text-xs text-gray-300">Accuracy</div>
                                </div>
                            </div>
                            
                            <div class="w-full bg-deep-800/50 rounded-full h-2">
                                <div class="bg-gradient-to-r from-green-400 to-green-600 h-2 rounded-full transition-all duration-300" style="width: {{ min($wordScrambleAccuracy, 100) }}%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <a href="/games" class="flex-1 bg-gradient-to-r from-ocean-500 to-ocean-600 hover:from-ocean-600 hover:to-ocean-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-300 text-center text-sm">
                            <i class="fas fa-play mr-2"></i>
                            Play Games
                        </a>
                    </div>
                </div>

                <!-- Recent Game Sessions -->
                <div class="glass-dark rounded-2xl p-6 border border-ocean-500/30">
                    <h3 class="text-xl font-bold text-white mb-4">
                        <i class="fas fa-history mr-2 text-ocean-400"></i>
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
                                        <div class="w-8 h-8 rounded-full bg-ocean-500/20 flex items-center justify-center">
                                            @if($session->game_type === 'quiz')
                                                <i class="fas fa-brain text-blue-400 text-sm"></i>
                                            @elseif($session->game_type === 'word_scramble')
                                                <i class="fas fa-spell-check text-green-400 text-sm"></i>
                                            @else
                                                <i class="fas fa-gamepad text-purple-400 text-sm"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="text-white font-medium text-sm">{{ $session->game_name }}</div>
                                            <div class="text-gray-300 text-xs">{{ $session->played_at->format('M j, g:i A') }}</div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-green-400 font-bold text-sm">{{ $session->score }} pts</div>
                                        <div class="text-gray-300 text-xs">{{ number_format($session->accuracy, 0) }}%</div>
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

                <!-- Leaderboards Preview -->
                <div class="glass-dark rounded-2xl p-6 border border-ocean-500/30">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-white">
                            <i class="fas fa-crown mr-2 text-yellow-400"></i>
                            Your Rankings
                        </h3>
                        <a href="{{ route('leaderboards') }}" class="bg-ocean-500/20 hover:bg-ocean-500/30 text-ocean-400 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-300 flex items-center gap-2">
                            <i class="fas fa-external-link-alt"></i>
                            View Full Leaderboards
                        </a>
                    </div>

                    <!-- Quick Stats Summary -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <!-- Overall Rank -->
                        <div class="bg-gradient-to-br from-yellow-500/10 to-orange-500/10 rounded-xl p-4 border border-yellow-500/20">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-300 mb-1">Overall Rank</h4>
                                    <p class="text-2xl font-bold text-yellow-400">
                                        @php
                                            $overallRank = auth()->user()->getOverallRank();
                                        @endphp
                                        #{{ $overallRank ?: 'N/A' }}
                                    </p>
                                </div>
                                <div class="text-3xl">🏆</div>
                            </div>
                        </div>

                        <!-- Quiz Rank -->
                        <div class="bg-gradient-to-br from-blue-500/10 to-purple-500/10 rounded-xl p-4 border border-blue-500/20">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-300 mb-1">Quiz Rank</h4>
                                    <p class="text-2xl font-bold text-blue-400">
                                        @php
                                            $quizRank = auth()->user()->getGameRank('quiz');
                                        @endphp
                                        #{{ $quizRank ?: 'N/A' }}
                                    </p>
                                </div>
                                <div class="text-3xl">🧠</div>
                            </div>
                        </div>

                        <!-- Word Scramble Rank -->
                        <div class="bg-gradient-to-br from-green-500/10 to-emerald-500/10 rounded-xl p-4 border border-green-500/20">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-300 mb-1">Word Scramble Rank</h4>
                                    <p class="text-2xl font-bold text-green-400">
                                        @php
                                            $wordScrambleRank = auth()->user()->getGameRank('word_scramble');
                                        @endphp
                                        #{{ $wordScrambleRank ?: 'N/A' }}
                                    </p>
                                </div>
                                <div class="text-3xl">🔤</div>
                            </div>
                        </div>
                    </div>

                    <!-- Top 3 Preview -->
                    <div class="text-center mb-4">
                        <p class="text-gray-300 text-sm">See where you stand among the top players!</p>
                    </div>

                    <div class="flex justify-center">
                        <a href="{{ route('leaderboards') }}" class="bg-gradient-to-r from-ocean-500 to-ocean-600 hover:from-ocean-600 hover:to-ocean-700 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300 text-center inline-flex items-center gap-2">
                            <i class="fas fa-trophy"></i>
                            View Complete Leaderboards
                        </a>
                    </div>
                </div>

                <!-- Account Benefits -->
                <div class="glass-dark rounded-2xl p-6 border border-ocean-500/30">
                    <h3 class="text-xl font-bold text-white mb-4">
                        <i class="fas fa-star mr-2 text-ocean-400"></i>
                        Account Benefits
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-ocean-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-gamepad text-ocean-400"></i>
                            </div>
                            <div>
                                <h4 class="text-white font-semibold mb-1 text-sm">Mini-Games Access</h4>
                                <p class="text-gray-300 text-xs">Play educational turtle conservation games</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-green-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-save text-green-400"></i>
                            </div>
                            <div>
                                <h4 class="text-white font-semibold mb-1 text-sm">Progress Saving</h4>
                                <p class="text-gray-300 text-xs">Save your progress and continue learning</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-yellow-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-chart-line text-yellow-400"></i>
                            </div>
                            <div>
                                <h4 class="text-white font-semibold mb-1 text-sm">Personalized Dashboard</h4>
                                <p class="text-gray-300 text-xs">View detailed analytics of your journey</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-purple-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-trophy text-purple-400"></i>
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
    const totalScoreElements = document.querySelectorAll('[data-stat="total-score"]');
    totalScoreElements.forEach(element => {
        element.textContent = stats.total_score || 0;
    });
    
    // Update total games played
    const totalGamesElements = document.querySelectorAll('[data-stat="total-games"]');
    totalGamesElements.forEach(element => {
        element.textContent = stats.total_games_played || 0;
    });
}

// Listen for custom events from game activity updates
document.addEventListener('userStatsUpdated', function(event) {
    updateUserStats(event.detail);
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

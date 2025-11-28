@extends('layouts.app')

@section('title', 'Leaderboards - Pawikan Patrol')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 py-8 relative overflow-hidden">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <!-- Floating particles -->
        <div class="absolute top-20 left-10 w-2 h-2 bg-blue-400 rounded-full animate-float opacity-20"></div>
        <div class="absolute top-40 right-20 w-3 h-3 bg-teal-400 rounded-full animate-float animation-delay-2000 opacity-30"></div>
        <div class="absolute bottom-40 left-1/4 w-2 h-2 bg-cyan-400 rounded-full animate-float animation-delay-4000 opacity-25"></div>
        <div class="absolute bottom-60 right-1/3 w-4 h-4 bg-emerald-400 rounded-full animate-float animation-delay-6000 opacity-20"></div>
        <div class="absolute top-1/3 left-3/4 w-2 h-2 bg-sky-400 rounded-full animate-float animation-delay-8000 opacity-30"></div>
        
        <!-- Gradient overlays -->
        <div class="absolute inset-0 bg-gradient-to-br from-blue-900/20 via-teal-900/20 to-cyan-900/20 animate-pulse-slow"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-blue-900/10 via-teal-900/5 to-transparent"></div>
        
        <!-- Animated grid pattern -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px); background-size: 50px 50px;"></div>
        </div>
    </div>
    
    <div class="container mx-auto px-4 max-w-6xl relative z-10">
        <!-- Header with Live Indicator -->
        <div class="text-center mb-12 relative mt-20">    
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-blue-500 via-teal-500 to-cyan-500 rounded-full mb-6 shadow-2xl transform hover:scale-110 transition-all duration-300 border border-white/20 backdrop-blur-sm">
                <span class="text-3xl animate-bounce">🏆</span>
            </div>
            <h1 class="text-5xl md:text-6xl font-bold text-white mb-4 bg-gradient-to-r from-blue-400 via-teal-400 to-cyan-400 bg-clip-text text-transparent drop-shadow-lg cinzel-heading">Leaderboards</h1>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto cinzel-body">Compete with the best players and climb your way to the top of the rankings</p>
        </div>  

        <!-- Your Rankings Summary with Social Sharing -->
        <div class="mb-12">
            <h2 class="text-3xl font-bold text-white mb-8 text-center drop-shadow-lg cinzel-subheading">Your Current Rankings</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Overall Rank -->
                <div class="bg-white/10 backdrop-blur-md rounded-2xl shadow-2xl p-6 text-center transform hover:scale-105 transition-all duration-200 border border-white/20 relative overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-r from-yellow-400/20 to-orange-500/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative z-10">
                        @php
                            $overallRank = auth()->user()->getOverallRank();
                            $overallScore = auth()->user()->total_score;
                        @endphp
                        <div class="inline-flex items-center justify-center w-14 h-14 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full mb-4 shadow-lg border border-white/20">
                            <span class="text-2xl">🏆</span>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-2">Overall</h3>
                        <div class="text-4xl font-bold bg-gradient-to-r from-yellow-400 to-orange-500 bg-clip-text text-transparent mb-1">
                            #{{ $overallRank }}
                        </div>
                        <div class="text-sm text-gray-300 mb-3">{{ number_format($overallScore) }} points</div>
                    </div>
                </div>
                
                <!-- Quiz Rank -->
                <div class="bg-white/10 backdrop-blur-md rounded-2xl shadow-2xl p-6 text-center transform hover:scale-105 transition-all duration-200 border border-white/20 relative overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-400/20 to-indigo-500/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative z-10">
                        @php
                            $quizRank = auth()->user()->getGameRank('quiz');
                            $quizScore = auth()->user()->getBestScoreForGame('quiz');
                        @endphp
                        <div class="inline-flex items-center justify-center w-14 h-14 bg-gradient-to-r from-blue-400 to-indigo-500 rounded-full mb-4 shadow-lg border border-white/20">
                            <span class="text-2xl">🧠</span>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-2">Quiz</h3>
                        <div class="text-4xl font-bold bg-gradient-to-r from-blue-400 to-indigo-500 bg-clip-text text-transparent mb-1">
                            #{{ $quizRank }}
                        </div>
                        <div class="text-sm text-gray-300 mb-3">{{ number_format($quizScore) }} points</div>
                    </div>
                </div>
                
                <!-- Word Scramble Rank -->
                <div class="bg-white/10 backdrop-blur-md rounded-2xl shadow-2xl p-6 text-center transform hover:scale-105 transition-all duration-200 border border-white/20 relative overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-r from-green-400/20 to-emerald-500/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative z-10">
                        @php
                            $wordScrambleRank = auth()->user()->getGameRank('word_scramble');
                            $wordScrambleScore = auth()->user()->getBestScoreForGame('word_scramble');
                        @endphp
                        <div class="inline-flex items-center justify-center w-14 h-14 bg-gradient-to-r from-green-400 to-emerald-500 rounded-full mb-4 shadow-lg border border-white/20">
                            <span class="text-2xl">📝</span>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-2">Word Scramble</h3>
                        <div class="text-4xl font-bold bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent mb-1">
                            #{{ $wordScrambleRank }}
                        </div>
                        <div class="text-sm text-gray-300 mb-3">{{ number_format($wordScrambleScore) }} points</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Leaderboards Container -->
        <div class="bg-white/10 backdrop-blur-md rounded-2xl shadow-2xl border border-white/20 overflow-hidden relative">
            <!-- Auto-refresh Controls -->
            <div class="absolute top-4 right-4 z-10 flex items-center gap-2">
                <div class="flex items-center gap-2 px-3 py-1 bg-white/10 backdrop-blur-sm rounded-lg text-sm border border-white/20">
                    <span class="text-gray-300">Auto-refresh:</span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="autoRefreshToggle" class="sr-only peer" checked>
                        <div class="w-11 h-6 bg-gray-600 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>
                <div class="text-sm text-gray-300">
                    <span id="refreshCountdown">30</span>s
                </div>
            </div>
            
            <!-- Tab Navigation -->
            <div class="flex flex-col sm:flex-row justify-center gap-2 p-6 bg-white/5 backdrop-blur-sm border-b border-white/10">
                <button class="tab-button active flex-1 sm:flex-none px-6 py-3 bg-gradient-to-r from-blue-500/80 to-indigo-600/80 backdrop-blur-sm text-white rounded-xl font-semibold text-sm shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105 border border-white/20" data-tab="overall" onclick="playTabSound()">
                    <span class="flex items-center justify-center gap-2">
                        <span class="animate-pulse">🏆</span>
                        <span>Overall</span>
                        <span class="tab-indicator hidden bg-red-500 text-white text-xs px-2 py-1 rounded-full">New</span>
                    </span>
                </button>
                <button class="tab-button flex-1 sm:flex-none px-6 py-3 bg-white/10 backdrop-blur-sm text-white/80 rounded-xl font-semibold text-sm border border-white/20 hover:bg-white/20 transition-all duration-200 transform hover:scale-105" data-tab="quiz" onclick="playTabSound()">
                    <span class="flex items-center justify-center gap-2">
                        <span>🧠</span>
                        <span>Quiz</span>
                        <span class="tab-indicator hidden bg-red-500 text-white text-xs px-2 py-1 rounded-full">New</span>
                    </span>
                </button>
                <button class="tab-button flex-1 sm:flex-none px-6 py-3 bg-white/10 backdrop-blur-sm text-white/80 rounded-xl font-semibold text-sm border border-white/20 hover:bg-white/20 transition-all duration-200 transform hover:scale-105" data-tab="word-scramble" onclick="playTabSound()">
                    <span class="flex items-center justify-center gap-2">
                        <span>📝</span>
                        <span>Word Scramble</span>
                        <span class="tab-indicator hidden bg-red-500 text-white text-xs px-2 py-1 rounded-full">New</span>
                    </span>
                </button>
            </div>

            <!-- Tab Content Container -->
            <div class="tab-content-container">
                <!-- Overall Leaderboard -->
                <div class="leaderboard-content active" data-content="overall">
                    <div class="p-6">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                            <div>
                                <h2 class="text-2xl font-bold text-white mb-1 drop-shadow-lg">Overall Rankings</h2>
                                <p class="text-gray-300">Top performers across all games</p>
                            </div>
                            
                            <!-- Enhanced Controls -->
                            <div class="flex flex-wrap gap-2">
                                <select id="overallTimeRange" class="px-4 py-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-lg text-sm text-black focus:ring-2 focus:ring-blue-500 focus:border-transparent hover:bg-white/20 transition-all duration-200" onchange="playFilterSound()">
                                    <option value="all">🌍 All Time</option>
                                    <option value="month">📅 This Month</option>
                                    <option value="week">📆 This Week</option>
                                    <option value="today">📅 Today</option>
                                </select>
                                
                                <select id="overallSortBy" class="px-4 py-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-lg text-sm text-black focus:ring-2 focus:ring-blue-500 focus:border-transparent hover:bg-white/20 transition-all duration-200" onchange="playFilterSound()">
                                    <option value="score">🏆 Score</option>
                                    <option value="accuracy">🎯 Accuracy</option>
                                    <option value="games">🎮 Games Played</option>
                                    <option value="recent">⏰ Most Recent</option>
                                </select>
                                
                                <button id="refreshOverall" class="px-4 py-2 bg-gradient-to-r from-blue-500/80 to-indigo-600/80 backdrop-blur-sm hover:from-blue-600/80 hover:to-indigo-700/80 text-white rounded-lg text-sm font-medium transition-all duration-200 transform hover:scale-105 shadow-lg border border-white/20" onclick="refreshLeaderboard('overall')">
                                    <span class="flex items-center gap-2">
                                        <span>↻</span>
                                        <span>Refresh</span>
                                    </span>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Enhanced Leaderboard Table -->
                        <div class="overflow-x-auto rounded-lg border border-white/10 shadow-xl backdrop-blur-sm">
                            <table class="w-full">
                                <thead class="bg-white/5 backdrop-blur-sm border-b border-white/10">
                                    <tr>
                                        <th class="text-left py-4 px-6 font-semibold text-white border-b border-white/10">Rank</th>
                                        <th class="text-left py-4 px-6 font-semibold text-white border-b border-white/10">Player</th>
                                        <th class="text-right py-4 px-6 font-semibold text-white border-b border-white/10">Score</th>
                                        <th class="text-right py-4 px-6 font-semibold text-white border-b border-white/10">Games</th>
                                        <th class="text-right py-4 px-6 font-semibold text-white border-b border-white/10">Accuracy</th>
                                    </tr>
                                </thead>
                                <tbody id="overallLeaderboardBody" class="bg-white/5 backdrop-blur-sm">
                                    @if($overallLeaderboard->count() > 0)
                                        @php
                                            $currentScore = null;
                                            $currentRank = 0;
                                        @endphp
                                        @foreach($overallLeaderboard as $index => $player)
                                            @php
                                                // Handle ties by checking if score is different from previous
                                                if ($player->total_score != $currentScore) {
                                                    $currentRank = $index + 1;
                                                    $currentScore = $player->total_score;
                                                }
                                            @endphp
                                            <tr class="hover:bg-white/10 transition-all duration-150 @if(auth()->id() == $player->user_id) bg-blue-500/20 border-l-4 border-blue-400 @endif border-b border-white/5 player-row" data-player-id="{{ $player->user_id }}" data-player-name="{{ $player->name }}" data-player-score="{{ $player->total_score }}" data-player-games="{{ $player->games_played }}" data-player-accuracy="{{ number_format($player->avg_accuracy, 1) }}">
                                                <td class="py-4 px-6">
                                                    @if($currentRank <= 3)
                                                        <!-- Enhanced Rank Badge -->
                                                        <div class="relative inline-flex items-center justify-center group">
                                                            <!-- Outer glow ring -->
                                                            <div class="absolute inset-0 rounded-full animate-pulse @if($currentRank == 1) bg-yellow-400/30 @elseif($currentRank == 2) bg-gray-400/30 @else bg-orange-400/30 @endif opacity-50 blur-md"></div>
                                                            
                                                            <!-- Main badge container -->
                                                            <div class="relative inline-flex flex-col items-center">
                                                                <!-- Badge background with gradient and border -->
                                                                <div class="w-14 h-14 rounded-full @if($currentRank == 1) bg-gradient-to-br from-yellow-400/80 via-yellow-500/80 to-yellow-600/80 @elseif($currentRank == 2) bg-gradient-to-br from-gray-400/80 via-gray-500/80 to-gray-600/80 @else bg-gradient-to-br from-orange-400/80 via-orange-500/80 to-orange-600/80 @endif shadow-lg border-2 @if($currentRank == 1) border-yellow-400/50 @elseif($currentRank == 2) border-gray-400/50 @else border-orange-400/50 @endif flex items-center justify-center transform hover:scale-110 transition-all duration-300 cursor-pointer backdrop-blur-sm" onclick="playRankSound()" data-tooltip="Top {{ $currentRank }} Player - Click for details!">
                                                                    <!-- Rank number -->
                                                                    <span class="text-white font-bold text-lg drop-shadow-md">{{ $currentRank }}</span>
                                                                </div>
                                                                
                                                                <!-- Achievement crown/icon -->
                                                                @if($currentRank == 1)
                                                                    <div class="absolute -top-1 -right-1 w-6 h-6 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-full border-2 border-yellow-300/50 flex items-center justify-center shadow-lg animate-bounce backdrop-blur-sm">
                                                                        <span class="text-white text-xs">👑</span>
                                                                    </div>
                                                                @elseif($currentRank == 2)
                                                                    <div class="absolute -top-1 -right-1 w-6 h-6 bg-gradient-to-br from-gray-300 to-gray-500 rounded-full border-2 border-gray-600 flex items-center justify-center shadow-lg">
                                                                        <span class="text-white text-xs">🥈</span>
                                                                    </div>
                                                                @else
                                                                    <div class="absolute -top-1 -right-1 w-6 h-6 bg-gradient-to-br from-orange-400 to-orange-600 rounded-full border-2 border-orange-700 flex items-center justify-center shadow-lg">
                                                                        <span class="text-white text-xs">🥉</span>
                                                                    </div>
                                                                @endif
                                                                
                                                                <!-- Milestone indicator -->
                                                                <div class="mt-1 px-2 py-0.5 bg-gradient-to-r @if($currentRank == 1) from-yellow-500/80 to-yellow-600/80 @elseif($currentRank == 2) from-gray-500/80 to-gray-600/80 @else from-orange-500/80 to-orange-600/80 @endif text-white text-xs font-bold rounded-full shadow-md backdrop-blur-sm transform scale-90 border border-white/20">
                                                                    @if($currentRank == 1)
                                                                        CHAMPION
                                                                    @elseif($currentRank == 2)
                                                                        ELITE
                                                                    @else
                                                                        MASTER
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <!-- Regular rank badge with enhanced design -->
                                                        <div class="relative inline-flex items-center group">
                                                            @if($currentRank <= 10)
                                                                <!-- Top 10 special badge -->
                                                                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500/80 to-purple-600/80 rounded-full flex items-center justify-center shadow-md border-2 border-indigo-400/50 transform hover:scale-105 transition-all duration-200 cursor-pointer backdrop-blur-sm" onclick="playRankSound()" data-tooltip="Top 10 Player - Excellent performance!">
                                                                    <span class="text-white font-bold text-sm">{{ $currentRank }}</span>
                                                                </div>
                                                                <div class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 px-1.5 py-0.5 bg-indigo-600/80 text-white text-xs font-bold rounded-full whitespace-nowrap backdrop-blur-sm border border-white/20">
                                                                    TOP 10
                                                                </div>
                                                            @elseif($currentRank <= 25)
                                                                <!-- Top 25 badge -->
                                                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500/80 to-indigo-600/80 rounded-full flex items-center justify-center shadow-md border-2 border-blue-400/50 transform hover:scale-105 transition-all duration-200 cursor-pointer backdrop-blur-sm" onclick="playRankSound()" data-tooltip="Top 25 Player - Great job!">
                                                                    <span class="text-white font-bold text-sm">{{ $currentRank }}</span>
                                                                </div>
                                                                <div class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 px-1.5 py-0.5 bg-blue-600/80 text-white text-xs font-bold rounded-full whitespace-nowrap backdrop-blur-sm border border-white/20">
                                                                    TOP 25
                                                                </div>
                                                            @elseif($currentRank <= 50)
                                                                <!-- Top 50 badge -->
                                                                <div class="w-10 h-10 bg-gradient-to-br from-green-500/80 to-emerald-600/80 rounded-full flex items-center justify-center shadow-md border-2 border-green-400/50 transform hover:scale-105 transition-all duration-200 cursor-pointer backdrop-blur-sm" onclick="playRankSound()" data-tooltip="Top 50 Player - Keep it up!">
                                                                    <span class="text-white font-bold text-sm">{{ $currentRank }}</span>
                                                                </div>
                                                                <div class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 px-1.5 py-0.5 bg-green-600/80 text-white text-xs font-bold rounded-full whitespace-nowrap backdrop-blur-sm border border-white/20">
                                                                    TOP 50
                                                                </div>
                                                            @else
                                                                <!-- Regular rank -->
                                                                <span class="text-gray-300 font-semibold text-lg hover:text-white transition-colors duration-200 cursor-pointer" onclick="playRankSound()" data-tooltip="Rank #{{ $currentRank }}">#{{ $currentRank }}</span>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="py-4 px-6">
                                                    <div class="flex items-center gap-3 group">
                                                        @if($player->profile_picture)
                                                        <img src="{{ asset('storage/' . $player->profile_picture) }}"
                                                            alt="{{ $player->name }}'s Profile Picture"
                                                            class="w-10 h-10 rounded-full object-cover shadow-md transform hover:scale-110 transition-all duration-200 cursor-pointer backdrop-blur-sm border-2 border-white/20"
                                                            onclick="playClickSound()"
                                                            data-tooltip="{{ $player->name }}'s Profile Picture"
                                                            onerror="this.onerror=null; this.replaceWith(
                                                                Object.assign(document.createElement('div'), {
                                                                    className: 'w-10 h-10 bg-gradient-to-r from-blue-500/80 to-indigo-600/80 rounded-full flex items-center justify-center text-white text-sm font-bold shadow-md transform hover:scale-110 transition-all duration-200 cursor-pointer backdrop-blur-sm border border-white/20',
                                                                    onclick: playClickSound,
                                                                    dataset: { tooltip: '{{ $player->name }}\'s Avatar' },
                                                                    innerHTML: '<span class=&quot;text-lg&quot;>👤</span>'
                                                                })
                                                            );"
                                                        />

                                                        @else
                                                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500/80 to-indigo-600/80 rounded-full flex items-center justify-center text-white text-sm font-bold shadow-md transform hover:scale-110 transition-all duration-200 cursor-pointer backdrop-blur-sm border border-white/20" onclick="playClickSound()" data-tooltip="{{ $player->name }}'s Avatar">
                                                                <span class="text-lg">{{ strtoupper(substr($player->name, 0, 1)) }}</span>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <div class="font-semibold text-white group-hover:text-blue-400 transition-colors duration-200 cursor-pointer" onclick="showPlayerDetails({{ $player->user_id }}, '{{ $player->name }}')">{{ $player->name }}</div>
                                                            @if(auth()->id() == $player->user_id)
                                                                <div class="text-sm text-blue-400 font-medium animate-pulse">• You</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="py-4 px-6 text-right font-bold text-white group-hover:text-blue-400 transition-colors duration-200">
                                                    <span class="cursor-pointer" onclick="playClickSound()" data-tooltip="{{ number_format($player->total_score) }} total points">{{ number_format($player->total_score) }}</span>
                                                </td>
                                                <td class="py-4 px-6 text-right text-gray-300 group-hover:text-blue-400 transition-colors duration-200">
                                                    <span class="cursor-pointer" onclick="playClickSound()" data-tooltip="{{ $player->games_played }} games played">{{ $player->games_played }}</span>
                                                </td>
                                                <td class="py-4 px-6 text-right text-gray-300 font-medium group-hover:text-blue-400 transition-colors duration-200">
                                                    <span class="cursor-pointer" onclick="playClickSound()" data-tooltip="{{ number_format($player->avg_accuracy, 1) }}% accuracy">{{ number_format($player->avg_accuracy, 1) }}%</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="py-12 px-6 text-center text-gray-400">
                                                <div class="text-gray-500 mb-2 text-4xl animate-bounce">📊</div>
                                                <div class="font-medium text-lg text-white">No leaderboard data available</div>
                                                <div class="text-sm text-gray-300">Start playing games to appear on the leaderboard!</div>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Quiz Leaderboard -->
                <div class="leaderboard-content" data-content="quiz">
                    <div class="p-6">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                            <div>
                                <h2 class="text-2xl font-bold text-white mb-1">🧠 Quiz Rankings</h2>
                                <p class="text-gray-300">Top quiz masters and trivia experts</p>
                            </div>
                            
                            <!-- Enhanced Controls -->
                            <div class="flex flex-wrap gap-2">
                                <select id="quizTimeRange" class="px-4 py-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-lg text-sm text-black focus:ring-2 focus:ring-blue-500/50 focus:border-transparent hover:bg-white/15 transition-all duration-200" onchange="playFilterSound()">
                                    <option value="all">🌍 All Time</option>
                                    <option value="month">📅 This Month</option>
                                    <option value="week">📆 This Week</option>
                                    <option value="today">📅 Today</option>
                                </select>
                                
                                <select id="quizSortBy" class="px-4 py-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-lg text-sm text-black focus:ring-2 focus:ring-blue-500/50 focus:border-transparent hover:bg-white/15 transition-all duration-200" onchange="playFilterSound()">
                                    <option value="score">🏆 Score</option>
                                    <option value="accuracy">🎯 Accuracy</option>
                                    <option value="games">🎮 Games Played</option>
                                    <option value="recent">⏰ Most Recent</option>
                                </select>
                                
                                <button id="refreshQuiz" class="px-4 py-2 bg-gradient-to-r from-blue-500/80 to-indigo-600/80 hover:from-blue-600/80 hover:to-indigo-700/80 text-white rounded-lg text-sm font-medium transition-all duration-200 transform hover:scale-105 shadow-md backdrop-blur-sm border border-white/20" onclick="refreshLeaderboard('quiz')">
                                    <span class="flex items-center gap-2">
                                        <span>↻</span>
                                        <span>Refresh</span>
                                    </span>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Enhanced Leaderboard Table -->
                        <div class="overflow-x-auto rounded-lg border border-white/10 shadow-sm">
                            <table class="w-full">
                                <thead class="bg-gradient-to-r from-blue-500/20 to-indigo-600/20 backdrop-blur-sm">
                                    <tr>
                                        <th class="text-left py-4 px-6 font-semibold text-white border-b border-white/20">Rank</th>
                                        <th class="text-left py-4 px-6 font-semibold text-white border-b border-white/20">Player</th>
                                        <th class="text-right py-4 px-6 font-semibold text-white border-b border-white/20">Score</th>
                                        <th class="text-right py-4 px-6 font-semibold text-white border-b border-white/20">Games</th>
                                        <th class="text-right py-4 px-6 font-semibold text-white border-b border-white/20">Accuracy</th>
                                    </tr>
                                </thead>
                                <tbody id="quizLeaderboardBody">
                                    @if($quizLeaderboard->count() > 0)
                                        @php
                                            $currentScore = null;
                                            $currentRank = 0;
                                        @endphp
                                        @foreach($quizLeaderboard as $index => $player)
                                            @php
                                                // Handle ties by checking if score is different from previous
                                                if ($player->best_score != $currentScore) {
                                                    $currentRank = $index + 1;
                                                    $currentScore = $player->best_score;
                                                }
                                            @endphp
                                            <tr class="hover:bg-blue-500/10 transition-all duration-150 @if(auth()->id() == $player->user_id) bg-blue-500/20 border-l-4 border-blue-400 @endif border-b border-white/10 player-row" data-player-id="{{ $player->user_id }}" data-player-name="{{ $player->name }}" data-player-score="{{ $player->best_score }}" data-player-games="{{ $player->games_played }}" data-player-accuracy="{{ number_format($player->avg_accuracy, 1) }}">
                                                <td class="py-4 px-6">
                                                    @if($currentRank <= 3)
                                                        <!-- Enhanced Rank Badge -->
                                                        <div class="relative inline-flex items-center justify-center group">
                                                            <!-- Outer glow ring -->
                                                            <div class="absolute inset-0 rounded-full animate-pulse @if($currentRank == 1) bg-blue-400/30 @elseif($currentRank == 2) bg-indigo-400/30 @else bg-purple-400/30 @endif opacity-50 blur-md"></div>
                                                            
                                                            <!-- Main badge container -->
                                                            <div class="relative inline-flex flex-col items-center">
                                                                <!-- Badge background with gradient and border -->
                                                                <div class="w-14 h-14 rounded-full @if($currentRank == 1) bg-gradient-to-br from-blue-400/80 via-blue-500/80 to-blue-600/80 @elseif($currentRank == 2) bg-gradient-to-br from-indigo-400/80 via-indigo-500/80 to-indigo-600/80 @else bg-gradient-to-br from-purple-400/80 via-purple-500/80 to-purple-600/80 @endif shadow-lg border-2 @if($currentRank == 1) border-blue-400/50 @elseif($currentRank == 2) border-indigo-400/50 @else border-purple-400/50 @endif flex items-center justify-center transform hover:scale-110 transition-all duration-300 cursor-pointer backdrop-blur-sm" onclick="playRankSound()" data-tooltip="Top {{ $currentRank }} Quiz Master - Click for details!">
                                                                    <!-- Rank number -->
                                                                    <span class="text-white font-bold text-lg drop-shadow-md">{{ $currentRank }}</span>
                                                                </div>
                                                                
                                                                <!-- Achievement crown/icon -->
                                                                @if($currentRank == 1)
                                                                    <div class="absolute -top-1 -right-1 w-6 h-6 bg-gradient-to-br from-blue-400/80 to-blue-600/80 rounded-full border-2 border-blue-500/50 flex items-center justify-center shadow-lg animate-bounce backdrop-blur-sm">
                                                                        <span class="text-white text-xs">🧠</span>
                                                                    </div>
                                                                @elseif($currentRank == 2)
                                                                    <div class="absolute -top-1 -right-1 w-6 h-6 bg-gradient-to-br from-indigo-400/80 to-indigo-600/80 rounded-full border-2 border-indigo-500/50 flex items-center justify-center shadow-lg backdrop-blur-sm">
                                                                        <span class="text-white text-xs">🥈</span>
                                                                    </div>
                                                                @else
                                                                    <div class="absolute -top-1 -right-1 w-6 h-6 bg-gradient-to-br from-purple-400/80 to-purple-600/80 rounded-full border-2 border-purple-500/50 flex items-center justify-center shadow-lg backdrop-blur-sm">
                                                                        <span class="text-white text-xs">🥉</span>
                                                                    </div>
                                                                @endif
                                                                
                                                                <!-- Milestone indicator -->
                                                                <div class="mt-1 px-2 py-0.5 bg-gradient-to-r @if($currentRank == 1) from-blue-500/80 to-blue-600/80 @elseif($currentRank == 2) from-indigo-500/80 to-indigo-600/80 @else from-purple-500/80 to-purple-600/80 @endif text-white text-xs font-bold rounded-full shadow-md backdrop-blur-sm transform scale-90 border border-white/20">
                                                                    @if($currentRank == 1)
                                                                        GENIUS
                                                                    @elseif($currentRank == 2)
                                                                        EXPERT
                                                                    @else
                                                                        MASTER
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <!-- Regular rank badge with enhanced design -->
                                                        <div class="relative inline-flex items-center group">
                                                            @if($currentRank <= 10)
                                                                <!-- Top 10 special badge -->
                                                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500/80 to-indigo-600/80 rounded-full flex items-center justify-center shadow-md border-2 border-blue-400/50 transform hover:scale-105 transition-all duration-200 cursor-pointer backdrop-blur-sm" onclick="playRankSound()" data-tooltip="Top 10 Quiz Player - Brilliant mind!">
                                                                    <span class="text-white font-bold text-sm">{{ $currentRank }}</span>
                                                                </div>
                                                                <div class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 px-1.5 py-0.5 bg-blue-600/80 text-white text-xs font-bold rounded-full whitespace-nowrap backdrop-blur-sm border border-white/20">
                                                                    TOP 10
                                                                </div>
                                                            @elseif($currentRank <= 25)
                                                                <!-- Top 25 badge -->
                                                                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500/80 to-purple-600/80 rounded-full flex items-center justify-center shadow-md border-2 border-indigo-400/50 transform hover:scale-105 transition-all duration-200 cursor-pointer backdrop-blur-sm" onclick="playRankSound()" data-tooltip="Top 25 Quiz Player - Great knowledge!">
                                                                    <span class="text-white font-bold text-sm">{{ $currentRank }}</span>
                                                                </div>
                                                                <div class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 px-1.5 py-0.5 bg-indigo-600/80 text-white text-xs font-bold rounded-full whitespace-nowrap backdrop-blur-sm border border-white/20">
                                                                    TOP 25
                                                                </div>
                                                            @elseif($currentRank <= 50)
                                                                <!-- Top 50 badge -->
                                                                <div class="w-10 h-10 bg-gradient-to-br from-purple-500/80 to-pink-600/80 rounded-full flex items-center justify-center shadow-md border-2 border-purple-400/50 transform hover:scale-105 transition-all duration-200 cursor-pointer backdrop-blur-sm" onclick="playRankSound()" data-tooltip="Top 50 Quiz Player - Keep learning!">
                                                                    <span class="text-white font-bold text-sm">{{ $currentRank }}</span>
                                                                </div>
                                                                <div class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 px-1.5 py-0.5 bg-purple-600/80 text-white text-xs font-bold rounded-full whitespace-nowrap backdrop-blur-sm border border-white/20">
                                                                    TOP 50
                                                                </div>
                                                            @else
                                                                <!-- Regular rank -->
                                                                <span class="text-gray-300 font-semibold text-lg hover:text-white transition-colors duration-200 cursor-pointer" onclick="playRankSound()" data-tooltip="Quiz Rank #{{ $currentRank }}">#{{ $currentRank }}</span>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="py-4 px-6">
                                                    <div class="flex items-center gap-3 group">
                                                        @if($player->profile_picture)
                                                        <img src="{{ asset('storage/' . $player->profile_picture) }}"
                                                            alt="{{ $player->name }}'s Profile Picture"
                                                            class="w-10 h-10 rounded-full object-cover shadow-md transform hover:scale-110 transition-all duration-200 cursor-pointer backdrop-blur-sm border-2 border-white/20"
                                                            onclick="playClickSound()"
                                                            data-tooltip="{{ $player->name }}'s Profile Picture"
                                                            onerror="this.onerror=null; this.replaceWith(
                                                                Object.assign(document.createElement('div'), {
                                                                    className: 'w-10 h-10 bg-gradient-to-r from-blue-500/80 to-indigo-600/80 rounded-full flex items-center justify-center text-white text-sm font-bold shadow-md transform hover:scale-110 transition-all duration-200 cursor-pointer backdrop-blur-sm border border-white/20',
                                                                    onclick: playClickSound,
                                                                    dataset: { tooltip: '{{ $player->name }}\'s Avatar' },
                                                                    innerHTML: '<span class=&quot;text-lg&quot;>👤</span>'
                                                                })
                                                            );"
                                                        />

                                                        @else
                                                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500/80 to-indigo-600/80 rounded-full flex items-center justify-center text-white text-sm font-bold shadow-md transform hover:scale-110 transition-all duration-200 cursor-pointer backdrop-blur-sm border border-white/20" onclick="playClickSound()" data-tooltip="{{ $player->name }}'s Avatar">
                                                                <span class="text-lg">{{ strtoupper(substr($player->name, 0, 1)) }}</span>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <div class="font-semibold text-white group-hover:text-blue-400 transition-colors duration-200 cursor-pointer" onclick="showPlayerDetails({{ $player->user_id }}, '{{ $player->name }}')">{{ $player->name }}</div>
                                                            @if(auth()->id() == $player->user_id)
                                                                <div class="text-sm text-blue-400 font-medium animate-pulse">• You</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="py-4 px-6 text-right font-bold text-white group-hover:text-blue-400 transition-colors duration-200">
                                                    <span class="cursor-pointer" onclick="playClickSound()" data-tooltip="{{ number_format($player->best_score) }} quiz points">{{ number_format($player->best_score) }}</span>
                                                </td>
                                                <td class="py-4 px-6 text-right text-gray-300 group-hover:text-blue-400 transition-colors duration-200">
                                                    <span class="cursor-pointer" onclick="playClickSound()" data-tooltip="{{ $player->games_played }} quiz games">{{ $player->games_played }}</span>
                                                </td>
                                                <td class="py-4 px-6 text-right text-gray-300 font-medium group-hover:text-blue-400 transition-colors duration-200">
                                                    <span class="cursor-pointer" onclick="playClickSound()" data-tooltip="{{ number_format($player->avg_accuracy, 1) }}% quiz accuracy">{{ number_format($player->avg_accuracy, 1) }}%</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="py-12 px-6 text-center text-gray-400">
                                                <div class="text-gray-400 mb-2 text-4xl animate-bounce">🧠</div>
                                                <div class="text-lg font-medium text-gray-300 mb-1">No quiz players yet</div>
                                                <div class="text-sm text-gray-500">Be the first to play and top the leaderboard!</div>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Word Scramble Leaderboard -->
                <div class="leaderboard-content hidden" data-content="word-scramble">
                    <div class="p-6">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                            <div>
                                <h2 class="text-2xl font-bold text-white mb-1">🔤 Word Scramble Rankings</h2>
                                <p class="text-gray-300">Top word puzzle masters and vocabulary experts</p>
                            </div>
                            
                            <!-- Enhanced Controls -->
                            <div class="flex flex-wrap gap-2">
                                <select id="wordScrambleTimeRange" class="px-4 py-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-lg text-sm text-black focus:ring-2 focus:ring-green-500/50 focus:border-transparent hover:bg-white/15 transition-all duration-200" onchange="playFilterSound()">
                                    <option value="all">🌍 All Time</option>
                                    <option value="month">📅 This Month</option>
                                    <option value="week">📆 This Week</option>
                                    <option value="today">📅 Today</option>
                                </select>
                                
                                <select id="wordScrambleSortBy" class="px-4 py-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-lg text-sm text-black focus:ring-2 focus:ring-green-500/50 focus:border-transparent hover:bg-white/15 transition-all duration-200" onchange="playFilterSound()">
                                    <option value="score">🏆 Score</option>
                                    <option value="accuracy">🎯 Accuracy</option>
                                    <option value="games">🎮 Games Played</option>
                                    <option value="recent">⏰ Most Recent</option>
                                </select>
                                
                                <button id="refreshWordScramble" class="px-4 py-2 bg-gradient-to-r from-green-500/80 to-emerald-600/80 hover:from-green-600/80 hover:to-emerald-700/80 text-white rounded-lg text-sm font-medium transition-all duration-200 transform hover:scale-105 shadow-md backdrop-blur-sm border border-white/20" onclick="refreshLeaderboard('word-scramble')">
                                    <span class="flex items-center gap-2">
                                        <span>↻</span>
                                        <span>Refresh</span>
                                    </span>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Leaderboard Table -->
                        <div class="overflow-x-auto rounded-lg border border-white/10 shadow-sm">
                            <table class="w-full">
                                <thead class="bg-gradient-to-r from-green-500/20 to-emerald-600/20 backdrop-blur-sm">
                                    <tr>
                                        <th class="text-left py-4 px-6 font-semibold text-white border-b border-white/20">Rank</th>
                                        <th class="text-left py-4 px-6 font-semibold text-white border-b border-white/20">Player</th>
                                        <th class="text-right py-4 px-6 font-semibold text-white border-b border-white/20">Score</th>
                                        <th class="text-right py-4 px-6 font-semibold text-white border-b border-white/20">Games</th>
                                        <th class="text-right py-4 px-6 font-semibold text-white border-b border-white/20">Accuracy</th>
                                    </tr>
                                </thead>
                                <tbody id="wordScrambleLeaderboardBody">
                                    @if($wordScrambleLeaderboard->count() > 0)
                                        @php
                                            $currentScore = null;
                                            $currentRank = 0;
                                        @endphp
                                        @foreach($wordScrambleLeaderboard as $index => $player)
                                            @php
                                                // Handle ties by checking if score is different from previous
                                                if ($player->best_score != $currentScore) {
                                                    $currentRank = $index + 1;
                                                    $currentScore = $player->best_score;
                                                }
                                            @endphp
                                            <tr class="hover:bg-green-500/10 transition-all duration-150 @if(auth()->id() == $player->user_id) bg-green-500/20 border-l-4 border-green-400 @endif border-b border-white/10 player-row" data-player-id="{{ $player->user_id }}" data-player-name="{{ $player->name }}" data-player-score="{{ $player->best_score }}" data-player-games="{{ $player->games_played }}" data-player-accuracy="{{ number_format($player->avg_accuracy, 1) }}">
                                                <td class="py-4 px-6">
                                                    @if($currentRank <= 3)
                                                        <!-- Enhanced Rank Badge -->
                                                        <div class="relative inline-flex items-center justify-center group">
                                                            <!-- Outer glow ring -->
                                                            <div class="absolute inset-0 rounded-full animate-pulse @if($currentRank == 1) bg-green-400/30 @elseif($currentRank == 2) bg-emerald-400/30 @else bg-teal-400/30 @endif opacity-50 blur-md"></div>
                                                            
                                                            <!-- Main badge container -->
                                                            <div class="relative inline-flex flex-col items-center">
                                                                <!-- Badge background with gradient and border -->
                                                                <div class="w-14 h-14 rounded-full @if($currentRank == 1) bg-gradient-to-br from-green-400/80 via-green-500/80 to-green-600/80 @elseif($currentRank == 2) bg-gradient-to-br from-emerald-400/80 via-emerald-500/80 to-emerald-600/80 @else bg-gradient-to-br from-teal-400/80 via-teal-500/80 to-teal-600/80 @endif shadow-lg border-2 @if($currentRank == 1) border-green-400/50 @elseif($currentRank == 2) border-emerald-400/50 @else border-teal-400/50 @endif flex items-center justify-center transform hover:scale-110 transition-all duration-300 cursor-pointer backdrop-blur-sm" onclick="playRankSound()" data-tooltip="Top {{ $currentRank }} Word Master - Click for details!">
                                                                    <!-- Rank number -->
                                                                    <span class="text-white font-bold text-lg drop-shadow-md">{{ $currentRank }}</span>
                                                                </div>
                                                                
                                                                <!-- Achievement crown/icon -->
                                                                @if($currentRank == 1)
                                                                    <div class="absolute -top-1 -right-1 w-6 h-6 bg-gradient-to-br from-green-400/80 to-green-600/80 rounded-full border-2 border-green-500/50 flex items-center justify-center shadow-lg animate-bounce backdrop-blur-sm">
                                                                        <span class="text-white text-xs">📝</span>
                                                                    </div>
                                                                @elseif($currentRank == 2)
                                                                    <div class="absolute -top-1 -right-1 w-6 h-6 bg-gradient-to-br from-emerald-400/80 to-emerald-600/80 rounded-full border-2 border-emerald-500/50 flex items-center justify-center shadow-lg backdrop-blur-sm">
                                                                        <span class="text-white text-xs">🥈</span>
                                                                    </div>
                                                                @else
                                                                    <div class="absolute -top-1 -right-1 w-6 h-6 bg-gradient-to-br from-teal-400/80 to-teal-600/80 rounded-full border-2 border-teal-500/50 flex items-center justify-center shadow-lg backdrop-blur-sm">
                                                                        <span class="text-white text-xs">🥉</span>
                                                                    </div>
                                                                @endif
                                                                
                                                                <!-- Milestone indicator -->
                                                                <div class="mt-1 px-2 py-0.5 bg-gradient-to-r @if($currentRank == 1) from-green-500/80 to-green-600/80 @elseif($currentRank == 2) from-emerald-500/80 to-emerald-600/80 @else from-teal-500/80 to-teal-600/80 @endif text-white text-xs font-bold rounded-full shadow-md backdrop-blur-sm transform scale-90 border border-white/20">
                                                                    @if($currentRank == 1)
                                                                        SAGE
                                                                    @elseif($currentRank == 2)
                                                                        WIZARD
                                                                    @else
                                                                        GURU
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <!-- Regular rank badge with enhanced design -->
                                                        <div class="relative inline-flex items-center group">
                                                            @if($currentRank <= 10)
                                                                <!-- Top 10 special badge -->
                                                                <div class="w-10 h-10 bg-gradient-to-br from-green-500/80 to-emerald-600/80 rounded-full flex items-center justify-center shadow-md border-2 border-green-400/50 transform hover:scale-105 transition-all duration-200 cursor-pointer backdrop-blur-sm" onclick="playRankSound()" data-tooltip="Top 10 Word Scrambler - Amazing vocabulary!">
                                                                    <span class="text-white font-bold text-sm">{{ $currentRank }}</span>
                                                                </div>
                                                                <div class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 px-1.5 py-0.5 bg-gradient-to-r from-green-500/80 to-emerald-600/80 text-white text-xs font-bold rounded-full whitespace-nowrap backdrop-blur-sm border border-white/20">
                                                                    TOP 10
                                                                </div>
                                                            @elseif($currentRank <= 25)
                                                                <!-- Top 25 badge -->
                                                                <div class="w-10 h-10 bg-gradient-to-br from-emerald-500/80 to-teal-600/80 rounded-full flex items-center justify-center shadow-md border-2 border-emerald-400/50 transform hover:scale-105 transition-all duration-200 cursor-pointer backdrop-blur-sm" onclick="playRankSound()" data-tooltip="Top 25 Word Scrambler - Great skills!">
                                                                    <span class="text-white font-bold text-sm">{{ $currentRank }}</span>
                                                                </div>
                                                                <div class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 px-1.5 py-0.5 bg-gradient-to-r from-emerald-500/80 to-teal-600/80 text-white text-xs font-bold rounded-full whitespace-nowrap backdrop-blur-sm border border-white/20">
                                                                    TOP 25
                                                                </div>
                                                            @elseif($currentRank <= 50)
                                                                <!-- Top 50 badge -->
                                                                <div class="w-10 h-10 bg-gradient-to-br from-teal-500/80 to-cyan-600/80 rounded-full flex items-center justify-center shadow-md border-2 border-teal-400/50 transform hover:scale-105 transition-all duration-200 cursor-pointer backdrop-blur-sm" onclick="playRankSound()" data-tooltip="Top 50 Word Scrambler - Keep practicing!">
                                                                    <span class="text-white font-bold text-sm">{{ $currentRank }}</span>
                                                                </div>
                                                                <div class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 px-1.5 py-0.5 bg-gradient-to-r from-teal-500/80 to-cyan-600/80 text-white text-xs font-bold rounded-full whitespace-nowrap backdrop-blur-sm border border-white/20">
                                                                    TOP 50
                                                                </div>
                                                            @else
                                                                <!-- Regular rank -->
                                                                <span class="text-gray-400 font-semibold text-lg hover:text-green-400 transition-colors duration-200 cursor-pointer" onclick="playRankSound()" data-tooltip="Word Scramble Rank #{{ $currentRank }}">#{{ $currentRank }}</span>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="py-4 px-6">
                                                    <div class="flex items-center gap-3 group">
                                                        @if($player->profile_picture)
                                                        <img src="{{ asset('storage/' . $player->profile_picture) }}"
                                                            alt="{{ $player->name }}'s Profile Picture"
                                                            class="w-10 h-10 rounded-full object-cover shadow-md transform hover:scale-110 transition-all duration-200 cursor-pointer backdrop-blur-sm border-2 border-white/20"
                                                            onclick="playClickSound()"
                                                            data-tooltip="{{ $player->name }}'s Profile Picture"
                                                            onerror="this.onerror=null; this.replaceWith(
                                                                Object.assign(document.createElement('div'), {
                                                                    className: 'w-10 h-10 bg-gradient-to-r from-blue-500/80 to-indigo-600/80 rounded-full flex items-center justify-center text-white text-sm font-bold shadow-md transform hover:scale-110 transition-all duration-200 cursor-pointer backdrop-blur-sm border border-white/20',
                                                                    onclick: playClickSound,
                                                                    dataset: { tooltip: '{{ $player->name }}\'s Avatar' },
                                                                    innerHTML: '<span class=&quot;text-lg&quot;>👤</span>'
                                                                })
                                                            );"
                                                        />

                                                        @else
                                                            <div class="w-10 h-10 bg-gradient-to-r from-green-500/80 to-emerald-600/80 rounded-full flex items-center justify-center text-white text-sm font-bold shadow-md transform hover:scale-110 transition-all duration-200 cursor-pointer backdrop-blur-sm border border-white/20" onclick="playClickSound()" data-tooltip="{{ $player->name }}'s Avatar">
                                                                <span class="text-lg">{{ strtoupper(substr($player->name, 0, 1)) }}</span>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <div class="font-semibold text-white group-hover:text-green-400 transition-colors duration-200 cursor-pointer" onclick="showPlayerDetails({{ $player->user_id }}, '{{ $player->name }}')">{{ $player->name }}</div>
                                                            @if(auth()->id() == $player->user_id)
                                                                <div class="text-sm text-green-400 font-medium animate-pulse">• You</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="py-4 px-6 text-right font-bold text-white group-hover:text-green-400 transition-colors duration-200">
                                                    <span class="cursor-pointer" onclick="playClickSound()" data-tooltip="{{ number_format($player->best_score) }} word scramble points">{{ number_format($player->best_score) }}</span>
                                                </td>
                                                <td class="py-4 px-6 text-right text-gray-300 group-hover:text-green-400 transition-colors duration-200">
                                                    <span class="cursor-pointer" onclick="playClickSound()" data-tooltip="{{ $player->games_played }} word scramble games">{{ $player->games_played }}</span>
                                                </td>
                                                <td class="py-4 px-6 text-right">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gradient-to-r from-green-500/80 to-emerald-600/80 text-white shadow-sm backdrop-blur-sm border border-white/20 cursor-pointer" onclick="playClickSound()" data-tooltip="{{ number_format($player->avg_accuracy, 1) }}% accuracy in word scramble">
                                                        {{ number_format($player->avg_accuracy, 1) }}%
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="py-12 px-6 text-center">
                                                <div class="text-green-400/60 mb-2 text-4xl animate-bounce">📝</div>
                                                <div class="text-gray-300 font-medium text-lg">No word scramble leaderboard data available</div>
                                                <div class="text-gray-400 text-sm">Start playing word scramble games to appear on the leaderboard!</div>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back to Profile Button -->
        <div class="mt-8 text-center">
            <a href="{{ route('profile') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-medium transition-colors duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Profile
            </a>
        </div>
    </div>
</div>

<!-- Custom CSS Animations -->
<style>
    @keyframes float {
        0%, 100% {
            transform: translateY(0px) translateX(0px);
        }
        25% {
            transform: translateY(-20px) translateX(10px);
        }
        50% {
            transform: translateY(-10px) translateX(-10px);
        }
        75% {
            transform: translateY(-30px) translateX(5px);
        }
    }
    
    @keyframes pulse-slow {
        0%, 100% {
            opacity: 0.3;
        }
        50% {
            opacity: 0.6;
        }
    }
    
    .animate-float {
        animation: float 8s ease-in-out infinite;
    }
    
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    
    .animation-delay-4000 {
        animation-delay: 4s;
    }
    
    .animation-delay-6000 {
        animation-delay: 6s;
    }
    
    .animation-delay-8000 {
        animation-delay: 8s;
    }
    
    .animate-pulse-slow {
        animation: pulse-slow 4s ease-in-out infinite;
    }
    
    /* Glass morphism enhancements */
    .glass-morphism {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    /* Leaderboard table enhancements */
    .leaderboard-table {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .leaderboard-table th {
        background: rgba(255, 255, 255, 0.1);
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .leaderboard-table td {
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }
    
    /* Tab enhancements */
    .tab-button {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .tab-button.active {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.8), rgba(99, 102, 241, 0.8));
        border: 1px solid rgba(255, 255, 255, 0.3);
    }
</style>

<!-- JavaScript for tab switching -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tab switching functionality
        const tabButtons = document.querySelectorAll('.tab-button');
        const leaderboardContents = document.querySelectorAll('.leaderboard-content');
        
        function switchTab(targetTab) {
            // Update button states
            tabButtons.forEach(btn => {
                if (btn.dataset.tab === targetTab) {
                    btn.classList.add('bg-gradient-to-r', 'from-blue-500', 'to-indigo-600', 'text-white', 'shadow-md');
                    btn.classList.remove('bg-white', 'text-gray-700', 'border', 'border-gray-300');
                } else {
                    btn.classList.remove('bg-gradient-to-r', 'from-blue-500', 'to-indigo-600', 'text-white', 'shadow-md');
                    btn.classList.add('bg-white', 'text-gray-700', 'border', 'border-gray-300');
                }
            });
            
            // Show/hide content
            leaderboardContents.forEach(content => {
                if (content.dataset.content === targetTab) {
                    content.classList.remove('hidden');
                    content.classList.add('active');
                } else {
                    content.classList.add('hidden');
                    content.classList.remove('active');
                }
            });
        }
        
        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                const targetTab = button.dataset.tab;
                switchTab(targetTab);
            });
        });
        
        // Initialize first tab
        switchTab('overall');
        
        // Add refresh functionality
        const refreshButtons = ['refreshOverall', 'refreshQuiz', 'refreshWordScramble'];
        refreshButtons.forEach(buttonId => {
            const button = document.getElementById(buttonId);
            if (button) {
                button.addEventListener('click', () => {
                    // Add loading state
                    button.innerHTML = '⟳ Loading...';
                    button.disabled = true;
                    
                    // Simulate refresh (in real app, this would fetch new data)
                    setTimeout(() => {
                        button.innerHTML = '↻ Refresh';
                        button.disabled = false;
                    }, 1000);
                });
            }
        });
    });
</script>
@endsection

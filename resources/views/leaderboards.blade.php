to @extends('layouts.app')

@section('title', 'Leaderboards - Pawikan Patrol')

@section('content')
<div class="min-h-screen bg-gray-900 py-8 relative overflow-hidden">
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
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-green-500 via-green-400 to-emerald-500 rounded-full mb-6 shadow-2xl transform hover:scale-110 transition-all duration-300 border border-white/20 backdrop-blur-sm">
                <span class="text-3xl animate-bounce">🏆</span>
            </div>
            <h1 class="text-5xl md:text-6xl font-bold text-green-400 mb-4 drop-shadow-lg" style="font-family: 'Poppins', sans-serif;">Leaderboards</h1>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto cinzel-body">Compete with the best players and climb your way to the top of the rankings</p>
        </div>  

        @if(!auth()->check() || (auth()->user()->role !== 'admin' && auth()->user()->role !== 'patroller'))
        <!-- Your Rankings Summary with Social Sharing -->
        <div class="mb-12">
            <h2 class="text-3xl font-bold text-green-400 mb-8 text-center drop-shadow-lg cinzel-subheading">Your Current Rankings</h2>
            
            @auth
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <!-- Memory Match Rank -->
                <div class="bg-white/10 backdrop-blur-md rounded-2xl shadow-2xl p-6 text-center transform hover:scale-105 transition-all duration-200 border border-white/20 relative overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-r from-purple-400/20 to-pink-500/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative z-10">
                        @php
                            $memoryMatchRank = auth()->user()->getGameRank('memory-match');
                            $memoryMatchScore = auth()->user()->getBestTimeForGame('memory-match');
                        @endphp
                        <div class="inline-flex items-center justify-center w-14 h-14 bg-gradient-to-r from-purple-400 to-pink-500 rounded-full mb-4 shadow-lg border border-white/20">
                            <span class="text-2xl">🧠</span>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-2">Memory Match</h3>
                        <div class="text-4xl font-bold bg-gradient-to-r from-purple-400 to-pink-500 bg-clip-text text-transparent mb-1">
                            #{{ $memoryMatchRank ?: 'N/A' }}
                        </div>
                        <div class="text-sm text-gray-300 mb-3">{{ $memoryMatchScore > 0 ? sprintf('%02d:%02d.%02d', floor($memoryMatchScore / 60), floor($memoryMatchScore) % 60, ($memoryMatchScore - floor($memoryMatchScore)) * 100) : '--' }}</div>
                    </div>
                </div>
                
                <!-- Puzzle Rank -->
                <div class="bg-white/10 backdrop-blur-md rounded-2xl shadow-2xl p-6 text-center transform hover:scale-105 transition-all duration-200 border border-white/20 relative overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-r from-orange-400/20 to-red-500/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative z-10">
                        @php
                            $puzzleRank = auth()->user()->getGameRank('puzzle');
                            $puzzleScore = auth()->user()->getBestTimeForGame('puzzle');
                        @endphp
                        <div class="inline-flex items-center justify-center w-14 h-14 bg-gradient-to-r from-orange-400 to-red-500 rounded-full mb-4 shadow-lg border border-white/20">
                            <span class="text-2xl">🧩</span>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-2">Pawikan Puzzle</h3>
                        <div class="text-4xl font-bold bg-gradient-to-r from-orange-400 to-red-500 bg-clip-text text-transparent mb-1">
                            #{{ $puzzleRank ?: 'N/A' }}
                        </div>
                        <div class="text-sm text-gray-300 mb-3">{{ $puzzleScore > 0 ? sprintf('%02d:%02d.%02d', floor($puzzleScore / 60), floor($puzzleScore) % 60, ($puzzleScore - floor($puzzleScore)) * 100) : '--' }}</div>
                    </div>
                </div>

                <!-- Find the Pawikan Rank -->
                <div class="bg-white/10 backdrop-blur-md rounded-2xl shadow-2xl p-6 text-center transform hover:scale-105 transition-all duration-200 border border-white/20 relative overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-r from-teal-400/20 to-cyan-500/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative z-10">
                        @php
                            $findPawikanRank = auth()->user()->getGameRank('find-the-pawikan');
                            $findPawikanScore = auth()->user()->getBestTimeForGame('find-the-pawikan');
                        @endphp
                        <div class="inline-flex items-center justify-center w-14 h-14 bg-gradient-to-r from-teal-400 to-cyan-500 rounded-full mb-4 shadow-lg border border-white/20">
                            <span class="text-2xl">🐢</span>
                        </div>
                        <h3 class="text-xl font-semibold text-white mb-2">Find the Pawikan</h3>
                        <div class="text-4xl font-bold bg-gradient-to-r from-teal-400 to-cyan-500 bg-clip-text text-transparent mb-1">
                            #{{ $findPawikanRank ?: 'N/A' }}
                        </div>
                        <div class="text-sm text-gray-300 mb-3">{{ $findPawikanScore > 0 ? sprintf('%02d:%02d.%02d', floor($findPawikanScore / 60), floor($findPawikanScore) % 60, ($findPawikanScore - floor($findPawikanScore)) * 100) : '--' }}</div>
                    </div>
                </div>
            </div>
            @else
            <div class="text-center py-8 bg-white/5 backdrop-blur-md rounded-2xl border border-white/10">
                <p class="text-xl text-gray-300 mb-4">Log in to see your rankings and track your progress!</p>
                <a href="#" onclick="event.preventDefault(); openAuthModal('login')" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-medium rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg">
                    <span>Log In / Register</span>
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                    </svg>
                </a>
            </div>
            @endauth
        </div>
        @endif

        <!-- Leaderboards Container -->
        <div class="bg-white/10 backdrop-blur-md rounded-2xl shadow-2xl border border-white/20 overflow-hidden relative">

            
            <!-- Tab Navigation -->
            <div class="border-b border-white/10">
                <div class="flex justify-center gap-8 px-6">
                    <button class="tab-btn active" data-tab="memory-match">
                        <span class="text-xl">🧠</span>
                        <span>Memory</span>
                    </button>
                    <button class="tab-btn" data-tab="puzzle">
                        <span class="text-xl">🧩</span>
                        <span>Puzzle</span>
                    </button>
                    <button class="tab-btn" data-tab="find-the-pawikan">
                        <span class="text-xl">🐢</span>
                        <span>Ocean Guardians</span>
                    </button>
                </div>
            </div>

            <!-- Tab Content Container -->
            <div class="tab-content-container">
                <!-- Memory Match Leaderboard -->
                <div class="leaderboard-content active" data-content="memory-match">
                    <div class="p-6">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                            <div>
                                <h2 class="text-2xl font-bold text-white mb-1">🧠 Memory Match Rankings</h2>
                                <p class="text-gray-300">Top players with the best memory skills</p>
                            </div>
                            
                            <!-- Controls -->
                            <div class="flex flex-wrap gap-2">
                                <button id="refreshMemoryMatch" class="px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-lg text-sm font-medium transition-all duration-200 border border-white/20" onclick="refreshLeaderboard('memory-match')">
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
                                <thead class="bg-white/10 backdrop-blur-sm border-b border-white/10">
                                    <tr>
                                        <th class="text-left py-4 px-6 font-semibold text-white border-b border-white/10">Rank</th>
                                        <th class="text-left py-4 px-6 font-semibold text-white border-b border-white/10">Player</th>
                                        <th class="text-center py-4 px-6 font-semibold text-white border-b border-white/10">
                                            <select onchange="window.filterLeaderboard(this, 'memory-match')" class="bg-black/30 border border-white/20 text-white text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-1 cursor-pointer hover:bg-white/10 transition-colors">
                                                <option class="bg-gray-800" value="all" selected>All Levels</option>
                                                <option class="bg-gray-800" value="easy">Easy</option>
                                                <option class="bg-gray-800" value="medium">Medium</option>
                                                <option class="bg-gray-800" value="hard">Hard</option>
                                            </select>
                                        </th>
                                        <th class="text-right py-4 px-6 font-semibold text-white border-b border-white/10">Best Time</th>
                                        <th class="text-right py-4 px-6 font-semibold text-white border-b border-white/10">Games Played</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($memoryMatchLeaderboard->count() > 0)
                                        @php $currentRank = 0; $previousTime = null; @endphp
                                        @foreach($memoryMatchLeaderboard as $index => $player)
                                            @php
                                                if ($player->best_time != $previousTime) {
                                                    $currentRank = $index + 1;
                                                    $previousTime = $player->best_time;
                                                }
                                            @endphp
                                            <tr class="lb-row hover:bg-white/10 transition-all duration-150 @if(auth()->check() && auth()->id() == $player->user_id) bg-green-500/20 border-l-4 border-green-400 @endif border-b border-white/5" data-difficulty="{{ strtolower($player->difficulty) }}" data-user-id="{{ $player->user_id }}">
                                                <td class="py-4 px-6 text-white font-bold rank-cell">#{{ $currentRank }}</td>
                                                <td class="py-4 px-6 text-white">
                                                    <div class="flex items-center gap-3">
                                                        @if($player->profile_picture)
                                                            <img src="{{ asset('storage/' . $player->profile_picture) }}" class="w-8 h-8 rounded-full object-cover border border-white/20 shadow-sm">
                                                        @else
                                                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-xs font-bold border border-white/20 shadow-sm text-white">
                                                                {{ substr($player->name, 0, 1) }}
                                                            </div>
                                                        @endif
                                                        <span class="font-medium">{{ $player->name }}</span>
                                                        @if(auth()->check() && auth()->id() == $player->user_id)
                                                            <span class="text-xs text-green-300 font-semibold ml-2 bg-green-500/20 px-2 py-0.5 rounded-full border border-green-500/30">You</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="py-4 px-6 text-center text-gray-300">{{ ucfirst($player->difficulty ?? 'N/A') }}</td>
                                                <td class="py-4 px-6 text-right text-white font-bold tracking-wide">{{ sprintf('%02d:%02d.%02d', floor($player->best_time / 60), floor($player->best_time) % 60, ($player->best_time - floor($player->best_time)) * 100) }}</td>
                                                <td class="py-4 px-6 text-right text-gray-300">{{ $player->games_played }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="py-12 px-6 text-center text-gray-400">
                                                <div class="text-4xl mb-2">🧠</div>
                                                <p>No records yet. Be the first!</p>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Puzzle Leaderboard -->
                <div class="leaderboard-content hidden" data-content="puzzle">
                    <div class="p-6">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                            <div>
                                <h2 class="text-2xl font-bold text-white mb-1">🧩 Pawikan Puzzle Rankings</h2>
                                <p class="text-gray-300">Fastest puzzle solvers</p>
                            </div>
                            
                            <div class="flex flex-wrap gap-2">
                                <button id="refreshPuzzle" class="px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-lg text-sm font-medium transition-all duration-200 border border-white/20" onclick="refreshLeaderboard('puzzle')">
                                    <span class="flex items-center gap-2">
                                        <span>↻</span>
                                        <span>Refresh</span>
                                    </span>
                                </button>
                            </div>
                        </div>
                        
                        <div class="overflow-x-auto rounded-lg border border-white/10 shadow-sm">
                            <table class="w-full">
                                <thead class="bg-white/10 backdrop-blur-sm border-b border-white/10">
                                    <tr>
                                        <th class="text-left py-4 px-6 font-semibold text-white border-b border-white/10">Rank</th>
                                        <th class="text-left py-4 px-6 font-semibold text-white border-b border-white/10">Player</th>
                                        <th class="text-center py-4 px-6 font-semibold text-white border-b border-white/10">
                                            <select onchange="window.filterLeaderboard(this, 'puzzle')" class="bg-black/30 border border-white/20 text-white text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-1 cursor-pointer hover:bg-white/10 transition-colors">
                                                <option class="bg-gray-800" value="all" selected>All Levels</option>
                                                <option class="bg-gray-800" value="easy">Easy</option>
                                                <option class="bg-gray-800" value="medium">Medium</option>
                                                <option class="bg-gray-800" value="hard">Hard</option>
                                            </select>
                                        </th>
                                        <th class="text-right py-4 px-6 font-semibold text-white border-b border-white/10">Best Time</th>
                                        <th class="text-right py-4 px-6 font-semibold text-white border-b border-white/10">Games Played</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($puzzleLeaderboard->count() > 0)
                                        @php $currentRank = 0; $previousTime = null; @endphp
                                        @foreach($puzzleLeaderboard as $index => $player)
                                            @php
                                                if ($player->best_time != $previousTime) {
                                                    $currentRank = $index + 1;
                                                    $previousTime = $player->best_time;
                                                }
                                            @endphp
                                            <tr class="lb-row hover:bg-white/10 transition-all duration-150 @if(auth()->check() && auth()->id() == $player->user_id) bg-green-500/20 border-l-4 border-green-400 @endif border-b border-white/5" data-difficulty="{{ strtolower($player->difficulty) }}" data-user-id="{{ $player->user_id }}">
                                                <td class="py-4 px-6 text-white font-bold rank-cell">#{{ $currentRank }}</td>
                                                <td class="py-4 px-6 text-white">
                                                    <div class="flex items-center gap-3">
                                                        @if($player->profile_picture)
                                                            <img src="{{ asset('storage/' . $player->profile_picture) }}" class="w-8 h-8 rounded-full object-cover border border-white/20 shadow-sm">
                                                        @else
                                                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-xs font-bold border border-white/20 shadow-sm text-white">
                                                                {{ substr($player->name, 0, 1) }}
                                                            </div>
                                                        @endif
                                                        <span class="font-medium">{{ $player->name }}</span>
                                                        @if(auth()->check() && auth()->id() == $player->user_id)
                                                            <span class="text-xs text-green-300 font-semibold ml-2 bg-green-500/20 px-2 py-0.5 rounded-full border border-green-500/30">You</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="py-4 px-6 text-center text-gray-300">{{ ucfirst($player->difficulty ?? 'N/A') }}</td>
                                                <td class="py-4 px-6 text-right text-white font-bold tracking-wide">{{ sprintf('%02d:%02d.%02d', floor($player->best_time / 60), floor($player->best_time) % 60, ($player->best_time - floor($player->best_time)) * 100) }}</td>
                                                <td class="py-4 px-6 text-right text-gray-300">{{ $player->games_played }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="py-12 px-6 text-center text-gray-400">
                                                <div class="text-4xl mb-2">🧩</div>
                                                <p>No records yet. Be the first!</p>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Find the Pawikan Leaderboard -->
                <div class="leaderboard-content hidden" data-content="find-the-pawikan">
                    <div class="p-6">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                            <div>
                                <h2 class="text-2xl font-bold text-white mb-1">🐢 Find the Pawikan Rankings</h2>
                                <p class="text-gray-300">Best spotters in the wild</p>
                            </div>
                            
                            <div class="flex flex-wrap gap-2">
                                <button id="refreshFindPawikan" class="px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-lg text-sm font-medium transition-all duration-200 border border-white/20" onclick="refreshLeaderboard('find-the-pawikan')">
                                    <span class="flex items-center gap-2">
                                        <span>↻</span>
                                        <span>Refresh</span>
                                    </span>
                                </button>
                            </div>
                        </div>
                        
                        <div class="overflow-x-auto rounded-lg border border-white/10 shadow-sm">
                            <table class="w-full">
                                <thead class="bg-white/10 backdrop-blur-sm border-b border-white/10">
                                    <tr>
                                        <th class="text-left py-4 px-6 font-semibold text-white border-b border-white/10">Rank</th>
                                        <th class="text-left py-4 px-6 font-semibold text-white border-b border-white/10">Player</th>
                                        <th class="text-center py-4 px-6 font-semibold text-white border-b border-white/10">
                                            <select onchange="window.filterLeaderboard(this, 'find-the-pawikan')" class="bg-black/30 border border-white/20 text-white text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-1 cursor-pointer hover:bg-white/10 transition-colors">
                                                <option class="bg-gray-800" value="all" selected>All Levels</option>
                                                <option class="bg-gray-800" value="easy">Easy</option>
                                                <option class="bg-gray-800" value="medium">Medium</option>
                                                <option class="bg-gray-800" value="hard">Hard</option>
                                            </select>
                                        </th>
                                        <th class="text-right py-4 px-6 font-semibold text-white border-b border-white/10">Best Time</th>
                                        <th class="text-right py-4 px-6 font-semibold text-white border-b border-white/10">Games Played</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($findPawikanLeaderboard->count() > 0)
                                        @php $currentRank = 0; $previousTime = null; @endphp
                                        @foreach($findPawikanLeaderboard as $index => $player)
                                            @php
                                                if ($player->best_time != $previousTime) {
                                                    $currentRank = $index + 1;
                                                    $previousTime = $player->best_time;
                                                }
                                            @endphp
                                            <tr class="lb-row hover:bg-white/10 transition-all duration-150 @if(auth()->check() && auth()->id() == $player->user_id) bg-green-500/20 border-l-4 border-green-400 @endif border-b border-white/5" data-difficulty="{{ strtolower($player->difficulty) }}" data-user-id="{{ $player->user_id }}">
                                                <td class="py-4 px-6 text-white font-bold rank-cell">#{{ $currentRank }}</td>
                                                <td class="py-4 px-6 text-white">
                                                    <div class="flex items-center gap-3">
                                                        @if($player->profile_picture)
                                                            <img src="{{ asset('storage/' . $player->profile_picture) }}" class="w-8 h-8 rounded-full object-cover border border-white/20 shadow-sm">
                                                        @else
                                                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-xs font-bold border border-white/20 shadow-sm text-white">
                                                                {{ substr($player->name, 0, 1) }}
                                                            </div>
                                                        @endif
                                                        <span class="font-medium">{{ $player->name }}</span>
                                                        @if(auth()->check() && auth()->id() == $player->user_id)
                                                            <span class="text-xs text-green-300 font-semibold ml-2 bg-green-500/20 px-2 py-0.5 rounded-full border border-green-500/30">You</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="py-4 px-6 text-center text-gray-300">{{ ucfirst($player->difficulty ?? 'N/A') }}</td>
                                                <td class="py-4 px-6 text-right text-white font-bold tracking-wide">{{ sprintf('%02d:%02d.%02d', floor($player->best_time / 60), floor($player->best_time) % 60, ($player->best_time - floor($player->best_time)) * 100) }}</td>
                                                <td class="py-4 px-6 text-right text-gray-300">{{ $player->games_played }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="py-12 px-6 text-center text-gray-400">
                                                <div class="text-4xl mb-2">🐢</div>
                                                <p>No records yet. Be the first!</p>
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
    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
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
    
    /* Simple Tab Buttons */
    .tab-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        padding: 16px 24px;
        color: rgba(156, 163, 175, 1);
        background: transparent;
        border: none;
        border-bottom: 3px solid transparent;
        transition: all 0.3s ease;
        cursor: pointer;
        font-weight: 500;
    }
    
    .tab-btn:hover {
        color: rgba(229, 231, 235, 1);
    }
    
    .tab-btn.active {
        color: white;
        border-bottom-color: #16a34a;
    }
    
    /* Content slide animations */
    .tab-content-container {
        position: relative;
    }
    
    .leaderboard-content {
        transition: opacity 0.3s ease;
    }
    
    .leaderboard-content.hidden {
        display: none;
    }
    
    .leaderboard-content.active {
        display: block;
        animation: slideIn 0.3s ease-out;
    }
</style>

<!-- JavaScript for tab switching -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tab switching functionality
        const tabButtons = document.querySelectorAll('.tab-btn');
        const leaderboardContents = document.querySelectorAll('.leaderboard-content');
        
        function switchTab(targetTab) {
            // Update button states
            tabButtons.forEach(btn => {
                if (btn.dataset.tab === targetTab) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            });
            
            // Show/hide content with animation
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
        switchTab('memory-match');
        
        // Add refresh functionality
        const refreshButtons = ['refreshMemoryMatch', 'refreshPuzzle', 'refreshFindPawikan'];
        refreshButtons.forEach(buttonId => {
            const button = document.getElementById(buttonId);
            if (button) {
                button.addEventListener('click', () => {
                    // Add loading state
                    const originalContent = button.innerHTML;
                    button.innerHTML = '<span class="animate-spin inline-block mr-2">⟳</span> Loading...';
                    button.disabled = true;
                    
                    // Reload the page to get fresh data
                    window.location.reload();
                });
            }
        });
        
        // Initialize filters for all games on load
        document.querySelectorAll('select[onchange^="window.filterLeaderboard"]').forEach(select => {
            const gameType = select.getAttribute('onchange').match(/'([^']+)'/)[1];
            select.value = 'all';
            window.filterLeaderboard(select, gameType);
        });
    });
        
        // Expose filter function globally
        window.filterLeaderboard = function(selectElement, gameType) {
            const difficulty = selectElement.value;
            const content = document.querySelector(`.leaderboard-content[data-content="${gameType}"]`);
            if (!content) return;
            
            const rows = content.querySelectorAll('tbody tr.lb-row');
            let currentRank = 1;
            let visibleCount = 0;
            const seenUsers = new Set();
            
            rows.forEach(row => {
                const rowDiff = row.getAttribute('data-difficulty');
                const userId = row.getAttribute('data-user-id');
                
                let shouldShow = false;

                if (difficulty === 'all') {
                    // Show only if we haven't seen this user yet (assumes rows are ordered by best time)
                    if (!seenUsers.has(userId)) {
                        shouldShow = true;
                        seenUsers.add(userId);
                    }
                } else {
                    // Standard filter match
                    if (rowDiff === difficulty) {
                        shouldShow = true;
                    }
                }

                if (shouldShow) {
                    row.style.display = '';
                    
                    // Update rank number for visible rows to be sequential
                    const rankCell = row.querySelector('.rank-cell');
                    if (rankCell) {
                        rankCell.textContent = '#' + currentRank;
                    }
                    currentRank++;
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });
            
            // Handle "No records" message if all filtered out
            let noRecordsMsg = content.querySelector('.no-records-row');
            if (visibleCount === 0) {
                if (!noRecordsMsg) {
                    const tbody = content.querySelector('tbody');
                    noRecordsMsg = document.createElement('tr');
                    noRecordsMsg.className = 'no-records-row';
                    noRecordsMsg.innerHTML = '<td colspan="5" class="py-12 px-6 text-center text-gray-400"><p>No records for this selection yet.</p></td>';
                    tbody.appendChild(noRecordsMsg);
                } else {
                    noRecordsMsg.style.display = '';
                }
            } else if (noRecordsMsg) {
                noRecordsMsg.style.display = 'none';
            }
        };
    </script>

@include('auth.modal')

@endsection

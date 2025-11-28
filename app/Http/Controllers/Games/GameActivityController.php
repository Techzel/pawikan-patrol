<?php

namespace App\Http\Controllers\Games;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\GameActivity;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class GameActivityController extends Controller
{
    /**
     * Record a new game activity
     */
    public function record(Request $request)
    {
        try {
            // Check if user is authorized to save game records (only regular users, not admins or patrollers)
            $user = Auth::user();
            if ($user->role !== 'user') {
                return response()->json([
                    'success' => false,
                    'message' => 'Only regular users can save game records'
                ], 403);
            }

            $validated = $request->validate([
                'game_type' => 'required|string|max:50',
                'game_name' => 'required|string|max:100',
                'score' => 'required|integer|min:0',
                'total_questions' => 'nullable|integer|min:0',
                'correct_answers' => 'nullable|integer|min:0',
                'accuracy' => 'nullable|numeric|min:0|max:100',
                'time_spent' => 'nullable|integer|min:0',
                'difficulty_level' => 'nullable|string|max:20',
                'completed' => 'boolean',
                'game_data' => 'nullable|array'
            ]);

            $activity = GameActivity::create([
                'user_id' => Auth::id(),
                'game_type' => $validated['game_type'],
                'game_name' => $validated['game_name'],
                'score' => $validated['score'],
                'total_questions' => $validated['total_questions'] ?? 0,
                'correct_answers' => $validated['correct_answers'] ?? 0,
                'accuracy' => $validated['accuracy'] ?? 0,
                'time_spent' => $validated['time_spent'] ?? 0,
                'difficulty_level' => $validated['difficulty_level'] ?? 'medium',
                'completed' => $validated['completed'] ?? false,
                'game_data' => $validated['game_data'] ?? null
            ]);

            // Get updated user statistics
            $userStats = $this->getUserStatistics();

            return response()->json([
                'success' => true,
                'message' => 'Game activity recorded successfully',
                'activity_id' => $activity->id,
                'user_stats' => $userStats
            ]);

        } catch (\Exception $e) {
            Log::error('Error recording game activity: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to record game activity'
            ], 500);
        }
    }

    /**
     * Get user's game activities
     */
    public function index(Request $request)
    {
        try {
            $query = GameActivity::where('user_id', Auth::id())
                ->orderBy('created_at', 'desc');

            // Apply filters
            if ($request->has('game_type')) {
                $query->where('game_type', $request->game_type);
            }

            if ($request->has('completed')) {
                $query->where('completed', $request->boolean('completed'));
            }

            $activities = $query->paginate(20);

            return response()->json([
                'success' => true,
                'activities' => $activities
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching game activities: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch game activities'
            ], 500);
        }
    }

    /**
     * Get user's game statistics
     */
    public function statistics()
    {
        try {
            $stats = $this->getUserStatistics();

            return response()->json([
                'success' => true,
                'statistics' => $stats
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching game statistics: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch game statistics'
            ], 500);
        }
    }

    /**
     * Get user's best scores
     */
    public function bestScores()
    {
        try {
            $bestScores = GameActivity::where('user_id', Auth::id())
                ->where('completed', true)
                ->select('game_type', 'game_name')
                ->selectRaw('MAX(score) as best_score')
                ->selectRaw('COUNT(*) as games_played')
                ->selectRaw('AVG(accuracy) as avg_accuracy')
                ->groupBy('game_type', 'game_name')
                ->get();

            return response()->json([
                'success' => true,
                'best_scores' => $bestScores
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching best scores: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch best scores'
            ], 500);
        }
    }

    /**
     * Get leaderboard
     */
    public function leaderboard($gameType = null)
    {
        try {
            if ($gameType) {
                // For specific game types, get best scores per user
                $query = GameActivity::where('completed', true)
                    ->where('game_activities.game_type', $gameType)
                    ->join('users', 'game_activities.user_id', '=', 'users.id')
                    ->select(
                        'users.id as user_id',
                        'users.name',
                        'users.username',
                        'users.profile_picture',
                        'game_activities.game_type',
                        DB::raw('MAX(game_activities.score) as best_score'),
                        DB::raw('COUNT(game_activities.id) as games_played'),
                        DB::raw('AVG(game_activities.accuracy) as avg_accuracy'),
                        DB::raw('SUM(game_activities.score) as total_score')
                    )
                    ->groupBy('users.id', 'users.name', 'users.username', 'users.profile_picture', 'game_activities.game_type')
                    ->orderBy('best_score', 'desc')
                    ->limit(50);
            } else {
                // For overall leaderboard, get total scores across all games
                $query = GameActivity::where('completed', true)
                    ->join('users', 'game_activities.user_id', '=', 'users.id')
                    ->select(
                        'users.id as user_id',
                        'users.name',
                        'users.username',
                        'users.profile_picture',
                        DB::raw('NULL as game_type'),
                        DB::raw('MAX(game_activities.score) as best_score'),
                        DB::raw('COUNT(game_activities.id) as games_played'),
                        DB::raw('AVG(game_activities.accuracy) as avg_accuracy'),
                        DB::raw('SUM(game_activities.score) as total_score')
                    )
                    ->groupBy('users.id', 'users.name', 'users.username', 'users.profile_picture')
                    ->orderBy('total_score', 'desc')
                    ->limit(50);
            }

            $leaderboard = $query->get();

            return response()->json([
                'success' => true,
                'leaderboard' => $leaderboard
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching leaderboard: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch leaderboard'
            ], 500);
        }
    }

    /**
     * Delete a game activity
     */
    public function destroy($id)
    {
        try {
            $activity = GameActivity::where('user_id', Auth::id())->findOrFail($id);
            $activity->delete();

            return response()->json([
                'success' => true,
                'message' => 'Game activity deleted successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Error deleting game activity: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete game activity'
            ], 500);
        }
    }

    /**
     * Get recent global activities (admin only)
     */
    public function recentGlobal()
    {
        try {
            $recentActivities = GameActivity::with('user')
                ->orderBy('created_at', 'desc')
                ->limit(20)
                ->get();

            return response()->json([
                'success' => true,
                'activities' => $recentActivities
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching recent global activities: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch recent activities'
            ], 500);
        }
    }

    /**
     * Get user statistics helper method
     */
    private function getUserStatistics()
    {
        $userId = Auth::id();
        
        // Get total games played
        $totalGamesPlayed = GameActivity::where('user_id', $userId)
            ->where('completed', true)
            ->count();

        // Get total score
        $totalScore = GameActivity::where('user_id', $userId)
            ->where('completed', true)
            ->sum('score');

        // Get average accuracy
        $averageAccuracy = GameActivity::where('user_id', $userId)
            ->where('completed', true)
            ->avg('accuracy') ?? 0;

        // Get best scores for each game type
        $bestScores = GameActivity::where('user_id', $userId)
            ->where('completed', true)
            ->select('game_type')
            ->selectRaw('MAX(score) as best_score')
            ->groupBy('game_type')
            ->pluck('best_score', 'game_type');

        // Get recent activities
        $recentActivities = GameActivity::where('user_id', $userId)
            ->where('completed', true)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return [
            'total_games_played' => $totalGamesPlayed,
            'total_score' => $totalScore,
            'average_accuracy' => $averageAccuracy,
            'best_scores' => $bestScores,
            'recent_activities' => $recentActivities
        ];
    }
}

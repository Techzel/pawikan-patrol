<?php

namespace App\Http\Controllers\Games;

use App\Http\Controllers\Controller;
use App\Models\GameActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GameActivityController extends Controller
{
    /**
     * Record a new game activity.
     */
    public function record(Request $request)
    {
        \Log::info('Game activity record request received', [
            'data' => $request->all(),
            'user_id' => Auth::id()
        ]);
        
        $request->validate([
            'game_type' => 'required|string',
            'time_spent' => 'required|numeric',
            'moves' => 'nullable|integer',
            'difficulty' => 'nullable|string',
        ]);

        $user = Auth::user();
        
        \Log::info('Attempting to save game activity', [
            'user_id' => $user->id,
            'data' => $request->all()
        ]);
        
        try {
            $activity = $user->recordGameActivity($request->all());
            
            \Log::info('Game activity saved successfully', [
                'activity_id' => $activity->id
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Game activity recorded successfully',
                'data' => $activity
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to save game activity', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to save game activity: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user's recent activities.
     */
    public function index()
    {
        $activities = Auth::user()->getRecentActivities(20);
        return response()->json($activities);
    }

    /**
     * Get user's game statistics.
     */
    public function statistics()
    {
        $stats = Auth::user()->getGameStatistics();
        return response()->json($stats);
    }

    /**
     * Get user's best scores by game type.
     */
    public function bestScores()
    {
        $stats = Auth::user()->getGameStatistics();
        return response()->json($stats['best_times'] ?? []);
    }

    /**
     * Get leaderboard for a specific game type.
     */
    /**
     * Get leaderboard for a specific game type.
     */
    public function leaderboard($gameType = null)
    {
        // Start building the query
        $query = GameActivity::join('users', 'game_activities.user_id', '=', 'users.id')
            ->selectRaw('
                users.id as user_id, 
                users.name, 
                users.email,
                users.profile_picture
            ');

        if ($gameType === 'overall') {
            // Overall: Rank by average time across all games, lower is better
            $query->selectRaw('avg(game_activities.time_spent) as overall_avg_time')
                  ->orderBy('overall_avg_time', 'asc');
        } else {
            // Specific game: Group by user AND difficulty to get best time per difficulty
            $query->selectRaw('min(game_activities.time_spent) as best_time, game_activities.difficulty')
                  ->where('game_activities.game_type', $gameType)
                  ->groupBy('users.id', 'users.name', 'users.profile_picture', 'users.email', 'game_activities.difficulty')
                  ->orderBy('best_time', 'asc');
        }

        $leaderboard = $query->limit(150)->get();

        // Transform collection to ensure consistency
        $leaderboard->transform(function ($item) use ($gameType) {
            // Calculate games played for the user in this context
            if ($gameType === 'overall') {
                $item->games_played = $item->total_score;
                $item->avg_accuracy = 0; 
                $item->difficulty = 'N/A';
            } else {
                $item->games_played = GameActivity::where('user_id', $item->user_id)
                    ->where('game_type', $gameType)
                    ->count();
                
                // Difficulty is now part of the item, default to 'easy' if null/missing
                $item->difficulty = $item->difficulty ?: 'easy';
            }
            
            return $item;
        });

        return $leaderboard;
    }
}

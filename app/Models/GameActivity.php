<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameActivity extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'game_type',
        'game_name',
        'score',
        'total_questions',
        'correct_answers',
        'accuracy',
        'time_spent',
        'game_data',
        'difficulty_level',
        'completed',
        'played_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'score' => 'integer',
        'total_questions' => 'integer',
        'correct_answers' => 'integer',
        'accuracy' => 'decimal:2',
        'time_spent' => 'integer',
        'game_data' => 'array',
        'difficulty_level' => 'string',
        'completed' => 'boolean',
        'played_at' => 'datetime',
    ];

    /**
     * Get the user that owns the game activity.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include activities of a given game type.
     */
    public function scopeByGameType($query, $gameType)
    {
        return $query->where('game_type', $gameType);
    }

    /**
     * Scope a query to only include completed games.
     */
    public function scopeCompleted($query)
    {
        return $query->where('completed', true);
    }

    /**
     * Scope a query to only include activities from a specific user.
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope a query to order by score descending.
     */
    public function scopeHighScore($query)
    {
        return $query->orderBy('score', 'desc');
    }

    /**
     * Scope a query to get recent activities.
     */
    public function scopeRecent($query, $days = 7)
    {
        return $query->where('played_at', '>=', now()->subDays($days));
    }

    /**
     * Calculate the performance rating based on accuracy and completion.
     */
    public function getPerformanceRating(): string
    {
        if (!$this->completed) {
            return 'Incomplete';
        }

        if ($this->accuracy >= 90) {
            return 'Excellent';
        } elseif ($this->accuracy >= 75) {
            return 'Good';
        } elseif ($this->accuracy >= 60) {
            return 'Average';
        } else {
            return 'Needs Improvement';
        }
    }

    /**
     * Get the time spent in a human-readable format.
     */
    public function getTimeSpentFormatted(): string
    {
        $minutes = floor($this->time_spent / 60);
        $seconds = $this->time_spent % 60;
        
        if ($minutes > 0) {
            return "{$minutes}m {$seconds}s";
        }
        
        return "{$seconds}s";
    }

    /**
     * Create a new game activity record.
     */
    public static function recordActivity(array $data): self
    {
        return self::create([
            'user_id' => $data['user_id'],
            'game_type' => $data['game_type'],
            'game_name' => $data['game_name'] ?? $data['game_type'],
            'score' => $data['score'] ?? 0,
            'total_questions' => $data['total_questions'] ?? 0,
            'correct_answers' => $data['correct_answers'] ?? 0,
            'accuracy' => $data['accuracy'] ?? 0,
            'time_spent' => $data['time_spent'] ?? 0,
            'game_data' => $data['game_data'] ?? null,
            'difficulty_level' => $data['difficulty_level'] ?? 'medium',
            'completed' => $data['completed'] ?? false,
            'played_at' => $data['played_at'] ?? now(),
        ]);
    }

    /**
     * Get the overall leaderboard across all games.
     */
    public static function getOverallLeaderboard($limit = 10)
    {
        return self::select(
                'users.id as user_id',
                'users.name',
                'users.profile_picture',
                
                // Count total games played
                self::raw('COUNT(*) as games_played'),
                
                // Sum total scores
                self::raw('SUM(score) as total_score'),
                
                // Calculate average accuracy
                self::raw('AVG(accuracy) as avg_accuracy')
            )
            ->join('users', 'game_activities.user_id', '=', 'users.id')
            ->completed()
            ->groupBy('users.id', 'users.name', 'users.profile_picture')
            ->orderBy('total_score', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get the leaderboard for a specific game type.
     */
    public static function getGameLeaderboard($gameType, $limit = 10)
    {
        return self::select(
                'users.id as user_id',
                'users.name',
                'users.profile_picture',
                
                // Count games played for this type
                self::raw('COUNT(*) as games_played'),
                
                // Get best score for this game type
                self::raw('MAX(score) as best_score'),
                
                // Calculate average accuracy for this game type
                self::raw('AVG(accuracy) as avg_accuracy')
            )
            ->join('users', 'game_activities.user_id', '=', 'users.id')
            ->byGameType($gameType)
            ->completed()
            ->groupBy('users.id', 'users.name', 'users.profile_picture')
            ->orderBy('best_score', 'desc')
            ->limit($limit)
            ->get();
    }
}

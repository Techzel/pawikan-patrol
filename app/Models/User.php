<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'phone',
        'role',
        'is_active',
        'last_login_at',
        'profile_picture',
        'created_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * The accessors to append to the model's array form.
     * Get the user's game activities.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    /**
     * Get the user's game activities.
     */
    public function gameActivities()
    {
        return $this->hasMany(GameActivity::class);
    }

    /**
     * Get the user's verification record.
     */
    public function verification(): HasOne
    {
        return $this->hasOne(UserVerification::class);
    }

    /**
     * Get the user's patroller profile.
     */
    public function patrollerProfile(): HasOne
    {
        return $this->hasOne(PatrollerProfile::class);
    }



    /**
     * Get the admin who created this user.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    /**
     * Get the created by display name.
     */
    public function getCreatedByDisplayName()
    {
        if ($this->created_by === 'admin') {
            return 'admin';
        }
        
        return $this->createdBy ? $this->createdBy->name : 'Unknown';
    }

    /**
     * Get the username field for authentication.
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getVerifierAttribute()
    {
        return $this->verification ? $this->verification->verifier : null;
    }

    /**
     * Legacy accessor for verifiedBy to maintain backward compatibility with views.
     */
    public function getVerifiedByAttribute()
    {
        return $this->verifier;
    }

    /**
     * Legacy accessor for verification_status to maintain backward compatibility.
     */
    public function getVerificationStatusAttribute()
    {
        return $this->verification ? $this->verification->status : 'unverified';
    }

    /**
     * Scope to filter by verification status (abstracts the join/whereHas).
     */
    public function scopeHasVerificationStatus($query, $status)
    {
        return $query->whereHas('verification', function($q) use ($status) {
            $q->where('status', $status);
        });
    }

    /**
     * Check if the user is verified.
     *
     * @return bool
     */
    public function isVerified()
    {
        return $this->verification_status === 'verified';
    }

    /**
     * Check if the user is pending verification.
     *
     * @return bool
     */
    public function isPendingVerification()
    {
        return $this->verification_status === 'pending';
    }

    /**
     * Check if the user is rejected.
     *
     * @return bool
     */
    public function isRejected()
    {
        return $this->verification_status === 'rejected';
    }

    /**
     * Get the verification status display text.
     */
    public function getVerificationStatusText()
    {
        return $this->verification ? $this->verification->getStatusText() : 'Unverified';
    }

    /**
     * Get the verification status badge HTML.
     */
    public function getVerificationBadge()
    {
        return $this->verification ? $this->verification->getStatusBadge() : '<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-500/20 text-gray-100 border border-gray-500/30"><i class="fas fa-question mr-1"></i> Unverified</span>';
    }

    // Simplified verification checks removed in favor of consistent relationship usage 
    // or consolidated into getVerificationBadge/Text methods.

    /**
     * Check if user is under review using the new verification system.
     *
     * @return bool
     */
    public function isUnderReview()
    {
        if ($this->verification) {
            return $this->verification->isUnderReview();
        }
        
        return false;
    }

    /**
     * Check if user requires resubmission using the new verification system.
     *
     * @return bool
     */
    public function requiresResubmission()
    {
        if ($this->verification) {
            return $this->verification->requiresResubmission();
        }
        
        return false;
    }

    /**
     * Check if the user is an admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if the user is a patroller.
     *
     * @return bool
     */
    public function isPatroller()
    {
        return $this->role === 'patroller';
    }

    /**
     * Check if the user is active.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->is_active;
    }

    /**
     * Legacy accessor for status to maintain backward compatibility.
     * Maps is_active boolean to 'active'/'inactive' strings.
     *
     * @return string
     */
    public function getStatusAttribute()
    {
        return $this->is_active ? 'active' : 'inactive';
    }

     /**
      * Get the user's total score across all games (Total Games Played for now).
      */
    public function getTotalScoreAttribute()
    {
        return $this->gameActivities()->count();
    }

    /**
     * Get the user's total games played.
     */
    public function getTotalGamesPlayedAttribute()
    {
        return $this->gameActivities()->count();
    }

    /**
     * Get the user's average accuracy across all games.
     */
    /**
     * Get the user's average accuracy across all games.
     * @deprecated Accuracy is no longer tracked in the simple schema
     */
    public function getAverageAccuracyAttribute()
    {
        return 0;
    }

    /**
     * Get the user's overall rank across all games (based on average time - lower is better).
     */
    public function getOverallRank()
    {
        $myAvgTime = $this->gameActivities()->avg('time_spent');
        if (!$myAvgTime) return null;

        // Rank by average time (lower is better)
        $betterRankers = \DB::table('game_activities')
            ->selectRaw('avg(time_spent) as avg_time')
            ->groupBy('user_id')
            ->having('avg_time', '<', $myAvgTime)
            ->get()
            ->count();
            
        return $betterRankers + 1;
    }



    /**
     * Get the user's rank for a specific game type.
     */
    public function getGameRank($gameType)
    {
        if ($gameType === 'quiz') {
            // Rank by score (high to low)
            $myHighScore = $this->gameActivities()
                ->where('game_type', $gameType)
                ->max('score');
            
            if ($myHighScore === null) return null;

            // Count users with strictly better (higher) score
            // For simplicity in this helper, we only look at score primarily
            $betterRankers = \DB::table('game_activities')
                ->selectRaw('max(score) as high_score')
                ->where('game_type', $gameType)
                ->groupBy('user_id')
                ->having('high_score', '>', $myHighScore)
                ->get()
                ->count();

            // Tie-breaking with time could be added here, but let's keep it simple for the profile card
            
            return $betterRankers + 1;
        }

        // Default: Rank by time (lower is better) for other games
        // Get user's best time
        $myBestTime = $this->gameActivities()
            ->where('game_type', $gameType)
            ->min('time_spent');
            
        if (!$myBestTime) return null;

        // Rank by time (lower is better)
        // Count users with a strictly better (lower) time
        $betterRankers = \DB::table('game_activities')
            ->selectRaw('min(time_spent) as best_time')
            ->where('game_type', $gameType)
            ->groupBy('user_id')
            ->having('best_time', '<', $myBestTime)
            ->get()
            ->count();
            
        return $betterRankers + 1;
    }

    /**
     * Get the user's best time for a specific game type.
     */
    public function getBestTimeForGame($gameType)
    {
        return $this->gameActivities()
            ->where('game_type', $gameType)
            ->min('time_spent') ?? 0;
    }

    /**
     * Get the user's high score for a specific game type (e.g. Quiz).
     */
    public function getBestScoreForGame($gameType)
    {
        return $this->gameActivities()
            ->where('game_type', $gameType)
            ->max('score') ?? 0;
    }

    /**
     * Activate the user as a patroller using the normalized PatrollerProfile relationship.
     */
    public function activatePatroller()
    {
        $this->patrollerProfile()->updateOrCreate(
            ['user_id' => $this->id],
            [
                'patroller_id' => 'PTR-' . str_pad($this->id, 4, '0', STR_PAD_LEFT),
                'patrol_since' => now(),
                'rank' => 'Member'
            ]
        );
    }

    /**
     * Get recent activities for the user.
     * 
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRecentActivities($limit = 5)
    {
        return $this->gameActivities()
            ->latest()
            ->limit($limit)
            ->get();
    }
    
    /**
     * Get game statistics for the user (counts by game type).
     * 
     * @return array
     */
    public function getGameStatistics()
    {
        $activities = $this->gameActivities;
        
        $stats = [
            'total_games' => $activities->count(),
            'by_game_type' => [],
            'best_times' => []
        ];
        
        // Group by game type
        $grouped = $activities->groupBy('game_type');
        
        foreach ($grouped as $type => $games) {
            $stats['by_game_type'][$type] = $games->count();
            $bestTime = $games->min('time_spent');
            $stats['best_times'][$type] = $bestTime;
        }
        
        return $stats;
    }
    
    /**
     * Record a new game activity for the user.
     * 
     * @param array $data
     * @return GameActivity
     */
    public function recordGameActivity(array $data)
    {
        return $this->gameActivities()->create($data);
    }

    /**
     * Get the user's progress for all games.
     */
    public function getGameProgress()
    {
        $progress = [
            'find-the-pawikan' => ['easy'],
            'memory-match' => ['easy'],
            'puzzle' => [
                0 => 1, // Image 0, max level 1
                1 => 1, // Image 1, max level 1
                2 => 1  // Image 2, max level 1
            ]
        ];

        // Find the Pawikan progression
        $findPawikanCompleted = $this->gameActivities()
            ->where('game_type', 'find-the-pawikan')
            ->pluck('difficulty')
            ->unique();
        
        if ($findPawikanCompleted->contains('easy')) $progress['find-the-pawikan'][] = 'medium';
        if ($findPawikanCompleted->contains('medium')) $progress['find-the-pawikan'][] = 'hard';

        // Memory Match progression
        $memoryMatchCompleted = $this->gameActivities()
            ->where('game_type', 'memory-match')
            ->pluck('difficulty')
            ->unique();
        
        if ($memoryMatchCompleted->contains('easy')) $progress['memory-match'][] = 'medium';
        if ($memoryMatchCompleted->contains('medium')) $progress['memory-match'][] = 'hard';

        // Puzzle progression (per image)
        // Note: For puzzle, we might need a way to track which image was played.
        // Looking at the schema, we don't have an image_index field.
        // If we want to be thorough, we might need to add it, but for now we can approximate 
        // or just use a global puzzle progression if image index isn't stored.
        // Actually, the current puzzle.blade.php uses {0: 1, 1: 1, 2: 1} in localStorage.
        // Since we don't store image index in DB, we'll just use the highest difficulty reached globally for all images if we want to sync.
        // Or better yet, we can check how 'puzzle' is recorded.
        
        $puzzleCompleted = $this->gameActivities()
            ->where('game_type', 'puzzle')
            ->select('difficulty')
            ->distinct()
            ->get();

        $maxPuzzleLevel = 1;
        foreach ($puzzleCompleted as $activity) {
            $level = 1;
            if ($activity->difficulty === 'medium') $level = 2;
            if ($activity->difficulty === 'hard') $level = 3;
            if ($level >= $maxPuzzleLevel) $maxPuzzleLevel = $level + 1;
        }
        $maxPuzzleLevel = min($maxPuzzleLevel, 3);

        $progress['puzzle'] = [
            0 => $maxPuzzleLevel,
            1 => $maxPuzzleLevel,
            2 => $maxPuzzleLevel
        ];

        return $progress;
    }
}


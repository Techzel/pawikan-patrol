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
        'verification_status',
        'verification_rejection_reason',
        'verified_by',
        'verified_at',
        'name',
        'username',
        'email',
        'password',
        'phone',
        'role',
        'is_active',
        'last_login_at',
        'patroller_id',
        'profile_picture',
        'patroller_since',
        'created_by',
        'verification_status',
        'verification_notes',
        'verified_at',
        'verified_by',
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
            'verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'patroller_since' => 'datetime',
        ];
    }

    /**
     * The accessors to append to the model's array form.
     * Get the user's game activities.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gameActivities()
    {
        return $this->hasMany(GameActivity::class);
    }

    /**
     * Get the user's verification record.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function verification()
    {
        return $this->hasOne(UserVerification::class);
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

    /**
     * Get the admin who verified this user.
     */
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
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
     *
     * @return string
     */
    public function getVerificationStatusText()
    {
        return match($this->verification_status) {
            'pending' => 'Pending Verification',
            'verified' => 'Verified',
            'rejected' => 'Rejected',
            default => 'Unknown',
        };
    }

    /**
     * Get the verification status badge HTML (legacy method for backward compatibility).
     *
     * @return string
     */
    public function getVerificationStatusBadge()
    {
        return match($this->verification_status) {
            'pending' => '<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-500/20 text-yellow-100 border border-yellow-500/30"><i class="fas fa-clock mr-1"></i> Pending</span>',
            'verified' => '<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-500/20 text-green-100 border border-green-500/30"><i class="fas fa-check-circle mr-1"></i> Verified</span>',
            'rejected' => '<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-500/20 text-red-100 border border-red-500/30"><i class="fas fa-times-circle mr-1"></i> Rejected</span>',
            default => '<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-500/20 text-gray-100 border border-gray-500/30"><i class="fas fa-question mr-1"></i> Unknown</span>',
        };
    }

    /**
     * Get the verification status badge HTML using the new verification system.
     *
     * @return string
     */
    public function getVerificationBadge()
    {
        if ($this->verification) {
            return $this->verification->getStatusBadge();
        }
        
        // Fallback to legacy system
        return $this->getVerificationStatusBadge();
    }

    /**
     * Get the verification status text using the new verification system.
     *
     * @return string
     */
    public function getVerificationText()
    {
        if ($this->verification) {
            return $this->verification->getStatusText();
        }
        
        // Fallback to legacy system
        return $this->getVerificationStatusText();
    }

    /**
     * Check if user is verified using the new verification system.
     *
     * @return bool
     */
    public function isVerifiedNew()
    {
        if ($this->verification) {
            return $this->verification->isVerified();
        }
        
        // Fallback to legacy system
        return $this->isVerified();
    }

    /**
     * Check if user is pending verification using the new verification system.
     *
     * @return bool
     */
    public function isPendingVerificationNew()
    {
        if ($this->verification) {
            return $this->verification->isPending();
        }
        
        // Fallback to legacy system
        return $this->isPendingVerification();
    }

    /**
     * Check if user is rejected using the new verification system.
     *
     * @return bool
     */
    public function isRejectedNew()
    {
        if ($this->verification) {
            return $this->verification->isRejected();
        }
        
        // Fallback to legacy system
        return $this->isRejected();
    }

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
     * Get the user's total score across all games.
     */
    public function getTotalScoreAttribute()
    {
        return $this->gameActivities()->sum('score');
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
    public function getAverageAccuracyAttribute()
    {
        return $this->gameActivities()->avg('accuracy') ?? 0;
    }

    /**
     * Get the user's best score for a specific game type.
     */
    public function getBestScoreForGame($gameType)
    {
        return $this->gameActivities()
            ->byGameType($gameType)
            ->completed()
            ->max('score') ?? 0;
    }

    /**
     * Get the user's recent game activities.
     */
    public function getRecentActivities($limit = 10)
    {
        return $this->gameActivities()
            ->with('user')
            ->orderBy('played_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get the user's game statistics.
     */
    public function getGameStatistics()
    {
        $activities = $this->gameActivities();
        
        return [
            'total_games' => $activities->count(),
            'total_score' => $activities->sum('score'),
            'average_accuracy' => $activities->avg('accuracy') ?? 0,
            'total_time_spent' => $activities->sum('time_spent'),
            'completed_games' => $activities->completed()->count(),
            'games_by_type' => $activities->selectRaw('game_type, count(*) as count')
                ->groupBy('game_type')
                ->pluck('count', 'game_type')
                ->toArray(),
            'best_scores' => $activities->selectRaw('game_type, max(score) as best_score')
                ->groupBy('game_type')
                ->pluck('best_score', 'game_type')
                ->toArray(),
        ];
    }

    /**
     * Record a new game activity for the user.
     */
    public function recordGameActivity(array $data)
    {
        $data['user_id'] = $this->id;
        return GameActivity::recordActivity($data);
    }

    /**
     * Get the user's overall rank across all games.
     */
    public function getOverallRank()
    {
        $userTotalScore = $this->total_score;
        
        if ($userTotalScore == 0) {
            return null;
        }
        
        // Count users with higher total scores
        $rank = GameActivity::select('users.id')
            ->join('users', 'game_activities.user_id', '=', 'users.id')
            ->completed()
            ->groupBy('users.id')
            ->havingRaw('SUM(score) > ?', [$userTotalScore])
            ->count();
        
        return $rank + 1; // Add 1 because ranks start at 1
    }

    /**
     * Get the user's rank for a specific game type.
     */
    public function getGameRank($gameType)
    {
        $userBestScore = $this->getBestScoreForGame($gameType);
        
        if ($userBestScore == 0) {
            return null;
        }
        
        // Count users with higher best scores for this game type
        $rank = GameActivity::select('users.id')
            ->join('users', 'game_activities.user_id', '=', 'users.id')
            ->byGameType($gameType)
            ->completed()
            ->groupBy('users.id')
            ->havingRaw('MAX(score) > ?', [$userBestScore])
            ->count();
        
        return $rank + 1; // Add 1 because ranks start at 1
    }

    /**
     * Activate the user as a patroller by generating a patroller ID and setting the patroller_since timestamp.
     *
     * @return void
     */
    public function activatePatroller()
    {
        if (!$this->patroller_id) {
            $this->patroller_id = 'PTR-' . str_pad($this->id, 4, '0', STR_PAD_LEFT);
        }
        
        if (!$this->patroller_since) {
            $this->patroller_since = now();
        }
        
        $this->save();
    }

}

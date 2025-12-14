<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'game_type',

        'time_spent',
        'moves',
        'difficulty',
        'played_at'
    ];

    protected $casts = [
        'played_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include activities of a specific game type.
     */
    public function scopeByGameType($query, $gameType)
    {
        return $query->where('game_type', $gameType);
    }

    /**
     * Scope a query to only include completed games.
     * Since we removed the status field, all records are considered completed.
     */
    public function scopeCompleted($query)
    {
        return $query; // All game activities are completed by default
    }
}

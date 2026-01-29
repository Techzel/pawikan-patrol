<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PatrollerProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'patroller_id',
        'badge_number',
        'rank',
        'bio',
        'department',
        'patrol_areas',
        'patrol_since',
        'total_patrols',
        'turtles_saved',
        'nests_protected',
        'performance_rating',
    ];

    protected $casts = [
        'patrol_since' => 'datetime',
        'patrol_areas' => 'array',
        'performance_rating' => 'float',
    ];

    /**
     * Get the user that owns the patroller profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

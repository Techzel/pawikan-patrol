<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PatrolReportPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'patrol_report_id',
        'photo_path',
        'caption',
        'display_order',
    ];

    protected $casts = [
        'display_order' => 'integer',
    ];

    /**
     * Get the patrol report that owns the photo.
     */
    public function patrolReport(): BelongsTo
    {
        return $this->belongsTo(PatrolReport::class);
    }

    /**
     * Get the full URL for the photo.
     */
    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->photo_path);
    }
}

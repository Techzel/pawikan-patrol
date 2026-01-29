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
        // If it's a base64 string, return it directly
        if (str_starts_with($this->photo_path, 'data:')) {
            return $this->photo_path;
        }
        
        // If it's already a URL, return it
        if (filter_var($this->photo_path, FILTER_VALIDATE_URL)) {
            return $this->photo_path;
        }

        return asset('storage/' . $this->photo_path);
    }
}

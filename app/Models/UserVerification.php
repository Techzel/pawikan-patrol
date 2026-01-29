<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserVerification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'rejection_reason',
        'admin_notes',
        'verified_by',
        'verified_at',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    /**
     * Get the user that owns the verification.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the status display text.
     */
    public function getStatusText(): string
    {
        return match($this->status) {
            'pending' => 'Pending Verification',
            'verified' => 'Verified',
            'rejected' => 'Rejected',
            'under_review' => 'Under Review',
            'requires_resubmission' => 'Requires Resubmission',
            default => ucfirst($this->status),
        };
    }

    /**
     * Get the status badge HTML.
     */
    public function getStatusBadge(): string
    {
        return match($this->status) {
            'pending' => '<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-500/20 text-yellow-100 border border-yellow-500/30"><i class="fas fa-clock mr-1"></i> Pending</span>',
            'verified' => '<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-500/20 text-green-100 border border-green-500/30"><i class="fas fa-check-circle mr-1"></i> Verified</span>',
            'rejected' => '<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-500/20 text-red-100 border border-red-500/30"><i class="fas fa-times-circle mr-1"></i> Rejected</span>',
            'under_review' => '<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-500/20 text-blue-100 border border-blue-500/30"><i class="fas fa-search mr-1"></i> Under Review</span>',
            'requires_resubmission' => '<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-500/20 text-orange-100 border border-orange-500/30"><i class="fas fa-exclamation-triangle mr-1"></i> Resubmission Needed</span>',
            default => '<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-500/20 text-gray-100 border border-gray-500/30"> ' . ucfirst($this->status) . '</span>',
        };
    }

    /**
     * Check if status is verified.
     */
    public function isVerified(): bool
    {
        return $this->status === 'verified';
    }

    /**
     * Check if status is pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if status is rejected.
     */
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    /**
     * Check if status is under review.
     */
    public function isUnderReview(): bool
    {
        return $this->status === 'under_review';
    }

    /**
     * Check if status requires resubmission.
     */
    public function requiresResubmission(): bool
    {
        return $this->status === 'requires_resubmission';
    }
    /**
     * Get the admin who verified the user.
     */
    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class PatrolReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'patroller_id',
        'report_type',
        'title',
        'description',
        'location',
        'latitude',
        'longitude',
        'priority',
        'status',
        'images',
        'evidence',
        'gender',
        'egg_count',
        'turtle_count',
        'turtle_species',
        'turtle_condition',
        'weather_conditions',
        'immediate_actions',
        'recommendations',
        'requires_followup',
        'incident_datetime',
        'reviewed_by',
        'admin_notes',
        'reviewed_at',
        'validated_by',
        'validated_at',
        'validation_notes',
        'evidence_verified',
        'location_verified',
        'followup_notes',
        'validation_status',
        'needs_followup'
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'turtle_count' => 'integer',
        'requires_followup' => 'boolean',
        'images' => 'array',
        'evidence' => 'array',
        'incident_datetime' => 'datetime',
        'reviewed_at' => 'datetime',
        'validated_at' => 'datetime',
        'evidence_verified' => 'boolean',
        'location_verified' => 'boolean',
        'needs_followup' => 'boolean',
    ];

    protected $appends = ['validation_status_label', 'report_type_label'];

    // Validation statuses (renamed to avoid conflict with status types)
    const VALIDATION_PENDING = 'pending_validation';
    const VALIDATION_APPROVED = 'validated';
    const VALIDATION_NEEDS_CORRECTION = 'needs_correction';
    const VALIDATION_REJECTED = 'validation_rejected';

    /**
     * Get all possible validation statuses
     *
     * @return array
     */
    public static function getValidationStatuses()
    {
        return [
            self::VALIDATION_PENDING => 'Pending Validation',
            self::VALIDATION_APPROVED => 'Validated',
            self::VALIDATION_NEEDS_CORRECTION => 'Needs Correction',
            self::VALIDATION_REJECTED => 'Rejected',
        ];
    }

    /**
     * Get the validation status label
     *
     * @return string
     */
    public function getValidationStatusLabelAttribute()
    {
        $statuses = self::getValidationStatuses();
        return $statuses[$this->validation_status] ?? 'Unknown';
    }

    /**
     * Check if the report is validated
     *
     * @return bool
     */
    public function isValidated()
    {
        return $this->validation_status === self::VALIDATION_APPROVED;
    }

    /**
     * Check if the report needs correction
     *
     * @return bool
     */
    public function needsCorrection()
    {
        return $this->validation_status === self::VALIDATION_NEEDS_CORRECTION;
    }

    /**
     * Check if the report is rejected
     *
     * @return bool
     */
    public function isRejected()
    {
        return $this->validation_status === self::VALIDATION_REJECTED;
    }

    /**
     * Check if the report is pending validation
     *
     * @return bool
     */
    public function isPendingValidation()
    {
        return $this->validation_status === self::VALIDATION_PENDING || empty($this->validation_status);
    }


    /**
     * Scope a query to only include reports that need validation
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNeedsValidation($query)
    {
        return $query->whereIn('validation_status', [self::VALIDATION_PENDING, null])
                    ->orWhere('validation_status', self::VALIDATION_NEEDS_CORRECTION);
    }

    /**
     * Scope a query to only include validated reports
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeValidated($query)
    {
        return $query->where('validation_status', self::VALIDATION_APPROVED);
    }

    /**
     * Scope a query to only include reports that need correction
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNeedsCorrection($query)
    {
        return $query->where('validation_status', self::VALIDATION_NEEDS_CORRECTION);
    }

    /**
     * Scope a query to only include rejected reports
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRejected($query)
    {
        return $query->where('validation_status', self::VALIDATION_REJECTED);
    }

    // Report types
    const TYPE_NESTING = 'nesting';
    const TYPE_HATCHLING = 'hatchling';
    const TYPE_STRANDING = 'stranding';
    const TYPE_RESCUE = 'rescue';
    const TYPE_HAZARD = 'hazard';
    const TYPE_SIGHTING = 'sighting';
    const TYPE_INCIDENT = 'incident';
    const TYPE_OBSERVATION = 'observation';
    const TYPE_MAINTENANCE = 'maintenance';
    const TYPE_EMERGENCY = 'emergency';

    // Species types
    const SPECIES_OLIVE_RIDLEY = 'olive_ridley';
    const SPECIES_GREEN_SEA_TURTLE = 'green_sea_turtle';
    const SPECIES_HAWKSBILL = 'hawksbill';
    const SPECIES_LEATHERBACK = 'leatherback';
    const SPECIES_LOGGERHEAD = 'loggerhead';

    // Gender types
    const GENDER_MALE = 'male';
    const GENDER_FEMALE = 'female';
    const GENDER_UNKNOWN = 'unknown';

    // Incident categories
    const INCIDENT_INJURY = 'injury';
    const INCIDENT_POACHING = 'poaching';
    const INCIDENT_POLLUTION = 'pollution';
    const INCIDENT_STRANDING = 'stranding';
    const INCIDENT_OTHER = 'other';

    // Priority levels
    const PRIORITY_LOW = 'low';
    const PRIORITY_MEDIUM = 'medium';
    const PRIORITY_HIGH = 'high';
    const PRIORITY_CRITICAL = 'critical';

    // Status types
    const STATUS_SUBMITTED = 'submitted';
    const STATUS_PENDING = 'pending';
    const STATUS_ACCEPTED = 'accepted';
    const STATUS_REJECTED = 'rejected';
    const STATUS_VERIFIED = 'verified';
    const STATUS_NEEDS_CORRECTION = 'needs_correction';
    const STATUS_UNDER_REVIEW = 'under_review';
    const STATUS_RESOLVED = 'resolved';
    const STATUS_CLOSED = 'closed';
    
    
    // Turtle conditions
    const CONDITION_HEALTHY = 'healthy';
    const CONDITION_INJURED = 'injured';
    const CONDITION_DEAD = 'dead';
    const CONDITION_UNKNOWN = 'unknown';
    
    
    
    /**
     * Scope a query to only include pending validation reports.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePendingValidation($query)
    {
        return $query->where('validation_status', self::VALIDATION_PENDING)
                    ->orWhereNull('validation_status');
    }

    /**
     * Get the patroller who submitted the report.
     */
    public function patroller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'patroller_id');
    }

    /**
     * Alias for patroller relationship (for compatibility with controller).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'patroller_id');
    }

    /**
     * Get the admin who reviewed the report.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Get the admin who validated the report.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function validator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

    /**
     * Alias for validator relationship (for compatibility with controller).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

    /**
     * Get the photos associated with the report.
     */
    public function photos(): HasMany
    {
        return $this->hasMany(PatrolReportPhoto::class)->orderBy('display_order');
    }

    /**
     * Scope a query to only include verified reports.
     */
    public function scopeVerified($query)
    {
        return $query->where('status', self::STATUS_VERIFIED);
    }

    /**
     * Scope a query to only include public reports.
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    /**
     * Scope a query to filter by report type.
     */
    public function scopeByType($query, $type)
    {
        return $query->where('report_type', $type);
    }

    /**
     * Scope a query to filter by species.
     */
    public function scopeBySpecies($query, $species)
    {
        return $query->where('species', $species);
    }

    /**
     * Scope a query to filter by gender.
     */
    public function scopeByGender($query, $gender)
    {
        return $query->where('gender', $gender);
    }

    /**
     * Scope a query to filter by egg count range.
     */
    public function scopeByEggCountRange($query, $min, $max)
    {
        return $query->whereBetween('egg_count', [$min, $max]);
    }

    /**
     * Scope a query to filter by incident type.
     */
    public function scopeByIncidentType($query, $incidentType)
    {
        return $query->where('incident_type', $incidentType);
    }

    /**
     * Scope a query to find reports within a certain radius of a point.
     */
    public function scopeWithinRadius($query, $latitude, $longitude, $radius)
    {
        // Using Haversine formula for distance calculation
        return $query->selectRaw(
            "*, (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance",
            [$latitude, $longitude, $latitude]
        )->havingRaw('distance <= ?', [$radius]);
    }

    /**
     * Report type select options (new taxonomy).
     */
    public static function getReportTypeOptions(): array
    {
        return [
            self::TYPE_NESTING => 'Nesting Report',
            self::TYPE_HATCHLING => 'Hatchling Report',
            self::TYPE_STRANDING => 'Stranding Report',
            self::TYPE_RESCUE => 'Rescue & Rehabilitation Report',
            self::TYPE_HAZARD => 'Threat / Hazard Report',
        ];
    }

    /**
     * Legacy report type labels that may still exist in historical data.
     */
    public static function getLegacyReportTypeLabels(): array
    {
        return [
            self::TYPE_SIGHTING => 'Wildlife Sighting',
            self::TYPE_INCIDENT => 'Incident Report',
            self::TYPE_OBSERVATION => 'Observation Report',
            self::TYPE_MAINTENANCE => 'Maintenance Issue',
            self::TYPE_EMERGENCY => 'Emergency Report',
        ];
    }

    /**
     * Combined mapping for all known report type labels.
     */
    public static function getAllReportTypeLabels(): array
    {
        return self::getReportTypeOptions() + self::getLegacyReportTypeLabels();
    }

    /**
     * Allowed values for validation. Can optionally include legacy types.
     */
    public static function getReportTypeValidationKeys(bool $includeLegacy = false): array
    {
        return array_keys($includeLegacy ? self::getAllReportTypeLabels() : self::getReportTypeOptions());
    }

    /**
     * Helper to provide consistent badge color classes per report type.
     */
    public static function getReportTypeBadgeClasses(string $type): string
    {
        return match ($type) {
            self::TYPE_NESTING => 'bg-emerald-500/20 text-emerald-300',
            self::TYPE_HATCHLING => 'bg-teal-500/20 text-teal-300',
            self::TYPE_STRANDING => 'bg-orange-500/20 text-orange-300',
            self::TYPE_RESCUE => 'bg-blue-500/20 text-blue-300',
            self::TYPE_HAZARD => 'bg-red-500/20 text-red-300',
            default => 'bg-gray-500/20 text-gray-300',
        };
    }

    /**
     * Get human-readable species name.
     */
    public function getSpeciesNameAttribute(): string
    {
        return match($this->species) {
            self::SPECIES_OLIVE_RIDLEY => 'Olive Ridley',
            self::SPECIES_GREEN_SEA_TURTLE => 'Green Sea Turtle',
            self::SPECIES_HAWKSBILL => 'Hawksbill',
            self::SPECIES_LEATHERBACK => 'Leatherback',
            self::SPECIES_LOGGERHEAD => 'Loggerhead',
            default => 'Unknown Species',
        };
    }

    /**
     * Get human-readable report type name.
     */
    public function getReportTypeLabelAttribute(): string
    {
        $labels = self::getAllReportTypeLabels();

        if (isset($labels[$this->report_type])) {
            return $labels[$this->report_type];
        }

        return Str::headline($this->report_type ?? 'Unknown');
    }

    public function getReportTypeNameAttribute(): string
    {
        return $this->report_type_label;
    }

    /**
     * Get human-readable incident type name.
     */
    public function getIncidentTypeNameAttribute(): string
    {
        return match($this->incident_type) {
            self::INCIDENT_INJURY => 'Injury',
            self::INCIDENT_POACHING => 'Poaching',
            self::INCIDENT_POLLUTION => 'Pollution',
            self::INCIDENT_STRANDING => 'Stranding',
            self::INCIDENT_OTHER => 'Other',
            default => 'Unknown Incident',
        };
    }

    /**
     * Get status badge color.
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            self::STATUS_PENDING => 'warning',
            self::STATUS_VERIFIED => 'success',
            self::STATUS_REJECTED => 'danger',
            default => 'secondary',
        };
    }

    /**
     * Get formatted coordinates.
     */
    public function getFormattedCoordinatesAttribute(): string
    {
        return sprintf('%s, %s', number_format($this->latitude, 6), number_format($this->longitude, 6));
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patroller extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'patroller_id',
        'badge_number',
        'department',
        'supervisor_id',
        'emergency_contact',
        'emergency_phone',
        'certifications',
        'training_completed',
        'specializations',
        'equipment_assigned',
        'status',
        'availability_schedule',
        'performance_rating',
        'last_performance_review',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected function casts(): array
    {
        return [
            'certifications' => 'array',
            'training_completed' => 'array',
            'specializations' => 'array',
            'equipment_assigned' => 'array',
            'availability_schedule' => 'array',
            'performance_rating' => 'decimal:2',
            'last_performance_review' => 'datetime',
            'emergency_phone' => 'string',
        ];
    }

    /**
     * Get the user that owns the patroller profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the supervisor that oversees this patroller.
     */
    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    /**
     * Get the patrol reports submitted by this patroller.
     */
    public function patrolReports()
    {
        return $this->hasMany(PatrolReport::class);
    }

    /**
     * Get the turtle sightings reported by this patroller.
     */
    public function turtleSightings()
    {
        return $this->hasMany(TurtleSighting::class);
    }

    /**
     * Get the nest discoveries made by this patroller.
     */
    public function nestDiscoveries()
    {
        return $this->hasMany(NestDiscovery::class);
    }

    /**
     * Get the rescue operations participated in by this patroller.
     */
    public function rescueOperations()
    {
        return $this->hasMany(RescueOperation::class);
    }

    /**
     * Scope a query to only include active patrollers.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include inactive patrollers.
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    /**
     * Scope a query to only include patrollers on leave.
     */
    public function scopeOnLeave($query)
    {
        return $query->where('status', 'on_leave');
    }

    /**
     * Scope a query to only include patrollers in a specific department.
     */
    public function scopeInDepartment($query, $department)
    {
        return $query->where('department', $department);
    }

    /**
     * Scope a query to only include patrollers with a specific certification.
     */
    public function scopeWithCertification($query, $certification)
    {
        return $query->whereJsonContains('certifications', $certification);
    }

    /**
     * Scope a query to only include patrollers with a specific specialization.
     */
    public function scopeWithSpecialization($query, $specialization)
    {
        return $query->whereJsonContains('specializations', $specialization);
    }

    /**
     * Get the patroller's full name with title.
     *
     * @return string
     */
    public function getFullNameWithTitleAttribute()
    {
        return "Patroller {$this->user->name}";
    }

    /**
     * Get the patroller's status badge HTML.
     *
     * @return string
     */
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'active' => '<span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Active</span>',
            'inactive' => '<span class="px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full">Inactive</span>',
            'on_leave' => '<span class="px-2 py-1 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded-full">On Leave</span>',
            'suspended' => '<span class="px-2 py-1 text-xs font-semibold text-gray-800 bg-gray-100 rounded-full">Suspended</span>',
        ];

        return $badges[$this->status] ?? $badges['inactive'];
    }

    /**
     * Get the patroller's performance level.
     *
     * @return string
     */
    public function getPerformanceLevelAttribute()
    {
        $rating = $this->performance_rating ?? 0;

        if ($rating >= 4.5) return 'Exceptional';
        if ($rating >= 4.0) return 'Excellent';
        if ($rating >= 3.5) return 'Good';
        if ($rating >= 3.0) return 'Satisfactory';
        return 'Needs Improvement';
    }

    /**
     * Get the patroller's certifications as formatted list.
     *
     * @return string
     */
    public function getCertificationsFormattedAttribute()
    {
        if (empty($this->certifications)) {
            return 'No certifications';
        }

        return is_array($this->certifications) 
            ? implode(', ', $this->certifications)
            : $this->certifications;
    }

    /**
     * Get the patroller's specializations as formatted list.
     *
     * @return string
     */
    public function getSpecializationsFormattedAttribute()
    {
        if (empty($this->specializations)) {
            return 'No specializations';
        }

        return is_array($this->specializations) 
            ? implode(', ', $this->specializations)
            : $this->specializations;
    }

    /**
     * Get the patroller's total conservation impact from user data.
     *
     * @return int
     */
    public function getTotalConservationImpactAttribute()
    {
        return $this->user ? $this->user->total_conservation_impact : 0;
    }

    /**
     * Get the patroller's rank from user data.
     *
     * @return string
     */
    public function getPatrollerRankAttribute()
    {
        return $this->user ? $this->user->patroller_rank : 'Unknown';
    }

    /**
     * Check if the patroller is currently on duty.
     *
     * @return bool
     */
    public function isOnDuty()
    {
        if (empty($this->availability_schedule)) {
            return false;
        }

        $currentDay = strtolower(date('l'));
        $currentTime = date('H:i');

        $schedule = is_array($this->availability_schedule) 
            ? $this->availability_schedule 
            : json_decode($this->availability_schedule, true);

        if (isset($schedule[$currentDay])) {
            $daySchedule = $schedule[$currentDay];
            if ($daySchedule['available'] && isset($daySchedule['start_time'], $daySchedule['end_time'])) {
                return $currentTime >= $daySchedule['start_time'] && $currentTime <= $daySchedule['end_time'];
            }
        }

        return false;
    }

    /**
     * Add a certification to the patroller.
     *
     * @param string $certification
     * @return void
     */
    public function addCertification($certification)
    {
        $certifications = $this->certifications ?? [];
        if (!in_array($certification, $certifications)) {
            $certifications[] = $certification;
            $this->update(['certifications' => $certifications]);
        }
    }

    /**
     * Remove a certification from the patroller.
     *
     * @param string $certification
     * @return void
     */
    public function removeCertification($certification)
    {
        $certifications = $this->certifications ?? [];
        if (($key = array_search($certification, $certifications)) !== false) {
            unset($certifications[$key]);
            $this->update(['certifications' => array_values($certifications)]);
        }
    }

    /**
     * Add a specialization to the patroller.
     *
     * @param string $specialization
     * @return void
     */
    public function addSpecialization($specialization)
    {
        $specializations = $this->specializations ?? [];
        if (!in_array($specialization, $specializations)) {
            $specializations[] = $specialization;
            $this->update(['specializations' => $specializations]);
        }
    }

    /**
     * Remove a specialization from the patroller.
     *
     * @param string $specialization
     * @return void
     */
    public function removeSpecialization($specialization)
    {
        $specializations = $this->specializations ?? [];
        if (($key = array_search($specialization, $specializations)) !== false) {
            unset($specializations[$key]);
            $this->update(['specializations' => array_values($specializations)]);
        }
    }

    /**
     * Update performance rating.
     *
     * @param float $rating
     * @param string|null $notes
     * @return void
     */
    public function updatePerformanceRating($rating, $notes = null)
    {
        $updateData = [
            'performance_rating' => $rating,
            'last_performance_review' => now(),
        ];

        if ($notes !== null) {
            $updateData['notes'] = $notes;
        }

        $this->update($updateData);
    }

    /**
     * Get the patroller's contact information.
     *
     * @return array
     */
    public function getContactInfoAttribute()
    {
        return [
            'email' => $this->user->email ?? 'N/A',
            'phone' => $this->user->phone ?? 'N/A',
            'emergency_contact' => $this->emergency_contact ?? 'N/A',
            'emergency_phone' => $this->emergency_phone ?? 'N/A',
        ];
    }

    /**
     * Get the patroller's assignment summary.
     *
     * @return array
     */
    public function getAssignmentSummaryAttribute()
    {
        return [
            'department' => $this->department ?? 'Unassigned',
            'supervisor' => $this->supervisor ? $this->supervisor->name : 'Unassigned',
            'patrol_areas' => $this->user ? $this->user->patrol_areas_formatted : 'No areas assigned',
            'status' => $this->status ?? 'inactive',
            'on_duty' => $this->isOnDuty(),
        ];
    }
}

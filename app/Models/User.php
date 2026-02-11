<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'fname',
        'mname',
        'lname',
        'course',
        'gender',
        'email',
        'password',
        'role',
        'specialization',
        'experience',
        'coach_id',
        'photo',
        'date_of_birth',
        'athlete_id',
        'nickname',
        'age',
        'nationality',
        'place_of_birth',
        'current_residence',
        'height',
        'weight',
        'wingspan',
        'body_fat_percentage',
        'dominant_hand',
        'dominant_foot',
        'position_role',
        'jersey_number',
        'primary_sport',
        'discipline_event',
        'level',
        'years_active',
        'club_team_name',
        'league_federation',
        'training_location',
        'strength_conditioning_program',
        'weekly_training_hours',
        'secondary_sports',
        'key_performance_metrics',
        'personal_bests',
        'seasonal_statistics',
        'career_statistics',
        'rankings',
        'competition_history',
        'recovery_methods',
        'sports_academies_attended',
        'injury_history',
        'medical_conditions',
        'current_injuries',
        'rehabilitation_status',
        'last_physical_examination',
        'clearance_status',
        'certifications',
        'scholarships_grants',
        'medals_awards',
        'records_held',
        'notable_performances',
        'education_level',
        'school_university',
        'titles_won',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'date',
            'last_physical_examination' => 'date',

            // JSON fields
            'secondary_sports' => 'array',
            'key_performance_metrics' => 'array',
            'personal_bests' => 'array',
            'seasonal_statistics' => 'array',
            'career_statistics' => 'array',
            'rankings' => 'array',
            'competition_history' => 'array',
            'recovery_methods' => 'array',
            'injury_history' => 'array',
            'current_injuries' => 'array',
            'medical_conditions' => 'array',
            'titles_won' => 'array',
            'medals_awards' => 'array',
            'records_held' => 'array',
            'notable_performances' => 'array',
            'scholarships_grants' => 'array',
            'sports_academies_attended' => 'array',
            'certifications' => 'array',
        ];
    }

    // Accessor methods to ensure array fields are always arrays
    public function getSecondarySportsAttribute($value)
    {
        return $this->ensureArray($value);
    }

    public function getKeyPerformanceMetricsAttribute($value)
    {
        return $this->ensureArray($value);
    }

    public function getPersonalBestsAttribute($value)
    {
        return $this->ensureArray($value);
    }

    public function getSeasonalStatisticsAttribute($value)
    {
        return $this->ensureArray($value);
    }

    public function getCareerStatisticsAttribute($value)
    {
        return $this->ensureArray($value);
    }

    public function getRankingsAttribute($value)
    {
        return $this->ensureArray($value);
    }

    public function getCompetitionHistoryAttribute($value)
    {
        return $this->ensureArray($value);
    }

    public function getRecoveryMethodsAttribute($value)
    {
        return $this->ensureArray($value);
    }

    public function getInjuryHistoryAttribute($value)
    {
        return $this->ensureArray($value);
    }

    public function getCurrentInjuriesAttribute($value)
    {
        return $this->ensureArray($value);
    }

    public function getMedicalConditionsAttribute($value)
    {
        return $this->ensureArray($value);
    }

    public function getTitlesWonAttribute($value)
    {
        return $this->ensureArray($value);
    }

    public function getMedalsAwardsAttribute($value)
    {
        return $this->ensureArray($value);
    }

    public function getRecordsHeldAttribute($value)
    {
        return $this->ensureArray($value);
    }

    public function getNotablePerformancesAttribute($value)
    {
        return $this->ensureArray($value);
    }

    public function getScholarshipsGrantsAttribute($value)
    {
        return $this->ensureArray($value);
    }

    public function getSportsAcademiesAttendedAttribute($value)
    {
        return $this->ensureArray($value);
    }

    public function getCertificationsAttribute($value)
    {
        return $this->ensureArray($value);
    }

    /**
     * Ensure the value is always an array
     */
    private function ensureArray($value)
    {
        if (is_array($value)) {
            return $value;
        }

        if (is_string($value) && !empty($value)) {
            // Try to decode as JSON first
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return $decoded;
            }
            // If not valid JSON, treat as comma-separated string
            return array_map('trim', explode(',', $value));
        }

        return [];
    }

    // Relationships
    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    public function athletes()
    {
        return $this->hasMany(User::class, 'coach_id');
    }

    public function sportRequirements()
    {
        return $this->hasMany(SportRequirement::class, 'coach_id');
    }
}

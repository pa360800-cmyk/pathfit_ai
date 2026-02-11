<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'fname' => ['required', 'string', 'max:255'],
            'mname' => ['nullable', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'course' => ['nullable', 'string', 'max:255'],
            'gender' => ['nullable', 'string', 'in:Male,Female,Other'],
            'date_of_birth' => ['nullable', 'date'],
            'athlete_id' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'nickname' => ['nullable', 'string', 'max:255'],
            'age' => ['nullable', 'integer', 'min:0', 'max:150'],
            'nationality' => ['nullable', 'string', 'max:255'],
            'place_of_birth' => ['nullable', 'string', 'max:255'],
            'current_residence' => ['nullable', 'string', 'max:255'],
            'height' => ['nullable', 'numeric', 'min:0', 'max:300'],
            'weight' => ['nullable', 'numeric', 'min:0', 'max:500'],
            'wingspan' => ['nullable', 'numeric', 'min:0', 'max:300'],
            'body_fat_percentage' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'dominant_hand' => ['nullable', 'string', 'in:left,right,ambidextrous'],
            'dominant_foot' => ['nullable', 'string', 'in:left,right,both'],
            'position_role' => ['nullable', 'string', 'max:255'],
            'jersey_number' => ['nullable', 'integer', 'min:0', 'max:999'],
            'primary_sport' => ['nullable', 'string', 'max:255'],
            'discipline_event' => ['nullable', 'string', 'max:255'],
            'level' => ['nullable', 'string', 'in:youth,amateur,semi-pro,professional,elite'],
            'years_active' => ['nullable', 'integer', 'min:0', 'max:100'],
            'club_team_name' => ['nullable', 'string', 'max:255'],
            'league_federation' => ['nullable', 'string', 'max:255'],
            'training_location' => ['nullable', 'string', 'max:255'],
            'strength_conditioning_program' => ['nullable', 'string', 'max:255'],
            'weekly_training_hours' => ['nullable', 'integer', 'min:0', 'max:168'],
            'secondary_sports' => ['nullable', 'string'],
            'key_performance_metrics' => ['nullable', 'string'],
            'personal_bests' => ['nullable', 'string'],
            'seasonal_statistics' => ['nullable', 'string'],
            'career_statistics' => ['nullable', 'string'],
            'rankings' => ['nullable', 'string'],
            'competition_history' => ['nullable', 'string'],
            'recovery_methods' => ['nullable', 'string'],
            'sports_academies_attended' => ['nullable', 'string'],
            'injury_history' => ['nullable', 'string'],
            'medical_conditions' => ['nullable', 'string'],
            'current_injuries' => ['nullable', 'string'],
            'rehabilitation_status' => ['nullable', 'string', 'max:255'],
            'last_physical_examination' => ['nullable', 'date'],
            'clearance_status' => ['nullable', 'string', 'max:255'],
            'certifications' => ['nullable', 'string'],
            'scholarships_grants' => ['nullable', 'string'],
            'medals_awards' => ['nullable', 'string'],
            'records_held' => ['nullable', 'string'],
            'notable_performances' => ['nullable', 'string'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ];
    }
}

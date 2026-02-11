<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Route;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display the current user's profile.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        if ($user->role === 'Athlete') {
            return view('athlete.profile.index', compact('user'));
        } elseif ($user->role === 'Coach') {
            return view('coach.profile.index', compact('user'));
        }
        return view('admin.profile.index', compact('user'));
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        if ($request->user()->role === 'Athlete') {
            return view('athlete.profile.edit', [
                'user' => $request->user(),
            ]);
        } elseif ($request->user()->role === 'Coach') {
            return view('coach.profile.edit', [
                'user' => $request->user(),
            ]);
        }
        return view('profile.edits', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validated();

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($user->photo && \Storage::disk('public')->exists($user->photo)) {
                \Storage::disk('public')->delete($user->photo);
            }

            // Store new photo
            $photoPath = $request->file('photo')->store('photos', 'public');
            $validated['photo'] = $photoPath;
        }

        // Convert comma-separated strings to arrays for JSON fields
        $arrayFields = [
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
            'current_injuries',
            'medical_conditions',
            'titles_won',
            'medals_awards',
            'records_held',
            'notable_performances',
            'scholarships_grants',
            'certifications'
        ];
        foreach ($arrayFields as $field) {
            if (isset($validated[$field]) && is_string($validated[$field])) {
                $validated[$field] = array_map('trim', explode(',', $validated[$field]));
            }
        }

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $route = $user->role === 'Athlete' ? 'athlete.profile.index' : ($user->role === 'Coach' ? 'coach.profile.index' : 'profile.edit');
        return Redirect::route($route)->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}

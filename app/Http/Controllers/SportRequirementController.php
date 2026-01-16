<?php

namespace App\Http\Controllers;

use App\Models\SportRequirement;
use App\Models\SportAvailable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SportRequirementController extends Controller
{
    public function index()
    {
        $requirements = SportRequirement::where('coach_id', Auth::id())
            ->with('sportAvailable')
            ->get()
            ->map(function ($requirement) {
                $requirement->sport_name = $requirement->sportAvailable->name ?? 'Unknown Sport';
                return $requirement;
            });

        return view('coach.sport-requirements.index', compact('requirements'));
    }

    public function create()
    {
        $sports = SportAvailable::all();
        return view('coach.sport-requirements.create', compact('sports'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sport_available_id' => 'required|exists:sport_availables,id',
            'min_age' => 'nullable|integer|min:1|max:100',
            'max_age' => 'nullable|integer|min:1|max:100|gte:min_age',
            'min_height' => 'nullable|integer|min:50|max:250',
            'max_height' => 'nullable|integer|min:50|max:250|gte:min_height',
            'min_weight' => 'nullable|integer|min:20|max:300',
            'max_weight' => 'nullable|integer|min:20|max:300|gte:min_weight',
            'required_gender' => 'required|in:male,female,both',
            'min_experience_years' => 'nullable|integer|min:0|max:50',
            'required_level' => 'nullable|in:beginner,intermediate,advanced,professional',
            'required_positions' => 'nullable|string',
            'preferred_attributes' => 'nullable|string',
            'medical_restrictions' => 'nullable|string',
            'additional_notes' => 'nullable|string|max:1000',
            'is_active' => 'boolean'
        ]);

        SportRequirement::create([
            'coach_id' => Auth::id(),
            'sport_available_id' => $request->sport_available_id,
            'min_age' => $request->min_age,
            'max_age' => $request->max_age,
            'required_gender' => $request->required_gender,
            'min_height' => $request->min_height,
            'max_height' => $request->max_height,
            'min_weight' => $request->min_weight,
            'max_weight' => $request->max_weight,
            'min_experience_years' => $request->min_experience_years,
            'required_level' => $request->required_level,
            'required_positions' => $request->required_positions ? array_map('trim', explode(',', $request->required_positions)) : null,
            'preferred_attributes' => $request->preferred_attributes ? array_map('trim', explode(',', $request->preferred_attributes)) : null,
            'medical_restrictions' => $request->medical_restrictions ? array_map('trim', explode(',', $request->medical_restrictions)) : null,
            'additional_notes' => $request->additional_notes,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('coach.sport-requirements.index')->with('success', 'Sport requirement created successfully.');
    }

    public function show(SportRequirement $sportRequirement)
    {
        // Ensure the requirement belongs to the authenticated coach
        if ($sportRequirement->coach_id !== Auth::id()) {
            abort(403);
        }

        $sportRequirement->load('sportAvailable');
        $sportRequirement->sport_name = $sportRequirement->sportAvailable->name ?? 'Unknown Sport';
        return view('coach.sport-requirements.show', compact('sportRequirement'));
    }

    public function edit(SportRequirement $sportRequirement)
    {
        // Ensure the requirement belongs to the authenticated coach
        if ($sportRequirement->coach_id !== Auth::id()) {
            abort(403);
        }

        $sports = SportAvailable::all();
        return view('coach.sport-requirements.edit', compact('sportRequirement', 'sports'));
    }

    public function update(Request $request, SportRequirement $sportRequirement)
    {
        // Ensure the requirement belongs to the authenticated coach
        if ($sportRequirement->coach_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'sport_available_id' => 'required|exists:sport_availables,id',
            'min_age' => 'nullable|integer|min:1|max:100',
            'max_age' => 'nullable|integer|min:1|max:100|gte:min_age',
            'min_height' => 'nullable|integer|min:50|max:250',
            'max_height' => 'nullable|integer|min:50|max:250|gte:min_height',
            'min_weight' => 'nullable|integer|min:20|max:300',
            'max_weight' => 'nullable|integer|min:20|max:300|gte:min_weight',
            'required_gender' => 'required|in:male,female,both',
            'min_experience_years' => 'nullable|integer|min:0|max:50',
            'required_level' => 'nullable|in:beginner,intermediate,advanced,professional',
            'required_positions' => 'nullable|string',
            'preferred_attributes' => 'nullable|string',
            'medical_restrictions' => 'nullable|string',
            'additional_notes' => 'nullable|string|max:1000',
            'is_active' => 'boolean'
        ]);

        $sportRequirement->update([
            'sport_available_id' => $request->sport_available_id,
            'min_age' => $request->min_age,
            'max_age' => $request->max_age,
            'required_gender' => $request->required_gender,
            'min_height' => $request->min_height,
            'max_height' => $request->max_height,
            'min_weight' => $request->min_weight,
            'max_weight' => $request->max_weight,
            'min_experience_years' => $request->min_experience_years,
            'required_level' => $request->required_level,
            'required_positions' => $request->required_positions ? array_map('trim', explode(',', $request->required_positions)) : null,
            'preferred_attributes' => $request->preferred_attributes ? array_map('trim', explode(',', $request->preferred_attributes)) : null,
            'medical_restrictions' => $request->medical_restrictions ? array_map('trim', explode(',', $request->medical_restrictions)) : null,
            'additional_notes' => $request->additional_notes,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('coach.sport-requirements.index')->with('success', 'Sport requirement updated successfully.');
    }

    public function destroy(SportRequirement $sportRequirement)
    {
        // Ensure the requirement belongs to the authenticated coach
        if ($sportRequirement->coach_id !== Auth::id()) {
            abort(403);
        }

        $sportRequirement->delete();
        return redirect()->route('coach.sport-requirements.index')->with('success', 'Sport requirement deleted successfully.');
    }

    public function toggle(SportRequirement $sportRequirement)
    {
        // Ensure the requirement belongs to the authenticated coach
        if ($sportRequirement->coach_id !== Auth::id()) {
            abort(403);
        }

        $sportRequirement->update(['is_active' => !$sportRequirement->is_active]);
        return redirect()->route('coach.sport-requirements.index')->with('success', 'Sport requirement status updated successfully.');
    }
}

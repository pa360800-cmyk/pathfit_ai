<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SportRequirement;
use App\Models\SportAvailable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:Administrator,Athlete,Coach',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function adminDashboard()
    {
        $users = User::all();
        $totalUsers = User::count();
        $totalCoaches = User::where('role', 'Coach')->count();
        $totalAthletes = User::where('role', 'Athlete')->count();
        $totalAdministrators = User::where('role', 'Administrator')->count();
        $totalSports = \App\Models\SportAvailable::count();
        $totalActivities = \App\Models\SportActivity::count();
        $recentUsers = User::latest()->take(10)->get();
        $recentCoaches = User::where('role', 'Coach')->latest()->take(5)->get();
        $recentAthletes = User::where('role', 'Athlete')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'users',
            'totalUsers',
            'totalCoaches',
            'totalAthletes',
            'totalAdministrators',
            'totalSports',
            'totalActivities',
            'recentUsers',
            'recentCoaches',
            'recentAthletes'
        ));
    }

    public function userRead()
    {
        // Return view for user management
        return view('admin.dashboard');
    }

    public function userCreate(Request $request)
    {
        // Validate and create user
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:Administrator,Athlete,Coach',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->back()->with('success', 'User created successfully');
    }

    public function userEdit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.dashboard', compact('user'));
    }

    public function userUpdate(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->update($request->only(['name', 'email', 'role']));
        return redirect()->back()->with('success', 'User updated successfully');
    }

    public function userPassUpdate(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->update(['password' => Hash::make($request->password)]);
        return redirect()->back()->with('success', 'Password updated successfully');
    }

    public function userDelete($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'User deleted successfully');
    }

    public function adminCoachIndex()
    {
        $coaches = User::where('role', 'Coach')->get();
        return view('admin.coach.index', compact('coaches'));
    }

    public function createCoach()
    {
        $sports = SportAvailable::all();
        return view('admin.coach.create', compact('sports'));
    }

    public function storeCoach(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'specialization' => 'nullable|string|max:255',
            'experience' => 'nullable|integer|min:0',
            'sport_id' => 'nullable|exists:sport_availables,id',
        ]);

        $coach = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'Coach',
            'specialization' => $request->specialization,
            'experience' => $request->experience,
        ]);

        // If sport is selected, create or update sport requirement for AI qualification
        if ($request->sport_id) {
            SportRequirement::updateOrCreate(
                ['coach_id' => $coach->id, 'sport_available_id' => $request->sport_id],
                ['is_active' => true] // Default to active, can be expanded
            );
        }

        return redirect()->route('admin.coach.index')->with('success', 'Coach created successfully.');
    }

    public function showCoach(User $coach)
    {
        // Ensure the user is a coach
        if ($coach->role !== 'Coach') {
            abort(404);
        }

        return view('admin.coach.show', compact('coach'));
    }

    public function editCoach(User $coach)
    {
        // Ensure the user is a coach
        if ($coach->role !== 'Coach') {
            abort(404);
        }

        $sports = SportAvailable::all();
        return view('admin.coach.edit', compact('coach', 'sports'));
    }

    public function updateCoach(Request $request, User $coach)
    {
        // Ensure the user is a coach
        if ($coach->role !== 'Coach') {
            abort(404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $coach->id,
            'specialization' => 'nullable|string|max:255',
            'experience' => 'nullable|integer|min:0',
            'sport_id' => 'nullable|exists:sport_availables,id',
        ]);

        $coach->update([
            'name' => $request->name,
            'email' => $request->email,
            'specialization' => $request->specialization,
            'experience' => $request->experience,
        ]);

        // Update sport requirement if sport is selected
        if ($request->sport_id) {
            SportRequirement::updateOrCreate(
                ['coach_id' => $coach->id, 'sport_available_id' => $request->sport_id],
                ['is_active' => true]
            );
        }

        return redirect()->route('admin.coach.index')->with('success', 'Coach updated successfully.');
    }

    public function destroyCoach(User $coach)
    {
        // Ensure the user is a coach
        if ($coach->role !== 'Coach') {
            abort(404);
        }

        $coach->delete();

        return redirect()->route('admin.coach.index')->with('success', 'Coach deleted successfully.');
    }

    public function coachQualificationsForSport(User $coach, SportAvailable $sport)
    {
        // Get coach's requirements for this sport
        $requirement = SportRequirement::where('coach_id', $coach->id)
            ->where('sport_available_id', $sport->id)
            ->first();

        // Calculate AI qualification score (placeholder logic, can be enhanced)
        $aiQualificationScore = $this->calculateAIQualificationScore($coach, $sport);

        return view('admin.coach.qualifications', compact('coach', 'sport', 'requirement', 'aiQualificationScore'));
    }

    private function calculateAIQualificationScore(User $coach, SportAvailable $sport)
    {
        // Placeholder AI logic: Base score on experience and specialization match
        $score = 50; // Base score

        if ($coach->experience) {
            $score += min($coach->experience * 2, 30); // Up to 30 points for experience
        }

        if ($coach->specialization && stripos($coach->specialization, $sport->name) !== false) {
            $score += 20; // Bonus for specialization match
        }

        return min($score, 100); // Cap at 100
    }

    public function assignCoachIndex()
    {
        $athletes = User::where('role', 'Athlete')->get();
        $coaches = User::where('role', 'Coach')->get();

        // Calculate qualification scores for each athlete-coach pair
        $qualificationScores = [];
        foreach ($athletes as $athlete) {
            foreach ($coaches as $coach) {
                $score = $this->calculateQualificationScore($athlete, $coach);
                $qualificationScores[$athlete->id][$coach->id] = $score;
            }
        }

        return view('admin.assigncoach.index', compact('athletes', 'coaches', 'qualificationScores'));
    }

    public function assignCoachStore(Request $request)
    {
        $request->validate([
            'athlete_id' => 'required|exists:users,id',
            'coach_id' => 'required|exists:users,id',
        ]);

        // Here you would typically create or update a relationship
        // For example, if there's a pivot table or a field in users table
        // Since the exact relationship isn't specified, I'll assume updating a field or creating a record

        // For now, let's assume we have a coach_id field in users table or similar
        // You may need to adjust this based on your database schema

        $athlete = User::findOrFail($request->athlete_id);
        $athlete->coach_id = $request->coach_id; // Assuming you add this field
        $athlete->save();

        return redirect()->route('admin.assigncoach.index')->with('success', 'Coach assigned successfully');
    }

    public function playerStatus()
    {
        $users = User::where('role', 'Athlete')->get();
        return view('admin.player-status', compact('users'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:Administrator,Athlete,Coach',
        ]);

        $user->update($request->only(['name', 'email', 'role']));

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }

    public function athleteDashboard()
    {
        $user = Auth::user();
        return view('athlete.dashboard', compact('user'));
    }

    private function calculateQualificationScore(User $athlete, User $coach)
    {
        $score = 0;

        // Get athlete's primary sport
        $athleteSport = $athlete->primary_sport;
        if (!$athleteSport) {
            return 0; // No sport specified
        }

        // Find sport available record
        $sportAvailable = SportAvailable::where('name', $athleteSport)->first();
        if (!$sportAvailable) {
            return 0; // Sport not found
        }

        // Get coach's requirements for this sport
        $requirement = SportRequirement::where('sport_available_id', $sportAvailable->id)
            ->where('coach_id', $coach->id)
            ->where('is_active', true)
            ->first();

        if (!$requirement) {
            return 0; // No requirements set by coach for this sport
        }

        $totalCriteria = 0;
        $matchedCriteria = 0;

        // Age compatibility
        $athleteAge = $athlete->age ?? (now()->diffInYears($athlete->date_of_birth));
        if ($requirement->min_age || $requirement->max_age) {
            $totalCriteria++;
            if (($requirement->min_age && $athleteAge >= $requirement->min_age) &&
                ($requirement->max_age && $athleteAge <= $requirement->max_age)) {
                $matchedCriteria++;
            }
        }

        // Gender compatibility
        if ($requirement->required_gender !== 'both') {
            $totalCriteria++;
            if (strtolower($athlete->gender ?? '') === $requirement->required_gender) {
                $matchedCriteria++;
            }
        }

        // Height compatibility
        if ($athlete->height && ($requirement->min_height || $requirement->max_height)) {
            $totalCriteria++;
            if (($requirement->min_height && $athlete->height >= $requirement->min_height) &&
                ($requirement->max_height && $athlete->height <= $requirement->max_height)) {
                $matchedCriteria++;
            }
        }

        // Weight compatibility
        if ($athlete->weight && ($requirement->min_weight || $requirement->max_weight)) {
            $totalCriteria++;
            if (($requirement->min_weight && $athlete->weight >= $requirement->min_weight) &&
                ($requirement->max_weight && $athlete->weight <= $requirement->max_weight)) {
                $matchedCriteria++;
            }
        }

        // Experience requirements
        if ($requirement->min_experience_years) {
            $totalCriteria++;
            if (($athlete->years_active ?? 0) >= $requirement->min_experience_years) {
                $matchedCriteria++;
            }
        }

        // Level compatibility
        if ($requirement->required_level) {
            $totalCriteria++;
            if (strtolower($athlete->level ?? '') === strtolower($requirement->required_level)) {
                $matchedCriteria++;
            }
        }

        // Position requirements
        if ($requirement->required_positions && !empty($requirement->required_positions)) {
            $totalCriteria++;
            $athletePosition = strtolower($athlete->position_role ?? '');
            $requiredPositions = array_map('strtolower', $requirement->required_positions);
            if (in_array($athletePosition, $requiredPositions)) {
                $matchedCriteria++;
            }
        }

        // Medical restrictions
        if ($requirement->medical_restrictions && !empty($requirement->medical_restrictions)) {
            $totalCriteria++;
            $athleteConditions = $athlete->medical_conditions ?? [];
            $conflicts = array_intersect($athleteConditions, $requirement->medical_restrictions);
            if (empty($conflicts)) {
                $matchedCriteria++;
            }
        }

        // Calculate percentage score
        if ($totalCriteria > 0) {
            $score = round(($matchedCriteria / $totalCriteria) * 100);
        }

        return $score;
    }
}

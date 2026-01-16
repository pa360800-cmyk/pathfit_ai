<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TrainingSchedule;
use App\Models\ActivityReport;
use App\Models\SportAvailable;
use App\Models\SportRequirement;
use Illuminate\Support\Facades\Auth;
use OpenAI\Client;

class UserController extends Controller
{
    // User specific routes
    public function userTrainingSchedule()
    {
        $user = Auth::user();
        $trainingSchedules = TrainingSchedule::where('user_id', $user->id)->get();
        return view('user.training-schedule', compact('trainingSchedules'));
    }

    public function assignedCoach()
    {
        $user = Auth::user();
        $coach = User::where('id', $user->coach_id)->first();
        $trainingSchedules = TrainingSchedule::where('user_id', $user->id)->get();
        return view('user.assigned-coach', compact('coach', 'trainingSchedules'));
    }

    public function reportActivity()
    {
        return view('user.report-activity');
    }

    public function storeReportActivity(Request $request)
    {
        $request->validate([
            'activity_date' => 'required|date',
            'activity_type' => 'required|in:training,competition,practice,recovery,other',
            'duration' => 'required|integer|min:1',
            'description' => 'required|string|max:1000',
            'performance_rating' => 'required|integer|min:1|max:10',
        ]);

        ActivityReport::create([
            'user_id' => Auth::id(),
            'activity_date' => $request->activity_date,
            'activity_type' => $request->activity_type,
            'duration' => $request->duration,
            'description' => $request->description,
            'performance_rating' => $request->performance_rating,
        ]);

        return redirect()->route('user.report-activity')->with('success', 'Activity report submitted successfully!');
    }

    public function messenger()
    {
        return redirect()->route('messages.index');
    }

    // Admin user management
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
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully');
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

    public function playerStatus()
    {
        $users = User::where('role', 'Athlete')->get();
        return view('admin.player-status', compact('users'));
    }

    public function adminCoachIndex()
    {
        $coaches = User::where('role', 'Coach')->get();
        return view('admin.coach.index', compact('coaches'));
    }

    public function adminAthleteIndex()
    {
        $athletes = User::where('role', 'Athlete')->get();
        return view('admin.athlete.index', compact('athletes'));
    }

    public function adminPlayerIndex()
    {
        $players = User::where('role', 'Athlete')->get();
        return view('admin.player.index', compact('players'));
    }

    // Athlete routes
    public function athleteDashboard()
    {
        $user = Auth::user();

        // Statistics
        $trainingSessions = ActivityReport::where('user_id', $user->id)->count();
        $personalBests = count($user->personal_bests ?? []);
        $performanceScore = ActivityReport::where('user_id', $user->id)->avg('performance_rating') ?? 0;
        $performanceScore = round($performanceScore, 1); // Round to 1 decimal

        // New Statistics
        $totalTrainingHours = ActivityReport::where('user_id', $user->id)->sum('duration') / 60;
        $totalTrainingHours = round($totalTrainingHours, 1);
        $avgSessionDuration = ActivityReport::where('user_id', $user->id)->avg('duration') ?? 0;
        $avgSessionDuration = round($avgSessionDuration, 1);
        $currentStreak = $this->calculateCurrentStreak($user->id);
        $weeklyGoal = $user->weekly_training_hours ?? 10; // Default 10 hours
        $weeklyProgress = $this->getWeeklyProgress($user->id);

        // Coach Information
        $coach = $user->coach;

        // Recent Activities
        $recentActivities = ActivityReport::where('user_id', $user->id)
            ->orderBy('activity_date', 'desc')
            ->limit(5)
            ->get();

        // Upcoming Sessions
        $upcomingSessions = TrainingSchedule::where('user_id', $user->id)
            ->where('date', '>=', now()->toDateString())
            ->orderBy('date')
            ->limit(3)
            ->get();

        // Injury Status
        $currentInjuries = $user->current_injuries ?? [];
        $injuryAlerts = count($currentInjuries);

        // Achievement Showcase
        $recentAchievements = $this->getRecentAchievements($user);

        // Chart Data
        // Training Progress: Weekly training hours (sum duration / 60 for hours)
        $trainingProgress = [];
        $weeks = ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5', 'Week 6'];
        for ($i = 0; $i < 6; $i++) {
            $startDate = now()->startOfWeek()->subWeeks(5 - $i);
            $endDate = $startDate->copy()->endOfWeek();
            $hours = ActivityReport::where('user_id', $user->id)
                ->whereBetween('activity_date', [$startDate, $endDate])
                ->sum('duration') / 60; // Convert minutes to hours
            $trainingProgress[] = round($hours, 1);
        }

        // Goal Achievement: Based on performance rating
        $totalActivities = ActivityReport::where('user_id', $user->id)->count();
        $completed = ActivityReport::where('user_id', $user->id)->where('performance_rating', '>=', 8)->count();
        $inProgress = ActivityReport::where('user_id', $user->id)->whereBetween('performance_rating', [5, 7])->count();
        $notStarted = $totalActivities - $completed - $inProgress;
        $goalAchievement = [$completed, $inProgress, max(0, $notStarted)];

        // Performance Trend: Monthly performance scores
        $performanceTrend = [];
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
        for ($i = 0; $i < 6; $i++) {
            $month = now()->subMonths(5 - $i)->month;
            $year = now()->subMonths(5 - $i)->year;
            $avg = ActivityReport::where('user_id', $user->id)
                ->whereYear('activity_date', $year)
                ->whereMonth('activity_date', $month)
                ->avg('performance_rating') ?? 0;
            $performanceTrend[] = round($avg, 1);
        }

        // New Charts Data
        // Skills Radar Chart
        $skillsData = $this->getSkillsData($user);

        // Time Distribution (by activity type)
        $timeDistribution = $this->getTimeDistribution($user->id);

        // Comparison Chart (vs average athlete)
        $comparisonData = $this->getComparisonData($user->id);

        return view('athlete.dashboard', compact(
            'user',
            'trainingSessions',
            'personalBests',
            'performanceScore',
            'totalTrainingHours',
            'avgSessionDuration',
            'currentStreak',
            'weeklyGoal',
            'weeklyProgress',
            'coach',
            'recentActivities',
            'upcomingSessions',
            'injuryAlerts',
            'currentInjuries',
            'recentAchievements',
            'trainingProgress',
            'goalAchievement',
            'performanceTrend',
            'skillsData',
            'timeDistribution',
            'comparisonData'
        ));
    }

    public function athleteProfile()
    {
        $user = Auth::user();
        return view('athlete.profile.index', compact('user'));
    }

    // Coach routes
    public function coachDashboard()
    {
        $user = Auth::user();
        $athletes = User::where('coach_id', $user->id)->get();

        // Statistics
        $athletesCount = $athletes->count();
        $upcomingSessions = TrainingSchedule::where('coach_id', $user->id)
            ->where('date', '>=', now()->toDateString())
            ->count();
        $recentActivities = ActivityReport::whereHas('user', function($query) use ($user) {
            $query->where('coach_id', $user->id);
        })->count();
        $messagesCount = 0; // Placeholder, implement if needed

        // Lists
        $upcomingSessionsList = TrainingSchedule::where('coach_id', $user->id)
            ->where('date', '>=', now()->toDateString())
            ->orderBy('date')
            ->get();
        $recentActivitiesList = ActivityReport::whereHas('user', function($query) use ($user) {
            $query->where('coach_id', $user->id);
        })->orderBy('activity_date', 'desc')->get();

        return view('coach.dashboard', compact(
            'athletes',
            'athletesCount',
            'upcomingSessions',
            'recentActivities',
            'messagesCount',
            'upcomingSessionsList',
            'recentActivitiesList'
        ));
    }

    public function coachList()
    {
        $user = Auth::user();
        $athletes = User::where('coach_id', $user->id)->get();
        return view('coach.list', compact('athletes'));
    }

    public function coachShowAthlete(User $athlete)
    {
        return view('coach.athletes.show', compact('athlete'));
    }

    public function coachEditAthlete(User $athlete)
    {
        return view('coach.athletes.edit', compact('athlete'));
    }

    public function coachUpdateAthlete(Request $request, User $athlete)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $athlete->id,
        ]);

        $athlete->update($request->only(['name', 'email']));

        return redirect()->route('coach.athletes.show', $athlete)->with('success', 'Athlete updated successfully');
    }

    public function coachDestroyAthlete(User $athlete)
    {
        $athlete->delete();
        return redirect()->route('coach.dashboard')->with('success', 'Athlete deleted successfully');
    }

    public function coachAthletesIndex()
    {
        $user = Auth::user();

        // Get sports that this coach specializes in (has active requirements for)
        $coachSports = SportRequirement::where('coach_id', $user->id)
            ->where('is_active', true)
            ->pluck('sport_available_id')
            ->unique();

        // Get the names of sports that this coach specializes in
        $sportNames = SportAvailable::whereIn('id', $coachSports)->pluck('name');

        // Get athletes who have selected sports that this coach specializes in
        $athletes = User::where('role', 'Athlete')
            ->whereNotNull('primary_sport')
            ->whereIn('primary_sport', $sportNames)
            ->paginate(10);

        return view('coach.athletes.index', compact('athletes'));
    }

    public function coachCreateAthlete()
    {
        return view('coach.athletes.create');
    }

    public function coachStoreAthlete(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'Athlete',
            'coach_id' => Auth::id(),
        ]);

        return redirect()->route('coach.athletes.index')->with('success', 'Athlete created successfully');
    }

    public function coachActivityReports()
    {
        $user = Auth::user();
        $activityReports = ActivityReport::whereHas('user', function($query) use ($user) {
            $query->where('coach_id', $user->id);
        })->paginate(10);
        return view('coach.activity-reports.index', compact('activityReports'));
    }

    public function coachCreateActivityReport()
    {
        $user = Auth::user();
        $athletes = User::where('coach_id', $user->id)->get();
        return view('coach.activity-reports.create', compact('athletes'));
    }

    public function coachStoreActivityReport(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'activity_date' => 'required|date',
            'activity_type' => 'required|in:training,competition,practice,recovery,other',
            'duration' => 'required|integer|min:1',
            'description' => 'required|string|max:1000',
            'performance_rating' => 'required|integer|min:1|max:10',
        ]);

        // Verify the user belongs to this coach
        $athlete = User::find($request->user_id);
        if ($athlete->coach_id !== Auth::id()) {
            return redirect()->back()->withErrors(['user_id' => 'You can only create reports for your athletes.']);
        }

        ActivityReport::create($request->all());

        return redirect()->route('coach.activity-reports.index')->with('success', 'Activity report created successfully');
    }

    public function sportSuggestion()
    {
        $user = Auth::user();
        $sports = SportAvailable::all();

        // Try AI suggestions first, fall back to rule-based logic
        $suggestions = $this->generateAISportSuggestions($user, $sports);

        if (empty($suggestions)) {
            $suggestions = $this->generateSportSuggestions($user, $sports);
        }

        return view('athlete.sport-suggestion', compact('user', 'suggestions'));
    }

    private function generateSportSuggestions(User $user, $sports)
    {
        $suggestions = [];

        foreach ($sports as $sport) {
            $totalScore = 0;
            $reasons = [];
            $coachRequirements = SportRequirement::where('sport_available_id', $sport->id)
                ->where('is_active', true)
                ->get();

            // Base compatibility score (without coach requirements)
            $baseScore = $this->calculateBaseCompatibilityScore($user, $sport);
            $totalScore += $baseScore['score'];
            $reasons = array_merge($reasons, $baseScore['reasons']);

            // Coach requirements compatibility
            if ($coachRequirements->isNotEmpty()) {
                foreach ($coachRequirements as $requirement) {
                    $coachScore = $this->calculateCoachRequirementScore($user, $requirement);
                    $totalScore += $coachScore['score'];
                    $reasons = array_merge($reasons, $coachScore['reasons']);
                }
            }

            // Profile completeness bonus
            $completenessBonus = $this->calculateProfileCompletenessBonus($user);
            $totalScore += $completenessBonus['score'];
            $reasons = array_merge($reasons, $completenessBonus['reasons']);

            // Injury and medical considerations
            $medicalScore = $this->calculateMedicalCompatibilityScore($user, $sport, $coachRequirements);
            $totalScore += $medicalScore['score'];
            $reasons = array_merge($reasons, $medicalScore['reasons']);

            // Performance metrics consideration
            $performanceScore = $this->calculatePerformanceBasedScore($user, $sport);
            $totalScore += $performanceScore['score'];
            $reasons = array_merge($reasons, $performanceScore['reasons']);

            if ($totalScore > 0) {
                $suggestions[] = [
                    'sport' => $sport,
                    'score' => min($totalScore, 100), // Cap at 100
                    'reasons' => array_unique($reasons), // Remove duplicates
                    'coach_requirements_count' => $coachRequirements->count()
                ];
            }
        }

        // Sort by score descending, then by coach requirements count
        usort($suggestions, function($a, $b) {
            if ($b['score'] === $a['score']) {
                return $b['coach_requirements_count'] <=> $a['coach_requirements_count'];
            }
            return $b['score'] <=> $a['score'];
        });

        return array_slice($suggestions, 0, 5); // Return top 5 suggestions
    }

    private function matchesPhysicalAttributes(User $user, $sport)
    {
        // Simple logic based on sport name and user attributes
        $sportName = strtolower($sport->name);

        if (str_contains($sportName, 'basketball') || str_contains($sportName, 'volleyball')) {
            return $user->height > 170; // Tall sports
        }

        if (str_contains($sportName, 'football') || str_contains($sportName, 'rugby')) {
            return $user->weight > 70; // Contact sports requiring strength
        }

        if (str_contains($sportName, 'swimming') || str_contains($sportName, 'diving')) {
            return true; // Aquatic sports
        }

        return false;
    }

    private function matchesPosition(User $user, $sport)
    {
        // Simple matching based on position and sport
        $position = strtolower($user->position_role);
        $sportName = strtolower($sport->name);

        if (str_contains($position, 'forward') && str_contains($sportName, 'basketball')) {
            return true;
        }

        if (str_contains($position, 'goalkeeper') && str_contains($sportName, 'football')) {
            return true;
        }

        return false;
    }

    private function matchesExperience(User $user, $sport)
    {
        // Match based on years active and level
        $years = $user->years_active ?? 0;
        $level = strtolower($user->level ?? '');

        if ($years > 5 && str_contains($level, 'professional')) {
            return true; // Experienced athletes
        }

        return $years > 0; // Any experience
    }

    private function calculateBaseCompatibilityScore(User $user, SportAvailable $sport)
    {
        $score = 0;
        $reasons = [];

        // Primary sport match (highest weight)
        if (strtolower($user->primary_sport ?? '') === strtolower($sport->name)) {
            $score += 40;
            $reasons[] = 'Perfect match with your primary sport';
        }

        // Secondary sports match
        $secondarySports = array_map('strtolower', $user->secondary_sports ?? []);
        if (in_array(strtolower($sport->name), $secondarySports)) {
            $score += 25;
            $reasons[] = 'Matches your secondary sports interests';
        }

        // Position/role compatibility
        if ($this->matchesPosition($user, $sport)) {
            $score += 15;
            $reasons[] = 'Aligns with your preferred position/role';
        }

        // Experience level match
        if ($this->matchesExperience($user, $sport)) {
            $score += 10;
            $reasons[] = 'Suitable for your experience level';
        }

        // Physical attributes compatibility
        if ($this->matchesPhysicalAttributes($user, $sport)) {
            $score += 10;
            $reasons[] = 'Compatible with your physical attributes';
        }

        return ['score' => $score, 'reasons' => $reasons];
    }

    private function calculateCoachRequirementScore(User $user, SportRequirement $requirement)
    {
        $score = 0;
        $reasons = [];

        // Age compatibility
        $userAge = $user->age ?? (now()->diffInYears($user->date_of_birth));
        if ($requirement->min_age && $userAge < $requirement->min_age) {
            $score -= 50; // Penalty for being too young
            $reasons[] = 'Below minimum age requirement';
        } elseif ($requirement->max_age && $userAge > $requirement->max_age) {
            $score -= 50; // Penalty for being too old
            $reasons[] = 'Above maximum age requirement';
        } elseif (($requirement->min_age && $userAge >= $requirement->min_age) ||
                  ($requirement->max_age && $userAge <= $requirement->max_age)) {
            $score += 20;
            $reasons[] = 'Within coach\'s recommended age range';
        }

        // Gender compatibility
        $userGender = strtolower($user->gender ?? '');
        if ($requirement->required_gender !== 'both' &&
            $requirement->required_gender !== $userGender) {
            $score -= 100; // Complete disqualification
            $reasons[] = 'Gender requirement not met';
        } elseif ($requirement->required_gender === $userGender ||
                  $requirement->required_gender === 'both') {
            $score += 15;
            $reasons[] = 'Meets coach\'s gender requirements';
        }

        // Height compatibility
        if ($user->height) {
            if ($requirement->min_height && $user->height < $requirement->min_height) {
                $score -= 30;
                $reasons[] = 'Below minimum height requirement';
            } elseif ($requirement->max_height && $user->height > $requirement->max_height) {
                $score -= 30;
                $reasons[] = 'Above maximum height requirement';
            } elseif (($requirement->min_height && $user->height >= $requirement->min_height) ||
                      ($requirement->max_height && $user->height <= $requirement->max_height)) {
                $score += 15;
                $reasons[] = 'Within coach\'s height requirements';
            }
        }

        // Weight compatibility
        if ($user->weight) {
            if ($requirement->min_weight && $user->weight < $requirement->min_weight) {
                $score -= 25;
                $reasons[] = 'Below minimum weight requirement';
            } elseif ($requirement->max_weight && $user->weight > $requirement->max_weight) {
                $score -= 25;
                $reasons[] = 'Above maximum weight requirement';
            } elseif (($requirement->min_weight && $user->weight >= $requirement->min_weight) ||
                      ($requirement->max_weight && $user->weight <= $requirement->max_weight)) {
                $score += 15;
                $reasons[] = 'Within coach\'s weight requirements';
            }
        }

        // Experience requirements
        $userExperience = $user->years_active ?? 0;
        if ($requirement->min_experience_years && $userExperience < $requirement->min_experience_years) {
            $score -= 40;
            $reasons[] = 'Below minimum experience requirement';
        } elseif ($requirement->min_experience_years && $userExperience >= $requirement->min_experience_years) {
            $score += 20;
            $reasons[] = 'Meets coach\'s experience requirements';
        }

        // Level compatibility
        $userLevel = strtolower($user->level ?? '');
        $requiredLevel = strtolower($requirement->required_level ?? '');
        if ($requiredLevel && str_contains($userLevel, $requiredLevel)) {
            $score += 15;
            $reasons[] = 'Matches coach\'s level requirements';
        }

        // Position requirements
        $userPosition = strtolower($user->position_role ?? '');
        $requiredPositions = array_map('strtolower', $requirement->required_positions ?? []);
        if (!empty($requiredPositions) && in_array($userPosition, $requiredPositions)) {
            $score += 20;
            $reasons[] = 'Matches coach\'s position requirements';
        }

        return ['score' => $score, 'reasons' => $reasons];
    }

    private function calculateProfileCompletenessBonus(User $user)
    {
        $score = 0;
        $reasons = [];
        $completeness = 0;

        // Check essential profile fields
        $essentialFields = [
            'height', 'weight', 'age', 'gender', 'primary_sport',
            'position_role', 'level', 'years_active'
        ];

        foreach ($essentialFields as $field) {
            if (!empty($user->$field)) {
                $completeness += 12.5; // 100/8 = 12.5
            }
        }

        // Bonus for additional profile information
        if (!empty($user->secondary_sports) && count($user->secondary_sports) > 0) {
            $completeness += 5;
        }
        if (!empty($user->personal_bests) && count($user->personal_bests) > 0) {
            $completeness += 5;
        }
        if (!empty($user->competition_history) && count($user->competition_history) > 0) {
            $completeness += 5;
        }

        // Convert completeness to score bonus
        $score = min($completeness * 0.5, 15); // Max 15 points bonus

        if ($completeness >= 80) {
            $reasons[] = 'Highly complete profile provides better recommendations';
        } elseif ($completeness >= 60) {
            $reasons[] = 'Well-completed profile enhances accuracy';
        }

        return ['score' => $score, 'reasons' => $reasons];
    }

    private function calculateMedicalCompatibilityScore(User $user, SportAvailable $sport, $coachRequirements)
    {
        $score = 0;
        $reasons = [];

        // Check current injuries
        $currentInjuries = $user->current_injuries ?? [];
        if (!empty($currentInjuries)) {
            $score -= 30;
            $reasons[] = 'Current injuries may limit participation';
        }

        // Check medical conditions
        $medicalConditions = $user->medical_conditions ?? [];
        if (!empty($medicalConditions)) {
            // Check against coach restrictions
            foreach ($coachRequirements as $requirement) {
                $restrictions = $requirement->medical_restrictions ?? [];
                $conflicts = array_intersect($medicalConditions, $restrictions);
                if (!empty($conflicts)) {
                    $score -= 50;
                    $reasons[] = 'Medical conditions conflict with coach requirements';
                    break;
                }
            }
        }

        // Check injury history for sport-specific concerns
        $injuryHistory = $user->injury_history ?? [];
        $sportName = strtolower($sport->name);

        if (str_contains($sportName, 'contact') || str_contains($sportName, 'football') ||
            str_contains($sportName, 'rugby') || str_contains($sportName, 'basketball')) {
            // Contact sports - check for joint/knee injuries
            foreach ($injuryHistory as $injury) {
                if (str_contains(strtolower($injury), 'knee') ||
                    str_contains(strtolower($injury), 'ankle') ||
                    str_contains(strtolower($injury), 'shoulder')) {
                    $score -= 20;
                    $reasons[] = 'Injury history may affect contact sport participation';
                    break;
                }
            }
        }

        // Positive factors
        if (empty($currentInjuries) && empty($medicalConditions)) {
            $score += 10;
            $reasons[] = 'No current medical restrictions';
        }

        return ['score' => $score, 'reasons' => $reasons];
    }

    private function calculatePerformanceBasedScore(User $user, SportAvailable $sport)
    {
        $score = 0;
        $reasons = [];

        // Personal bests analysis
        $personalBests = $user->personal_bests ?? [];
        if (!empty($personalBests)) {
            $score += 10;
            $reasons[] = 'Performance history indicates athletic capability';
        }

        // Competition history
        $competitionHistory = $user->competition_history ?? [];
        if (!empty($competitionHistory)) {
            $score += 8;
            $reasons[] = 'Competition experience enhances suitability';
        }

        // Rankings
        $rankings = $user->rankings ?? [];
        if (!empty($rankings)) {
            $score += 12;
            $reasons[] = 'Existing rankings suggest competitive potential';
        }

        // Seasonal statistics
        $seasonalStats = $user->seasonal_statistics ?? [];
        if (!empty($seasonalStats)) {
            $score += 6;
            $reasons[] = 'Statistical performance data available';
        }

        // Career statistics
        $careerStats = $user->career_statistics ?? [];
        if (!empty($careerStats)) {
            $score += 8;
            $reasons[] = 'Career statistics indicate experience level';
        }

        // Key performance metrics
        $keyMetrics = $user->key_performance_metrics ?? [];
        if (!empty($keyMetrics)) {
            $score += 6;
            $reasons[] = 'Performance metrics support athletic assessment';
        }

        return ['score' => $score, 'reasons' => $reasons];
    }

    private function calculateCurrentStreak($userId)
    {
        // Calculate consecutive days with activity reports
        $activities = ActivityReport::where('user_id', $userId)
            ->orderBy('activity_date', 'desc')
            ->pluck('activity_date')
            ->map(function ($date) {
                return $date->toDateString();
            })
            ->unique()
            ->sort()
            ->values();

        if ($activities->isEmpty()) {
            return 0;
        }

        $streak = 0;
        $currentDate = now()->toDateString();

        // Check if today has activity
        if (!$activities->contains($currentDate)) {
            // If no activity today, check yesterday
            $currentDate = now()->subDay()->toDateString();
            if (!$activities->contains($currentDate)) {
                return 0;
            }
        }

        // Count consecutive days backwards from current date
        while ($activities->contains($currentDate)) {
            $streak++;
            $currentDate = \Carbon\Carbon::parse($currentDate)->subDay()->toDateString();
        }

        return $streak;
    }

    private function getWeeklyProgress($userId)
    {
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

        $weeklyHours = ActivityReport::where('user_id', $userId)
            ->whereBetween('activity_date', [$startOfWeek, $endOfWeek])
            ->sum('duration') / 60;

        return round($weeklyHours, 1);
    }

    private function getSkillsData(User $user)
    {
        // Mock skills data based on user profile and activity
        $skills = [
            'speed' => 7,
            'endurance' => 6,
            'strength' => 8,
            'agility' => 7,
            'technique' => 6,
            'mental' => 7
        ];

        // Adjust based on activity reports
        $avgPerformance = ActivityReport::where('user_id', $user->id)->avg('performance_rating') ?? 5;
        $activityCount = ActivityReport::where('user_id', $user->id)->count();

        // Boost skills based on performance and experience
        $boost = min($avgPerformance / 10, 0.5) + min($activityCount / 50, 0.5);

        foreach ($skills as $skill => $value) {
            $skills[$skill] = min(10, round($value + $boost, 1));
        }

        return array_values($skills);
    }

    private function getTimeDistribution($userId)
    {
        $activities = ActivityReport::where('user_id', $userId)->get();

        $distribution = [
            'training' => 0,
            'rest' => 0,
            'warm-up' => 0,
            'cool-down' => 0,
            'other' => 0
        ];

        foreach ($activities as $activity) {
            $type = strtolower($activity->activity_type);
            if (isset($distribution[$type])) {
                $distribution[$type] += $activity->duration;
            } else {
                $distribution['other'] += $activity->duration;
            }
        }

        // Convert to percentages
        $total = array_sum($distribution);
        if ($total > 0) {
            foreach ($distribution as $key => $value) {
                $distribution[$key] = round(($value / $total) * 100);
            }
        }

        return array_values($distribution);
    }

    private function getComparisonData($userId)
    {
        $userAvg = ActivityReport::where('user_id', $userId)->avg('performance_rating') ?? 0;
        $userThisMonth = ActivityReport::where('user_id', $userId)
            ->whereYear('activity_date', now()->year)
            ->whereMonth('activity_date', now()->month)
            ->avg('performance_rating') ?? 0;
        $userLastMonth = ActivityReport::where('user_id', $userId)
            ->whereYear('activity_date', now()->subMonth()->year)
            ->whereMonth('activity_date', now()->subMonth()->month)
            ->avg('performance_rating') ?? 0;

        // Mock team average (in real app, calculate from all athletes)
        $teamAverage = 6.5;

        return [
            'yourData' => [round($userThisMonth, 1), round($userLastMonth, 1), round($userAvg, 1)],
            'teamAverage' => [$teamAverage, $teamAverage, $teamAverage]
        ];
    }

    private function getRecentAchievements(User $user)
    {
        $achievements = [];

        // Check for various achievements based on user data
        $activityCount = ActivityReport::where('user_id', $user->id)->count();
        $avgPerformance = ActivityReport::where('user_id', $user->id)->avg('performance_rating') ?? 0;
        $personalBests = count($user->personal_bests ?? []);
        $streak = $this->calculateCurrentStreak($user->id);

        if ($activityCount >= 10) {
            $achievements[] = [
                'icon' => '🏃‍♂️',
                'title' => 'Dedicated Athlete',
                'description' => 'Completed 10+ training sessions',
                'date' => now()->format('M d, Y')
            ];
        }

        if ($avgPerformance >= 8) {
            $achievements[] = [
                'icon' => '⭐',
                'title' => 'High Performer',
                'description' => 'Maintained excellent performance ratings',
                'date' => now()->format('M d, Y')
            ];
        }

        if ($personalBests > 0) {
            $achievements[] = [
                'icon' => '🏆',
                'title' => 'Personal Best',
                'description' => 'Set new personal records',
                'date' => now()->format('M d, Y')
            ];
        }

        if ($streak >= 7) {
            $achievements[] = [
                'icon' => '🔥',
                'title' => 'Consistency King',
                'description' => 'Maintained a ' . $streak . '-day training streak',
                'date' => now()->format('M d, Y')
            ];
        }

        // Return up to 3 recent achievements
        return array_slice($achievements, 0, 3);
    }

    private function generateAISportSuggestions(User $user, $sports)
    {
        $apiKey = env('OPENAI_API_KEY');
        if (!$apiKey) {
            return []; // Fall back to rule-based logic
        }

        try {
            $client = Client::factory()->withApiKey($apiKey)->make();

            // Prepare user profile data for the prompt
            $profileData = [
                'age' => $user->age ?? 'Not specified',
                'gender' => $user->gender ?? 'Not specified',
                'height' => $user->height ? $user->height . ' cm' : 'Not specified',
                'weight' => $user->weight ? $user->weight . ' kg' : 'Not specified',
                'primary_sport' => $user->primary_sport ?? 'Not specified',
                'secondary_sports' => $user->secondary_sports ?? [],
                'position_role' => $user->position_role ?? 'Not specified',
                'level' => $user->level ?? 'Not specified',
                'years_active' => $user->years_active ?? 'Not specified',
                'current_injuries' => $user->current_injuries ?? [],
                'medical_conditions' => $user->medical_conditions ?? [],
                'personal_bests' => $user->personal_bests ?? [],
                'competition_history' => $user->competition_history ?? [],
            ];

            // Prepare available sports list
            $sportsList = $sports->pluck('name')->toArray();

            // Create the prompt
            $prompt = "Based on the following athlete profile, suggest the top 5 most suitable sports from the available list. For each suggestion, provide a compatibility score (0-100) and 2-3 brief reasons why it's suitable.\n\n";
            $prompt .= "Athlete Profile:\n";
            $prompt .= "- Age: {$profileData['age']}\n";
            $prompt .= "- Gender: {$profileData['gender']}\n";
            $prompt .= "- Height: {$profileData['height']}\n";
            $prompt .= "- Weight: {$profileData['weight']}\n";
            $prompt .= "- Primary Sport: {$profileData['primary_sport']}\n";
            $prompt .= "- Secondary Sports: " . implode(', ', $profileData['secondary_sports']) . "\n";
            $prompt .= "- Position/Role: {$profileData['position_role']}\n";
            $prompt .= "- Level: {$profileData['level']}\n";
            $prompt .= "- Years Active: {$profileData['years_active']}\n";
            $prompt .= "- Current Injuries: " . implode(', ', $profileData['current_injuries']) . "\n";
            $prompt .= "- Medical Conditions: " . implode(', ', $profileData['medical_conditions']) . "\n";
            $prompt .= "- Personal Bests: " . implode(', ', $profileData['personal_bests']) . "\n";
            $prompt .= "- Competition History: " . implode(', ', $profileData['competition_history']) . "\n\n";
            $prompt .= "Available Sports: " . implode(', ', $sportsList) . "\n\n";
            $prompt .= "Please respond in the following JSON format:\n";
            $prompt .= "[\n";
            $prompt .= "  {\n";
            $prompt .= "    \"sport\": \"Sport Name\",\n";
            $prompt .= "    \"score\": 85,\n";
            $prompt .= "    \"reasons\": [\"Reason 1\", \"Reason 2\", \"Reason 3\"]\n";
            $prompt .= "  },\n";
            $prompt .= "  ...\n";
            $prompt .= "]\n\n";
            $prompt .= "Ensure the sport names exactly match from the available sports list.";

            // Call OpenAI API
            $response = $client->chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'user', 'content' => $prompt],
                ],
                'max_tokens' => 1000,
                'temperature' => 0.7,
            ]);

            $content = $response->choices[0]->message->content;

            // Parse the JSON response
            $aiSuggestions = json_decode($content, true);

            if (!is_array($aiSuggestions)) {
                return []; // Invalid response, fall back to rule-based
            }

            // Format the suggestions to match the expected structure
            $formattedSuggestions = [];
            foreach ($aiSuggestions as $suggestion) {
                if (isset($suggestion['sport'], $suggestion['score'], $suggestion['reasons'])) {
                    // Find the sport model
                    $sport = $sports->firstWhere('name', $suggestion['sport']);
                    if ($sport) {
                        $formattedSuggestions[] = [
                            'sport' => $sport,
                            'score' => min(max((int)$suggestion['score'], 0), 100),
                            'reasons' => is_array($suggestion['reasons']) ? $suggestion['reasons'] : [],
                            'coach_requirements_count' => 0, // AI doesn't consider coach requirements
                        ];
                    }
                }
            }

            return $formattedSuggestions;

        } catch (\Exception $e) {
            // Log the error and fall back to rule-based logic
            \Log::error('OpenAI API error: ' . $e->getMessage());
            return [];
        }
    }
}

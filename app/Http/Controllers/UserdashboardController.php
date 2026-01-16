<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityReport;

class UserdashboardController extends Controller
{
    public function user()
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
        $upcomingSessions = \App\Models\TrainingSchedule::where('user_id', $user->id)
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

    private function calculateCurrentStreak($userId)
    {
        $streak = 0;
        $date = now()->toDateString();

        while (true) {
            $hasActivity = ActivityReport::where('user_id', $userId)
                ->whereDate('activity_date', $date)
                ->exists();

            if (!$hasActivity) break;

            $streak++;
            $date = \Carbon\Carbon::parse($date)->subDay()->toDateString();
        }

        return $streak;
    }

    private function getWeeklyProgress($userId)
    {
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

        $hours = ActivityReport::where('user_id', $userId)
            ->whereBetween('activity_date', [$startOfWeek, $endOfWeek])
            ->sum('duration') / 60;

        return round($hours, 1);
    }

    private function getRecentAchievements($user)
    {
        $achievements = [];

        // Check for personal bests
        if (!empty($user->personal_bests)) {
            $achievements[] = [
                'title' => 'Personal Best Updated',
                'description' => 'New personal best recorded',
                'icon' => '🏆',
                'date' => now()->format('M d')
            ];
        }

        // Check for high performance sessions
        $highPerfCount = ActivityReport::where('user_id', $user->id)
            ->where('performance_rating', '>=', 9)
            ->where('activity_date', '>=', now()->subDays(30))
            ->count();

        if ($highPerfCount > 0) {
            $achievements[] = [
                'title' => 'High Performance',
                'description' => $highPerfCount . ' excellent sessions this month',
            ];
        }

        return $achievements;
    }

    public function coach()
    {
        $user = Auth::user();
        $athletes = \App\Models\User::where('coach_id', $user->id)->get();

        // Statistics
        $athletesCount = $athletes->count();
        $upcomingSessions = \App\Models\TrainingSchedule::where('coach_id', $user->id)
            ->where('date', '>=', now()->toDateString())
            ->count();
        $recentActivities = \App\Models\ActivityReport::whereHas('user', function($query) use ($user) {
            $query->where('coach_id', $user->id);
        })->count();
        $messagesCount = 0; // Placeholder, implement if needed

        // Lists
        $upcomingSessionsList = \App\Models\TrainingSchedule::where('coach_id', $user->id)
            ->where('date', '>=', now()->toDateString())
            ->orderBy('date')
            ->get();
        $recentActivitiesList = \App\Models\ActivityReport::whereHas('user', function($query) use ($user) {
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

    private function getSkillsData($user)
    {
        // Placeholder for skills radar chart data
        return [];
    }

    private function getTimeDistribution($userId)
    {
        // Placeholder for time distribution chart data
        return [];
    }

    private function getComparisonData($userId)
    {
        // Placeholder for comparison chart data
        return [];
    }
}

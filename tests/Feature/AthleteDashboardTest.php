<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\ActivityReport;
use Illuminate\Support\Facades\Auth;

class AthleteDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_athlete_dashboard_loads_with_dynamic_data()
    {
        // Create an athlete user
        $athlete = User::factory()->create([
            'role' => 'Athlete',
            'name' => 'Test Athlete',
            'personal_bests' => ['100m: 10.5s', '200m: 21.8s']
        ]);

        // Create some activity reports for the athlete
        ActivityReport::create([
            'user_id' => $athlete->id,
            'activity_date' => now(),
            'activity_type' => 'training',
            'duration' => 120, // 2 hours in minutes
            'description' => 'Morning training session',
            'performance_rating' => 8
        ]);

        ActivityReport::create([
            'user_id' => $athlete->id,
            'activity_date' => now()->subDays(1),
            'activity_type' => 'competition',
            'duration' => 90,
            'description' => 'Competition training',
            'performance_rating' => 9
        ]);

        // Act as the athlete
        $this->actingAs($athlete);

        // Visit the dashboard
        $response = $this->get(route('athlete.dashboard'));

        // Assert the response is successful
        $response->assertStatus(200);

        // Assert the view has the expected data
        $response->assertViewHasAll([
            'user',
            'trainingSessions',
            'personalBests',
            'performanceScore',
            'trainingProgress',
            'goalAchievement',
            'performanceTrend'
        ]);

        // Assert specific data values
        $viewData = $response->viewData('trainingSessions');
        $this->assertEquals(2, $viewData); // Should have 2 training sessions

        $personalBests = $response->viewData('personalBests');
        $this->assertEquals(2, $personalBests); // Should have 2 personal bests

        $performanceScore = $response->viewData('performanceScore');
        $this->assertEquals(8.5, $performanceScore); // Average of 8 and 9

        // Assert chart data arrays are present and properly structured
        $trainingProgress = $response->viewData('trainingProgress');
        $this->assertIsArray($trainingProgress);
        $this->assertCount(6, $trainingProgress); // Should have 6 weeks of data

        $goalAchievement = $response->viewData('goalAchievement');
        $this->assertIsArray($goalAchievement);
        $this->assertCount(3, $goalAchievement); // [completed, in_progress, not_started]

        $performanceTrend = $response->viewData('performanceTrend');
        $this->assertIsArray($performanceTrend);
        $this->assertCount(6, $performanceTrend); // Should have 6 months of data
    }

    public function test_athlete_dashboard_handles_no_activity_reports()
    {
        // Create an athlete user with no activity reports
        $athlete = User::factory()->create([
            'role' => 'Athlete',
            'name' => 'Test Athlete',
            'personal_bests' => []
        ]);

        // Act as the athlete
        $this->actingAs($athlete);

        // Visit the dashboard
        $response = $this->get(route('athlete.dashboard'));

        // Assert the response is successful
        $response->assertStatus(200);

        // Assert default values when no data exists
        $trainingSessions = $response->viewData('trainingSessions');
        $this->assertEquals(0, $trainingSessions);

        $personalBests = $response->viewData('personalBests');
        $this->assertEquals(0, $personalBests);

        $performanceScore = $response->viewData('performanceScore');
        $this->assertEquals(0.0, $performanceScore);

        // Assert chart data arrays are still present
        $trainingProgress = $response->viewData('trainingProgress');
        $this->assertIsArray($trainingProgress);
        $this->assertCount(6, $trainingProgress);

        $goalAchievement = $response->viewData('goalAchievement');
        $this->assertIsArray($goalAchievement);
        $this->assertCount(3, $goalAchievement);

        $performanceTrend = $response->viewData('performanceTrend');
        $this->assertIsArray($performanceTrend);
        $this->assertCount(6, $performanceTrend);
    }

    public function test_athlete_dashboard_requires_authentication()
    {
        // Try to access dashboard without authentication
        $response = $this->get(route('athlete.dashboard'));

        // Should redirect to login
        $response->assertRedirect(route('login'));
    }
}

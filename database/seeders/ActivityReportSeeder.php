<?php

namespace Database\Seeders;

use App\Models\ActivityReport;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ActivityReportSeeder extends Seeder
{
    public function run(): void
    {
        $athletes = User::where('role', 'Athlete')->get();

        foreach ($athletes as $athlete) {
            // Create activity reports for the last 6 months
            for ($i = 0; $i < 6; $i++) {
                $date = Carbon::now()->subMonths($i)->startOfMonth()->addDays(rand(0, 27));

                // Create 2-4 activities per month per athlete
                $activitiesPerMonth = rand(2, 4);
                for ($j = 0; $j < $activitiesPerMonth; $j++) {
                    $activityDate = $date->copy()->addDays(rand(0, 27));

                    ActivityReport::create([
                        'user_id' => $athlete->id,
                        'activity_date' => $activityDate,
                        'activity_type' => $this->getRandomActivityType(),
                        'duration' => rand(30, 180), // 30 minutes to 3 hours
                        'description' => $this->getRandomDescription($athlete->primary_sport),
                        'performance_rating' => rand(5, 10),
                    ]);
                }
            }
        }
    }

    private function getRandomActivityType()
    {
        $types = ['training', 'competition', 'practice', 'recovery', 'other'];
        return $types[array_rand($types)];
    }

    private function getRandomDescription($sport)
    {
        $descriptions = [
            "Regular {$sport} training session focusing on technique improvement.",
            "Intensive {$sport} workout with strength and conditioning.",
            "Team {$sport} practice session.",
            "{$sport} competition preparation and tactical drills.",
            "Recovery session with light {$sport} activities.",
            "Skill development session for {$sport}.",
            "{$sport} endurance training.",
            "Technical {$sport} practice.",
        ];

        return $descriptions[array_rand($descriptions)];
    }
}

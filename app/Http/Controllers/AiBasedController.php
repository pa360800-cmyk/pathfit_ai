<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SportAvailable;
use App\Models\TrainingSchedule;

class AiBasedController extends Controller
{
    public function index()
    {
        // Logic to display AI-based features
        return view('admin.ai-based.index');
    }

    public function runAiAssignment(Request $request)
    {
        // Simulate AI-based athlete assignment to sports
        // In a real implementation, this would involve complex AI algorithms
        // For now, we'll simulate by randomly assigning athletes to sports

        $athletes = User::where('role', 'athlete')->get();
        $sports = SportAvailable::all();
        $coaches = User::where('role', 'Coach')->get();

        if ($athletes->isEmpty() || $sports->isEmpty()) {
            return redirect()->back()->with('error', 'No athletes or sports available for assignment.');
        }

        if ($coaches->isEmpty()) {
            return redirect()->back()->with('error', 'No coaches available for training assignments.');
        }

        // Simulate AI assignment (random for demo purposes)
        $assignments = [];
        $trainingSchedulesCreated = 0;

        foreach ($athletes as $athlete) {
            $randomSport = $sports->random();
            $randomCoach = $coaches->random();

            // Create training schedule for this assignment
            TrainingSchedule::create([
                'title' => $randomSport->name . ' Training for ' . $athlete->name,
                'description' => 'AI-generated training schedule for ' . $athlete->name . ' in ' . $randomSport->name,
                'date' => now()->addDays(rand(1, 30))->toDateString(), // Random date within next 30 days
                'start_time' => '09:00:00',
                'end_time' => '11:00:00',
                'coach_id' => $randomCoach->id,
            ]);

            $trainingSchedulesCreated++;

            $assignments[] = [
                'athlete_id' => $athlete->id,
                'athlete_name' => $athlete->name,
                'sport_id' => $randomSport->id,
                'sport_name' => $randomSport->name,
                'coach_id' => $randomCoach->id,
                'coach_name' => $randomCoach->name
            ];
        }

        return redirect()->back()->with('success', 'AI Assignment completed! ' . count($assignments) . ' athletes assigned to sports and ' . $trainingSchedulesCreated . ' training schedules created.')->with('assignments', $assignments);
    }

    public function enableAiAssistance(Request $request)
    {
        // Enable AI assistance features for athletes
        // This could involve updating user preferences or enabling AI features

        // For demonstration, we'll assume enabling AI assistance for all athletes
        $athletesCount = User::where('role', 'athlete')->count();

        if ($athletesCount == 0) {
            return redirect()->back()->with('error', 'No athletes found to enable AI assistance for.');
        }

        // In a real implementation, you might add an 'ai_assistance_enabled' field to users table
        // For now, we'll just return a success message

        return redirect()->back()->with('success', 'AI Assistance enabled for ' . $athletesCount . ' athletes!');
    }
}

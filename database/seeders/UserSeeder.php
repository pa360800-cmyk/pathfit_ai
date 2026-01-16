<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'fname' => 'Admin',
            'mname' => '',
            'lname' => 'User',
            'email' => 'admin@pathfit.com',
            'password' => Hash::make('password'),
            'role' => 'Admin',
            'gender' => 'male',
            'date_of_birth' => '1980-01-01',
            'age' => 44,
            'nationality' => 'Philippine',
            'place_of_birth' => 'Manila',
            'current_residence' => 'Manila',
        ]);

        // Create Coach Users
        $coachJohn = User::create([
            'name' => 'Coach John Smith',
            'fname' => 'John',
            'mname' => 'Michael',
            'lname' => 'Smith',
            'email' => 'coach.john@pathfit.com',
            'password' => Hash::make('password'),
            'role' => 'Coach',
            'gender' => 'male',
            'date_of_birth' => '1975-05-15',
            'age' => 49,
            'nationality' => 'Philippine',
            'place_of_birth' => 'Cebu',
            'current_residence' => 'Manila',
            'certifications' => ['NSCA-CSCS', 'USSF License A'],
            'years_active' => 20,
        ]);

        $coachMaria = User::create([
            'name' => 'Coach Maria Santos',
            'fname' => 'Maria',
            'mname' => 'Elena',
            'lname' => 'Santos',
            'email' => 'coach.maria@pathfit.com',
            'password' => Hash::make('password'),
            'role' => 'Coach',
            'gender' => 'female',
            'date_of_birth' => '1982-08-20',
            'age' => 42,
            'nationality' => 'Philippine',
            'place_of_birth' => 'Davao',
            'current_residence' => 'Manila',
            'certifications' => ['FIFA Coaching License', 'PNBF Level 2'],
            'years_active' => 15,
        ]);

        // Create Athlete Users assigned to coaches
        User::create([
            'name' => 'Juan dela Cruz',
            'fname' => 'Juan',
            'mname' => 'Carlos',
            'lname' => 'dela Cruz',
            'email' => 'juan.athlete@pathfit.com',
            'password' => Hash::make('password'),
            'role' => 'Athlete',
            'coach_id' => $coachJohn->id,
            'gender' => 'male',
            'date_of_birth' => '2000-03-10',
            'age' => 24,
            'nationality' => 'Philippine',
            'place_of_birth' => 'Quezon City',
            'current_residence' => 'Manila',
            'height' => 175,
            'weight' => 70,
            'primary_sport' => 'Basketball',
            'level' => 'amateur',
            'years_active' => 8,
            'position_role' => 'Point Guard',
            'jersey_number' => 7,
            'club_team_name' => 'UST Growling Tigers',
            'weekly_training_hours' => 15,
            'secondary_sports' => ['Volleyball'],
            'personal_bests' => ['100m: 11.2s', 'Long Jump: 6.8m'],
            'medals_awards' => ['UAAP Champion 2023', 'MVP 2022'],
        ]);

        User::create([
            'name' => 'Ana Garcia',
            'fname' => 'Ana',
            'mname' => 'Maria',
            'lname' => 'Garcia',
            'email' => 'ana.athlete@pathfit.com',
            'password' => Hash::make('password'),
            'role' => 'Athlete',
            'coach_id' => $coachJohn->id,
            'gender' => 'female',
            'date_of_birth' => '1998-11-25',
            'age' => 26,
            'nationality' => 'Philippine',
            'place_of_birth' => 'Makati',
            'current_residence' => 'Manila',
            'height' => 165,
            'weight' => 55,
            'primary_sport' => 'Volleyball',
            'level' => 'professional',
            'years_active' => 12,
            'position_role' => 'Setter',
            'jersey_number' => 12,
            'club_team_name' => 'Creamline Cool Smashers',
            'weekly_training_hours' => 20,
            'secondary_sports' => ['Swimming'],
            'personal_bests' => ['Spike: 85km/h', 'Block: 3.2m'],
            'medals_awards' => ['PVL Champion 2023', 'Best Setter 2022'],
            'injury_history' => ['ACL Tear 2019'],
            'current_injuries' => [],
        ]);

        User::create([
            'name' => 'Miguel Torres',
            'fname' => 'Miguel',
            'mname' => 'Antonio',
            'lname' => 'Torres',
            'email' => 'miguel.athlete@pathfit.com',
            'password' => Hash::make('password'),
            'role' => 'Athlete',
            'coach_id' => $coachJohn->id,
            'gender' => 'male',
            'date_of_birth' => '1995-07-12',
            'age' => 29,
            'nationality' => 'Philippine',
            'place_of_birth' => 'Pasig',
            'current_residence' => 'Manila',
            'height' => 180,
            'weight' => 75,
            'primary_sport' => 'Soccer',
            'level' => 'semi-pro',
            'years_active' => 15,
            'position_role' => 'Midfielder',
            'jersey_number' => 10,
            'club_team_name' => 'Kaya FC',
            'weekly_training_hours' => 18,
            'secondary_sports' => ['Basketball'],
            'personal_bests' => ['Goals: 25/season', 'Assists: 15/season'],
            'medals_awards' => ['PFL Cup Winner 2022'],
            'recovery_methods' => ['Foam Rolling', 'Ice Baths', 'Compression Therapy'],
        ]);

        User::create([
            'name' => 'Sofia Reyes',
            'fname' => 'Sofia',
            'mname' => 'Isabella',
            'lname' => 'Reyes',
            'email' => 'sofia.athlete@pathfit.com',
            'password' => Hash::make('password'),
            'role' => 'Athlete',
            'coach_id' => $coachMaria->id,
            'gender' => 'female',
            'date_of_birth' => '2002-09-05',
            'age' => 22,
            'nationality' => 'Philippine',
            'place_of_birth' => 'Taguig',
            'current_residence' => 'Manila',
            'height' => 170,
            'weight' => 60,
            'primary_sport' => 'Swimming',
            'level' => 'elite',
            'years_active' => 10,
            'position_role' => 'Freestyle',
            'club_team_name' => 'PSC Swimming Club',
            'weekly_training_hours' => 25,
            'secondary_sports' => ['Water Polo'],
            'personal_bests' => ['50m Free: 26.5s', '100m Free: 58.2s', '200m Free: 2:08.5'],
            'medals_awards' => ['SEA Games Gold 2023', 'Philippine Record Holder'],
            'recovery_methods' => ['Active Recovery', 'Stretching', 'Massage'],
        ]);

        User::create([
            'name' => 'Carlos Mendoza',
            'fname' => 'Carlos',
            'mname' => 'Rafael',
            'lname' => 'Mendoza',
            'email' => 'carlos.athlete@pathfit.com',
            'password' => Hash::make('password'),
            'role' => 'Athlete',
            'coach_id' => $coachMaria->id,
            'gender' => 'male',
            'date_of_birth' => '1997-12-18',
            'age' => 27,
            'nationality' => 'Philippine',
            'place_of_birth' => 'Parañaque',
            'current_residence' => 'Manila',
            'height' => 185,
            'weight' => 80,
            'primary_sport' => 'Track and Field',
            'discipline_event' => '100m Sprint',
            'level' => 'elite',
            'years_active' => 14,
            'club_team_name' => 'Philippine Athletics Track Club',
            'weekly_training_hours' => 22,
            'secondary_sports' => ['Basketball'],
            'personal_bests' => ['100m: 10.45s', '200m: 21.8s'],
            'medals_awards' => ['Asian Games Bronze 2022', 'Philippine Champion 2023'],
            'recovery_methods' => ['Cryotherapy', 'Compression', 'Nutrition'],
        ]);
    }
}

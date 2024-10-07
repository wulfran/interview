<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamsTableSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->getTeams() as $team) {
            Team::create($team);
        }
    }

    private function getTeams(): array
    {
        return [
            [
                'name' => 'Asrenal London',
                'points' => 0,
                'matches_played' => 0,
                'wins' => 0,
                'draws' => 0,
                'loses' => 0,
                'goal_balance' => 0,
            ],
            [
                'name' => 'Manchester United',
                'points' => 0,
                'matches_played' => 0,
                'wins' => 0,
                'draws' => 0,
                'loses' => 0,
                'goal_balance' => 0,
            ],
            [
                'name' => 'Tottenham Hotspur',
                'points' => 0,
                'matches_played' => 0,
                'wins' => 0,
                'draws' => 0,
                'loses' => 0,
                'goal_balance' => 0,
            ],
            [
                'name' => 'Everton',
                'points' => 0,
                'matches_played' => 0,
                'wins' => 0,
                'draws' => 0,
                'loses' => 0,
                'goal_balance' => 0,
            ],
        ];
    }
}

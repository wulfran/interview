<?php

namespace Database\Factories;

use App\Models\Round;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoundFactory extends Factory
{
    protected $model = Round::class;


    public function definition(): array
    {
        return [
            'home_team_id' => Team::factory(),
            'guest_team_id' => Team::factory(),
            'home_team_goals' => rand(0,6),
            'guest_team_goals' => rand(0,6),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory
{
    protected $model = Team::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'points' => $this->faker->numberBetween(0, 36),
            'matches_played' => $this->faker->numberBetween(0, 12),
            'wins' => $this->faker->numberBetween(0, 10),
            'loses' => $this->faker->numberBetween(0, 10),
            'draws' => $this->faker->numberBetween(0, 10),
            'goal_balance' => $this->faker->numberBetween(-10, 10),
        ];
    }
}

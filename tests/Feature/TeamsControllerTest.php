<?php

namespace Tests\Feature;

use App\Models\Team;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TeamsControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testItCanRetrieveAllTeams()
    {
        $teams = Team::query()
            ->select(['name', 'points', 'matches_played', 'wins', 'draws', 'loses', 'goal_balance'])
            ->orderBy('points', 'desc')
            ->orderBy('goal_balance', 'desc')
            ->get();

        $response = $this->get(route('teams'));
        $response->assertStatus(200);

        $response->assertJsonFragment($teams->first()->toArray());
    }
}

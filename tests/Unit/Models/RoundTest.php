<?php

namespace Tests\Unit\Models;

use App\Exceptions\RoundsLimitExceeded;
use App\Models\Round;
use App\Models\Team;
use Tests\TestCase;

class RoundTest extends TestCase
{
    public function testItCanCreateRound()
    {
        $round = Round::factory()->create();

        $this->assertDatabaseCount('rounds', 1);
        $this->assertDatabaseHas('rounds', [
            'home_team_id' => $round->home_team_id,
            'guest_team_id' => $round->guest_team_id,
            'home_team_goals' => $round->home_team_goals,
            'guest_team_goals' => $round->guest_team_goals,
        ]);
    }

    public function testItHasNoTimestamps()
    {
        $team = Round::factory()->create();
        $this->assertNull($team->created_at);
        $this->assertNull($team->updated_at);
    }

    public function testItIsConnectedToTeams()
    {
        $round = Round::factory()->create();
        $this->assertInstanceOf(Team::class, $round->homeTeam);
        $this->assertInstanceOf(Team::class, $round->guestTeam);

        $this->assertEquals($round->homeTeam->id, $round->home_team_id);
        $this->assertEquals($round->guestTeam->id, $round->guest_team_id);
    }

    public function testItCanGetMatchesSetupArray()
    {
        $this->assertIsArray(Round::getMatchesSetup());
    }

    public function testItCanGetRoundsLimit()
    {
        $this->assertIsNumeric(Round::getRoundsLimit());
    }

    public function testItCanGetMatchSetupByRound()
    {
        $this->assertNotNull(Round::getSetupByRound(rand(0, 3)));
    }

    public function testItThrowsErrorWhenRoundsLimitExceeds()
    {
        $this->expectException(RoundsLimitExceeded::class);
        Round::getSetupByRound(4);
    }
}

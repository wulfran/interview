<?php

namespace Tests\Unit\Models;

use App\Models\Team;
use Tests\TestCase;

class  TeamTest extends TestCase
{
    public function testItCanCreateTeam(): void
    {
        $team = Team::factory()->create();
        $this->assertDatabaseCount('teams', 1);
        $this->assertDatabaseHas('teams', $team->toArray());
    }

    public function testItHasNoTimestamps()
    {
        $team = Team::factory()->create();
        $this->assertNull($team->created_at);
        $this->assertNull($team->updated_at);
    }
}

<?php

namespace Tests\Feature\Controllers\Api;

use App\Http\Controllers\Api\TeamsController;
use App\Models\Team;
use App\Repositories\TeamRepository\TeamRepository;
use App\Repositories\TeamRepository\TeamRepositoryInterface;
use Illuminate\Support\Traits\ReflectsClosures;
use Tests\TestCase;

class TeamsControllerTest extends TestCase
{
    use ReflectsClosures;

    public function testItCanRetrieveAllTeams()
    {
        $teams = Team::factory()->count(3)->create();

        $response = $this->get(route('teams'));
        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                'data' => [
                    '*' => [
                        'name',
                        'points',
                        'matches_played',
                        'wins',
                        'draws',
                        'loses',
                        'goal_balance'
                    ]
                ]
            ]
        ]);

        foreach($teams as $team) {
            $response->assertJsonFragment([
                'name' => $team->name,
                'points' => $team->points,
                'matches_played' => $team->matches_played,
            ]);
        }
    }

    public function testItCanGetTeams()
    {
        $teams = Team::factory()->count(3)->create();

        $teamRepositoryMock = \Mockery::mock(TeamRepository::class);

        $teamRepositoryMock
            ->shouldReceive('all')
            ->once()
            ->andReturn($teams);

        $controller = new TeamsController($teamRepositoryMock);

        $response = $controller->index();

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testItShouldUseTeamRepositoryInterface()
    {
        $teamRepositoryMock = \Mockery::mock(TeamRepository::class);
        $controller = new TeamsController($teamRepositoryMock);

        $reflection = new \ReflectionClass(TeamsController::class);
        $property = $reflection->getProperty('teamRepository');
        $this->assertTrue($property->getValue($controller) instanceof TeamRepositoryInterface);
    }
}

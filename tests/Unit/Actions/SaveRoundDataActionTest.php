<?php

namespace Tests\Unit\Actions;

use App\Actions\SaveRoundDataAction;
use App\Models\Team;
use App\Repositories\RoundRepository\RoundRepository;
use App\Repositories\RoundRepository\RoundRepositoryInterface;
use Tests\TestCase;

class SaveRoundDataActionTest extends TestCase
{
    public function testInitializeDependencies()
    {
        $repositoryMock = \Mockery::mock(RoundRepository::class);
        $action = new SaveRoundDataAction($repositoryMock);

        $reflection = new \ReflectionClass(SaveRoundDataAction::class);
        $property = $reflection->getProperty('roundRepository');

        $this->assertTrue($property->getValue($action) instanceof RoundRepositoryInterface);
    }

    public function testItCanSaveRoundData()
    {
        $repositoryMock = \Mockery::mock(RoundRepository::class);
        $repositoryMock->shouldReceive('store')->once();
        $action = new SaveRoundDataAction($repositoryMock);

        $teams = Team::factory()->count(2)->create();
        $data = [
            'home_team_id' => $teams[0]->id,
            'guest_team_id' => $teams[1]->id,
            'home_team_goals' => 1,
            'guest_team_goals' => 3,
        ];

        $action->execute($data);
    }
}

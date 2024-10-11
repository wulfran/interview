<?php

namespace Tests\Feature\Controllers\Api;

use App\Actions\SimulateRoundAction;
use App\Http\Controllers\RoundsController;
use App\Jobs\CalculateLeagueOdds;
use App\Models\Round;
use App\Models\Team;
use App\Repositories\RoundRepository\RoundRepository;
use App\Repositories\RoundRepository\RoundRepositoryInterface;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Traits\ReflectsClosures;
use Mockery;
use Tests\TestCase;

class RoundsControllerTest extends TestCase
{
    use ReflectsClosures;

    public function testInitializeDependencies()
    {
        $repositoryMock = \Mockery::mock(RoundRepository::class);
        $actionMock = \Mockery::mock(SimulateRoundAction::class);

        $controller = new RoundsController($repositoryMock, $actionMock);

        $reflection = new \ReflectionClass(RoundsController::class);
        $propertyRepository = $reflection->getProperty('roundRepository');
        $propertyAction = $reflection->getProperty('simulateRoundAction');

        $this->assertTrue($propertyRepository->getValue($controller) instanceof RoundRepositoryInterface);
        $this->assertTrue($propertyAction->getValue($controller) instanceof SimulateRoundAction);
    }

    public function testItCanRetrieveAllRounds()
    {
        $rounds = Round::factory()->count(3)->create();

        $response = $this->get(route('rounds.index'));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'data' => [
                    '*' => [
                        'homeTeam',
                        'guestTeam',
                        'score'
                    ]
                ]
            ]
        ]);

        foreach($rounds as $round) {
            $response->assertJsonFragment([
                'homeTeam' => $round->homeTeam->name,
                'guestTeam' => $round->guestTeam->name,
                'score' => $round->score
            ]);
        }
    }

    public function testItCanGetRounds()
    {
        $rounds = Round::factory()->count(3)->create();

        $roundRepositoryMock = \Mockery::mock(RoundRepository::class);
        $actionMock = \Mockery::mock(SimulateRoundAction::class);

        $roundRepositoryMock
            ->shouldReceive('all')
            ->once()
            ->andReturn($rounds);

        $controller = new RoundsController($roundRepositoryMock, $actionMock);

        $response = $controller->index();
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testItCanSimulateRound()
    {
        Team::factory()->count(4)->create();
        $queue = Queue::fake();

        $this->get(route('rounds.simulate'))->assertStatus(200);

        $queue->assertPushed(CalculateLeagueOdds::class);
    }

    public function testItShouldThrowExceptionIfSomethingGoesWrong()
    {
        $actionMock = Mockery::mock(SimulateRoundAction::class);
        $roundRepositoryMock = \Mockery::mock(RoundRepository::class);

        $actionMock->shouldReceive('execute')
            ->andThrow(new \Exception('Whoops... something went wrong', 400));

        $controller = new RoundsController($roundRepositoryMock, $actionMock);

        $response = $controller->simulateRound();

        $this->assertEquals(400, $response->getStatusCode());

        $responseData = json_decode($response->getContent());

        $this->assertSame('Whoops... something went wrong', $responseData->message);
    }
}

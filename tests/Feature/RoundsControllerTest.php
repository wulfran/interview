<?php

namespace Tests\Feature;

use App\Jobs\CalculateLeagueOdds;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class RoundsControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testItCanReceiveAllRounds()
    {
        $this->get(route('rounds.index'))->assertStatus(200);
    }

    public function testItCanSimulateRounds()
    {
        $queue = Queue::fake();
        $this->get(route('rounds.simulate'))->assertStatus(200);

        $queue->assertPushed(CalculateLeagueOdds::class);
    }
}

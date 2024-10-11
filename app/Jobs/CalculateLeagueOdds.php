<?php

namespace App\Jobs;

use App\Events\OddsCalculationFinished;
use App\Models\Round;
use App\Repositories\RoundRepository\RoundRepositoryInterface;
use App\Repositories\TeamRepository\TeamRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CalculateLeagueOdds implements ShouldQueue
{
    use Queueable;

    public function __construct(private readonly TeamRepository $teamRepository, private readonly RoundRepositoryInterface $roundRepository)
    {
    }

    public function handle(): void
    {
        $teams = $this->teamRepository->all();
        $rounds = $this->roundRepository->all();

        $remainingRounds =  Round::TOTAL_ROUNDS - (int)ceil($rounds->count() / 2);

        $teamOdds = [];
        $maxPoints = [];
        foreach($teams as $team) {
            $maxPoints[$team->name] = $team->points + ($remainingRounds*3);
        }
        $bestScore = max($maxPoints);
        foreach($teams as $team) {
            $teamOdds[$team->name] = $bestScore > 0 ? number_format(($team->points / ($remainingRounds * 3)) * 100, 2) : 0;
        }

        arsort($teamOdds);

        OddsCalculationFinished::dispatch($teamOdds);
    }
}

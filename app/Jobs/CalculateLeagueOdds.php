<?php

namespace App\Jobs;

use App\Events\OddsCalculationFinished;
use App\Models\Round;
use App\Repositories\RoundRepository\RoundRepositoryInterface;
use App\Repositories\TeamRepository\TeamRepositoryInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CalculateLeagueOdds implements ShouldQueue
{
    use Queueable;
    private TeamRepositoryInterface $teamRepository;
    private RoundRepositoryInterface $roundRepository;

    public function handle(): void
    {
        $this->initializeDependencies();
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

    private function initializeDependencies(): void
    {
        $this->teamRepository = app(TeamRepositoryInterface::class);
        $this->roundRepository = app(RoundRepositoryInterface::class);
    }
}

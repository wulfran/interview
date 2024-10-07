<?php

namespace App\Jobs;

use App\Events\OddsCalculationFinished;
use App\Models\Round;
use App\Models\Team;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CalculateLeagueOdds implements ShouldQueue
{
    use Queueable;

    public function handle(): void
    {
        $teams = Team::all();
        $rounds = Round::all();
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

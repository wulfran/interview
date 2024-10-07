<?php

namespace App\Observers;

use App\Models\Round;

class RoundObserver
{
    public function created(Round $round): void
    {
        $balance = $round->home_team_goals - $round->guest_team_goals;
        $homeWon = $balance > 0;
        $guestWon = $balance < 0;

        $round->homeTeam->update([
            'goal_balance' => $round->homeTeam->goal_balance + $balance,
            'wins' => $round->homeTeam->wins + ($homeWon ? 1: 0),
            'loses' => $round->homeTeam->loses + ($balance !== 0 && $guestWon? 1: 0),
            'draws' => $round->homeTeam->draws + ($balance === 0 ? 1: 0),
        ]);

        $round->guestTeam->update([
            'goal_balance' => $round->guestTeam->goal_balance + ($balance * -1),
            'wins' => $round->guestTeam->wins + ($guestWon ? 1: 0),
            'loses' => $round->guestTeam->loses + ($balance !== 0 && $homeWon ? 1: 0),
            'draws' => $round->guestTeam->draws + ($balance === 0 ? 1: 0),
        ]);
    }
}

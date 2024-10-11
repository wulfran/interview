<?php

namespace App\Actions;

class PlayMatchAction
{
    public function execute(): array
    {
        $result = $this->getMatchOutcome();
        $min  = $result === 2 ? 0 : 1;
        $winningTeamGoals = $this->getTeamGoals($min);
        $limit = $result === 2 ? $min : $min - 1;
        $losingTeamGoals = $this->getTeamGoals(0, $limit);

        return $this->prepareData($result, $winningTeamGoals, $losingTeamGoals);
    }

    private function getMatchOutcome(): int
    {
        // result 0 => home team wins
        // result 1 => guest team wins
        // result 2 => draw
        return rand(0,2);
    }

    private function getTeamGoals(int $min=0, int $max=6): int
    {
        return rand($min, $max);
    }

    private function prepareData(int $result, int $winningTeamGoals, int $losingTeamGoals): array
    {
        return [
            'home_team_goals' => $result === 0 || $result === 2 ? $winningTeamGoals : $losingTeamGoals,
            'guest_team_goals' => $result === 1 || $result === 2 ? $winningTeamGoals : $losingTeamGoals,
        ];
    }
}

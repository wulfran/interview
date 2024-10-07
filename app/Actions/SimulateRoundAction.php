<?php

namespace App\Actions;

use App\Models\Round;
use App\Models\Team;
use Illuminate\Support\Collection;

class SimulateRoundAction
{
    private Collection $teams;
    private Collection $rounds;

    private array $schedule;
    private Collection $firstMatch;
    private Collection $secondMatch;

    public function __construct()
    {
        $this->teams = Team::all();
        $this->rounds = Round::all();
        if (($this->rounds->count() / 2) >= Round::getRoundsLimit()) {
            throw new \Exception('Rounds limit exceeded');
        }
        $this->schedule = Round::getSetupByRound($this->rounds->count() / 2);
        $this->firstMatch = collect();
        $this->secondMatch = collect();
    }

    public function execute(): void
    {
        $this->setPairs();
        try {
            $this->playMatch();
            $this->playMatch('secondMatch');
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    private function setPairs(): void
    {
        $i1 = $this->schedule[0][0];
        $i2 = $this->schedule[0][1];
        $i3 = $this->schedule[1][0];
        $i4 = $this->schedule[1][1];

        $this->firstMatch->push($this->teams[$i1]);
        $this->firstMatch->push($this->teams[$i2]);
        $this->secondMatch->push($this->teams[$i3]);
        $this->secondMatch->push($this->teams[$i4]);
    }

    private function getMatchOutcome(): int
    {
        // result 0 => home team wins
        // result 1 => guest team wins
        // result 2 => draw
        return rand(0,2);
    }

    private function playMatch(string $matchNumber='firstMatch'): void
    {
        $result = $this->getMatchOutcome();
        $min  = $result === 2 ? 0 : 1;
        $winningTeamGoals = $this->getTeamGoals($min);
        $limit = $result === 2 ? $min : $min - 1;
        $losingTeamGoals = $this->getTeamGoals(0, $limit);

        $roundData = $this->prepareRoundData($matchNumber, $result, $winningTeamGoals, $losingTeamGoals);
        $this->saveRound($roundData);
    }

    private function getTeamGoals(int $min=0, int $max=6): int
    {
        return rand($min, $max);
    }

    public function prepareRoundData(string $matchNumber, int $result, int $winningTeamGoals, int $losingTeamGoals): array
    {
        return [
            'home_team_id' => $this->{$matchNumber}[0]->id,
            'guest_team_id' => $this->{$matchNumber}[1]->id,
            'home_team_goals' => $result === 0 || $result == 2 ? $winningTeamGoals : $losingTeamGoals,
            'guest_team_goals' => $result === 1 || $result == 2 ? $winningTeamGoals : $losingTeamGoals,
        ];
    }

    private function saveRound(array $roundData): void
    {
        try {
            Round::create($roundData);
        } catch (\Exception $e) {
            report($e);
        }
    }
}

<?php

namespace App\Actions;

use App\Exceptions\RoundsLimitExceeded;
use App\Models\Round;
use App\Repositories\RoundRepository\RoundRepositoryInterface;
use App\Repositories\TeamRepository\TeamRepositoryInterface;
use Illuminate\Support\Collection;

class SimulateRoundAction
{
    private Collection $teams;
    private Collection $rounds;
    private array $schedule;
    private Collection $firstMatch;
    private Collection $secondMatch;

    public function __construct(
        protected readonly TeamRepositoryInterface $teamRepository,
        protected readonly RoundRepositoryInterface $roundRepository,
        protected readonly PlayMatchAction $playMatchAction,
        protected readonly SaveRoundDataAction $saveRoundDataAction,
    )
    {
    }

    private function initialize(): void
    {
        $this->initializeTeams();
        $this->initializeRounds();
        $this->checkRoundLimits();
        $this->initializeSchedule();
        $this->initializeMatches();
    }

    public function initializeTeams(): void
    {
        $this->teams = $this->teamRepository->all();
    }

    public function initializeRounds(): void
    {
        $this->rounds = $this->roundRepository->all();
    }

    public function initializeSchedule(): void
    {
        $this->schedule = Round::getSetupByRound((int)($this->rounds->count() / 2));
    }

    public function initializeMatches(): void
    {
        $this->firstMatch = collect();
        $this->secondMatch = collect();
    }

    public function execute(): void
    {
        $this->initialize();
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
        $i1 = $this->getTeamIndex(0,0);
        $i2 = $this->getTeamIndex(0,1);
        $i3 = $this->getTeamIndex(1,0);
        $i4 = $this->getTeamIndex(1,1);

        $this->firstMatch->push($this->teams[$i1]);
        $this->firstMatch->push($this->teams[$i2]);
        $this->secondMatch->push($this->teams[$i3]);
        $this->secondMatch->push($this->teams[$i4]);
    }

    public function getTeamIndex(int $firstIndex, int $secondIndex): int
    {
        return $this->schedule[$firstIndex][$secondIndex];
    }

    private function playMatch(string $matchNumber='firstMatch'): void
    {
        $outcome = $this->playMatchAction->execute();
        $roundData = $this->prepareRoundData($matchNumber, $outcome);
        $this->saveRoundDataAction->execute($roundData);
    }

    public function prepareRoundData(string $matchNumber, array $outcome): array
    {
        return array_merge([
            'home_team_id' => $this->{$matchNumber}[0]->id,
            'guest_team_id' => $this->{$matchNumber}[1]->id,
        ], $outcome);
    }

    private function checkRoundLimits(): void
    {
        if (($this->rounds->count() / 2) >= Round::getRoundsLimit()) {
            throw new RoundsLimitExceeded('Rounds limit exceeded', 422);
        }
    }
}

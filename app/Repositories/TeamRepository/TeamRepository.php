<?php

namespace App\Repositories\TeamRepository;

use App\Models\Team;
use App\Repositories\Repository;
use Illuminate\Support\Collection;

class TeamRepository extends Repository implements TeamRepositoryInterface
{
    public function __construct(Team $model)
    {
        parent::__construct($model);
    }

    public function all(): Collection
    {
        return Team::query()
            ->select(['name', 'points', 'matches_played', 'wins', 'draws', 'loses', 'goal_balance'])
            ->orderBy('points', 'desc')
            ->orderBy('goal_balance', 'desc')
            ->get();
    }
}

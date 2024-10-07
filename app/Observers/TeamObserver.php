<?php

namespace App\Observers;

use App\Models\Team;

class TeamObserver
{
    public function updating(Team $team)
    {
        if($team->getOriginal('wins') < $team->wins) {
            $team->points += 3;
        } elseif ($team->getOriginal('draws') < $team->draws) {
            $team->points += 1;
        }
    }
}

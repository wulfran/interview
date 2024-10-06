<?php

namespace App\Http\Resources\Teams;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
{
    /**
     * Team resource
     *
     * @mixin Team
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'points' => $this->points,
            'matches_played' => $this->matches_played,
            'wins' => $this->wins,
            'drafts' => $this->drafts,
            'loses' => $this->loses,
            'goal_balance' => $this->goal_balance,
        ];
    }
}

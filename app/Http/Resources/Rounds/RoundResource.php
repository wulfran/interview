<?php

namespace App\Http\Resources\Rounds;

use App\Models\Round;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoundResource extends JsonResource
{
    /**
     * Round resource.
     *
     * @mixin Round
     */
    public function toArray(Request $request): array
    {
        return [
            'homeTeam' => $this->homeTeam->name,
            'guestTeam' => $this->guestTeam->name,
            'score' => $this->score
        ];
    }
}

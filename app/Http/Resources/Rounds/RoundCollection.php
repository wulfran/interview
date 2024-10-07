<?php

namespace App\Http\Resources\Rounds;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RoundCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'data' => RoundResource::collection($this->collection),
        ];
    }
}

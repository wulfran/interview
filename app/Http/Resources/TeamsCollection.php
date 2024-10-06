<?php

namespace App\Http\Resources;

use App\Http\Resources\Teams\TeamResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TeamsCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'data' => TeamResource::collection($this->collection),
        ];
    }
}

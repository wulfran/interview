<?php

namespace App\Http\Controllers;

use App\Actions\SimulateRoundAction;
use App\Http\Resources\Rounds\RoundCollection;
use App\Jobs\CalculateLeagueOdds;
use App\Models\Round;
use Illuminate\Http\JsonResponse;

class RoundsController extends Controller
{
    public function simulateRound(SimulateRoundAction $action): JsonResponse
    {
        try {
            $action->execute();

            CalculateLeagueOdds::dispatch();

            return response()->json([
                'message' => 'Round successfully played!',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ],$e->getCode());
        }
    }

    public function index(): JsonResponse
    {
        $rounds = Round::query()
            ->select()
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'data' => new RoundCollection($rounds),
        ]);
    }
}

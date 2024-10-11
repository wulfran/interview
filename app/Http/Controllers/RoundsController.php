<?php

namespace App\Http\Controllers;

use App\Actions\SimulateRoundAction;
use App\Http\Resources\Rounds\RoundCollection;
use App\Jobs\CalculateLeagueOdds;
use App\Repositories\RoundRepository\RoundRepositoryInterface;
use Illuminate\Http\JsonResponse;

class RoundsController extends Controller
{
    public function __construct(
        protected readonly RoundRepositoryInterface $roundRepository,
        protected readonly SimulateRoundAction $simulateRoundAction
    )
    {
    }

    public function simulateRound(): JsonResponse
    {
        try {
            $this->simulateRoundAction->execute();

            CalculateLeagueOdds::dispatch();

            return response()->json([
                'message' => 'Round successfully played!',
            ]);
        } catch (\Throwable $e) {
            report($e);
            return response()->json([
                'message' => $e->getMessage(),
            ],$e->getCode() !== 0 ? $e->getCode() : 500);
        }
    }

    public function index(): JsonResponse
    {
        $rounds = $this->roundRepository->all();

        return response()->json([
            'data' => new RoundCollection($rounds),
        ]);
    }
}

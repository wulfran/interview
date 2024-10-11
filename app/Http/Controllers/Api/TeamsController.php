<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Teams\TeamsCollection;
use App\Models\Team;
use Illuminate\Http\JsonResponse;

class TeamsController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $teams = Team::query()
                ->select(['name', 'points', 'matches_played', 'wins', 'draws', 'loses', 'goal_balance'])
                ->orderBy('points', 'desc')
                ->orderBy('goal_balance', 'desc')
                ->get();

            return response()->json([
                'message' => 'Success',
                'data' => new TeamsCollection($teams),
            ]);
        } catch (\Exception $e) {
            report ($e);

            return response()->json([
                'message' => $e->getMessage(),
                'data' => []
            ], $e->getCode());
        }
    }
}

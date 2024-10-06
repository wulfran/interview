<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TeamsCollection;
use App\Models\Team;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TeamsController extends Controller
{
    public function __invoke(): JsonResponse
    {
        try {
            $teams = Team::all();
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

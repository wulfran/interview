<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Teams\TeamsCollection;
use App\Models\Team;
use App\Repositories\TeamRepository\TeamRepositoryInterface;
use Illuminate\Http\JsonResponse;

class TeamsController extends Controller
{
    public function __construct(private readonly TeamRepositoryInterface $teamRepository)
    {
    }

    public function index(): JsonResponse
    {
        try {
            $teams = $this->teamRepository->all();

            return response()->json([
                'data' => new TeamsCollection($teams),
            ]);
        } catch (\Exception $e) {
            report ($e);

            return response()->json([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }
}

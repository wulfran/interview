<?php

use App\Http\Controllers\Api\TeamsController;
use Illuminate\Support\Facades\Route;

Route::get('teams', TeamsController::class);

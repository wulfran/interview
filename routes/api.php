<?php

use App\Http\Controllers\Api\TeamsController;
use App\Http\Controllers\RoundsController;
use Illuminate\Support\Facades\Route;

Route::get('teams', TeamsController::class)->name('teams');
Route::prefix('rounds')->as('rounds.')->group(function () {
    Route::get('simulate', [RoundsController::class, 'simulateRound'])->name('simulate');
    Route::get('', [RoundsController::class, 'index'])->name('index');
});


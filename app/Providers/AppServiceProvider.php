<?php

namespace App\Providers;

use App\Models\Round;
use App\Models\Team;
use App\Observers\RoundObserver;
use App\Observers\TeamObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Round::observe(RoundObserver::class);
        Team::observe(TeamObserver::class);
    }
}

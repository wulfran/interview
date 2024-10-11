<?php

namespace App\Providers;

use App\Models\Round;
use App\Models\Team;
use App\Observers\RoundObserver;
use App\Observers\TeamObserver;
use App\Repositories\Repository;
use App\Repositories\RepositoryInterface;
use App\Repositories\RoundRepository\RoundRepository;
use App\Repositories\RoundRepository\RoundRepositoryInterface;
use App\Repositories\TeamRepository\TeamRepository;
use App\Repositories\TeamRepository\TeamRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $bindings = [
        RepositoryInterface::class => Repository::class,
        TeamRepositoryInterface::class => TeamRepository::class,
        RoundRepositoryInterface::class => RoundRepository::class,
    ];

    public function register(): void
    {
        foreach ($this->bindings as $abstract => $specific) {
            $this->app->bind($abstract, $specific);
        }
    }

    public function boot(): void
    {
        Round::observe(RoundObserver::class);
        Team::observe(TeamObserver::class);
    }
}

<?php

namespace App\Repositories;

use Illuminate\Support\Collection;

interface RepositoryInterface
{
    public function all(): Collection;
}

<?php

namespace App\Repositories\RoundRepository;

use App\Repositories\RepositoryInterface;

interface RoundRepositoryInterface extends RepositoryInterface
{
    public function store(array $data): void;
}

<?php

namespace App\Repositories\RoundRepository;

use App\Models\Round;
use App\Repositories\Repository;
use Illuminate\Support\Collection;

class RoundRepository extends Repository implements RoundRepositoryInterface
{
    public function __construct(Round $model)
    {
        parent::__construct($model);
    }

    public function all(): Collection
    {
        return $this->model
            ->orderBy('id', 'desc')
            ->get();
    }
}

<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class Repository implements RepositoryInterface
{
    public function __construct(protected Model $model)
    {
    }

    public function all(): Collection {
        return $this->model->all();
    }
}

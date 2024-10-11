<?php

namespace App\Repositories\RoundRepository;

use App\Models\Round;
use App\Repositories\Repository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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

    public function store(array $data): void
    {
        DB::beginTransaction();

        try {
            $this->model->create($data);
            DB::commit();
        } catch (\Exception $e) {
            report($e);
            DB::rollBack();
        }
    }
}

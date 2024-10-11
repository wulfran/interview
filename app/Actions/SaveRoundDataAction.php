<?php

namespace App\Actions;

use App\Repositories\RoundRepository\RoundRepositoryInterface;

readonly class SaveRoundDataAction
{
    public function __construct(protected RoundRepositoryInterface $roundRepository)
    {
    }

    public function execute(array $data): void
    {
        $this->roundRepository->store($data);
    }
}

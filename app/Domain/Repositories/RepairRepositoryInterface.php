<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Repair;
use Illuminate\Database\Eloquent\Collection;

interface RepairRepositoryInterface
{
    public function getRepairsByCarId(int $carId): array;

    public function getRepairsFromCarsId(array $carIds): Collection;
}

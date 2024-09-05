<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Repair;

interface RepairRepositoryInterface
{
    public function getRepairsByCarId(int $carId): array;
}

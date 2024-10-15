<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Repair;
use App\Models\Repair as EloquentRepair;
use Illuminate\Database\Eloquent\Collection;

interface RepairRepositoryInterface
{
    public function getRepairsByCarId(int $carId): array;

    public function getRepairsFromCarsId(array $carIds): Collection;

    public function deleteRepairById(int $repairId): bool;
    public function deleteRepairModel(\App\Models\Repair $model): bool;

    public function getRepairEntityById(int $repairId): ?Repair;
    public function getRepairEloquentModelById(int $repairId): ?\App\Models\Repair;

    public function createRepair(Repair $repair): EloquentRepair;
}

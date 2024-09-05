<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Repair;
use App\Domain\Repositories\RepairRepositoryInterface;
use App\Models\Repair as EloquentRepair;

class EloquentRepairRepository implements RepairRepositoryInterface
{
    public function getRepairsByCarId(int $carId): array
    {
        $eloquentRepairs = EloquentRepair::where('car_id', $carId)->get();
        $repairs = [];

        foreach ($eloquentRepairs as $eloquentRepair) {

            $repairs[] = new Repair(
                $eloquentRepair->id,
                $eloquentRepair->car_id,
                $eloquentRepair->repair_type_id,
                $eloquentRepair->getRepairTypeName(),
                $eloquentRepair->price,
                $eloquentRepair->date,
                $eloquentRepair->is_planned_repair
            );
        }

        return $repairs;
    }
}

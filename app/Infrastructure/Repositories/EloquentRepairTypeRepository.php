<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\RepairType;
use App\Domain\Repositories\RepairTypesRepositoryInterface;
use App\Models\RepairType as EloquentRepairType;

class EloquentRepairTypeRepository implements RepairTypesRepositoryInterface
{

    public function getAll(): array
    {
        $eloquentRepairTypes = EloquentRepairType::all();
        $repairTypes = [];

        foreach ($eloquentRepairTypes as $eloquentRepairType) {
            $repairTypes[] = new RepairType(
                $eloquentRepairType->id,
                $eloquentRepairType->name,
            );
        }

        return $repairTypes;
    }
}

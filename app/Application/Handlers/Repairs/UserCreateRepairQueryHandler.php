<?php

namespace App\Application\Handlers\Repairs;

use App\Application\Queries\Repairs\UserCreateRepairQuery;
use App\Domain\Entities\Repair;
use App\Domain\Repositories\CarRepositoryInterface;
use App\Domain\Repositories\RepairRepositoryInterface;
use App\Http\Controllers\Repairs\UserCreateRepair;
use App\Presenters\Dtos\RepairDto;

class UserCreateRepairQueryHandler
{
    private RepairRepositoryInterface $repairRepository;

    public function __construct(
        RepairRepositoryInterface $repairRepository
    )
    {
        $this->repairRepository = $repairRepository;
    }

    public function handle(UserCreateRepairQuery $query)
    {
        $repairEntity = new Repair(
            null,
            $query->carId,
            $query->repairTypeId,
            null,
            $query->price,
            $query->date,
            $query->isPlannedRepair
        );

        $newRepair = $this->repairRepository->createRepair($repairEntity);


        return response()->json(RepairDto::fromModel($newRepair));



    }
}

<?php

namespace App\Application\Handlers\Repairs;

use App\Application\Queries\Repairs\UserEditVehicleRepairQuery;
use App\Application\Queries\Vehicles\EditUserVehicleQuery;
use App\Domain\Repositories\RepairRepositoryInterface;
use App\Presenters\Dtos\RepairDto;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserEditVehicleRepairHandler
{
    private RepairRepositoryInterface $repairRepository;

    public function __construct(
        RepairRepositoryInterface $repairRepository
    )
    {
        $this->repairRepository = $repairRepository;
    }

    public function handle(UserEditVehicleRepairQuery $query): JsonResponse | Response
    {
        $repair = $this->repairRepository->getRepairEntityById($query->id);

        if (!$repair) {
            throw new \Exception('Repair not found', 404);
        }

        $updatedRepair = $this->repairRepository->updateRepair($query);

        return response()->json(RepairDto::fromModel($updatedRepair));

    }
}

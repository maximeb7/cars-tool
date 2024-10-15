<?php

namespace App\Application\Handlers\Repairs;


use App\Application\Queries\Repairs\UserDeleteVehicleRepairQuery;
use App\Domain\Repositories\CarRepositoryInterface;
use App\Domain\Repositories\RepairRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class UserDeleteVehicleRepairQueryHandler
{
    private RepairRepositoryInterface $repairRepository;
    private CarRepositoryInterface $carRepository;

    public function __construct(
        RepairRepositoryInterface $repairRepository,
        CarRepositoryInterface    $carRepository
    )
    {
        $this->repairRepository = $repairRepository;
        $this->carRepository = $carRepository;
    }


    public function handle(UserDeleteVehicleRepairQuery $query): void
    {
        $user = Auth::user();

        if (!$user) {
            throw new \Exception('User not authenticated', 401);
        }

        $repairModel = $this->repairRepository->getRepairEloquentModelById($query->repairId);
        if (!$repairModel) {
            throw new \Exception('Repair not found', 404);
        }

        $carEntity = $this->carRepository->getCarById($repairModel->car_id);

        if (!$carEntity) {
            throw new \Exception('Car corresponding to this repair is not found', 404);
        }

        if ($carEntity->userId !== $user->id) {
            throw new \Exception('You can not delete this repair', 403);
        }

        $this->repairRepository->deleteRepairModel($repairModel);

    }
}

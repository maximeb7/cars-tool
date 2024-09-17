<?php

namespace App\Application\Handlers\Vehicles;

use App\Application\Queries\Vehicles\GetVehicleRepairDetailsQuery;
use App\Domain\Entities\Car;
use App\Domain\Repositories\CarRepositoryInterface;
use App\Domain\Repositories\RepairRepositoryInterface;
use App\Domain\Repositories\UserRepositoryInterface;

class GetVehicleRepairDetailsQueryHandler
{
    private UserRepositoryInterface $userRepository;
    private CarRepositoryInterface $carRepository;
    private RepairRepositoryInterface $repairRepository;


    public function __construct(
        UserRepositoryInterface $userRepository,
        CarRepositoryInterface $carRepository,
        RepairRepositoryInterface $repairRepository
    ) {
        $this->userRepository = $userRepository;
        $this->carRepository = $carRepository;
        $this->repairRepository = $repairRepository;
    }

    public function handle(GetVehicleRepairDetailsQuery $query): array | Car
    {
        $user = $this->userRepository->getUserById($query->userId);

        $car = $this->carRepository->getCarById($query->vehicleId);

        if (null == $car) {
            return [];
        }

        if ($car->userId !== $user->id ) {
            return [];
        }

        $repairs = $this->repairRepository->getRepairsByCarId($car->id);
        $car->repairs = $repairs;

        return $car;


    }
}

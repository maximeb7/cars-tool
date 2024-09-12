<?php

namespace App\Application\Handlers;

use App\Application\Queries\GetUserWithCarsAndRepairsQuery;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Domain\Repositories\CarRepositoryInterface;
use App\Domain\Repositories\RepairRepositoryInterface;

class GetUserWithCarsAndRepairsHandler
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

    public function handle(GetUserWithCarsAndRepairsQuery $query)
    {
        $user = $this->userRepository->getUserByUuid($query->userUuid);

        if (!$user) {
            return null;
        }

        $cars = $this->carRepository->getCarsByUserId($user->id);


        foreach ($cars as $car) {
            $repairs = $this->repairRepository->getRepairsByCarId($car->id);
            $car->repairs = $repairs;
            $user->addCar($car);
        }

        if (empty($user->cars)) {
            $user->cars = [];
        }

        return $user;
    }
}

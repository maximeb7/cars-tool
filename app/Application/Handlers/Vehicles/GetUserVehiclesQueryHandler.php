<?php

namespace App\Application\Handlers\Vehicles;

use App\Application\Queries\Vehicles\GetUserVehiclesQuery;
use App\Domain\Repositories\CarRepositoryInterface;
use App\Domain\Repositories\RepairRepositoryInterface;
use App\Domain\Repositories\UserRepositoryInterface;

class GetUserVehiclesQueryHandler
{
    private UserRepositoryInterface $userRepository;
    private CarRepositoryInterface $carRepository;


    public function __construct(
        UserRepositoryInterface $userRepository,
        CarRepositoryInterface $carRepository,
    ) {
        $this->userRepository = $userRepository;
        $this->carRepository = $carRepository;
    }

    public function handle(GetUserVehiclesQuery $query): array
    {
        $user = $this->userRepository->getUserByUuid($query->userUuid);

        if (!$user) {
            return [];
        }

        $cars = $this->carRepository->getCarsByUserId($user->id);


        return $cars;
    }
}

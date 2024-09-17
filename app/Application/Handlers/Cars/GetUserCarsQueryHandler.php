<?php

namespace App\Application\Handlers\Cars;

use App\Application\Queries\Cars\GetUserCarsQuery;
use App\Domain\Repositories\CarRepositoryInterface;
use App\Domain\Repositories\RepairRepositoryInterface;
use App\Domain\Repositories\UserRepositoryInterface;

class GetUserCarsQueryHandler
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

    public function handle(GetUserCarsQuery $query): array
    {
        $user = $this->userRepository->getUserByUuid($query->userUuid);

        if (!$user) {
            return [];
        }

        $cars = $this->carRepository->getCarsByUserId($user->id);


        return $cars;
    }
}

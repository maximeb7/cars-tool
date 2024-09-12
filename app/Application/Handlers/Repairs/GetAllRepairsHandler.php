<?php

namespace App\Application\Handlers\Repairs;

use App\Application\Queries\Repairs\GetAllRepairsQuery;
use App\Domain\Repositories\CarRepositoryInterface;
use App\Domain\Repositories\RepairRepositoryInterface;
use App\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class GetAllRepairsHandler
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

    public function handle(GetAllRepairsQuery $query): ?Collection
    {
        $user = $this->userRepository->getUserByUuid($query->uuid);

        if (!$user) {
            return null;
        }

        $carsIds = $this->carRepository->getCarsIdByUserId($user->id);

        $repairs = $this->repairRepository->getRepairsFromCarsId($carsIds);


        return $repairs;
    }
}

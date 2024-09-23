<?php

namespace App\Application\Handlers\Vehicles;

use App\Application\Queries\Vehicles\DeleteUserVehicleQuery;
use App\Domain\Repositories\CarRepositoryInterface;
use App\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class DeleteUserVehicleQueryHandler
{
    private CarRepositoryInterface $carRepository;


    public function __construct(
        CarRepositoryInterface $carRepository,
    )
    {
        $this->carRepository = $carRepository;
    }

    public function handle(DeleteUserVehicleQuery $query): void
    {
        $user = Auth::user();

        if (!$user) {
            throw new \Exception('User not authenticated', 401);
        }

        $car = $this->carRepository->getCarById($query->vehicleId);
        if (!$car) {
            throw new \Exception('Vehicle not found', 404);
        }

        if ($car->userId !== $user->id) {
            throw new \Exception('You do not have the right to delete this vehicle', 403);
        }

        $this->carRepository->deleteCarById($query->vehicleId);
    }

}

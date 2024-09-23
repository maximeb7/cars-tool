<?php

namespace App\Application\Handlers\Vehicles;

use App\Application\Queries\Vehicles\CreateUserVehicleQuery;
use App\Domain\Entities\Car;
use App\Domain\Repositories\CarRepositoryInterface;
use App\Presenters\Dtos\CarDto;
use Illuminate\Support\Facades\Auth;

class CreateUserVehicleQueryHandler
{
    private CarRepositoryInterface $carRepository;

    public function __construct(
        CarRepositoryInterface $carRepository
    )
    {
        $this->carRepository = $carRepository;
    }

    public function handle(CreateUserVehicleQuery $query)
    {
        $path = null;
        if ($query->imagePath) {
            $path = $query->imagePath->store('images', 'public');
        }

        $vehicleEntity = new Car(
            null,
            $query->userId,
            $query->brandId,
            null,
            $query->model,
            $query->year,
            $query->plate,
            $path
        );

        $newVehicle = $this->carRepository->createCar($vehicleEntity);

        return response()->json(CarDto::fromModel($newVehicle));
    }
}

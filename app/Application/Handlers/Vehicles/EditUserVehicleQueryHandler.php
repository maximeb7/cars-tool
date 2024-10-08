<?php

namespace App\Application\Handlers\Vehicles;

use App\Application\Queries\Vehicles\EditUserVehicleQuery;
use App\Domain\Repositories\CarRepositoryInterface;
use App\Presenters\Dtos\CarDto;

class EditUserVehicleQueryHandler
{
    private CarRepositoryInterface $carRepository;

    public function __construct(
        CarRepositoryInterface $carRepository
    )
    {
        $this->carRepository = $carRepository;
    }

    public function handle(EditUserVehicleQuery $query)
    {
        $vehicle = $this->carRepository->getCarById($query->id);

        if (isset($query->imagePath) && ($query->imagePath !== $vehicle->imagePath)) {
            if ($query->imagePath instanceof UploadedFile) {
                $query->imagePath = $query->imagePath->store('images', 'public');
            }
        }

        $updatedVehicle = $this->carRepository->updateCarById($query);

        return response()->json(CarDto::fromModel($updatedVehicle));
    }
}

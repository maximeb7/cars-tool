<?php

namespace App\Domain\Repositories;

use App\Application\Queries\Vehicles\EditUserVehicleQuery;
use App\Domain\Entities\Car;
use App\Models\Car as EloquentCar;

interface CarRepositoryInterface
{
    public function getCarsByUserId(int $userId): array;

    public function getCarsIdByUserId(int $userId): array;

    public function getCarById(int $carId): ?Car;

    public function createCar(Car $car): EloquentCar;

    public function deleteCarById(int $carId): bool;

    public function updateCarById(EditUserVehicleQuery $query): EloquentCar;
}

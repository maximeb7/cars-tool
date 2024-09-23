<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Car;
use App\Models\Car as EloquentCar;

interface CarRepositoryInterface
{
    public function getCarsByUserId(int $userId): array;

    public function getCarsIdByUserId(int $userId): array;

    public function getCarById(int $carId): ?Car;

    public function createCar(Car $car): EloquentCar;
}

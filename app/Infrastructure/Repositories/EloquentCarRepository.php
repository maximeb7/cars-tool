<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Car;
use App\Domain\Repositories\CarRepositoryInterface;
use App\Models\Car as EloquentCar;

class EloquentCarRepository implements CarRepositoryInterface
{
    public function getCarsByUserId(int $userId): array
    {
        $eloquentCars = EloquentCar::where('user_id', $userId)->get();
        $cars = [];


        foreach ($eloquentCars as $eloquentCar) {
            $cars[] = new Car(
                $eloquentCar->id,
                $eloquentCar->user_id,
                $eloquentCar->brand_id,
                $eloquentCar->getBrandName(),
                $eloquentCar->model,
                $eloquentCar->year
            );
        }

        return $cars;
    }

public function getCarsIdByUserId(int $userId): array
{
    $eloquentCarsIds = EloquentCar::where('user_id', $userId)->select('id')->pluck('id')->toArray();

    return $eloquentCarsIds;
}
}

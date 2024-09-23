<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Car;
use App\Domain\Repositories\CarRepositoryInterface;
use App\Models\Car as EloquentCar;
use App\Presenters\Dtos\CarDto;
use Illuminate\Support\Facades\DB;

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
                $eloquentCar->year,
                $eloquentCar->plate,
                $eloquentCar->imagePath
            );
        }

        return $cars;
    }

public function getCarsIdByUserId(int $userId): array
{
    $eloquentCarsIds = EloquentCar::where('user_id', $userId)->select('id')->pluck('id')->toArray();

    return $eloquentCarsIds;
}

    public function getCarById(int $carId): ?Car
    {
        $eloquentCar = EloquentCar::find($carId);
        if (!$eloquentCar) {
            return null;
        }

        return new Car(
            $eloquentCar->id,
            $eloquentCar->user_id,
            $eloquentCar->brand_id,
            $eloquentCar->getBrandName(),
            $eloquentCar->model,
            $eloquentCar->year,
            $eloquentCar->plate,
            $eloquentCar->imagePath
        );
    }

    public function createCar(Car $car): EloquentCar
    {
        try {
            $carEntity = DB::transaction(function () use ($car) {

                $createCar = EloquentCar::create([
                    'user_id' => $car->userId,
                    'brand_id' => $car->brandId,
                    'model' => $car->model,
                    'year' => $car->year,
                    'plate' => $car->plate,
                    'image_path' => $car->imagePath // Assure-toi de stocker le chemin dans la base de données
                ]);

                return $createCar;
            });

            return $carEntity;
        } catch (\Exception $e) {
            // Log l'erreur
            \Log::error('Erreur lors de la création de la voiture: ' . $e->getMessage());
            throw new \Exception('Impossible de créer la voiture. Veuillez réessayer.');
        }
    }

}

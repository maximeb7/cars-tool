<?php

namespace App\Infrastructure\Repositories;

use App\Application\Queries\Vehicles\EditUserVehicleQuery;
use App\Domain\Entities\Car;
use App\Domain\Repositories\CarRepositoryInterface;
use App\Models\Car as EloquentCar;
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
                $eloquentCar->imagePath,
                $eloquentCar->kilometers
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
            $eloquentCar->imagePath,
            $eloquentCar->kilometers
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
                    'image_path' => $car->imagePath,
                    'kilometers' => $car->kilometers,
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

    public function deleteCarById(int $carId): bool
    {
        $car = EloquentCar::find($carId);
        if (!$car) {
            return false;
        }

        try {
            return DB::transaction(function () use ($car) {
                $car->delete();
                return true;
            });
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la suppression du véhicule: ' . $e->getMessage());
            return false;
        }
    }

    public function updateCarById(EditUserVehicleQuery $query): EloquentCar
    {
        $eloquentCar = EloquentCar::findOrFail($query->id);

        $eloquentCar->brand_id = $query->brandId;
        $eloquentCar->model = $query->model;
        $eloquentCar->year = $query->year;
        $eloquentCar->plate = $query->plate;
        if ($query->imagePath) {
            $eloquentCar->image_path = $query->imagePath;
        }
        $eloquentCar->kilometers = $query->kilometers;
        $eloquentCar->save();

        return $eloquentCar;
    }
}

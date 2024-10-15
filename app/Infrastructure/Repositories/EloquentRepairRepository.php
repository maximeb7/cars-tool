<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Repair;
use App\Domain\Repositories\RepairRepositoryInterface;
use App\Models\Repair as EloquentRepair;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class EloquentRepairRepository implements RepairRepositoryInterface
{
    public function getRepairsByCarId(int $carId): array
    {
        $eloquentRepairs = EloquentRepair::where('car_id', $carId)->get();
        $repairs = [];

        foreach ($eloquentRepairs as $eloquentRepair) {

            $repairs[] = new Repair(
                $eloquentRepair->id,
                $eloquentRepair->car_id,
                $eloquentRepair->repair_type_id,
                $eloquentRepair->getRepairTypeName(),
                $eloquentRepair->price,
                $eloquentRepair->date,
                $eloquentRepair->is_planned_repair
            );
        }

        return $repairs;
    }

    public function getRepairsFromCarsId(array $carIds): Collection
    {
        return EloquentRepair::whereIn('car_id', $carIds)->get();
    }

    /**
     * Unused method for the moment
     * @param int $repairId
     * @return bool
     */
    public function deleteRepairById(int $repairId): bool
    {
        //TODO implement code
    }

    public function getRepairEntityById(int $repairId): ?Repair
    {
        $eloquenRepair = EloquentRepair::find($repairId);

        if (!$eloquenRepair) {
            return null;
        }

        return new Repair(
            $eloquenRepair->id,
            $eloquenRepair->car_id,
            $eloquenRepair->repair_type_id,
            $eloquenRepair->getRepairTypeName(),
            $eloquenRepair->price,
            $eloquenRepair->date,
            $eloquenRepair->is_planned_repair
        );
    }

    public function getRepairEloquentModelById(int $repairId): ?\App\Models\Repair
    {
        return EloquentRepair::findOrfail($repairId);
    }

    public function deleteRepairModel(\App\Models\Repair $model): bool
    {
        try {
            return DB::transaction(function () use ($model) {
                $model->delete();
                return true;
            });

        } catch (\Exception $e) {
            \Log::error('Erreur lors de la suppression du véhicule: ' . $e->getMessage());
            return false;
        }
    }

    public function createRepair(Repair $repair): EloquentRepair
    {
        try {
            $repairEntity = DB::transaction(function () use ($repair) {

                $createRepair = EloquentRepair::create([
                    'car_id' => $repair->carId,
                    'repair_type_id' => $repair->repairTypeId,
                    'price' => $repair->price,
                    'date' => $repair->date,
                    'is_planned_repair' => $repair->isPlannedRepair
                ]);
                return $createRepair;
            });

            return $repairEntity;
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la création de la réparation: ' . $e->getMessage());
            throw new \Exception('Impossible de créer votre entretien. Veuillez réessayer.');
        }
    }
}

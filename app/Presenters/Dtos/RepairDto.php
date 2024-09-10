<?php

namespace App\Presenters\Dtos;

use App\Domain\Entities\Repair;
use Illuminate\Database\Eloquent\Collection;

class RepairDto
{
    public int $id;
    public int $repairTypeId;
    public ?string $repairTypeName;

    public float $cost;
    public string $date;

    public function __construct(int $id, int $repairTypeId, ?string $repairTypeName, float $price, string $date)
    {
        $this->id = $id;
        $this->repairTypeId = $repairTypeId;
        $this->repairTypeName = $repairTypeName;
        $this->price = $price;
        $this->date = $date;
    }

    public static function fromEntity(Repair $repair): self
    {
        return new self(
            $repair->id,
            $repair->repairTypeId,
            $repair->repairTypeName,
            $repair->price,
            $repair->date
        );
    }


    public static function fromModel(\App\Models\Repair $repairModel): Repair
    {
        return new Repair(
            (int)$repairModel->id,
            (int)$repairModel->car_id,
            (int)$repairModel->repair_type_id,
            $repairModel->getRepairTypeNAme() ? (string)$repairModel->getRepairTypeNAme() : null, // Exemple de conversion
            (float)$repairModel->price,
            (string)$repairModel->date,
            $repairModel->is_planned_repair
        );
    }

    public static function fromCollection(Collection|array $repairs): array
    {
        return array_map(function (\App\Models\Repair $repairModel) {
            $repairEntity = self::fromModel($repairModel);
            return self::fromEntity($repairEntity);
        }, $repairs instanceof Collection ? $repairs->all() : $repairs);
    }
}

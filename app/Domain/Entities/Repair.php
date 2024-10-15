<?php

namespace App\Domain\Entities;

class Repair
{
    public ?int $id;
    public int $carId;
    public int $repairTypeId;
    public ?string $repairTypeName;

    public float $price;
    public string $date;
    public bool $isPlannedRepair;

    public function __construct(
        ?int $id,
        int $carId,
        int $repairTypeId,
        ?string $repairTypeName,
        float $price,
        string $date,
        bool $isPlannedRepair
    )
    {
        $this->id = $id;
        $this->carId = $carId;
        $this->repairTypeId = $repairTypeId;
        $this->repairTypeName = $repairTypeName;
        $this->price = $price;
        $this->date = $date;
        $this->isPlannedRepair = $isPlannedRepair;
    }
}

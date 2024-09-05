<?php

namespace App\Presenters\Dtos;

use App\Domain\Entities\Repair;

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
}

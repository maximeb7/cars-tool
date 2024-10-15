<?php

namespace App\Presenters\Dtos;

use App\Domain\Entities\RepairType;

class RepairTypesDto
{
    public $id;
    public $name;

    public function __construct(
        int    $id,
        string $name
    )
    {
        $this->id = $id;
        $this->name = $name;
    }

    public static function fromEntity(RepairType $repairType): self
    {
        return new self(
            $repairType->id,
            $repairType->name
        );
    }
}

<?php

namespace App\Presenters\Dtos;

use App\Domain\Entities\Car;

class CarDto
{
    public int $id;
    public int $brandId;
    public ?string $brandName;
    public string $model;
    public int $year;
    public array $repairs;

    public function __construct(int $id, int $brandId, string $brandName, string $model, int $year, array $repairs)
    {
        $this->id = $id;
        $this->brandId = $brandId;
        $this->brandName = $brandName;
        $this->model = $model;
        $this->year = $year;
        $this->repairs = $repairs;
    }

    public static function fromEntity(Car $car): self
    {
        $repairs = array_map(fn($repair) => RepairDTO::fromEntity($repair), $car->repairs);

        return new self(
            $car->id,
            $car->brandId,
            $car->brandName,
            $car->model,
            $car->year,
            $repairs
        );
    }
}

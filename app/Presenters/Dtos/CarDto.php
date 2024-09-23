<?php

namespace App\Presenters\Dtos;

use App\Domain\Entities\Car;
use App\Domain\Entities\Repair;
use Illuminate\Database\Eloquent\Collection;

class CarDto
{
    public int $id;
    public int $brandId;
    public int $userId;
    public ?string $brandName;
    public string $model;
    public int $year;

    public ?string $plate;
    public ?string $imagePath;
    public ?string $kilometers;
    public array $repairs;

    public function __construct(
        int $id,
        int $brandId,
        int $userId,
        string $brandName,
        string $model,
        int $year,
        ?string $plate,
        ?string $imagePath,
        ?string $kilometers,
        array $repairs)
    {
        $this->id = $id;
        $this->brandId = $brandId;
        $this->userId = $userId;
        $this->brandName = $brandName;
        $this->model = $model;
        $this->year = $year;
        $this->plate = $plate;
        $this->imagePath = $imagePath;
        $this->kilometers = $kilometers;
        $this->repairs = $repairs;

    }

    public static function fromEntity(Car $car): self
    {
        $repairs = array_map(fn($repair) => RepairDTO::fromEntity($repair), $car->repairs);

        return new self(
            $car->id,
            $car->brandId,
            $car->userId,
            $car->brandName,
            $car->model,
            $car->year,
            $car->plate,
            $car->imagePath,
            $car->kilometers,
            $repairs
        );
    }

    public static function fromModel(\App\Models\Car $car): Car
    {
        return new Car(
            (int)$car->id,
            (int)$car->brand_id,
            (int)$car->user_id,
            $car->getBrandName(),
            (string)$car->model,
            (string)$car->year,
            (string)$car->plate,
            (string)$car->image_path,
            (string)$car->kilometers
        );
    }
}

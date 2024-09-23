<?php

namespace App\Application\Queries\Vehicles;

use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;

class CreateUserVehicleQuery
{
    public int $brandId;

    public int $userId;
    public string $model;
    public string $year;
    public string $plate;
    public ?UploadedFile $imagePath;

    public function __construct(int $brandId, int $userId, string $model, string $year, string $plate, ?UploadedFile $imagePath)
    {
        $this->brandId = $brandId;
        $this->userId = $userId;
        $this->model = $model;
        $this->year = $year;
        $this->plate = $plate;
        $this->imagePath = !$imagePath ? null : $imagePath;
    }
}

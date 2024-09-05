<?php

namespace App\Domain\Entities;

class Car
{
    public int $id;
    public int $userId;
    public int $brandId;
    public ?string $brandName;
    public string $model;
    public int $year;
    public array $repairs = [];

    public function __construct(int $id, int $userId, int $brandId, ?string $brandName, string $model, int $year)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->brandId = $brandId;
        $this->brandName = $brandName;
        $this->model = $model;
        $this->year = $year;
    }

    public function addRepair(Repair $repair)
    {
        $this->repairs[] = $repair;
    }
}

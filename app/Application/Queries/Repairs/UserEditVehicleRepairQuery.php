<?php

namespace App\Application\Queries\Repairs;

use Carbon\Carbon;
use Illuminate\Support\Facades\Date;

class UserEditVehicleRepairQuery
{
    public int $id;
    public int $carId;
    public float $price;
    public Carbon $date;
    public int $repairTypeId;
    public bool $isPlannedRepair;

    public function __construct(
        int $id,
        int $carId,
        float $price,
        Carbon $date,
        int $repairTypeId,
        bool $isPlannedRepair,
    )
    {
        $this->id = $id;
        $this->carId = $carId;
        $this->price = $price;
        $this->date = $date;
        $this->repairTypeId = $repairTypeId;
        $this->isPlannedRepair = $isPlannedRepair;
    }
}

<?php

namespace App\Application\Queries\Repairs;

use Carbon\Carbon;
use Illuminate\Support\Facades\Date;

class UserCreateRepairQuery
{
    public int $carId;
    public int $repairTypeId;
    public float $price;
    public Carbon $date;
    public bool $isPlannedRepair = false;

    public function __construct(
        int   $carId,
        int   $repairTypeId,
        float $price,
        Carbon  $date,
        bool  $isPlannedRepair
    )
    {
        $this->carId = $carId;
        $this->repairTypeId = $repairTypeId;
        $this->price = $price;
        $this->date = $date;
        $this->isPlannedRepair = $isPlannedRepair;
    }
}

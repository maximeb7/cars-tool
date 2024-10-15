<?php

namespace App\Application\Queries\Repairs;


class UserDeleteVehicleRepairQuery
{
    public int $repairId;

    public function __construct(int $repairId)
    {
        $this->repairId = $repairId;
    }
}

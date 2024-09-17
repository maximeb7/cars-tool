<?php

namespace App\Application\Queries\Vehicles;

class GetVehicleRepairDetailsQuery
{
    public string $vehicleId;

    public function __construct(int $vehicleId, int $userId)
    {
        $this->vehicleId = $vehicleId;
        $this->userId = $userId;
    }
}

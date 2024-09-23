<?php

namespace App\Application\Queries\Vehicles;

class DeleteUserVehicleQuery
{
    public int $vehicleId;
    public function __construct(int $vehicleId)
    {
        $this->vehicleId = $vehicleId;
    }
}

<?php

namespace App\Application\Queries\Vehicles;

class GetUserVehiclesQuery
{
    public string $userUuid;

    public function __construct(string $userUuid)
    {
        $this->userUuid = $userUuid;
    }
}

<?php

namespace App\Application\Queries;

class GetUserWithCarsAndRepairsQuery
{
    public string $userUuid;

    public function __construct(string $userUuid)
    {
        $this->userUuid = $userUuid;
    }
}

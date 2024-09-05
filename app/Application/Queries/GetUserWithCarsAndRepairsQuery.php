<?php

namespace App\Application\Queries;

class GetUserWithCarsAndRepairsQuery
{
    public int $userId;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }
}

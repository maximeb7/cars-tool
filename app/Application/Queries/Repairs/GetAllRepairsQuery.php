<?php

namespace App\Application\Queries\Repairs;

class GetAllRepairsQuery
{
    public int $userId;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }
}

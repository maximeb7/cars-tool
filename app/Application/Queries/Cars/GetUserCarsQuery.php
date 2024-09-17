<?php

namespace App\Application\Queries\Cars;

class GetUserCarsQuery
{
    public string $userUuid;

    public function __construct(string $userUuid)
    {
        $this->userUuid = $userUuid;
    }
}

<?php

namespace App\Application\Queries\Repairs;

class GetAllRepairsQuery
{
    public string $uuid;

    public function __construct(string $uuid)
    {
        $this->uuid = $uuid;
    }
}

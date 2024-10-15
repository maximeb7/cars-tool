<?php

namespace App\Domain\Entities;

use Illuminate\Database\Eloquent\Model;

class RepairType
{
    public ?int $id;
    public string $name;

    public function __construct(
        ?int $id,
        string $name
    )
    {
        $this->id = $id;
        $this->name = $name;
    }
}

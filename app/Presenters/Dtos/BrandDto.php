<?php

namespace App\Presenters\Dtos;

use App\Domain\Entities\Brand;
use Illuminate\Database\Eloquent\Collection;

class BrandDto
{
    public $id;
    public $name;

    public function __construct(
        int $id,
        string $name
    )
    {
        $this->id = $id;
        $this->name = $name;
    }

    public static function fromEntity(Brand $brand): self
    {
        return new self(
            $brand->id,
            $brand->name
        );
    }
}

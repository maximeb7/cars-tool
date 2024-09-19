<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Brand;
use App\Domain\Repositories\BrandRepositoryInterface;
use App\Models\Brand as EloquentBrand;

class EloquentBrandRepository implements BrandRepositoryInterface
{

    public function getAll(): array
    {
        $eloquentBrands = EloquentBrand::all();
        $brands = [];

        foreach ($eloquentBrands as $brand) {
            $brands[] = new Brand(
                $brand->id,
                $brand->name,
            );
        }

        return $brands;
    }
}

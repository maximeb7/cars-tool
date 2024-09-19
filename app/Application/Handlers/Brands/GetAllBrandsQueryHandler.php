<?php

namespace App\Application\Handlers\Brands;

use App\Application\Queries\Brands\GetAllBrandsQuery;
use App\Domain\Repositories\BrandRepositoryInterface;
use App\Domain\Repositories\CarRepositoryInterface;
use App\Domain\Repositories\RepairRepositoryInterface;
use App\Domain\Repositories\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class GetAllBrandsQueryHandler
{
    private BrandRepositoryInterface $brandRepository;


    public function __construct(
        BrandRepositoryInterface $brandRepository
    ) {
        $this->brandRepository = $brandRepository;
    }

    public function handle(): ?array
    {
        return $this->brandRepository->getAll();
    }
}

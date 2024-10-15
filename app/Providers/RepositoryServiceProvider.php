<?php

namespace App\Providers;

use App\Domain\Repositories\BrandRepositoryInterface;
use App\Domain\Repositories\RepairTypesRepositoryInterface;
use App\Infrastructure\Repositories\EloquentBrandRepository;
use Illuminate\Support\ServiceProvider;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Infrastructure\Repositories\EloquentUserRepository;
use App\Domain\Repositories\CarRepositoryInterface;
use App\Infrastructure\Repositories\EloquentCarRepository;
use App\Domain\Repositories\RepairRepositoryInterface;
use App\Infrastructure\Repositories\EloquentRepairRepository;
use App\Infrastructure\Repositories\EloquentRepairTypeRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
        $this->app->bind(CarRepositoryInterface::class, EloquentCarRepository::class);
        $this->app->bind(RepairRepositoryInterface::class, EloquentRepairRepository::class);
        $this->app->bind(BrandRepositoryInterface::class, EloquentBrandRepository::class);
        $this->app->bind(RepairTypesRepositoryInterface::class, EloquentRepairTypeRepository::class);
    }
}

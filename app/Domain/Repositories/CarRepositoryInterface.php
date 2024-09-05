<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Car;

interface CarRepositoryInterface
{
    public function getCarsByUserId(int $userId): array;
}

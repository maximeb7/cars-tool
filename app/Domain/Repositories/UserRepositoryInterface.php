<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\User;

interface UserRepositoryInterface
{
public function getUserById(int $id): ?User;

public function getUserByUuid(string $uuid): ?User;
}

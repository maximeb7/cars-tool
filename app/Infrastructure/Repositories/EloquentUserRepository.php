<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Models\User as EloquentUser;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function getUserById(int $id): ?User
    {
        $eloquentUser = EloquentUser::find($id);

        if (!$eloquentUser) {
            return null;
        }

        return new User(
            $eloquentUser->id,
            $eloquentUser->uuid,
            $eloquentUser->name,
            $eloquentUser->email
        );
    }

    public function getUserByUuid(string $uuid): ?User
    {
        $eloquentUser= EloquentUser::where('uuid', $uuid)->first();

        return new User(
            $eloquentUser->id,
            $eloquentUser->uuid,
            $eloquentUser->name,
            $eloquentUser->email
        );
    }
}

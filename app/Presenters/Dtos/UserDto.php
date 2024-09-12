<?php

namespace App\Presenters\Dtos;

use App\Domain\Entities\User;

class UserDto
{
    public int $id;
    public string $uuid;
    public string $name;
    public string $email;
    public array $cars;

    public function __construct(int $id, string $uuid, string $name, string $email, array $cars)
    {
        $this->id = $id;
        $this->uuid = $uuid;
        $this->name = $name;
        $this->email = $email;
        $this->cars = $cars;
    }

    public static function fromEntity(User $user): self
    {
        $cars = array_map(fn($car) => CarDTO::fromEntity($car), $user->cars);

        return new self(
            $user->id,
            $user->uuid,
            $user->name,
            $user->email,
            $cars
        );
    }
}

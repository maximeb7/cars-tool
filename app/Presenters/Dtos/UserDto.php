<?php

namespace App\Presenters\Dtos;

use App\Domain\Entities\User;

class UserDto
{
    public int $id;
    public string $name;
    public string $email;
    public array $cars;

    public function __construct(int $id, string $name, string $email, array $cars)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->cars = $cars;
    }

    public static function fromEntity(User $user): self
    {
        $cars = array_map(fn($car) => CarDTO::fromEntity($car), $user->cars);

        return new self(
            $user->id,
            $user->name,
            $user->email,
            $cars
        );
    }
}

<?php

namespace App\Domain\Entities;

class User
{
    public int $id;
    public string $name;
    public string $email;
    public array $cars = [];

    public function __construct(int $id, string $name, string $email)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
    }

    public function addCar(Car $car)
    {
        $this->cars[] = $car;
    }
}

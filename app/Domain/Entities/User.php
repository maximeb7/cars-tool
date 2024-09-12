<?php

namespace App\Domain\Entities;

class User
{
    public int $id;
    public string $uuid;
    public string $name;
    public string $email;
    public array $cars = [];

    public function __construct(int $id, string $uuid, string $name, string $email)
    {
        $this->id = $id;
        $this->uuid = $uuid;
        $this->name = $name;
        $this->email = $email;
    }

    public function addCar(Car $car)
    {
        $this->cars[] = $car;
    }
}

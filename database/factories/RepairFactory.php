<?php

namespace Database\Factories;

use App\Models\Repair;
use App\Models\Car;
use App\Models\RepairType;
use Illuminate\Database\Eloquent\Factories\Factory;

class RepairFactory extends Factory
{
    protected $model = Repair::class;

    public function definition()
    {
        return [
            'car_id' => Car::factory(), // Crée une instance de Car associée
            'repair_type_id' => RepairType::factory(), // Crée une instance de RepairType associée
            'price' => $this->faker->numberBetween(10, 500), // Coût aléatoire entre 10 et 500
            'date' => $this->faker->date, // Date de la réparation
            'is_planned_repair' => $this->faker->boolean()
        ];
    }
}

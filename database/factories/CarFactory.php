<?php

namespace Database\Factories;

use App\Models\Car;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarFactory extends Factory
{
    protected $model = Car::class;

    public function definition()
    {
        return [
            'brand_id' => $this->faker->numberBetween([1],[10]),
            'model' => $this->faker->word,
            'year' => $this->faker->year,
            'user_id' => \App\Models\User::factory(), // Pour créer un utilisateur associé
        ];
    }
}

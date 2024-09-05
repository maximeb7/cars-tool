<?php

namespace Database\Factories;

use App\Models\RepairType;
use Illuminate\Database\Eloquent\Factories\Factory;

class RepairTypeFactory extends Factory
{
    protected $model = RepairType::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
        ];
    }
}

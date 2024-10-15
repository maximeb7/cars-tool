<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('brands')->insert([
            [
                'name' => 'Peugeot',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Renault',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Citröen',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Volkswagen',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Toyota',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mercedes',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Audi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Opel',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bmw',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Fiat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Nissan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ds',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ford',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bugatti',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Chrysler',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dacia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Alfa Romeo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Chevrolet',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cupra',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hyundai',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Honda',
                'created_at' => now(),
                'updated_at' => now(),
            ],[
                'name' => 'Infiniti',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jaguar',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jeep',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Land Rover',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Lexus',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Maserati',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mazda',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'MG',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mini',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mitsubishi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Porsche',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Seat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sköda',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Smart',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ssangyong',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tesla',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Volvo',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}

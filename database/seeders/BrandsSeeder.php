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
        ]);
    }
}

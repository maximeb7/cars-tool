<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RepairTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('repair_types')->insert([
           [
               'name' => 'Pneus',
               'created_at' => now(),
               'updated_at' => now(),
           ],
            [
                'name' => 'Révision',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Vidange',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Freinage',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Courroie de distribution',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Direction/Suspension',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Batterie/Démarrage',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Climatisation',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Motorisation',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Eclairage',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pare-brise/Vitrage',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Diagnostic',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Carrosserie',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Autres',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}

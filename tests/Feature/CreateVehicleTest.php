<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Brand;

// Si tu utilises des marques dans ta base
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CreateVehicleTest extends TestCase
{
    use RefreshDatabase;

    // Réinitialise la base de données entre chaque test

    public function test_user_can_create_vehicle_with_image()
    {
// Simuler le stockage local pour les fichiers
        Storage::fake('public');

// Créer un utilisateur pour le test
        $user = User::factory()->create();

// Créer une marque de véhicule (si nécessaire)
        $brand = Brand::factory()->create();

// Simuler un fichier image
        $file = UploadedFile::fake()->image('vehicle.jpg');

// Les données du véhicule
        $vehicleData = [
            'brand_id' => $brand->id,
            'model' => 'Captur',
            'year' => '2015',
            'plate' => 'BG-255-LM',
            'image_path' => $file, // Simuler le fichier uploadé
        ];

// Agir en tant qu'utilisateur authentifié
        $response = $this->actingAs($user)->postJson(route('vehicles.store'), $vehicleData);

// Vérifier que la réponse est correcte (succès)
        $response->assertStatus(201);

// Vérifier que le fichier a été correctement stocké
        Storage::disk('public')->assertExists('images/' . $file->hashName());

// Vérifier que le véhicule est bien créé dans la base de données
        $this->assertDatabaseHas('vehicles', [
            'user_id' => $user->id,
            'brand_id' => $brand->id,
            'model' => 'Captur',
            'year' => '2015',
            'plate' => 'BG-255-LM',
            'image_path' => 'images/' . $file->hashName(),
        ]);
    }
}

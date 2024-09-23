<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Car;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use App\Application\Queries\Vehicles\DeleteUserVehicleQuery;
use App\Application\Handlers\DeleteUserVehicleQueryHandler;

class DeleteUserVehicleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Crée un utilisateur pour les tests
        $this->user = User::factory()->create();
        // Crée un véhicule associé à cet utilisateur
        $this->car = Car::factory()->create(['user_id' => $this->user->id]);
    }

    /** @test */
    public function it_deletes_a_vehicle()
    {
        // Authentifie l'utilisateur
        Auth::login($this->user);

        $query = new DeleteUserVehicleQuery($this->car->id);
        $handler = new DeleteUserVehicleQueryHandler(/* Injection des dépendances si nécessaire */);

        $handler->handle($query);

        // Vérifie que le véhicule n'existe plus dans la base de données
        $this->assertDatabaseMissing('cars', ['id' => $this->car->id]);
    }

    /** @test */
    public function it_throws_exception_if_vehicle_not_found()
    {
        // Authentifie l'utilisateur
        Auth::login($this->user);

        $query = new DeleteUserVehicleQuery(999); // ID inexistant
        $handler = new DeleteUserVehicleQueryHandler(/* Injection des dépendances si nécessaire */);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Vehicle not found');

        $handler->handle($query);
    }

    /** @test */
    public function it_throws_exception_if_user_not_authorized()
    {
        // Crée un autre utilisateur
        $anotherUser = User::factory()->create();

        // Authentifie l'autre utilisateur
        Auth::login($anotherUser);

        $query = new DeleteUserVehicleQuery($this->car->id); // ID du véhicule créé pour l'utilisateur initial
        $handler = new DeleteUserVehicleQueryHandler(/* Injection des dépendances si nécessaire */);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('You do not have the right to delete this vehicle');

        $handler->handle($query);
    }
}

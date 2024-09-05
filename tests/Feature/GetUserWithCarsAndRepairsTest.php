<?php

namespace Tests\Feature;

use App\Models\Brand;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Car;
use App\Models\Repair;

class GetUserWithCarsAndRepairsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Brand::factory()->create([
            'id' => 1,
            'name' => 'Test Brand',
        ]);
    }

    /** @test */
    public function it_returns_user_with_cars_and_repairs_information()
    {

        $user = User::factory()->create();

        $car = Car::factory()->create(['user_id' => $user->id]);
        $repair = Repair::factory()->create(['car_id' => $car->id]);

        $response = $this->actingAs($user)->get("/api/user-informations/{$user->id}");

        $response->assertStatus(200);

        $response->assertJson([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'cars' => [
                    [
                        'id' => $car->id,
                        'brandId' => $car->brand_id,
                        'brandName' => $car->getBrandName(),
                        'model' => $car->model,
                        'year' => $car->year,
                        'repairs' => [
                            [
                                'id' => $repair->id,
                                'repairTypeId' => $repair->repair_type_id,
                                'repairTypeName' => $repair->getRepairTypeName(),
                                'date' => $repair->date->toIso8601String(),
                                'price' => intval($repair->price),
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

    /** @test */
    public function it_returns_empty_response_when_user_has_no_cars()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get("/api/user-informations/{$user->id}");

        $response->assertStatus(200);

        $response->assertJson([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'cars' => [],
            ],
        ]);
    }

    /** @test */
    public function it_returns_404_when_user_does_not_exist()
    {

        $response = $this->getJson("/api/user-informations/999");

        $response->assertStatus(401);
    }
}

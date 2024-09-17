<?php

namespace App\Http\Controllers\Vehicles;

use App\Application\Handlers\Vehicles\GetVehicleRepairDetailsQueryHandler;
use App\Application\Queries\Vehicles\GetVehicleRepairDetailsQuery;
use App\Http\Controllers\Controller;
use App\Presenters\Dtos\CarDto;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class GetVehicleRepairDetails extends Controller
{
    public function __construct(
        private readonly GetVehicleRepairDetailsQueryHandler $handler,
    )
    {
    }

    public function __invoke(int $id): JsonResponse | Response
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized.'], Response::HTTP_UNAUTHORIZED);
        }

        $query = new GetVehicleRepairDetailsQuery($id, $user->id);

        $vehicleDetails = $this->handler->handle($query);

        $vehicleDto = CarDto::fromEntity($vehicleDetails);

        return response()->json($vehicleDto);
    }
}

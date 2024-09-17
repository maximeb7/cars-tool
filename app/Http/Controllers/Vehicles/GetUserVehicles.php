<?php

namespace App\Http\Controllers\Vehicles;

use App\Application\Handlers\Vehicles\GetUserVehiclesQueryHandler;
use App\Application\Queries\Vehicles\GetUserVehiclesQuery;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GetUserVehicles extends Controller
{
    public function __construct(
        private readonly GetUserVehiclesQueryHandler $handler
    )
    {
    }

    public function __invoke(string $uuid): JsonResponse | Response
    {
        $query = new GetUserVehiclesQuery($uuid);
        $vehicles = $this->handler->handle($query);

        return response()->json($vehicles);
    }
}

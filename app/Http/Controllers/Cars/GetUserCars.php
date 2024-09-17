<?php

namespace App\Http\Controllers\Cars;

use App\Application\Handlers\Cars\GetUserCarsQueryHandler;
use App\Application\Queries\Cars\GetUserCarsQuery;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GetUserCars extends Controller
{
    public function __construct(
        private readonly GetUserCarsQueryHandler $handler
    )
    {
    }

    public function __invoke(string $uuid): JsonResponse | Response
    {
        $query = new GetUserCarsQuery($uuid);
        $vehicles = $this->handler->handle($query);

        return response()->json($vehicles);
    }
}

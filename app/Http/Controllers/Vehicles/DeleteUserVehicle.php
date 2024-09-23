<?php

namespace App\Http\Controllers\Vehicles;

use App\Application\Handlers\Vehicles\DeleteUserVehicleQueryHandler;
use App\Application\Queries\Vehicles\DeleteUserVehicleQuery;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class DeleteUserVehicle extends Controller
{
    public function __construct(
        private DeleteUserVehicleQueryHandler $handler
    )
    {
    }

    public function __invoke(int $id): JsonResponse|Response
    {
        $query = new DeleteUserVehicleQuery($id);
        $deleteVehicle = $this->handler->handle($query);
        return new JsonResponse($deleteVehicle, Response::HTTP_NO_CONTENT);
    }
}

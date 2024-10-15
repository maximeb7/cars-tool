<?php

namespace App\Http\Controllers\Repairs;

use App\Application\Handlers\Repairs\UserDeleteVehicleRepairQueryHandler;
use App\Application\Queries\Repairs\UserDeleteVehicleRepairQuery;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserDeleteVehicleRepair extends Controller
{
    public function __construct(
        private UserDeleteVehicleRepairQueryHandler $handler
    )
    {
    }

    public function __invoke(int $id): JsonResponse|Response
    {
        $query = new UserDeleteVehicleRepairQuery($id);
        $deleteRepair = $this->handler->handle($query);
        return new JsonResponse($deleteRepair, Response::HTTP_NO_CONTENT);
    }
}

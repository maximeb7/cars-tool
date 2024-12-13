<?php

namespace App\Http\Controllers\Repairs;

use App\Application\Handlers\Repairs\UserEditVehicleRepairHandler;
use App\Application\Queries\Repairs\UserEditVehicleRepairQuery;
use App\Http\Controllers\Controller;
use App\Http\Requests\Repairs\UserEditRepairPutRequest;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserEditVehicleRepair extends Controller
{
    public function __construct(
        private UserEditVehicleRepairHandler $handler
    )
    {
    }

    public function __invoke(int $id, UserEditRepairPutRequest $request ): JsonResponse|Response
    {
       $query = new UserEditVehicleRepairQuery(
           $id,
           $request->car_id,
           $request->price,
           Carbon::parse($request->date),
           $request->repair_type_id,
           $request->is_planned_repair
       );

       $updatedRepair = $this->handler->handle($query);

       return $updatedRepair;
    }
}

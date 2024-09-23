<?php

namespace App\Http\Controllers\Vehicles;

use App\Application\Handlers\Vehicles\CreateUserVehicleQueryHandler;
use App\Application\Queries\Vehicles\CreateUserVehicleQuery;
use App\Http\Controllers\Controller;
use App\Http\Requests\Vehicles\CreateUserVehicleFormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateUserVehicle extends Controller
{
    public function __construct(
        private CreateUserVehicleQueryHandler $handler
    )
    {
    }

    public function __invoke(CreateUserVehicleFormRequest $request): JsonResponse | Response
    {
        $user = $request->user();
        $file = $request->file('image_path') ? $request->file('image_path') : null;
        $query = new CreateUserVehicleQuery(
            $request->brand_id,
            $user->id,
            $request->model,
            $request->year,
            $request->plate,
            $file
        );

        $createVehicle = $this->handler->handle($query);

        return $createVehicle;
    }
}

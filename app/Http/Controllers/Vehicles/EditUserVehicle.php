<?php

namespace App\Http\Controllers\Vehicles;

use App\Application\Handlers\Vehicles\EditUserVehicleQueryHandler;
use App\Application\Queries\Vehicles\EditUserVehicleQuery;
use App\Http\Controllers\Controller;
use App\Http\Requests\Vehicles\EditUserVehicleFormRequest;
use App\Infrastructure\Repositories\EloquentCarRepository;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class EditUserVehicle extends Controller
{
    public function __construct(
        private EditUserVehicleQueryHandler $handler,
        private EloquentCarRepository       $carRepository,
    )
    {
    }

    public function __invoke(int $id, EditUserVehicleFormRequest $request): JsonResponse|Response
    {
        $user = $request->user();
        $file = null;

        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
            $file = $image->store('vehicles', 'public');
        }
        if (null === $request->file('image_path')) {
            $file = null;
        }

        $vehicle = $this->carRepository->getCarById($id);


        if ($vehicle->userId !== $user->id) {
            throw new \Exception('You do not have the right to delete this vehicle', 403);
        }
        $query = new EditUserVehicleQuery(
            $id,
            $request->brand_id,
            $user->id,
            $request->model,
            $request->year,
            $request->plate,
            $file,
            $request->kilometers
        );

        $updateVehicle = $this->handler->handle($query);

        return $updateVehicle;
    }
}

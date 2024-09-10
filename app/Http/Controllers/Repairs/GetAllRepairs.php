<?php


namespace App\Http\Controllers\Repairs;

use App\Application\Handlers\Repairs\GetAllRepairsHandler;
use App\Application\Queries\Repairs\GetAllRepairsQuery;
use App\Http\Controllers\Controller;
use App\Presenters\Dtos\RepairDto;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GetAllRepairs extends Controller
{
    public function __construct(
        private readonly GetAllRepairsHandler $handler,
    )
    {
    }

    public function __invoke(int $id): JsonResponse|Response
    {
        $query = new GetAllRepairsQuery($id);
        $repairs = $this->handler->handle($query);

        if (!$repairs) {
            return response()->json(['message' => 'No Repairs'], 404);
        }

        $repairsDto = RepairDto::fromCollection($repairs);

        return response()->json($repairsDto);
    }
}

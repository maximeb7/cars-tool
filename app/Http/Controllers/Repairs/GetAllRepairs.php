<?php


namespace App\Http\Controllers\Repairs;

use App\Application\Handlers\Repairs\GetAllRepairsHandler;
use App\Application\Queries\Repairs\GetAllRepairsQuery;
use App\Http\Controllers\Controller;
use App\Presenters\Dtos\RepairDto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GetAllRepairs extends Controller
{
    public function __construct(
        private readonly GetAllRepairsHandler $handler,
    )
    {
    }

    public function __invoke(Request $request, string $uuid): JsonResponse|Response
    {
        $query = new GetAllRepairsQuery($uuid);
        $repairs = $this->handler->handle($query);

        if (!$repairs) {
            return response()->json(['message' => 'No Repairs'], 404);
        }

        $repairsDto = RepairDto::fromCollection($repairs);

        $allByMonthForStats = $request->query('allByMonthForStats') === 'true';
        $allTypesForStats = $request->query('allTypesForStats') === 'true';

        if ($allByMonthForStats && $allTypesForStats) {
            $result = [
                'allByMonthForStats' => RepairDto::formatAllMonthsForStats($repairsDto),
                'allTypesForStats' => RepairDto::formatAllTypesForStats($repairsDto),
            ];
        } elseif ($allByMonthForStats) {
            $result = RepairDto::formatAllMonthsForStats($repairsDto);
        } elseif ($allTypesForStats) {
            $result = RepairDto::formatAllTypesForStats($repairsDto);
        } else {
            $result = $repairsDto;
        }

        return response()->json($result);
    }
}

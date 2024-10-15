<?php

namespace App\Http\Controllers\RepairTypes;

use App\Application\Handlers\RepairTypes\GetRepairTypesHandler;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GetRepairTypes extends Controller
{
    public function __construct(
        private readonly GetRepairTypesHandler $handler
    )
    {
    }

    public function __invoke(Request $request):JsonResponse|Response
    {
        $repairTypes = $this->handler->handle();

        return response()->json($repairTypes);
    }
}

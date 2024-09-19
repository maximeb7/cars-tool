<?php

namespace App\Http\Controllers\Brands;

use App\Application\Handlers\Brands\GetAllBrandsQueryHandler;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GetAllBrands extends Controller
{
    public function __construct(
        private readonly GetAllBrandsQueryHandler $handler,
    )
    {

    }

    public function __invoke(Request $request): JsonResponse|Response
    {
        $brands = $this->handler->handle();


        return response()->json($brands);
    }
}

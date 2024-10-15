<?php

namespace App\Http\Controllers\Repairs;

use App\Application\Handlers\Repairs\UserCreateRepairQueryHandler;
use App\Application\Queries\Repairs\UserCreateRepairQuery;
use App\Http\Controllers\Controller;
use App\Http\Requests\Repairs\UserCreateRepairPostRequest;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserCreateRepair extends Controller
{
    public function __construct(
        private UserCreateRepairQueryHandler $handler
    )
    {
    }

    public function __invoke(UserCreateRepairPostRequest $request): JsonResponse|Response
    {

        $data = $request->validated();
        $date = Carbon::parse($data['date']);
        $query = new UserCreateRepairQuery(
            $data['car_id'],
            $data['repair_type_id'],
            $data['price'],
            $date,
            $data['is_planned_repair']
        );

        return $this->handler->handle($query);
    }
}

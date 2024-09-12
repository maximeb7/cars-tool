<?php

namespace App\Http\Controllers\User;



use App\Application\Handlers\GetUserWithCarsAndRepairsHandler;
use App\Application\Queries\GetUserWithCarsAndRepairsQuery;
use App\Http\Controllers\Controller;
use App\Presenters\Dtos\UserDto;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GetUserWithCarsAndRepairs extends Controller
{

    public function __construct(
        private readonly GetUserWithCarsAndRepairsHandler  $handler,
        )
    {

    }

    public function __invoke(string $uuid): JsonResponse | Response
    {
        $query = new GetUserWithCarsAndRepairsQuery($uuid);
        $user = $this->handler->handle($query);


        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $userDTO = UserDto::fromEntity($user);

        return response()->json($userDTO);
    }
}

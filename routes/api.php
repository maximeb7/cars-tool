<?php

use App\Http\Controllers\Repairs\GetAllRepairs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\GetUserWithCarsAndRepairs;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    } );

    // USER ENDPOINTS
    Route::get('/user-informations/{uuid}', GetUserWithCarsAndRepairs::class);

    //REPAIRS ENDPOINT

    Route::get('/user-repairs/{uuid}', GetAllRepairs::class);
});

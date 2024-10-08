<?php

use App\Http\Controllers\Brands\GetAllBrands;
use App\Http\Controllers\Repairs\GetAllRepairs;
use App\Http\Controllers\Vehicles\CreateUserVehicle;
use App\Http\Controllers\Vehicles\DeleteUserVehicle;
use App\Http\Controllers\Vehicles\GetUserVehicles;
use App\Http\Controllers\Vehicles\GetVehicleRepairDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\GetUserWithCarsAndRepairs;
use App\Http\Controllers\Vehicles\EditUserVehicle;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    } );

    // USER ENDPOINTS
    Route::get('/user-informations/{uuid}', GetUserWithCarsAndRepairs::class);

    //REPAIRS ENDPOINTS

    Route::get('/user-repairs/{uuid}', GetAllRepairs::class);

    //VEHICLES ENDPOINTS

    Route::post('/vehicles', CreateUserVehicle::class);
    Route::put('/vehicles/{id}', EditUserVehicle::class);
    Route::get('/user/{uuid}/vehicles', GetUserVehicles::class);
    Route::get('/vehicle-details/{id}', GetVehicleRepairDetails::class);
    Route::delete('/vehicles/{id}', DeleteUserVehicle::class);


    //BRANDS
    Route::get('/brands', GetAllBrands::class);
});

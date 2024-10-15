<?php

use App\Http\Controllers\Brands\GetAllBrands;
use App\Http\Controllers\Repairs\GetAllRepairs;
use App\Http\Controllers\Repairs\UserCreateRepair;
use App\Http\Controllers\RepairTypes\GetRepairTypes;
use App\Http\Controllers\Vehicles\CreateUserVehicle;
use App\Http\Controllers\Vehicles\DeleteUserVehicle;
use App\Http\Controllers\Vehicles\GetUserVehicles;
use App\Http\Controllers\Vehicles\GetVehicleRepairDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\GetUserWithCarsAndRepairs;
use App\Http\Controllers\Vehicles\EditUserVehicle;
use App\Http\Controllers\Repairs\UserDeleteVehicleRepair;

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
    Route::post('/user-repairs', UserCreateRepair::class);
    Route::get('/user-repairs/{uuid}', GetAllRepairs::class);
    Route::delete('/user-repairs/{id}', UserDeleteVehicleRepair::class);

    //VEHICLES ENDPOINTS

    Route::post('/vehicles', CreateUserVehicle::class);
    Route::put('/vehicles/{id}', EditUserVehicle::class);
    Route::get('/user/{uuid}/vehicles', GetUserVehicles::class);
    Route::get('/vehicle-details/{id}', GetVehicleRepairDetails::class);
    Route::delete('/vehicles/{id}', DeleteUserVehicle::class);


    //BRANDS
    Route::get('/brands', GetAllBrands::class);

    //REPAIR TYPES
    Route::get('/repair-types', GetRepairTypes::class);
});

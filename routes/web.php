<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/repairs', function () {
    return Inertia::render('Repairs');
})->middleware(['auth', 'verified'])->name('repairs');

Route::get('/vehicles', function () {
    return Inertia::render('Vehicles');
})->middleware(['auth', 'verified'])->name('vehicles');

Route::get('/vehicle-details', function () {
    return Inertia::render('VehicleDetails');
})->middleware(['auth', 'verified'])->name('vehicle-details');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

<?php

use Core\Facade\Route;
use App\Controllers\ReservationController;
use App\Controllers\Auth\AuthController;

// ----------------- Routes ----------------------------------------
Route::get('/', ReservationController::class, 'index', true);
Route::get('reservations', ReservationController::class, 'index', true);
Route::get('reservations/:hourId/:date/reserve',
    ReservationController::class, 'reserve', true);

// ----------------- Auth ----------------------------------------
Route::get('login', AuthController::class, 'login');
Route::post('login', AuthController::class, 'login');
Route::get('logout', AuthController::class, 'logout', true);
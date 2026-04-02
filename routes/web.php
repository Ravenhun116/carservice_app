<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;

Route::get('/', [ClientController::class, 'index']);
Route::get('/clients/{client}/cars', [ClientController::class, 'getCarsDetails']);
Route::get('/cars/{car}/services', [ClientController::class, 'getServicesForCar']);
Route::post('/client/search', [ClientController::class, 'search']);
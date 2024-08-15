<?php

use App\Http\Controllers\PositionController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\User\IndexController;
use App\Http\Controllers\User\ShowController;
use App\Http\Controllers\User\StoreController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/positions', [PositionController::class, 'index']);
Route::get('/token', [TokenController::class, 'index']);

Route::group([], function () {
    Route::get('/users', IndexController::class);
    Route::post('/users', StoreController::class);
    Route::get('/users/{id}', ShowController::class);
});


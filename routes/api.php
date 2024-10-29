<?php

use App\Http\Controllers\API\PositionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AuthController;
use App\Http\Middleware\ApiTokenMiddleware;

Route::get('/token', [AuthController::class, 'getToken']);

Route::get('/positions', [PositionController::class, 'index']);

Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store'])
    ->middleware(ApiTokenMiddleware::class);
Route::get('/users/{id}', [UserController::class, 'show']);

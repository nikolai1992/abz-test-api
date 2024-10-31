<?php

use App\Http\Controllers\API\V1\TokenController;
use App\Http\Controllers\API\V1\PositionController;
use App\Http\Controllers\API\V1\UserController;
use App\Http\Middleware\ApiTokenMiddleware;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/token', [TokenController::class, 'getToken']);

    Route::get('/positions', [PositionController::class, 'index']);

    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store'])
        ->middleware(ApiTokenMiddleware::class);
    Route::get('/users/{id}', [UserController::class, 'show']);
});


<?php

use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\HomeController as v1HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', v1HomeController::class);

Route::prefix('v1')->group(function () {
    Route::post('/register', [AuthController::class, 'createUser']);
    Route::post('/login', [AuthController::class, 'loginUser']);
    // Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);

    Route::group(["middleware" => ['auth:sanctum']], function () {
        Route::get('/products', function () {
            return [
                'hello' => 'word',
            ];
        });
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

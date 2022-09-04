<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\ShopsController;
use App\Http\Controllers\Api\v1\ProductsController;
use App\Http\Controllers\Api\v1\SubCategoriesController;
use App\Http\Controllers\Api\v1\CategorieShopsController;
use App\Http\Controllers\Api\v1\CategoriesShopsController;
use App\Http\Controllers\Api\v1\CategoriesProductsController;
use App\Http\Controllers\Api\v1\SubCategoriesProductController;
use App\Http\Controllers\Api\v1\HomeController as v1HomeController;

Route::get('/', v1HomeController::class);

Route::prefix('v1')->group(function () {
    Route::post('/register', [AuthController::class, 'createUser']);
    Route::post('/login', [AuthController::class, 'loginUser']);
    // Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);

    Route::apiResource('catégorie-products',CategoriesProductsController::class);
    Route::apiResource('catégorie-shops',CategorieShopsController::class);
    Route::apiResource('sub-catégorie-products',SubCategoriesController::class);
    Route::apiResource('products-all',ProductsController::class);
    Route::apiResource('shops',ShopsController::class);

    Route::group(["middleware" => ['auth:sanctum']], function () {
        Route::get('/products', function () {
            return [
                'hello' => 'word',
            ];
        });
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});




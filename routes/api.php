<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\API\AuthController;

use App\Http\Controllers\API\UsersController;
use App\Http\Controllers\API\ProductsController;
use App\Http\Controllers\API\ProductCategoriesController;
use App\Http\Controllers\API\OrdersController;



Route::group(['prefix' => 'v1'], function() {
    Route::group(['prefix' => 'auth'], function() {
        Route::post('login', [AuthController::class, 'login'])->name('api.auth.login');
        Route::post('register', [AuthController::class, 'register'])->name('api.auth.customer.register');
    });

    // Health check api
    Route::get('health-check', function() {
        return [
            'status' => 'online',
            'services' => [
                'mysql_db' => 'online'
            ]
        ];
    })->name('api.health-check');

    Route::apiResource('users', UsersController::class)->except(['destroy']);
    Route::apiResources([
        'products' => ProductsController::class,
        'product-categories' => ProductCategoriesController::class,
        'orders' => OrdersController::class,
    ]);
});

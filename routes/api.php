<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\API\ProductsController;
use App\Http\Controllers\API\ProductCategoriesController;
use App\Http\Controllers\API\ProductImagesController;
use App\Http\Controllers\API\OrdersController;

Route::group(['prefix' => 'v1'], function() {

    Route::apiResource('product-images', ProductImagesController::class)->except(['update']);
    Route::apiResources([
        'products' => ProductsController::class,
        'product-categories' => ProductCategoriesController::class,
        'orders' => OrdersController::class,
    ]);
});

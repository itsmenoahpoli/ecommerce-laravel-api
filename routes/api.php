<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\API\ProductsController;
use App\Http\Controllers\API\ProductCategoriesController;

Route::group(['prefix' => 'v1'], function() {
    Route::apiResources([
        'products' => ProductsController::class,
        'product-categories' => ProductCategoriesController::class,
    ]);
});

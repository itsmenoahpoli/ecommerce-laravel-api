<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\API\ProductsController;

Route::group(['prefix' => 'v1'], function() {
    Route::apiResources([
        'products' => ProductsController::class,
    ]);
});

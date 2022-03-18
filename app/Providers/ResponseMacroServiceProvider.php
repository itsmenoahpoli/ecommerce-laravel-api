<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class ResponseMacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Success response macro
        Response::macro('success', function ($data, $httpStatusCode = 200) {
            return Response::json([
                'status' => $httpStatusCode,
                'message' => $data
            ], $httpStatusCode);
        });

        // Error response macro
        Response::macro('error', function ($data, $httpStatusCode = 500) {
            return Response::json([
                'status' => $httpStatusCode,
                'message' => $data
            ]);
        });
    }
}

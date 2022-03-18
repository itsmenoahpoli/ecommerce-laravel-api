<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Repositories & Interfaces
use App\Repositories\ProductRepository;
use App\Repositories\Interfaces\ProductRepositoryInterface;


use App\Repositories\ProductCategoryRepository;
use App\Repositories\Interfaces\ProductCategoryRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            ProductRepositoryInterface::class,
            ProductRepository::class
        );
        $this->app->bind(
            ProductCategoryRepositoryInterface::class,
            ProductCategoryRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

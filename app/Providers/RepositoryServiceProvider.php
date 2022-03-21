<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Repositories & Interfaces
use App\Repositories\ProductRepository;
use App\Repositories\Interfaces\ProductRepositoryInterface;


use App\Repositories\ProductCategoryRepository;
use App\Repositories\Interfaces\ProductCategoryRepositoryInterface;


use App\Repositories\OrderRepository;
use App\Repositories\Interfaces\OrderRepositoryInterface;

use App\Repositories\UserRepository;
use App\Repositories\Interfaces\UserRepositoryInterface;

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
        $this->app->bind(
            OrderRepositoryInterface::class,
            OrderRepository::class
        );
        $this->app->bind(
           UserRepositoryInterface::class,
           UserRepository::class
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

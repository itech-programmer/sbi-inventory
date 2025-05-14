<?php

namespace App\Providers;

use App\Contracts\Category\CategoryRepositoryInterface;
use App\Contracts\Category\CategoryServiceInterface;
use App\Contracts\Product\ProductRepositoryInterface;
use App\Contracts\Product\ProductServiceInterface;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            CategoryRepositoryInterface::class,
            CategoryRepository::class
        );

        $this->app->bind(
            CategoryServiceInterface::class,
            CategoryService::class
        );

        $this->app->bind(
            ProductRepositoryInterface::class,
            ProductRepository::class
        );

        $this->app->bind(
            ProductServiceInterface::class,
            ProductService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

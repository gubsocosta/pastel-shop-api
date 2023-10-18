<?php

namespace App\Providers;

use App\Adapters\Log\MonologLogger;
use App\Http\Controllers\ProductController;
use Core\Infra\Log\Logger;
use Core\Modules\Product\Application\UseCases\Create\CreateProductUseCase;
use Core\Modules\Product\Application\UseCases\List\ListProductsUseCase;
use Core\Modules\Product\Domain\Repositories\ProductRepository;
use Core\Modules\Product\Infra\Repositories\EloquentProductRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class ProductServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(Logger::class, MonologLogger::class);
        $this->app->bind(ProductRepository::class, EloquentProductRepository::class);
        $this->app->bind(CreateProductUseCase::class, function (Application $app) {
            return new CreateProductUseCase(
                $app->make(Logger::class),
                $app->make(ProductRepository::class)
            );
        });
        $this->app->bind(ListProductsUseCase::class, function (Application $app) {
            return new ListProductsUseCase(
                $app->make(Logger::class),
                $app->make(ProductRepository::class)
            );
        });
        $this->app->bind(ProductController::class, function (Application $app) {
            return new ProductController(
                $app->make(CreateProductUseCase::class),
                $app->make(ListProductsUseCase::class)
            );
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

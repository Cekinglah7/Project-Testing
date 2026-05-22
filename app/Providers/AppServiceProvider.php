<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Product;
use App\Observers\ProductObserver;
use App\Interfaces\ProductInterface;
use App\Repositories\ProductRepository;
use App\Interfaces\CartInterface;
use App\Repositories\CartRepository;
use App\Interfaces\HomeInterface;
use App\Repositories\HomeRepository;
use App\Interfaces\CategoryInterface;
use App\Repositories\CategoryRepository;
use App\Interfaces\FavoriteInterface;
use App\Repositories\FavoriteRepository;
use App\Interfaces\OrderInterface;
use App\Repositories\OrderRepository;
use App\Models\ProductImage;
use App\Observers\ProductImageObserver;
use App\Interfaces\NotificationInterface;
use App\Repositories\NotificationRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CartInterface::class, CartRepository::class);
        $this->app->bind(HomeInterface::class, HomeRepository::class);
        $this->app->bind(ProductInterface::class, ProductRepository::class);
        $this->app->bind(CategoryInterface::class, CategoryRepository::class);
        $this->app->bind(FavoriteInterface::class, FavoriteRepository::class);
        $this->app->bind(OrderInterface::class, OrderRepository::class);
        $this->app->bind(NotificationInterface::class, NotificationRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Product::observe(ProductObserver::class);
        ProductImage::observe(ProductImageObserver::class);
    }
}

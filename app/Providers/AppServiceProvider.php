<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Order\Repository\OrderRepositoryInterface;
use App\Domain\Order\Strategy\OrderCreationStrategy;
use App\Domain\Order\Strategy\SimpleOrderStrategy;
use App\Infrastructure\Persistence\Eloquent\OrderRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            OrderRepositoryInterface::class,
            OrderRepository::class
        );
        
        $this->app->bind(
            OrderCreationStrategy::class,
            SimpleOrderStrategy::class
        );
    }

    public function boot(): void
    {
        //
    }
}

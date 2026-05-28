<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Order\Repository\OrderRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\OrderRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            OrderRepositoryInterface::class,
            OrderRepository::class
        );
    }

    public function boot(): void
    {
        //
    }
}

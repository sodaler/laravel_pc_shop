<?php

namespace App\Providers;

use App\Support\Managers\CartManager;
use App\Support\StorageIdentities\SessionIdentityStorage;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->singleton(CartManager::class, function () {
            return new CartManager(new SessionIdentityStorage());
        });
    }

    public function register(): void
    {
        $this->app->register(
            ActionsServiceProvider::class
        );
    }
}

<?php

namespace App\Providers;

use App\Filters\BrandFilter;
use App\Filters\FilterManager;
use App\Filters\PriceFilter;
use Illuminate\Support\ServiceProvider;

class CatalogServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(FilterManager::class);
    }

    public function boot()
    {
        app(FilterManager::class)->registerFilters([
            new PriceFilter(),
            new BrandFilter()
        ]);
    }
}

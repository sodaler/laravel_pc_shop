<?php

namespace App\ViewModels;

use App\Cache\BrandCacheEnum;
use App\Models\Brand;
use App\Traits\Makeable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class BrandViewModel
{
    use Makeable;

    public function homePage(): Collection|array
    {
        return Cache::rememberForever(BrandCacheEnum::BrandHomePage->key(), function () {
            return Brand::query()
                ->homePage()
                ->get();
        });
    }
}

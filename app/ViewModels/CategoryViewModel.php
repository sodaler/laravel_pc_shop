<?php

namespace App\ViewModels;

use App\Cache\BrandCacheEnum;
use App\Cache\CategoryCacheEnum;
use App\Models\Brand;
use App\Models\Category;
use App\Traits\Makeable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class CategoryViewModel
{
    use Makeable;

    public function homePage(): Collection|array
    {
        return Cache::rememberForever(CategoryCacheEnum::CategoryHomePage->key(), function () {
            return Category::query()
                ->homePage()
                ->get();
        });
    }
}

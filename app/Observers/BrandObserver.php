<?php

namespace App\Observers;

use App\Cache\BrandCacheEnum;
use App\Models\Brand;
use Illuminate\Support\Facades\Cache;

class BrandObserver
{
    public function saved(Brand $brand): void
    {
        $this->clearCache();
    }

    public function deleted(Brand $brand): void
    {
        $this->clearCache();
    }

    protected function clearCache(): void
    {
        foreach (BrandCacheEnum::cases() as $case) {
            Cache::forget($case->key());
        }
    }
}

<?php

namespace App\Cache;

enum BrandCacheEnum: string
{
    case BrandHomePage = 'brand_home_page';

    public function key(): string
    {
        return $this->value;
    }
}

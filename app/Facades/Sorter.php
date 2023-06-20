<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\Sorters\Sorter as CatalogSorter;

class Sorter extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return CatalogSorter::class;
    }
}

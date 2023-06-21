<?php

namespace App\Facades;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Facade;
use App\Sorters\Sorter as CatalogSorter;
use Illuminate\Support\Stringable;

/**
 * @method static Builder run(Builder $query)
 * @method static Stringable sortData()
 * @see CatalogSorter
 */
class Sorter extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return CatalogSorter::class;
    }
}

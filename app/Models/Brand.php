<?php

namespace App\Models;

use App\Collections\BrandCollection;
use App\QueryBuilders\BrandQueryBuilder;
use App\Traits\Models\HasSlug;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    use HasFactory;
    use HasSlug;

    protected $fillable = [
        'slug',
        'title',
        'thumbnail',
        'on_home_page',
        'sorting'
    ];

    public function newCollection(array $models = []): BrandCollection
    {
        return new BrandCollection($models);
    }

    public function newEloquentBuilder($query): BrandQueryBuilder
    {
        return new BrandQueryBuilder($query);
    }

    protected function thumbnailDir(): string
    {
        return 'brands';
    }


    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}

<?php

namespace App\Models;

use App\Facades\Sorter;
use App\Support\Casts\PriceCast;
use App\Traits\Models\HasSlug;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Pipeline\Pipeline;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use HasFactory;
    use HasSlug;
    use Searchable;


    protected $fillable = [
        'title',
        'slug',
        'brand_id',
        'price',
        'thumbnail',
    ];

    protected $casts = [
      'price' => PriceCast::class
    ];

    protected function thumbnailDir(): string
    {
        return 'products';
    }

    public function scopeHomePage(Builder $query)
    {
        $query->where('on_home_page', true)
            ->orderBy('sorting')
            ->limit(6);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function properties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class)
            ->withPivot('value');
    }

    public function optionValues(): BelongsToMany
    {
        return $this->belongsToMany(OptionValue::class);
    }

    public function scopeFiltered(Builder $query)
    {
        return app(Pipeline::class)
            ->send($query)
            ->through(filters())
            ->thenReturn();
    }

    public function scopeSorted(Builder $query)
    {
        Sorter::run($query);
    }
}

<?php

namespace App\MoonShine\Resources;

use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Model;

use MoonShine\Decorations\Tab;
use MoonShine\Decorations\Tabs;
use MoonShine\Fields\BelongsTo;
use MoonShine\Fields\BelongsToMany;
use MoonShine\Fields\Image;
use MoonShine\Fields\Text;
use MoonShine\Filters\BelongsToFilter;
use MoonShine\Resources\Resource;
use MoonShine\Fields\ID;
use MoonShine\Decorations\Block;
use MoonShine\Actions\FiltersAction;

class ProductResource extends Resource
{
    public static string $model = Product::class;

    public static string $title = 'Products';

    public static array $with = [
        'brand',
        'categories',
        'properties',
        'optionValues'
    ];

    public function fields(): array
    {
        return [
            Block::make('form-container', [
                Tabs::make([
                    Tab::make('Basic', [
                        ID::make()->sortable(),
                        Text::make('Title'),
                        BelongsTo::make('Brand'),
                        Text::make('Price'),
                        Image::make('Thumbnail')
                            ->dir('images/products')
                            ->withPrefix('/storage/'),
                    ]),
                    Tab::make('Categories', [
                        BelongsToMany::make('Categories', resource: 'title')
                            ->hideOnIndex()
                    ]),
                    Tab::make('Properties', [
                        BelongsToMany::make('Properties', resource: 'title')
                            ->fields([
                                Text::make('Value')
                            ])
                            ->hideOnIndex()
                    ]),
                    Tab::make('Options', [
                        BelongsToMany::make('OptionValues', resource: 'title')
                            ->fields([
                                Text::make('Value')
                            ])
                            ->hideOnIndex()
                    ])
                ])
            ])
        ];
    }

    public function rules(Model $item): array
    {
        return [];
    }

    public function search(): array
    {
        return ['id'];
    }

    public function filters(): array
    {
        return [
            BelongsToFilter::make('Brand')
                ->searchable()
        ];
    }

    public function actions(): array
    {
        return [
            FiltersAction::make(trans('moonshine::ui.filters')),
        ];
    }
}

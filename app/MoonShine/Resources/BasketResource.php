<?php

namespace App\MoonShine\Resources;

use Domain\Cart\Models\Cart;
use Illuminate\Database\Eloquent\Model;

use MoonShine\Fields\HasMany;
use MoonShine\Resources\Resource;
use MoonShine\Fields\ID;
use MoonShine\Decorations\Block;
use MoonShine\Actions\FiltersAction;

class BasketResource extends Resource
{
    public static string $model = Cart::class;

    public static string $title = 'Basket';

    public static array $with = [
        'cartItems'
    ];

    public function fields(): array
    {
        return [
            Block::make('form-container', [
                ID::make()->sortable(),
                HasMany::make('Cart Item', 'cartItems')
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
        return [];
    }

    public function actions(): array
    {
        return [
            FiltersAction::make(trans('moonshine::ui.filters')),
        ];
    }
}

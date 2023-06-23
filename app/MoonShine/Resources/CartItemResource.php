<?php

namespace App\MoonShine\Resources;

use Domain\Cart\Models\CartItem;
use Illuminate\Database\Eloquent\Model;

use MoonShine\Fields\Number;
use MoonShine\Fields\Text;
use MoonShine\Resources\Resource;
use MoonShine\Fields\ID;
use MoonShine\Decorations\Block;
use MoonShine\Actions\FiltersAction;

class CartItemResource extends Resource
{
    public static string $model = CartItem::class;

    public static string $title = 'CartItem';

    public function fields(): array
    {
        return [
            Block::make('form-container', [
                ID::make()->sortable(),
                Number::make('Product id'),
                Text::make('Price'),
                Number::make('Quantity'),
                Text::make('Option values', 'string_option_values'),
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

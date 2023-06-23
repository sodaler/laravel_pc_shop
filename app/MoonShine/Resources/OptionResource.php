<?php

namespace App\MoonShine\Resources;


use Domain\Catalog\Models\Option;
use Illuminate\Database\Eloquent\Model;

use MoonShine\Fields\Text;
use MoonShine\Resources\Resource;
use MoonShine\Fields\ID;
use MoonShine\Decorations\Block;
use MoonShine\Actions\FiltersAction;

class OptionResource extends Resource
{
    public static string $model = Option::class;

    public static string $title = 'Option';

    public function fields(): array
    {
        return [
            Block::make('form-container', [
                ID::make()->sortable(),
                Text::make('Title')
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

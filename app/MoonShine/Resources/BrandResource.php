<?php

namespace App\MoonShine\Resources;

use Domain\Catalog\Models\Brand;
use Illuminate\Database\Eloquent\Model;


use MoonShine\Actions\ExportAction;
use MoonShine\Actions\FiltersAction;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Image;
use MoonShine\Fields\Number;
use MoonShine\Fields\SwitchBoolean;
use MoonShine\Fields\Text;
use MoonShine\Filters\TextFilter;
use MoonShine\Resources\Resource;

class BrandResource extends Resource
{
    public static string $model = Brand::class;

    public static string $title = 'Brand';

    public string $titleField = 'title';

    public function fields(): array
    {
        return [
            Block::make('form-container', [
                ID::make()->sortable(),
                Text::make('Title')->showOnExport(),
                Image::make('Thumbnail')
                    ->dir('images/brands')
                    ->withPrefix('/storage/'),
                SwitchBoolean::make('On home page'),
                Number::make('Sorting')
                    ->min(1)
                    ->max(999)
            ])
        ];
    }

    public function rules(Model $item): array
    {
        return [];
    }

    public function search(): array
    {
        return ['id', 'title'];
    }

    public function filters(): array
    {
        return [
            TextFilter::make('Title')
        ];
    }

    public function actions(): array
    {
        return [
            ExportAction::make('Export'),
            FiltersAction::make(trans('moonshine::ui.filters')),
        ];
    }
}

<?php

namespace App\Providers;

use App\MoonShine\Resources\BasketResource;
use App\MoonShine\Resources\BrandResource;
use App\MoonShine\Resources\CategoryResource;
use App\MoonShine\Resources\OptionResource;
use App\MoonShine\Resources\OrderResource;
use App\MoonShine\Resources\ProductResource;
use App\MoonShine\Resources\PropertyResource;
use Illuminate\Support\ServiceProvider;
use MoonShine\MoonShine;
use MoonShine\Menu\MenuGroup;
use MoonShine\Menu\MenuItem;
use MoonShine\Resources\MoonShineUserResource;
use MoonShine\Resources\MoonShineUserRoleResource;

class MoonShineServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        app(MoonShine::class)->menu([
            MenuGroup::make('moonshine::ui.resource.system', [
                MenuItem::make('moonshine::ui.resource.admins_title', new MoonShineUserResource())
                    ->translatable()
                    ->icon('users'),
                MenuItem::make('moonshine::ui.resource.role_title', new MoonShineUserRoleResource())
                    ->translatable()
                    ->icon('bookmark'),
            ])->translatable(),

            MenuGroup::make('Products', [
                MenuItem::make('Products', new ProductResource())->translatable(),
                MenuItem::make('Brands', new BrandResource()),
                MenuItem::make('Categories', new CategoryResource()),
                MenuItem::make('Properties', new PropertyResource()),
                MenuItem::make('Options', new OptionResource()),
            ])->translatable(),

            MenuGroup::make('Order', [
                MenuItem::make('Basket', new BasketResource()),
                MenuItem::make('Order', new OrderResource()),
            ]),

            MenuItem::make('Documentation', 'https://laravel.com')
                ->badge(fn() => 'Check'),
        ]);

    }
}

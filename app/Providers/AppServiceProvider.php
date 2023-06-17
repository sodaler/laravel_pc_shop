<?php

namespace App\Providers;

use App\Http\Kernel;
use Carbon\CarbonInterval;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
//        Model::preventLazyLoading(!app()->isProduction());
//        Model::preventSilentlyDiscardingAttributes(!app()->isProduction());

        Model::shouldBeStrict(!app()->isProduction());

        if (app()->isProduction()) {
            DB::listen(function ($query) {
                if ($query->time > 100) {
                    logger()
                        ->channel('telegram')
                        ->debug(
                            'query longer than 1s:' . $query->sql, $query->sql
                        );
                }
            });

//            DB::whenQueryingForLongerThan(500, function (Connection $connection) {
//                logger()->channel('telegram')->debug('whenQueryingForLongerThan:' . $connection->query()->toSql());
//            });


            app(Kernel::class)->whenRequestLifecycleIsLongerThan(
                CarbonInterval::seconds(4),
                fn() => logger()->channel('telegram')->debug('whenRequestLifecycleIsLongerThan:' . request()->url())
            );
        }
    }

}

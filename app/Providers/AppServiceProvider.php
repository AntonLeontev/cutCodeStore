<?php

namespace App\Providers;

use Faker\Factory;
use App\Http\Kernel;
use Carbon\CarbonInterval;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use App\Providers\Faker\FakerImageProvider;
use Faker\Generator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Model::shouldBeStrict(!app()->isProduction());

        if (app()->isProduction()) {
            DB::whenQueryingForLongerThan(CarbonInterval::seconds(5), function (Connection $connection) {
                logger()
                    ->channel('telegram')
                    ->debug('whenQueryingForLongerThan: ' . $connection->totalQueryDuration());
            });

            DB::listen(function ($query) {
                if ($query->time > 100) {
                    logger()
                        ->channel('telegram')
                        ->debug(
                            sprintf(
                                "DB::listen\ntime: %s\nSQL: %s\n",
                                $query->time,
                                $query->sql
                            )
                        );
                }
            });
        }

        $kernel = app(Kernel::class);
        $kernel->whenRequestLifecycleIsLongerThan(CarbonInterval::seconds(4), function () {
            logger()->channel('telegram')->debug('whenRequestLifecycleIsLongerThan: ' . request()->url());
        });
    }
}

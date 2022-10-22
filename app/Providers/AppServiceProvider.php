<?php

namespace App\Providers;

use App\Http\Kernel;
use Carbon\CarbonInterval;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Connection;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
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
                //log 
                // $connection->totalQueryDuration();
            });
        }

        DB::listen(function ($query) {
            // $query->sql
            // $query->binding
            // $query->time
            if ($query->time > 100) {
                // log
            }
        });

        $kernel = app(Kernel::class);
        $kernel->whenRequestLifecycleIsLongerThan(CarbonInterval::seconds(4), function () {
            //log
        });
    }
}

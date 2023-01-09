<?php

namespace App\Routing;

use App\Contracts\RouteRegistrar;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InterventionController;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;

class AppRegistrar implements RouteRegistrar
{
    public function map(Registrar $registrar): void
    {
        Route::middleware('web')->group(function (){
            Route::get('/', HomeController::class)->name('home');

            Route::get('/storage/images/{dir}/{method}/{size}/{file}', InterventionController::class)
                ->where('method', 'crop|resize|fit')
                ->where('size', '\d+x\d+')
                ->where('file', '.+\.(jpeg|jpg|webp|bmp|gif|png)')
                ->name('thumbnail');
        });
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Domains\Auth\Providers\AuthServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(AuthServiceProvider::class);
    }
}

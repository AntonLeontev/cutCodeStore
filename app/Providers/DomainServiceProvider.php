<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Domains\Auth\Providers\AuthServiceProvider;
use Src\Domains\Catalog\Providers\CatalogServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register(AuthServiceProvider::class);
        $this->app->register(CatalogServiceProvider::class);
    }
}

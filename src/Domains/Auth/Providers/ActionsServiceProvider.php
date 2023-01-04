<?php

namespace Src\Domains\Auth\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Domains\Auth\Actions\RegisterNewUserAction;
use Src\Domains\Auth\Contracts\RegisterNewUserContract;

class ActionsServiceProvider extends ServiceProvider
{
    public array $bindings = [
        RegisterNewUserContract::class => RegisterNewUserAction::class,
    ];
}

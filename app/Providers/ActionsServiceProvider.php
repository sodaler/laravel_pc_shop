<?php

namespace App\Providers;

use App\Actions\RegisterNewUserAction;
use App\Contracts\RegisterNewUserContract;
use Illuminate\Support\ServiceProvider;

class ActionsServiceProvider extends ServiceProvider
{
    public array $bindings = [
        RegisterNewUserContract::class => RegisterNewUserAction::class
    ];

}

<?php

namespace Sellvation\CCMV2\Users;

use Illuminate\Support\ServiceProvider;
use Sellvation\CCMV2\Users\Models\User;

class UserServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        \Config::set('auth.providers.users.model', User::class);

        $this->loadViewsFrom(__DIR__.'/views', 'user');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
    }
}

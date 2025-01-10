<?php

namespace Sellvation\CCMV2\Api;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class ApiServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Config::set('auth.guards.api', [
            'driver' => 'passport',
            'provider' => 'users',
        ]);
    }

    public function boot(Router $router): void
    {
        Passport::hashClientSecrets();
        Passport::tokensExpireIn(now()->addDays(15));
        Passport::refreshTokensExpireIn(now()->addDays(30));
        Passport::personalAccessTokensExpireIn(now()->addMonths(6));
        Passport::setClientUuids(false);

        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes/api.php');
        $this->mergeConfigFrom(__DIR__.'/config/passport.php', 'passport');

        $this->publishes([
            __DIR__.'/config/passport.php' => config_path('passport.php'),
        ], 'ccm-config');
    }
}

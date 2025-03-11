<?php

namespace Sellvation\CCMV2\Api;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Sellvation\CCMV2\Api\Facades\ApiScopes;
use Sellvation\CCMV2\Api\Facades\ApiScopesFacade;

class ApiServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerFacades();
        $this->registerLivewireComponents();
    }

    public function boot(Router $router): void
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes/api.php');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/views', 'api-tokens');
    }

    private function registerLivewireComponents(): void
    {
        Livewire::component('api::overview', Overview::class);
        Livewire::component('api::edit', Edit::class);
    }

    private function registerFacades(): void
    {
        $this->app->bind('api-scopes', ApiScopes::class);

        $loader = AliasLoader::getInstance();
        $loader->alias('ApiScopes', ApiScopesFacade::class);

    }
}

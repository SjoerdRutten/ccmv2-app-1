<?php

namespace Sellvation\CCMV2\Stripo;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Sellvation\CCMV2\Stripo\Facades\Stripo;
use Sellvation\CCMV2\Stripo\Facades\StripoFacade;

class StripoServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerFacades();
    }

    public function boot(): void
    {
        $this->mergeConfigFrom(__DIR__.'/config/stripo.php', 'stripo');

        $this->publishes([
            __DIR__.'/config/stripo.php' => config_path('stripo.php'),
        ], 'ccm-config');
    }

    private function registerFacades(): void
    {
        $this->app->bind('stripo', Stripo::class);

        $loader = AliasLoader::getInstance();
        $loader->alias('Stripo', StripoFacade::class);
    }
}

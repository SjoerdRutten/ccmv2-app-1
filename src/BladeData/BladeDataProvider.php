<?php

namespace Sellvation\CCMV2\BladeData;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Sellvation\CCMV2\BladeData\Facades\BladeExtensions;
use Sellvation\CCMV2\BladeData\Facades\BladeExtensionsFacade;

class BladeDataProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(Router $router): void
    {
        $this->registerFacades();
    }

    private function registerFacades()
    {
        $this->app->bind('blade-extensions', BladeExtensions::class);

        $loader = AliasLoader::getInstance();
        $loader->alias('BladeExtensions', BladeExtensionsFacade::class);
    }
}

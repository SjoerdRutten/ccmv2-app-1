<?php

namespace Sellvation\CCMV2\Ccm;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Sellvation\CCMV2\Ccm\Http\Middelware\CcmContextMiddleware;

class CcmServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(Router $router): void
    {
        Config::set('livewire.layout', 'ccm::layouts.app');

        $this->loadViewsFrom(__DIR__.'/views', 'ccm');

        $router->pushMiddlewareToGroup('web', CcmContextMiddleware::class);
    }
}

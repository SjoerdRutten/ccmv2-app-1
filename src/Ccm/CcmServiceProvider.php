<?php

namespace Sellvation\CCMV2\Ccm;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Laravel\Pennant\Feature;
use Livewire\Livewire;
use Sellvation\CCMV2\Ccm\Http\Middelware\CcmContextMiddleware;
use Sellvation\CCMV2\Ccm\Livewire\ModalError;
use Sellvation\CCMV2\Ccm\Livewire\ModalSuccess;

class CcmServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(Router $router): void
    {
        Config::set('livewire.layout', 'ccm::layouts.app');

        Feature::resolveScopeUsing(fn ($driver) => Auth::user()?->currentEnvironment);

        $this->loadViewsFrom(__DIR__.'/views', 'ccm');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        $router->pushMiddlewareToGroup('web', CcmContextMiddleware::class);
        if (! App::runningInConsole()) {
            $this->registerLivewireComponents();
        }
    }

    private function registerLivewireComponents(): void
    {
        Livewire::component('ccm::modal-success', ModalSuccess::class);
        Livewire::component('ccm::modal-error', ModalError::class);
    }
}

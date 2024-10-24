<?php

namespace Sellvation\CCMV2\Ccm;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Sellvation\CCMV2\Ccm\Components\dashboard\TypesenseCard;
use Sellvation\CCMV2\Ccm\Http\Middelware\CcmContextMiddleware;
use Sellvation\CCMV2\Ccm\Livewire\Admin\Customers\Edit;
use Sellvation\CCMV2\Ccm\Livewire\Admin\Customers\Overview;
use Sellvation\CCMV2\Ccm\Livewire\Admin\Features;
use Sellvation\CCMV2\Ccm\Livewire\EnvironmentSelector;
use Sellvation\CCMV2\Ccm\Livewire\ModalError;
use Sellvation\CCMV2\Ccm\Livewire\ModalSuccess;

class CcmServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(Router $router): void
    {
        Config::set('livewire.layout', 'ccm::layouts.app');

        $this->loadViewsFrom(__DIR__.'/views', 'ccm');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');

        $router->pushMiddlewareToGroup('web', CcmContextMiddleware::class);

        if (! App::runningInConsole()) {
            $this->registerLivewireComponents();

            Blade::component('ccm::dashboard.typesense-card', TypesenseCard::class);
        }
    }

    private function registerLivewireComponents(): void
    {
        Livewire::component('ccm::modal-success', ModalSuccess::class);
        Livewire::component('ccm::modal-error', ModalError::class);
        Livewire::component('ccm::environment-selector', EnvironmentSelector::class);

        Livewire::component('ccm::admin::features', Features::class);
        Livewire::component('ccm::admin::customers', Overview::class);
        Livewire::component('ccm::admin::customers.edit', Edit::class);
        Livewire::component('ccm::admin::environments', \Sellvation\CCMV2\Ccm\Livewire\Admin\Environments\Overview::class);
        Livewire::component('ccm::admin::environments.edit', \Sellvation\CCMV2\Ccm\Livewire\Admin\Environments\Edit::class);

        Livewire::component('ccm::dashboard::typesense-card', TypesenseCard::class);
    }
}

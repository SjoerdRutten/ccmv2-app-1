<?php

namespace Sellvation\CCMV2\Ccm;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Laravel\Pennant\Feature;
use Livewire\Livewire;
use Sellvation\CCMV2\Ccm\Components\dashboard\TypesenseCard;
use Sellvation\CCMV2\Ccm\Http\Middelware\CcmContextMiddleware;
use Sellvation\CCMV2\Ccm\Livewire\admin\Features;
use Sellvation\CCMV2\Ccm\Livewire\EnvironmentSelector;
use Sellvation\CCMV2\Ccm\Livewire\ModalError;
use Sellvation\CCMV2\Ccm\Livewire\ModalSuccess;
use Sellvation\CCMV2\Environments\Models\Environment;

class CcmServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(Router $router): void
    {
        Config::set('livewire.layout', 'ccm::layouts.app');

        $this->loadViewsFrom(__DIR__.'/views', 'ccm');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');
        $this->loadFeatures();

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

        Livewire::component('ccm::dashboard::typesense-card', TypesenseCard::class);
    }

    private function loadFeatures()
    {
        Feature::resolveScopeUsing(fn ($driver) => Auth::user()?->currentEnvironment);

        $environmentFeatures = [
            'crm',
            'ems',
            'targetGroups',
        ];

        Feature::define('admin', fn (Environment $environment) => \Str::startsWith(Auth::user()->name, 'sellvation'));

        foreach ($environmentFeatures as $feature) {
            Feature::define($feature, fn (Environment $environment) => $environment->hasFeature($feature));
        }
    }
}

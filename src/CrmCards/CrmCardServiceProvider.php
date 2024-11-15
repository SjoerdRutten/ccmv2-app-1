<?php

namespace Sellvation\CCMV2\CrmCards;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Sellvation\CCMV2\CrmCards\Facades\CrmFieldCorrector;
use Sellvation\CCMV2\CrmCards\Facades\CrmFieldCorrectorFacade;

class CrmCardServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/views', 'crm-cards');

        $this->registerEvents();
        $this->registerFacades();

        if (! App::runningInConsole()) {
            $this->registerLivewireComponents();
        }
    }

    private function registerLivewireComponents(): void
    {
        Livewire::component('crm-cards::fields::overview', \Sellvation\CCMV2\CrmCards\Livewire\Fields\Overview::class);
        Livewire::component('crm-cards::fields::edit', \Sellvation\CCMV2\CrmCards\Livewire\Fields\Edit::class);
        Livewire::component('crm-cards::fields::rule', \Sellvation\CCMV2\CrmCards\Livewire\Fields\Rule::class);
        Livewire::component('crm-cards::cards::overview', \Sellvation\CCMV2\CrmCards\Livewire\Cards\Overview::class);
        Livewire::component('crm-cards::cards::edit', \Sellvation\CCMV2\CrmCards\Livewire\Cards\Edit::class);
    }

    private function registerEvents()
    {
        $events = $this->app->make(Dispatcher::class);
    }

    private function registerFacades()
    {
        $this->app->bind('crm-field-correctors', CrmFieldCorrector::class);

        $loader = AliasLoader::getInstance();
        $loader->alias('CrmFieldCorrector', CrmFieldCorrectorFacade::class);

        \CrmFieldCorrector::discover();
    }
}

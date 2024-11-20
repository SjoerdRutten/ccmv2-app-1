<?php

namespace Sellvation\CCMV2\CrmCards;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Sellvation\CCMV2\CrmCards\Events\CrmCardCreatingEvent;
use Sellvation\CCMV2\CrmCards\Facades\CrmFieldCorrector;
use Sellvation\CCMV2\CrmCards\Facades\CrmFieldCorrectorFacade;
use Sellvation\CCMV2\CrmCards\Facades\CrmFieldValidator;
use Sellvation\CCMV2\CrmCards\Facades\CrmFieldValidatorFacade;
use Sellvation\CCMV2\CrmCards\Listeners\CreateCrmIdListener;

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
        Livewire::component('crm-cards::fields::corrector', \Sellvation\CCMV2\CrmCards\Livewire\Fields\Corrector::class);
        Livewire::component('crm-cards::fields::validator', \Sellvation\CCMV2\CrmCards\Livewire\Fields\Validator::class);
        Livewire::component('crm-cards::cards::overview', \Sellvation\CCMV2\CrmCards\Livewire\Cards\Overview::class);
        Livewire::component('crm-cards::cards::edit', \Sellvation\CCMV2\CrmCards\Livewire\Cards\Edit::class);
    }

    private function registerEvents()
    {
        $events = $this->app->make(Dispatcher::class);

        $events->listen(CrmCardCreatingEvent::class, CreateCrmIdListener::class);
    }

    private function registerFacades()
    {
        $this->app->bind('crm-field-correctors', CrmFieldCorrector::class);
        $this->app->bind('crm-field-validator', CrmFieldValidator::class);

        $loader = AliasLoader::getInstance();
        $loader->alias('CrmFieldCorrector', CrmFieldCorrectorFacade::class);
        $loader->alias('CrmFieldValidator', CrmFieldValidatorFacade::class);
    }
}

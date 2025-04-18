<?php

namespace Sellvation\CCMV2\CrmCards;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Sellvation\CCMV2\CrmCards\Commands\UpdateCrmCardMongoCommand;
use Sellvation\CCMV2\CrmCards\Commands\UpdateCrmCardsFromCcmpCommand;
use Sellvation\CCMV2\CrmCards\Events\CrmCardCreatingEvent;
use Sellvation\CCMV2\CrmCards\Events\CrmCardDeletingEvent;
use Sellvation\CCMV2\CrmCards\Events\CrmCardSavedEvent;
use Sellvation\CCMV2\CrmCards\Events\CrmFieldDeletedEvent;
use Sellvation\CCMV2\CrmCards\Facades\CrmFieldCorrector;
use Sellvation\CCMV2\CrmCards\Facades\CrmFieldCorrectorFacade;
use Sellvation\CCMV2\CrmCards\Facades\CrmFieldValidator;
use Sellvation\CCMV2\CrmCards\Facades\CrmFieldValidatorFacade;
use Sellvation\CCMV2\CrmCards\Listeners\CrmCardCreatingListener;
use Sellvation\CCMV2\CrmCards\Listeners\CrmCardDeletingListener;
use Sellvation\CCMV2\CrmCards\Listeners\CrmCardSavedListener;
use Sellvation\CCMV2\CrmCards\Listeners\CrmFieldDeletedListener;

class CrmCardServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/views', 'crm-cards');

        $this->commands([
            UpdateCrmCardMongoCommand::class,
            UpdateCrmCardsFromCcmpCommand::class,
        ]);

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
        Livewire::component('crm-cards::categories::overview', \Sellvation\CCMV2\CrmCards\Livewire\Categories\Overview::class);
        Livewire::component('crm-cards::categories::edit', \Sellvation\CCMV2\CrmCards\Livewire\Categories\Edit::class);
        Livewire::component('crm-cards::imports::index', \Sellvation\CCMV2\CrmCards\Livewire\Imports\Overview::class);
        Livewire::component('crm-cards::imports::edit', \Sellvation\CCMV2\CrmCards\Livewire\Imports\Edit::class);
        Livewire::component('crm-cards::imports::view', \Sellvation\CCMV2\CrmCards\Livewire\Imports\View::class);
    }

    private function registerEvents()
    {
        $events = $this->app->make(Dispatcher::class);

        $events->listen(CrmCardCreatingEvent::class, CrmCardCreatingListener::class);
        $events->listen(CrmCardSavedEvent::class, CrmCardSavedListener::class);
        $events->listen(CrmCardDeletingEvent::class, CrmCardDeletingListener::class);
        $events->listen(CrmFieldDeletedEvent::class, CrmFieldDeletedListener::class);
    }

    private function registerFacades()
    {
        $this->app->bind('crm-field-correctors', CrmFieldCorrector::class);
        $this->app->bind('crm-field-validator', CrmFieldValidator::class);

        $loader = AliasLoader::getInstance();
        $loader->alias('CrmFieldCorrector', CrmFieldCorrectorFacade::class);
        $loader->alias('CrmFieldValidator', CrmFieldValidatorFacade::class);
    }

    private function registerSchedulableCommands()
    {
        \SchedulableCommands::registerCommand(UpdateCrmCardsFromCcmpCommand::class);
    }
}

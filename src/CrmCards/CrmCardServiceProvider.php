<?php

namespace Sellvation\CCMV2\CrmCards;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Sellvation\CCMV2\CrmCards\Events\CrmFieldSavedEvent;
use Sellvation\CCMV2\CrmCards\Listeners\UpdateTypesenseSchemaListener;

class CrmCardServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/views', 'crm-cards');

        $this->registerEvents();

        if (! App::runningInConsole()) {
            $this->registerLivewireComponents();
        }
    }

    private function registerLivewireComponents(): void
    {
        Livewire::component('crm-cards::fields::overview', \Sellvation\CCMV2\CrmCards\Livewire\Fields\Overview::class);
        Livewire::component('crm-cards::fields::edit', \Sellvation\CCMV2\CrmCards\Livewire\Fields\Edit::class);
        Livewire::component('crm-cards::cards::overview', \Sellvation\CCMV2\CrmCards\Livewire\Cards\Overview::class);
        Livewire::component('crm-cards::cards::edit', \Sellvation\CCMV2\CrmCards\Livewire\Cards\Edit::class);
    }

    private function registerEvents()
    {
        $events = $this->app->make(Dispatcher::class);

        $events->listen(CrmFieldSavedEvent::class, UpdateTypesenseSchemaListener::class);
    }
}

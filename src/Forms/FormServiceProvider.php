<?php

namespace Sellvation\CCMV2\Forms;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Sellvation\CCMV2\Forms\Events\FormCreatingEvent;
use Sellvation\CCMV2\Forms\Events\FormResponseCreatedEvent;
use Sellvation\CCMV2\Forms\Listeners\AddUuidToFormListener;
use Sellvation\CCMV2\Forms\Listeners\ProcessFormResponseListener;
use Sellvation\CCMV2\Forms\Livewire\Forms\Edit;
use Sellvation\CCMV2\Forms\Livewire\Forms\Overview;

class FormServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/views', 'forms');

        $this->registerEvents();

        if (! App::runningInConsole()) {
            $this->registerLivewireComponents();
        }
    }

    private function registerLivewireComponents(): void
    {
        Livewire::component('forms::overview', Overview::class);
        Livewire::component('forms::edit', Edit::class);

    }

    private function registerEvents(): void
    {
        $events = $this->app->make(Dispatcher::class);

        $events->listen(FormCreatingEvent::class, AddUuidToFormListener::class);
        $events->listen(FormResponseCreatedEvent::class, ProcessFormResponseListener::class);
    }
}

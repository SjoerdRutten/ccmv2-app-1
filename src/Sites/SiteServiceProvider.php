<?php

namespace Sellvation\CCMV2\Sites;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Sellvation\CCMV2\Sites\Events\SiteSavingEvent;
use Sellvation\CCMV2\Sites\Events\SiteUpdatingEvent;
use Sellvation\CCMV2\Sites\Listeners\SiteSavingListener;
use Sellvation\CCMV2\Sites\Listeners\SiteUpdatingListener;
use Sellvation\CCMV2\Sites\Livewire\Sites\Edit;
use Sellvation\CCMV2\Sites\Livewire\Sites\Overview;

class SiteServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadRoutesFrom(__DIR__.'/routes/frontend.php');
        $this->loadViewsFrom(__DIR__.'/views', 'sites');

        $this->registerEvents();

        if (! App::runningInConsole()) {
            $this->registerLivewireComponents();
        }
    }

    private function registerLivewireComponents(): void
    {
        Livewire::component('sites::overview', Overview::class);
        Livewire::component('sites::edit', Edit::class);
        Livewire::component('layouts::overview', \Sellvation\CCMV2\Sites\Livewire\Layouts\Overview::class);
        Livewire::component('layouts::edit', \Sellvation\CCMV2\Sites\Livewire\Layouts\Edit::class);
        Livewire::component('imports::overview', \Sellvation\CCMV2\Sites\Livewire\Imports\Overview::class);
        Livewire::component('imports::edit', \Sellvation\CCMV2\Sites\Livewire\Imports\Edit::class);
    }

    private function registerEvents()
    {
        $events = $this->app->make(Dispatcher::class);

        $events->listen(SiteUpdatingEvent::class, SiteUpdatingListener::class);
        $events->listen(SiteSavingEvent::class, SiteSavingListener::class);
    }
}

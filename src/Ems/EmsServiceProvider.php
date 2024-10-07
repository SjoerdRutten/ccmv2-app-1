<?php

namespace Sellvation\CCMV2\Ems;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class EmsServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/views', 'ems');

        $this->registerEvents();

        if (! App::runningInConsole()) {
            $this->registerLivewireComponents();
        }
    }

    private function registerLivewireComponents(): void
    {
        Livewire::component('ems::emails::overview', \Sellvation\CCMV2\Ems\Livewire\Emails\Overview::class);
        Livewire::component('ems::emails::edit', \Sellvation\CCMV2\Ems\Livewire\Emails\Edit::class);

        Livewire::component('ems::emailcontents::overview', \Sellvation\CCMV2\Ems\Livewire\EmailContents\Overview::class);
        Livewire::component('ems::emailcontents::edit', \Sellvation\CCMV2\Ems\Livewire\EmailContents\Edit::class);
    }

    private function registerEvents()
    {
        $events = $this->app->make(Dispatcher::class);
    }
}

<?php

namespace Sellvation\CCMV2\Extensions;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Sellvation\CCMV2\Extensions\Facades\Extension;
use Sellvation\CCMV2\Extensions\Facades\ExtensionFacade;
use Sellvation\CCMV2\Scheduler\Livewire\Scheduler\Edit;
use Sellvation\CCMV2\Scheduler\Livewire\Scheduler\Overview;

class ExtensionServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerFacades();
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/views', 'extensions');

        if (! App::runningInConsole()) {
            $this->registerLivewireComponents();
        }
    }

    private function registerLivewireComponents(): void
    {
        //        Livewire::component('scheduler::overview', Overview::class);
        //        Livewire::component('scheduler::edit', Edit::class);
    }

    private function registerFacades(): void
    {
        $this->app->bind('extension', Extension::class);

        $loader = AliasLoader::getInstance();
        $loader->alias('Extension', ExtensionFacade::class);

    }
}

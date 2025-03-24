<?php

namespace Sellvation\CCMV2\Disks;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Sellvation\CCMV2\Disks\Facades\DiskService;
use Sellvation\CCMV2\Disks\Facades\DiskServiceFacade;
use Sellvation\CCMV2\Disks\Livewire\Edit;
use Sellvation\CCMV2\Disks\Livewire\Overview;

class DiskServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/views', 'disks');

        $this->registerEvents();
        $this->registerFacades();

        if (! App::runningInConsole()) {
            $this->registerLivewireComponents();
        }
    }

    private function registerLivewireComponents(): void
    {
        Livewire::component('disks::overview', Overview::class);
        Livewire::component('disks::edit', Edit::class);
    }

    private function registerEvents()
    {
        $events = $this->app->make(Dispatcher::class);
    }

    private function registerFacades()
    {
        $this->app->bind('disk-service', DiskService::class);

        $loader = AliasLoader::getInstance();
        $loader->alias('DiskService', DiskServiceFacade::class);
    }
}

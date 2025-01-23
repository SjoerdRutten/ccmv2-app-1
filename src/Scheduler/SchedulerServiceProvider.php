<?php

namespace Sellvation\CCMV2\Scheduler;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Sellvation\CCMV2\Scheduler\Facades\CcmScheduler;
use Sellvation\CCMV2\Scheduler\Facades\CcmSchedulerFacade;
use Sellvation\CCMV2\Scheduler\Facades\SchedulableCommands;
use Sellvation\CCMV2\Scheduler\Facades\SchedulableCommandsFacade;
use Sellvation\CCMV2\Scheduler\Livewire\Scheduler\Edit;
use Sellvation\CCMV2\Scheduler\Livewire\Scheduler\Overview;

class SchedulerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerFacades();
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/views', 'scheduler');

        if (! App::runningInConsole()) {
            $this->registerLivewireComponents();
        }

        \CcmScheduler::registerCommands();
    }

    private function registerLivewireComponents(): void
    {
        Livewire::component('scheduler::overview', Overview::class);
        Livewire::component('scheduler::edit', Edit::class);
    }

    private function registerFacades(): void
    {
        $this->app->bind('schedulable-commands', SchedulableCommands::class);
        $this->app->bind('ccm-scheduler', CcmScheduler::class);

        $loader = AliasLoader::getInstance();
        $loader->alias('SchedulableCommands', SchedulableCommandsFacade::class);
        $loader->alias('CcmScheduler', CcmSchedulerFacade::class);

    }
}

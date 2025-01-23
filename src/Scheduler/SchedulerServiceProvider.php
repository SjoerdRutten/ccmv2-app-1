<?php

namespace Sellvation\CCMV2\Scheduler;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Sellvation\CCMV2\Scheduler\Livewire\Scheduler\Edit;
use Sellvation\CCMV2\Scheduler\Livewire\Scheduler\Overview;

class SchedulerServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/views', 'scheduler');

        if (! App::runningInConsole()) {
            $this->registerLivewireComponents();
        }
    }

    private function registerLivewireComponents(): void
    {
        Livewire::component('scheduler::overview', Overview::class);
        Livewire::component('scheduler::edit', Edit::class);
    }
}

<?php

namespace Sellvation\CCMV2\Environments;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class EnvironmentServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');
        //        $this->loadRoutesFrom(__DIR__.'/routes/web.php');

        if (! App::runningInConsole()) {
            $this->registerLivewireComponents();
        }
    }

    private function registerLivewireComponents(): void
    {
        //Livewire::component('target-group-selector::form', Form::class);
    }
}

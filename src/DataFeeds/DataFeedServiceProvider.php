<?php

namespace Sellvation\CCMV2\DataFeeds;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Sellvation\CCMV2\DataFeeds\Livewire\DataFeeds\Edit;
use Sellvation\CCMV2\DataFeeds\Livewire\DataFeeds\Overview;

class DataFeedServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/views', 'df');

        $this->registerEvents();

        if (! App::runningInConsole()) {
            $this->registerLivewireComponents();
        }
    }

    private function registerLivewireComponents(): void
    {
        Livewire::component('df::overview', Overview::class);
        Livewire::component('df::edit', Edit::class);
    }

    private function registerEvents()
    {
        $events = $this->app->make(Dispatcher::class);
    }
}

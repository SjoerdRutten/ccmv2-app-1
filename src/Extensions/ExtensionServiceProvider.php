<?php

namespace Sellvation\CCMV2\Extensions;

use Illuminate\Events\Dispatcher;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Sellvation\CCMV2\Extensions\Facades\ExtensionService;
use Sellvation\CCMV2\Extensions\Facades\ExtensionServiceFacade;
use Sellvation\CCMV2\Extensions\Listeners\CcmEventListener;
use Sellvation\CCMV2\Extensions\Livewire\Edit;
use Sellvation\CCMV2\Extensions\Livewire\Overview;
use Sellvation\CCMV2\Extensions\Models\Extension;

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

        $this->registerEvents();
    }

    private function registerLivewireComponents(): void
    {
        Livewire::component('extensions::overview', Overview::class);
        Livewire::component('extensions::edit', Edit::class);
    }

    private function registerFacades(): void
    {
        $this->app->bind('extension-service', ExtensionService::class);

        $loader = AliasLoader::getInstance();
        $loader->alias('ExtensionService', ExtensionServiceFacade::class);

    }

    private function registerEvents()
    {
        $events = $this->app->make(Dispatcher::class);

        if (\Cache::has('extensionEvents')) {
            $extensionEvents = \Cache::get('extensionEvents');
        } else {
            $extensionEvents = [];
            foreach (Extension::select('event')->distinct()->get() as $extension) {
                $extensionEvents[] = $extension->event;
            }

            \Cache::add('extensionEvents', $extensionEvents, 300);
        }

        foreach ($extensionEvents as $event) {
            $events->listen($event, CcmEventListener::class);
        }
    }
}

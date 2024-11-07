<?php

namespace Sellvation\CCMV2\TargetGroups;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Sellvation\CCMV2\TargetGroups\Events\Listeners\CreateExportListener;
use Sellvation\CCMV2\TargetGroups\Events\TargetGroupExportCreatedEvent;
use Sellvation\CCMV2\TargetGroups\Facades\TargetGroupSelectorFacade;
use Sellvation\CCMV2\TargetGroups\Livewire\CreateTargetGroupFieldset;
use Sellvation\CCMV2\TargetGroups\Livewire\Form;
use Sellvation\CCMV2\TargetGroups\Livewire\Overview;
use Sellvation\CCMV2\TargetGroups\Livewire\Rule;

class TargetGroupServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $loader = AliasLoader::getInstance();

        $loader->alias('TargetGroupSelector', TargetGroupSelectorFacade::class);
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/views', 'target-group');

        $this->registerEvents();

        $this->publishes([
            __DIR__.'/resources/js' => public_path('vendor/ccm/js'),
        ], 'target-groups::js');

        if (! App::runningInConsole()) {
            $this->registerLivewireComponents();
        }
    }

    private function registerLivewireComponents(): void
    {
        Livewire::component('target-group-selector::form', Form::class);
        Livewire::component('target-group-selector::rule', Rule::class);
        Livewire::component('target-group-selector::overview', Overview::class);
        Livewire::component('target-group-selector::create-target-group-fieldset', CreateTargetGroupFieldset::class);
    }

    private function registerEvents()
    {
        $events = $this->app->make(Dispatcher::class);

        $events->listen(TargetGroupExportCreatedEvent::class, CreateExportListener::class);
    }
}

<?php

namespace Sellvation\CCMV2\TargetGroups;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Sellvation\CCMV2\TargetGroups\Facades\TargetGroupSelector;
use Sellvation\CCMV2\TargetGroups\Livewire\Form;
use Sellvation\CCMV2\TargetGroups\Livewire\Overview;
use Sellvation\CCMV2\TargetGroups\Livewire\Rule;

class TargetGroupServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $loader = AliasLoader::getInstance();

        $loader->alias('TargetGroupSelector', TargetGroupSelector::class);
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/views', 'target-group');

        if (! App::runningInConsole()) {
            $this->registerLivewireComponents();
        }
    }

    private function registerLivewireComponents(): void
    {
        Livewire::component('target-group-selector::form', Form::class);
        Livewire::component('target-group-selector::rule', Rule::class);
        Livewire::component('target-group-selector::overview', Overview::class);
    }
}

<?php

namespace Sellvation\CCMV2\CrmCards;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Sellvation\CCMV2\TargetGroups\Livewire\Form;
use Sellvation\CCMV2\TargetGroups\Livewire\Overview;
use Sellvation\CCMV2\TargetGroups\Livewire\Rule;

class CrmCardServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/views', 'crm-cards');

        $this->registerLivewireComponents();
    }

    private function registerLivewireComponents(): void
    {
        Livewire::component('crm-cards::overview-fields', \Sellvation\CCMV2\CrmCards\Livewire\Fields\Overview::class);
        Livewire::component('crm-cards::edit-fields', \Sellvation\CCMV2\CrmCards\Livewire\Fields\Edit::class);
    }
}

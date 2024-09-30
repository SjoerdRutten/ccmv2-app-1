<?php

namespace Sellvation\CCMV2\CrmCards;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class CrmCardServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/views', 'crm-cards');
    }
}

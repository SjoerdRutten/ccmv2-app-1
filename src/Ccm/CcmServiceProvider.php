<?php

namespace Sellvation\CCMV2\Ccm;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Sellvation\CCMV2\Ccm\Components\acitivity_log\Table;
use Sellvation\CCMV2\Ccm\Components\dashboard\QueueCard;
use Sellvation\CCMV2\Ccm\Components\dashboard\ScheduledTasksLogsCard;
use Sellvation\CCMV2\Ccm\Components\forms\CrmFieldsOptions;
use Sellvation\CCMV2\Ccm\Facades\CcmMenu;
use Sellvation\CCMV2\Ccm\Facades\CcmMenuFacade;
use Sellvation\CCMV2\Ccm\Http\Middelware\CcmContextMiddleware;
use Sellvation\CCMV2\Ccm\Livewire\Admin\Customers\Edit;
use Sellvation\CCMV2\Ccm\Livewire\Admin\Customers\Overview;
use Sellvation\CCMV2\Ccm\Livewire\EnvironmentSelector;
use Sellvation\CCMV2\Ccm\Livewire\ModalError;
use Sellvation\CCMV2\Ccm\Livewire\ModalSuccess;
use Sellvation\CCMV2\Ccm\Livewire\Typesense\Collection;

class CcmServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerFacades();
    }

    public function boot(Router $router): void
    {
        Config::set('livewire.layout', 'ccm::layouts.app');

        $this->loadViewsFrom(__DIR__.'/views', 'ccm');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');
        $this->loadJsonTranslationsFrom(__DIR__.'/resources/lang');
        $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'ccm');

        $this->mergeConfigFrom(__DIR__.'/config/ccm.php', 'ccm');

        $this->publishes([
            __DIR__.'/resources/js' => public_path('vendor/ccm/js'),
        ], 'ccm::js');

        $this->publishes([
            __DIR__.'/config/ccm.php' => config_path('ccm.php'),
        ], 'ccm-config');

        $router->pushMiddlewareToGroup('web', CcmContextMiddleware::class);

        if (! App::runningInConsole()) {
            $this->registerLivewireComponents();
            $this->registerBladeComponents();
        }
    }

    private function registerBladeComponents(): void
    {
        Blade::component('ccm::dashboard.queue-card', QueueCard::class);
        Blade::component('ccm::dashboard.scheduled-tasks-logs-card', ScheduledTasksLogsCard::class);
        Blade::component('ccm::activity_log.table', Table::class);
        Blade::component('ccm::forms.crm-fields-options', CrmFieldsOptions::class);
    }

    private function registerLivewireComponents(): void
    {
        Livewire::component('ccm::modal-success', ModalSuccess::class);
        Livewire::component('ccm::modal-error', ModalError::class);
        Livewire::component('ccm::environment-selector', EnvironmentSelector::class);

        Livewire::component('ccm::admin::customers', Overview::class);
        Livewire::component('ccm::admin::customers.edit', Edit::class);
        Livewire::component('ccm::admin::environments', \Sellvation\CCMV2\Ccm\Livewire\Admin\Environments\Overview::class);
        Livewire::component('ccm::admin::environments.edit', \Sellvation\CCMV2\Ccm\Livewire\Admin\Environments\Edit::class);

        Livewire::component('ccm::typesense::collection', Collection::class);
        Livewire::component('ccm::notifications::overview', \Sellvation\CCMV2\Ccm\Livewire\Notifications\Overview::class);
        Livewire::component('ccm::notifications::header', \Sellvation\CCMV2\Ccm\Livewire\Notifications\Header::class);
    }

    private function registerFacades()
    {
        $this->app->bind('ccm-menu', CcmMenu::class);

        $loader = AliasLoader::getInstance();
        $loader->alias('CcmMenu', CcmMenuFacade::class);
    }
}

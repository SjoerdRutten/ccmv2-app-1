<?php

namespace Sellvation\CCMV2\Ccmp;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Sellvation\CCMV2\Ccmp\Console\Commands\ConvertOptinOptoutCommand;
use Sellvation\CCMV2\Ccmp\Console\Commands\MigrateCcmpEnvironment;
use Sellvation\CCMV2\Ccmp\Console\Commands\MigrateCcmpGlobalCommand;
use Sellvation\CCMV2\Ccmp\Facades\CcmpSoapService;
use Sellvation\CCMV2\Ccmp\Facades\CcmpSoapServiceFacade;

class CcmpServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        $this->commands([
            ConvertOptinOptoutCommand::class,
            MigrateCcmpGlobalCommand::class,
            MigrateCcmpEnvironment::class,
        ]);

        $this->registerSchedulableCommands();
        $this->registerFacades();

        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');
        $this->mergeConfigFrom(__DIR__.'/config/ccmp.php', 'ccmp');
        $this->publishes([
            __DIR__.'/config/ccmp.php' => config_path('ccmp.php'),
        ], 'ccmp-config');
    }

    private function registerSchedulableCommands()
    {
        \SchedulableCommands::registerCommand(MigrateCcmpEnvironment::class);
    }

    private function registerFacades(): void
    {
        $this->app->bind('ccmp-soap-service', CcmpSoapService::class);

        $loader = AliasLoader::getInstance();
        $loader->alias('CcmpSoapService', CcmpSoapServiceFacade::class);

    }
}

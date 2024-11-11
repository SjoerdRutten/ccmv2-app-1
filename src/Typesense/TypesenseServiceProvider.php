<?php

namespace Sellvation\CCMV2\Typesense;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Sellvation\CCMV2\Typesense\Console\Commands\TypesenseCheckSchemasCommand;
use Sellvation\CCMV2\Typesense\Facades\Typesense;
use Sellvation\CCMV2\Typesense\Facades\TypesenseFacade;

class TypesenseServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind('typesense', Typesense::class);

        $loader = AliasLoader::getInstance();
        $loader->alias('Typesense', TypesenseFacade::class);

        $this->commands([
            TypesenseCheckSchemasCommand::class,
        ]);
    }

    public function boot(): void {}
}

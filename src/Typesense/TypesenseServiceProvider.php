<?php

namespace Sellvation\CCMV2\Typesense;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Sellvation\CCMV2\Typesense\Facades\TypesenseFacade;

class TypesenseServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $loader = AliasLoader::getInstance();

        $loader->alias('Typesense', TypesenseFacade::class);
    }

    public function boot(): void {}
}

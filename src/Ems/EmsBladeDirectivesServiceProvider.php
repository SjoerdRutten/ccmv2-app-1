<?php

namespace Sellvation\CCMV2\Ems;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class EmsBladeDirectivesServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Blade::directive('emailContent', function ($expression) {
            return "<?php echo emailContent($expression); ?>";
        });
    }
}

<?php

namespace Sellvation\CCMV2\CrmCards;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class CrmCardBladeDirectivesServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Blade::directive('crmCard', function ($expression) {
            if (\Context::has('crmCard')) {
                return "<?php echo Arr::get(\Context::get('crmCard')->data, $expression); ?>";
            }

            return "<?php echo '' ?>";
        });

        Blade::directive('crmCardDate', function ($expression) {
            if (\Context::has('crmCard')) {
                $attributes = explode(',', str_replace(['(', ')', ' ', "'"], '', $expression));
                $field = \Arr::first($attributes);
                $format = \Arr::get($attributes, '1', 'DD-MM-YYYY');

                try {
                    $date = Carbon::parse(Arr::get(\Context::get('crmCard')->data, $field));
                    $date = $date->isoFormat($format);

                    return '<?php echo \''.$date.'\'; ?>';
                } catch (\Exception $e) {

                }
            }

            return "<?php echo '' ?>";
        });
    }
}

<?php

declare(strict_types=1);

use Carbon\Carbon;
use Illuminate\Support\Arr;

if (! function_exists('crmData')) {
    function crmData(string $dataField, $default = null): mixed
    {
        if ($crmCard = \Context::get('crmCard', null)) {
            return Arr::get($crmCard->data, $dataField, $default);
        }

        return $default;
    }
}

if (! function_exists('crmDataDate')) {
    function crmDataDate(string $dataField, ?string $format = null, $default = null, $locale = 'nl_NL'): mixed
    {
        if ($crmCard = \Context::get('crmCard', null)) {
            try {
                $date = Carbon::parse(Arr::get($crmCard->data, $dataField));
                $date->locale($locale);
            } catch (\Exception $e) {
                return $default;
            }

            if ($format) {
                return $date->isoFormat($format);
            }

            return $date;
        }

        return $default;
    }
}

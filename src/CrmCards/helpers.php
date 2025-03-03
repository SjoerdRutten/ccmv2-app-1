<?php

declare(strict_types=1);

if (! function_exists('crmData')) {
    function crmData(string $dataField, $default = null): mixed
    {
        if ($crmCard = \Context::get('crmCard', null)) {
            return Arr::get($crmCard->data, $dataField, $default);
        }

        return $default;
    }
}

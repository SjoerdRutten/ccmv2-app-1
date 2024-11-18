<?php

namespace Sellvation\CCMV2\CrmCards\FieldValidators\Dates;

use Carbon\Carbon;
use Sellvation\CCMV2\CrmCards\FieldValidators\CrmFieldValidator;

class CrmFieldValidatorDateEquals extends CrmFieldValidator
{
    public string $group = 'dates';

    public string $name = 'is gelijk aan';

    public function getRules(\Sellvation\CCMV2\CrmCards\Models\CrmField $crmField, ...$params): array
    {
        $date = Carbon::parse(\Arr::get($params, 'date'))->toDateString();

        return [
            'date',
            'date_equals:'.$date,
        ];
    }

    public function getMessages(...$params): array
    {
        return [
            'date' => 'Waarde moet een datum zijn',
            'date_equals' => 'Waarde moet gelijk zijn aan :date',
        ];
    }
}

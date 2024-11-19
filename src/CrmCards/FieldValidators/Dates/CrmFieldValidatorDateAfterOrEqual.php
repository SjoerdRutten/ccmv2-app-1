<?php

namespace Sellvation\CCMV2\CrmCards\FieldValidators\Dates;

use Carbon\Carbon;
use Sellvation\CCMV2\CrmCards\FieldValidators\CrmFieldValidator;

class CrmFieldValidatorDateAfterOrEqual extends CrmFieldValidator
{
    public string $group = 'dates';

    public string $name = 'is groter dan of gelijk aan';

    public function getRules(\Sellvation\CCMV2\CrmCards\Models\CrmField $crmField, ...$params): array
    {
        $date = Carbon::parse(\Arr::get($params, 'value'))->toDateString();

        return [
            'date',
            'after_or_equal:'.$date,
        ];
    }

    public function getMessages(...$params): array
    {
        return [
            'date' => 'Waarde moet een datum zijn',
            'after_or_equal' => 'Waarde groter dan of gelijk zijn aan :date',
        ];
    }
}

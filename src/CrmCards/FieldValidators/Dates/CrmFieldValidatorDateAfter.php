<?php

namespace Sellvation\CCMV2\CrmCards\FieldValidators\Dates;

use Carbon\Carbon;
use Sellvation\CCMV2\CrmCards\FieldValidators\CrmFieldValidator;

class CrmFieldValidatorDateAfter extends CrmFieldValidator
{
    public string $group = 'dates';

    public string $name = 'is groter dan';

    public function getRules(\Sellvation\CCMV2\CrmCards\Models\CrmField $crmField, ...$params): array
    {
        $date = Carbon::parse(\Arr::get($params, 'date'))->toDateString();

        return [
            'date',
            'after:'.$date,
        ];
    }

    public function getMessages(...$params): array
    {
        return [
            'date' => 'Waarde moet een datum zijn',
            'after' => 'Waarde moet na :date liggen',
        ];
    }
}

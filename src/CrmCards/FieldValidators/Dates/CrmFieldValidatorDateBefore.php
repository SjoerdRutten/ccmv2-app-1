<?php

namespace Sellvation\CCMV2\CrmCards\FieldValidators\Dates;

use Carbon\Carbon;
use Sellvation\CCMV2\CrmCards\FieldValidators\CrmFieldValidator;

class CrmFieldValidatorDateBefore extends CrmFieldValidator
{
    public string $group = 'dates';

    public string $name = 'is kleiner dan';

    public function getRules(\Sellvation\CCMV2\CrmCards\Models\CrmField $crmField, ...$params): array
    {
        $date = Carbon::parse(\Arr::get($params, 'value'))->toDateString();

        return [
            'date',
            'before:'.$date,
        ];
    }

    public function getMessages(...$params): array
    {
        return [
            'date' => 'Waarde moet een datum zijn',
            'before' => 'Waarde moet voor :date liggen',
        ];
    }
}

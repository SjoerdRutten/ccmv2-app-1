<?php

namespace Sellvation\CCMV2\CrmCards\FieldValidators\Characters;

use Sellvation\CCMV2\CrmCards\FieldValidators\CrmFieldValidator;

class CrmFieldValidatorStrLengthGt extends CrmFieldValidator
{
    public string $group = 'characters';

    public string $name = 'is groter of gelijk aan';

    public function getRules(\Sellvation\CCMV2\CrmCards\Models\CrmField $crmField, ...$params): array
    {
        return [
            'string',
            'min:'.\Arr::get($params, 'value', 0),
        ];
    }

    public function getMessages(...$params): array
    {
        return [
            'string' => 'Waarde moet een string zijn',
            'min' => 'De waarde moet uit minimaal :min karakters bestaan',
        ];
    }
}

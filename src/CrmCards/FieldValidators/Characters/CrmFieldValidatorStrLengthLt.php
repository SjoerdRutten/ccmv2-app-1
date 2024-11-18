<?php

namespace Sellvation\CCMV2\CrmCards\FieldValidators\Characters;

use Sellvation\CCMV2\CrmCards\FieldValidators\CrmFieldValidator;

class CrmFieldValidatorStrLengthLt extends CrmFieldValidator
{
    public string $group = 'characters';

    public string $name = 'is kleiner of gelijk aan';

    public function getRules(\Sellvation\CCMV2\CrmCards\Models\CrmField $crmField, ...$params): array
    {
        return [
            'string',
            'max:'.\Arr::get($params, 'length', 0),
        ];
    }

    public function getMessages(...$params): array
    {
        return [
            'string' => 'Waarde moet een string zijn',
            'min' => 'De waarde moet uit maximaal :max karakters bestaan',
        ];
    }
}

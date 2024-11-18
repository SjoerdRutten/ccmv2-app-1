<?php

namespace Sellvation\CCMV2\CrmCards\FieldValidators\Characters;

use Sellvation\CCMV2\CrmCards\FieldValidators\CrmFieldValidator;
use Sellvation\CCMV2\CrmCards\Rules\StringLengthComparisonRule;

class CrmFieldValidatorStrLengthEqual extends CrmFieldValidator
{
    public string $group = 'characters';

    public string $name = 'is gelijk aan';

    public function getRules(\Sellvation\CCMV2\CrmCards\Models\CrmField $crmField, ...$params): array
    {
        return [
            'string',
            new StringLengthComparisonRule('eq', \Arr::get($params, 'length', 0)),
        ];
    }

    public function getMessages(...$params): array
    {
        return [
            'string' => 'Waarde moet een string zijn',
            'size' => 'De waarde moet uit exact :size karakters bestaan',
        ];
    }
}

<?php

namespace Sellvation\CCMV2\CrmCards\FieldValidators\Numbers;

use Sellvation\CCMV2\CrmCards\FieldValidators\CrmFieldValidator;
use Sellvation\CCMV2\CrmCards\Rules\NumberComparisonRule;

class CrmFieldValidatorNumberNotEqual extends CrmFieldValidator
{
    public string $group = 'numbers';

    public string $name = 'is niet gelijk aan';

    public function getRules(\Sellvation\CCMV2\CrmCards\Models\CrmField $crmField, ...$params): array
    {
        return [
            'numeric',
            new NumberComparisonRule('neq', \Arr::get($params, 'value', 0)),
        ];
    }

    public function getMessages(...$params): array
    {
        return [
            'numeric' => 'Waarde moet een getal zijn',
        ];
    }
}

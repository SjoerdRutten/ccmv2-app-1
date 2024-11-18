<?php

namespace Sellvation\CCMV2\CrmCards\FieldValidators\Numbers;

use Closure;
use Sellvation\CCMV2\CrmCards\FieldValidators\CrmFieldValidator;

class CrmFieldValidatorNumberLt extends CrmFieldValidator
{
    public string $group = 'numbers';

    public string $name = 'is kleiner dan';

    public function getRules(\Sellvation\CCMV2\CrmCards\Models\CrmField $crmField, ...$params): array
    {
        return [
            'numeric',
            function (string $attribute, mixed $value, Closure $fail) use ($params) {
                if ((float) $value >= (float) \Arr::get($params, 'value', 0)) {
                    $fail('De waarde moet kleiner zijn dan '.\Arr::get($params, 'value', 0));
                }
            },
        ];
    }

    public function getMessages(...$params): array
    {
        return [
            'numeric' => 'Waarde moet een getal zijn',
        ];
    }
}

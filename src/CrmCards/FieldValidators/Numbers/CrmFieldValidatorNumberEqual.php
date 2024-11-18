<?php

namespace Sellvation\CCMV2\CrmCards\FieldValidators\Numbers;

use Closure;
use Sellvation\CCMV2\CrmCards\FieldValidators\CrmFieldValidator;

class CrmFieldValidatorNumberEqual extends CrmFieldValidator
{
    public string $group = 'numbers';

    public string $name = 'is gelijk aan';

    public function getRules(\Sellvation\CCMV2\CrmCards\Models\CrmField $crmField, ...$params): array
    {
        return [
            'numeric',
            function (string $attribute, mixed $value, Closure $fail) use ($params) {
                if ((float) $value !== (float) \Arr::get($params, 'value', 0)) {
                    $fail('De waarde moet gelijk zijn aan '.\Arr::get($params, 'value', 0));
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

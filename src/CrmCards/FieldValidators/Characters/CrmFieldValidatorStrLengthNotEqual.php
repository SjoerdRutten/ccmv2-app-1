<?php

namespace Sellvation\CCMV2\CrmCards\FieldValidators\Characters;

use Closure;
use Sellvation\CCMV2\CrmCards\FieldValidators\CrmFieldValidator;

class CrmFieldValidatorStrLengthNotEqual extends CrmFieldValidator
{
    public string $group = 'characters';

    public string $name = 'is niet gelijk aan';

    public function getRules(\Sellvation\CCMV2\CrmCards\Models\CrmField $crmField, ...$params): array
    {
        return [
            'string',
            function (string $attribute, mixed $value, Closure $fail) use ($params) {
                if (strlen($value) === (int) \Arr::get($params, 'length', 0)) {
                    $fail('De waarde mag niet uit '.\Arr::get($params, 'length', 0).' karakters bestaan');
                }
            },
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

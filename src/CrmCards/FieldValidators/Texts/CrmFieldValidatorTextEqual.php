<?php

namespace Sellvation\CCMV2\CrmCards\FieldValidators\Texts;

use Closure;
use Sellvation\CCMV2\CrmCards\FieldValidators\CrmFieldValidator;

class CrmFieldValidatorTextEqual extends CrmFieldValidator
{
    public string $group = 'texts';

    public string $name = 'is gelijk aan';

    public function getRules(\Sellvation\CCMV2\CrmCards\Models\CrmField $crmField, ...$params): array
    {
        return [
            'string',
            function (string $attribute, mixed $value, Closure $fail) use ($params) {
                if ((string) $value !== (string) \Arr::get($params, 'value', 0)) {
                    $fail('De waarde moet gelijk zijn aan '.\Arr::get($params, 'value'));
                }
            },
        ];
    }

    public function getMessages(...$params): array
    {
        return [
            'string' => 'Waarde moet een string zijn',
        ];
    }
}

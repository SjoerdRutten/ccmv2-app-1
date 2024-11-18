<?php

namespace Sellvation\CCMV2\CrmCards\FieldValidators\Texts;

use Closure;
use Sellvation\CCMV2\CrmCards\FieldValidators\CrmFieldValidator;

class CrmFieldValidatorTextDoesNotEndWith extends CrmFieldValidator
{
    public string $group = 'texts';

    public string $name = 'eindigt niet met';

    public function getRules(\Sellvation\CCMV2\CrmCards\Models\CrmField $crmField, ...$params): array
    {
        return [
            'string',
            function (string $attribute, mixed $value, Closure $fail) use ($params) {
                if (\Str::endsWith($value, (string) \Arr::get($params, 'value'))) {
                    $fail('De waarde mag niet eindigen met '.\Arr::get($params, 'value'));
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

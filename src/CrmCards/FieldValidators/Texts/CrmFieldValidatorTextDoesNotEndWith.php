<?php

namespace Sellvation\CCMV2\CrmCards\FieldValidators\Texts;

use Sellvation\CCMV2\CrmCards\FieldValidators\CrmFieldValidator;
use Sellvation\CCMV2\CrmCards\Rules\StringComparisonRule;

class CrmFieldValidatorTextDoesNotEndWith extends CrmFieldValidator
{
    public string $group = 'texts';

    public string $name = 'eindigt niet met';

    public function getRules(\Sellvation\CCMV2\CrmCards\Models\CrmField $crmField, ...$params): array
    {
        return [
            'string',
            new StringComparisonRule('dnew', (string) \Arr::get($params, 'value')),
        ];
    }

    public function getMessages(...$params): array
    {
        return [
            'string' => 'Waarde moet een string zijn',
        ];
    }
}

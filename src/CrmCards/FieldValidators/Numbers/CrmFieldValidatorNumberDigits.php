<?php

namespace Sellvation\CCMV2\CrmCards\FieldValidators\Numbers;

use Sellvation\CCMV2\CrmCards\FieldValidators\CrmFieldValidator;

class CrmFieldValidatorNumberDigits extends CrmFieldValidator
{
    public string $group = 'numbers';

    public string $name = 'heeft aantal digits';

    public function getRules(\Sellvation\CCMV2\CrmCards\Models\CrmField $crmField, ...$params): array
    {
        return [
            'integer',
            'digits:'.\Arr::get($params, 'value'),
        ];
    }

    public function getMessages(...$params): array
    {
        return [
            'integer' => 'Waarde moet een geheel getal zijn',
            'digits' => 'Waarde moet uit :digits digits bestaan',
        ];
    }
}

<?php

namespace Sellvation\CCMV2\CrmCards\FieldValidators\Numbers;

use Sellvation\CCMV2\CrmCards\FieldValidators\CrmFieldValidator;

class CrmFieldValidatorNumberInteger extends CrmFieldValidator
{
    public string $group = 'numbers';

    public string $name = 'is een geheel getal';

    public function getRules(\Sellvation\CCMV2\CrmCards\Models\CrmField $crmField, ...$params): array
    {
        return [
            'integer',
        ];
    }

    public function getMessages(...$params): array
    {
        return [
            'numeric' => 'Waarde moet een geheel getal zijn',
        ];
    }
}

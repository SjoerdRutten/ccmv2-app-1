<?php

namespace Sellvation\CCMV2\CrmCards\FieldValidators\Pattern;

use Sellvation\CCMV2\CrmCards\FieldValidators\CrmFieldValidator;

class CrmFieldValidatorPatternEmail extends CrmFieldValidator
{
    public string $group = 'patterns';

    public string $name = 'E-mailadres';

    public bool $hasValue = false;

    public function getRules(\Sellvation\CCMV2\CrmCards\Models\CrmField $crmField, ...$params): array
    {
        return [
            'string',
            'email:rfc,dns',
        ];
    }

    public function getMessages(...$params): array
    {
        return [
            'string' => 'Waarde moet een string zijn',
            'email' => 'Dit is geen geldig e-mailadres',
        ];
    }
}

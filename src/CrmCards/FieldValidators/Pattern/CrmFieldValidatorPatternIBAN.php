<?php

namespace Sellvation\CCMV2\CrmCards\FieldValidators\Pattern;

use Nembie\IbanRule\ValidIban;
use Sellvation\CCMV2\CrmCards\FieldValidators\CrmFieldValidator;

class CrmFieldValidatorPatternIBAN extends CrmFieldValidator
{
    public string $group = 'patterns';

    public string $name = 'IBAN';

    public bool $hasValue = false;

    public function getRules(\Sellvation\CCMV2\CrmCards\Models\CrmField $crmField, ...$params): array
    {
        return [
            new ValidIban,
        ];
    }

    public function getMessages(...$params): array
    {
        return [
        ];
    }
}

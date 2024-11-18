<?php

namespace Sellvation\CCMV2\CrmCards\FieldValidators\Pattern;

use Axlon\PostalCodeValidation\Rules\PostalCode;
use Sellvation\CCMV2\CrmCards\FieldValidators\CrmFieldValidator;

class CrmFieldValidatorPostalcodeBE extends CrmFieldValidator
{
    public string $group = 'patterns';

    public string $name = 'Postcode Belgie';

    public bool $hasValue = false;

    public function getRules(\Sellvation\CCMV2\CrmCards\Models\CrmField $crmField, ...$params): array
    {
        return [
            PostalCode::for('BE'),
        ];
    }

    public function getMessages(...$params): array
    {
        return [
        ];
    }
}

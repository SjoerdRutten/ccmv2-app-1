<?php

namespace Sellvation\CCMV2\CrmCards\FieldValidators\Pattern;

use Sellvation\CCMV2\CrmCards\FieldValidators\CrmFieldValidator;
use Sellvation\CCMV2\CrmCards\Rules\EAN13Rule;

class CrmFieldValidatorPatternEAN extends CrmFieldValidator
{
    public string $group = 'patterns';

    public string $name = 'Europese artikelnummering (EAN13)';

    public bool $hasValue = false;

    public function getRules(\Sellvation\CCMV2\CrmCards\Models\CrmField $crmField, ...$params): array
    {
        return [
            'integer',
            new EAN13Rule,
        ];
    }

    public function getMessages(...$params): array
    {
        return [
            'integer' => 'Waarde mag alleen uit getallen bestaan',
        ];
    }
}

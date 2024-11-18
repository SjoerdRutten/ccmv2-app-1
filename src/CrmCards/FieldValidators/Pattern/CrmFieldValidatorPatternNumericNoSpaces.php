<?php

namespace Sellvation\CCMV2\CrmCards\FieldValidators\Pattern;

use Sellvation\CCMV2\CrmCards\FieldValidators\CrmFieldValidator;
use Sellvation\CCMV2\CrmCards\Rules\PatternRule;

class CrmFieldValidatorPatternNumericNoSpaces extends CrmFieldValidator
{
    public string $group = 'patterns';

    public string $name = 'Numeriek zonder witruimte';

    public bool $hasValue = false;

    public function getRules(\Sellvation\CCMV2\CrmCards\Models\CrmField $crmField, ...$params): array
    {
        return [
            new PatternRule('numericNoSpaces', null),
        ];
    }

    public function getMessages(...$params): array
    {
        return [
        ];
    }
}

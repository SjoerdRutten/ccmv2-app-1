<?php

namespace Sellvation\CCMV2\CrmCards\FieldValidators\Pattern;

use Sellvation\CCMV2\CrmCards\FieldValidators\CrmFieldValidator;
use Sellvation\CCMV2\CrmCards\Rules\PatternRule;

class CrmFieldValidatorPatternPersonName extends CrmFieldValidator
{
    public string $group = 'patterns';

    public string $name = 'Persoonsnaam';

    public bool $hasValue = false;

    public function getRules(\Sellvation\CCMV2\CrmCards\Models\CrmField $crmField, ...$params): array
    {
        return [
            new PatternRule('personName', null),
        ];
    }

    public function getMessages(...$params): array
    {
        return [
        ];
    }
}

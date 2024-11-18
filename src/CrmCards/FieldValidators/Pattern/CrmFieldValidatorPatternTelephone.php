<?php

namespace Sellvation\CCMV2\CrmCards\FieldValidators\Pattern;

use Sellvation\CCMV2\CrmCards\FieldValidators\CrmFieldValidator;
use Sellvation\CCMV2\CrmCards\Rules\PatternRule;

class CrmFieldValidatorPatternTelephone extends CrmFieldValidator
{
    public string $group = 'patterns';

    public string $name = 'Telefoonnummer';

    public bool $hasValue = false;

    public function getRules(\Sellvation\CCMV2\CrmCards\Models\CrmField $crmField, ...$params): array
    {
        return [
            new PatternRule('telephone', null),
        ];
    }

    public function getMessages(...$params): array
    {
        return [
        ];
    }
}

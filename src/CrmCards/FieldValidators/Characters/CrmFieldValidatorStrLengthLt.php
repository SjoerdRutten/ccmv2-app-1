<?php

namespace Sellvation\CCMV2\CrmCards\FieldValidators\Characters;

use Sellvation\CCMV2\CrmCards\FieldValidators\CrmFieldValidator;

class CrmFieldValidatorStrLengthLt extends CrmFieldValidator
{
    public string $group = 'characters';

    public string $name = 'is kleiner of gelijk aan';

    public function getRules($field, ...$params): array
    {
        return [
            'string',
            'max:'.$params[0],
        ];
    }
}

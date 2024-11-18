<?php

namespace Sellvation\CCMV2\CrmCards\FieldValidators\Characters;

use Sellvation\CCMV2\CrmCards\FieldValidators\CrmFieldValidator;

class CrmFieldValidatorStrLengthEqual extends CrmFieldValidator
{
    public string $group = 'characters';

    public string $name = 'is gelijk aan';

    public function getRules($field, ...$params): array
    {
        return [
            'string',
            'min:'.$params[0],
            'max:'.$params[0],
        ];
    }
}

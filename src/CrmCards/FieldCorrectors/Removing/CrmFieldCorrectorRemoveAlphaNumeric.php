<?php

namespace Sellvation\CCMV2\CrmCards\FieldCorrectors\Removing;

use Sellvation\CCMV2\CrmCards\FieldCorrectors\CrmFieldCorrector;

class CrmFieldCorrectorRemoveAlphaNumeric extends CrmFieldCorrector
{
    public string $group = 'removing';

    public string $name = 'Alle alfanumerieke-karakters';

    public function handle($value, ...$params): mixed
    {
        return preg_replace('/[\p{L}\d]/u', '', $value);
    }
}

<?php

namespace Sellvation\CCMV2\CrmCards\FieldCorrectors\Removing;

use Sellvation\CCMV2\CrmCards\FieldCorrectors\CrmFieldCorrector;

class CrmFieldCorrectorRemovenonNonAlphaNumeric extends CrmFieldCorrector
{
    public string $group = 'removing';

    public string $name = 'Alle niet alfanumerieke-karakters';

    public function handle($value, ...$params): mixed
    {
        return preg_replace('/[^\p{L}\d]/u', '', $value);
    }
}

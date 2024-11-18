<?php

namespace Sellvation\CCMV2\CrmCards\FieldCorrectors\Removing;

use Sellvation\CCMV2\CrmCards\FieldCorrectors\CrmFieldCorrector;

class CrmFieldCorrectorRemoveNonNumeric extends CrmFieldCorrector
{
    public string $group = 'removing';

    public string $name = 'Alle niet numerieke karakters';

    public function handle($value, ...$params): mixed
    {
        return preg_replace('/[^\d]/u', '', $value);
    }
}

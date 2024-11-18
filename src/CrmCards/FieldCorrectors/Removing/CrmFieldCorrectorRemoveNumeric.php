<?php

namespace Sellvation\CCMV2\CrmCards\FieldCorrectors\Removing;

use Sellvation\CCMV2\CrmCards\FieldCorrectors\CrmFieldCorrector;

class CrmFieldCorrectorRemoveNumeric extends CrmFieldCorrector
{
    public string $group = 'removing';

    public string $name = 'Alle numerieke karakters';

    public function handle($value, ...$params): mixed
    {
        return preg_replace('/[\d]/u', '', $value);
    }
}

<?php

namespace Sellvation\CCMV2\CrmCards\FieldCorrectors\Removing;

use Sellvation\CCMV2\CrmCards\FieldCorrectors\CrmFieldCorrector;

class CrmFieldCorrectorRemoveAlpha extends CrmFieldCorrector
{
    public string $group = 'removing';

    public string $name = 'Alle alfa-karakters';

    public function handle($value, ...$params): mixed
    {
        return preg_replace('/\p{L}/u', '', $value);
    }
}

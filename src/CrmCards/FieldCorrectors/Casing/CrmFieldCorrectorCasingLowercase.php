<?php

namespace Sellvation\CCMV2\CrmCards\FieldCorrectors\Casing;

use Illuminate\Support\Str;
use Sellvation\CCMV2\CrmCards\FieldCorrectors\CrmFieldCorrector;

class CrmFieldCorrectorCasingLowercase extends CrmFieldCorrector
{
    public string $group = 'casing';

    public string $name = 'Alle letters kleine letters';

    public function handle($value, ...$params): mixed
    {
        return Str::lower($value);
    }
}

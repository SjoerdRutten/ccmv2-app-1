<?php

namespace Sellvation\CCMV2\CrmCards\FieldCorrectors\Casing;

use Illuminate\Support\Str;
use Sellvation\CCMV2\CrmCards\FieldCorrectors\CrmFieldCorrector;

class CrmFieldCorrectorCasingUppercaseFirst extends CrmFieldCorrector
{
    public string $group = 'casing';

    public string $name = 'Eerste letter hoofdletter';

    public function handle($value, ...$params): mixed
    {
        return Str::ucfirst($value);
    }
}

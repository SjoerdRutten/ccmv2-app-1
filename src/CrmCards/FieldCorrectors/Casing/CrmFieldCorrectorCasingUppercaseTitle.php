<?php

namespace Sellvation\CCMV2\CrmCards\FieldCorrectors\Casing;

use Illuminate\Support\Str;
use Sellvation\CCMV2\CrmCards\FieldCorrectors\CrmFieldCorrector;

class CrmFieldCorrectorCasingUppercaseTitle extends CrmFieldCorrector
{
    public string $group = 'casing';

    public string $name = 'Eerste letter van elk woord hoofdletter';

    public function handle($value, ...$params): mixed
    {
        return Str::title($value);
    }
}

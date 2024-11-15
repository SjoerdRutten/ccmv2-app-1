<?php

namespace Sellvation\CCMV2\CrmCards\FieldCorrectors;

use Illuminate\Support\Str;

class CrmFieldCorrectorCasingUppercaseTitle extends CrmFieldCorrector
{
    public string $group = 'casing';

    public string $name = 'Eerste letter van elk woord hoofdletter';

    public function handle($value, ...$params): mixed
    {
        return Str::title($value);
    }
}

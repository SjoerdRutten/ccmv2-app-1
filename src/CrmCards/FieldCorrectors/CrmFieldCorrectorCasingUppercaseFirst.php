<?php

namespace Sellvation\CCMV2\CrmCards\FieldCorrectors;

use Illuminate\Support\Str;

class CrmFieldCorrectorCasingUppercaseFirst extends CrmFieldCorrector
{
    public string $group = 'casing';

    public string $name = 'Eerste letter hoofdletter';

    public function handle($value, ...$params): mixed
    {
        return Str::ucfirst($value);
    }
}

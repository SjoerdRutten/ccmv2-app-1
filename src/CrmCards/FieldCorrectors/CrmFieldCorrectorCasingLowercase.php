<?php

namespace Sellvation\CCMV2\CrmCards\FieldCorrectors;

use Illuminate\Support\Str;

class CrmFieldCorrectorCasingLowercase extends CrmFieldCorrector
{
    public string $group = 'casing';

    public string $name = 'Alle letters kleine letters';

    public function handle($value, ...$params): mixed
    {
        return Str::lower($value);
    }
}

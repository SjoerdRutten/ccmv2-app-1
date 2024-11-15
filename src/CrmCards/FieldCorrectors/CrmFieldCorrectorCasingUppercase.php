<?php

namespace Sellvation\CCMV2\CrmCards\FieldCorrectors;

use Illuminate\Support\Str;

class CrmFieldCorrectorCasingUppercase extends CrmFieldCorrector
{
    public string $group = 'casing';

    public string $name = 'Alle letters hoofdletters    ';

    public function handle($value, ...$params): mixed
    {
        return Str::upper($value);
    }
}

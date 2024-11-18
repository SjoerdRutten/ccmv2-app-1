<?php

namespace Sellvation\CCMV2\CrmCards\FieldCorrectors\Casing;

use Illuminate\Support\Str;
use Sellvation\CCMV2\CrmCards\FieldCorrectors\CrmFieldCorrector;

class CrmFieldCorrectorCasingUppercase extends CrmFieldCorrector
{
    public string $group = 'casing';

    public string $name = 'Alle letters hoofdletters    ';

    public function handle($value, ...$params): mixed
    {
        return Str::upper($value);
    }
}

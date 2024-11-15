<?php

namespace Sellvation\CCMV2\CrmCards\FieldCorrectors;

use Illuminate\Support\Str;

class CrmFieldCorrectorRemoveRTrim extends CrmFieldCorrector
{
    public string $group = 'removing';

    public string $name = 'Alle witruimte aan het eind';

    public function handle($value, ...$params): mixed
    {
        return Str::rtrim($value);
    }
}

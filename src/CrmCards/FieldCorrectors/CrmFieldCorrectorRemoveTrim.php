<?php

namespace Sellvation\CCMV2\CrmCards\FieldCorrectors;

use Illuminate\Support\Str;

class CrmFieldCorrectorRemoveTrim extends CrmFieldCorrector
{
    public string $group = 'removing';

    public string $name = 'Alle witruimte aan het begin en het eind';

    public function handle($value, ...$params): mixed
    {
        return Str::trim($value);
    }
}

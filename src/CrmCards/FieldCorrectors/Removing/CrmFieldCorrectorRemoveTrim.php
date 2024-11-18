<?php

namespace Sellvation\CCMV2\CrmCards\FieldCorrectors\Removing;

use Illuminate\Support\Str;
use Sellvation\CCMV2\CrmCards\FieldCorrectors\CrmFieldCorrector;

class CrmFieldCorrectorRemoveTrim extends CrmFieldCorrector
{
    public string $group = 'removing';

    public string $name = 'Alle witruimte aan het begin en het eind';

    public function handle($value, ...$params): mixed
    {
        return Str::trim($value);
    }
}

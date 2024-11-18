<?php

namespace Sellvation\CCMV2\CrmCards\FieldCorrectors\Removing;

use Illuminate\Support\Str;
use Sellvation\CCMV2\CrmCards\FieldCorrectors\CrmFieldCorrector;

class CrmFieldCorrectorRemoveRTrim extends CrmFieldCorrector
{
    public string $group = 'removing';

    public string $name = 'Alle witruimte aan het eind';

    public function handle($value, ...$params): mixed
    {
        return Str::rtrim($value);
    }
}

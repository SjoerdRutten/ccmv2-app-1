<?php

namespace Sellvation\CCMV2\CrmCards\FieldCorrectors;

use Illuminate\Support\Str;

class CrmFieldCorrectorRemoveSquish extends CrmFieldCorrector
{
    public string $group = 'removing';

    public string $name = 'Alle overbodige witruimte';

    public function handle($value, ...$params): mixed
    {
        return Str::squish($value);
    }
}

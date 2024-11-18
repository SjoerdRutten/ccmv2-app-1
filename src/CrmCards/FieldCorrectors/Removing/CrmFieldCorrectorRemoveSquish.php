<?php

namespace Sellvation\CCMV2\CrmCards\FieldCorrectors\Removing;

use Illuminate\Support\Str;
use Sellvation\CCMV2\CrmCards\FieldCorrectors\CrmFieldCorrector;

class CrmFieldCorrectorRemoveSquish extends CrmFieldCorrector
{
    public string $group = 'removing';

    public string $name = 'Alle overbodige witruimte';

    public function handle($value, ...$params): mixed
    {
        return Str::squish($value);
    }
}

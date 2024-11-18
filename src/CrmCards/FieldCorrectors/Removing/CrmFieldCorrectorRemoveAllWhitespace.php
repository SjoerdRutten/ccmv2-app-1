<?php

namespace Sellvation\CCMV2\CrmCards\FieldCorrectors\Removing;

use Illuminate\Support\Str;
use Sellvation\CCMV2\CrmCards\FieldCorrectors\CrmFieldCorrector;

class CrmFieldCorrectorRemoveAllWhitespace extends CrmFieldCorrector
{
    public string $group = 'removing';

    public string $name = 'Verwijder alle witruimte';

    public function handle($value, ...$params): mixed
    {
        return Str::replace([' ', "\t"], '', $value);
    }
}

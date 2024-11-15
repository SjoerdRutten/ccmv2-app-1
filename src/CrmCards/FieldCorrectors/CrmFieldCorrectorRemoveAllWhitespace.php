<?php

namespace Sellvation\CCMV2\CrmCards\FieldCorrectors;

use Illuminate\Support\Str;

class CrmFieldCorrectorRemoveAllWhitespace extends CrmFieldCorrector
{
    public string $group = 'removing';

    public string $name = 'Verwijder alle witruimte';

    public function handle($value, ...$params): mixed
    {
        return Str::replace([' ', "\t"], '', $value);
    }
}

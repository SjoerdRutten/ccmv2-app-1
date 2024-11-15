<?php

namespace Sellvation\CCMV2\CrmCards\FieldCorrectors;

use Illuminate\Support\Str;

class CrmFieldCorrectorRemoveLTrim extends CrmFieldCorrector
{
    public string $group = 'removing';

    public string $name = 'Alle witruimte aan het begin';

    public function handle($value, ...$params): mixed
    {
        return Str::ltrim($value);
    }
}

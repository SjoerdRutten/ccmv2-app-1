<?php

namespace Sellvation\CCMV2\CrmCards\FieldCorrectors\Removing;

use Illuminate\Support\Str;
use Sellvation\CCMV2\CrmCards\FieldCorrectors\CrmFieldCorrector;

class CrmFieldCorrectorRemoveLTrim extends CrmFieldCorrector
{
    public string $group = 'removing';

    public string $name = 'Alle witruimte aan het begin';

    public function handle($value, ...$params): mixed
    {
        return Str::ltrim($value);
    }
}

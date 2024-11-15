<?php

namespace Sellvation\CCMV2\CrmCards\FieldCorrectors;

class CrmFieldCorrectorRemoveNonAlpha extends CrmFieldCorrector
{
    public string $group = 'removing';

    public string $name = 'Alle niet alfa-karakters';

    public function handle($value, ...$params): mixed
    {
        return preg_replace('/[^\p{L}]/u', '', $value);
    }
}

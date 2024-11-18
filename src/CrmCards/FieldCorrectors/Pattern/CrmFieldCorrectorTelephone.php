<?php

namespace Sellvation\CCMV2\CrmCards\FieldCorrectors\Pattern;

use Illuminate\Support\Str;
use Sellvation\CCMV2\CrmCards\FieldCorrectors\CrmFieldCorrector;

class CrmFieldCorrectorTelephone extends CrmFieldCorrector
{
    public string $group = 'pattern';

    public string $name = 'Telefoonnumer';

    public ?string $pattern = '^((?:\+|00)(?:[1-9][0-9]{0,3}\s|[1-9][0-9]))(.*)$';

    public function handle($value, ...$params): mixed
    {
        if ($matches = $this->matchRegex($value)) {

            $cc = \Arr::get($matches, 1);
            $cc = Str::replace('00', '+', $cc);

            return Str::replace(' ', '', $cc.\Arr::get($matches, 2));
        }

        return false;
    }
}

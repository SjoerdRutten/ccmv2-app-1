<?php

namespace Sellvation\CCMV2\CrmCards\FieldCorrectors;

use Illuminate\Support\Str;

class CrmFieldCorrectorZipcodeNl extends CrmFieldCorrectorPersonName
{
    public string $group = 'pattern';

    public string $name = 'Postcode Nederland';

    public ?string $pattern = '^.*((?:\s*[0-9]{1}){4}\s*).*((?:\s*[a-z]{1}){2}\s*)$';

    public function handle($value): mixed
    {
        $value = Str::replace(' ', '', $value);

        if ($matches = $this->matchRegex($value)) {
            return \Arr::get($matches, 1).' '.Str::upper(\Arr::get($matches, 2));
        }

        return false;
    }
}

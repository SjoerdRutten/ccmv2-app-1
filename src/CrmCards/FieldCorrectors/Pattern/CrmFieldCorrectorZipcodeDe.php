<?php

namespace Sellvation\CCMV2\CrmCards\FieldCorrectors\Pattern;

use Illuminate\Support\Str;

class CrmFieldCorrectorZipcodeDe extends CrmFieldCorrectorPersonName
{
    public string $group = 'pattern';

    public string $name = 'Postcode Duitsland';

    public ?string $pattern = '^.*((?:\s*[0-9]{1}){5}\s*).*$';

    public function handle($value, ...$params): mixed
    {
        $value = Str::replace(' ', '', $value);

        if ($matches = $this->matchRegex($value)) {
            return \Arr::get($matches, 1);
        }

        return false;
    }
}

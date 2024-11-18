<?php

namespace Sellvation\CCMV2\CrmCards\FieldCorrectors\Pattern;

use Illuminate\Support\Str;
use Sellvation\CCMV2\CrmCards\FieldCorrectors\CrmFieldCorrector;

class CrmFieldCorrectorEmail extends CrmFieldCorrector
{
    public string $group = 'pattern';

    public string $name = 'E-mailadres';

    public ?string $pattern = '^[a-z0-9\s!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9\s!#$%&\'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9\s](?:[a-z0-9-\s]*[a-z0-9\s])?\.)+[a-z0-9\s](?:[a-z0-9-\s]*[a-z0-9\s])+$';

    public function handle($value, ...$params): mixed
    {
        if ($matches = $this->matchRegex($value)) {
            return Str::lower(\Arr::get($matches, 0));
        }

        return false;
    }
}

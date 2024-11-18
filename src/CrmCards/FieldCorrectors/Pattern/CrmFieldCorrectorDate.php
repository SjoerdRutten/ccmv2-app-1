<?php

namespace Sellvation\CCMV2\CrmCards\FieldCorrectors\Pattern;

use Carbon\Carbon;
use Sellvation\CCMV2\CrmCards\FieldCorrectors\CrmFieldCorrector;

class CrmFieldCorrectorDate extends CrmFieldCorrector
{
    public string $group = 'pattern';

    public string $name = 'Datum en tijd';

    public ?string $pattern = '^[\p{L}\s\d\-\+\:\\/\\\\]+$';

    public function handle($value, ...$params): mixed
    {
        if ($matches = $this->matchRegex($value)) {
            $date = \Arr::get($matches, 0);

            try {
                return Carbon::parse($date);

            } catch (\Exception $e) {
            }

            return $date;
        }

        return false;
    }
}

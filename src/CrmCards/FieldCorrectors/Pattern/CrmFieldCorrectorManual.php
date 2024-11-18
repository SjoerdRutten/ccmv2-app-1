<?php

namespace Sellvation\CCMV2\CrmCards\FieldCorrectors\Pattern;

use Sellvation\CCMV2\CrmCards\FieldCorrectors\CrmFieldCorrector;

class CrmFieldCorrectorManual extends CrmFieldCorrector
{
    public string $group = 'pattern';

    public string $name = 'Handmatige invoer van patroon';

    public function handle($value, ...$params): mixed
    {
        $this->pattern = \Arr::get($params, '0.regex');

        try {
            if ($matches = $this->matchRegex($value)) {

                $replacePattern = \Arr::get($params, '0.replacePattern');

                for ($i = 1; $i < count($matches); $i++) {
                    $replacePattern = \Str::replace('[placeholder:'.$i.']', $matches[$i], $replacePattern);
                }

                $replacePattern = preg_replace('/\[placeholder:\d+\]/', '', $replacePattern);

                return $replacePattern;
            }
        } catch (\Exception $e) {
            return false;
        }

        return false;
    }
}

<?php

namespace Sellvation\CCMV2\CrmCards\FieldCorrectors\Removing;

use Sellvation\CCMV2\CrmCards\FieldCorrectors\CrmFieldCorrector;

class CrmFieldCorrectorRemoveNonCharacterList extends CrmFieldCorrector
{
    public string $group = 'removing';

    public string $name = 'Alle karakters niet in opgegeven lijst';

    public function handle($value, ...$params): mixed
    {
        $characterList = \Arr::get($params, '0.characterlist');

        return preg_replace('/[^'.preg_quote($characterList, '/').']/u', '', $value);
    }
}

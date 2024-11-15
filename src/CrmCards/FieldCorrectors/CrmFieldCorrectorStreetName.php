<?php

namespace Sellvation\CCMV2\CrmCards\FieldCorrectors;

class CrmFieldCorrectorStreetName extends CrmFieldCorrectorPersonName
{
    public string $group = 'pattern';

    public string $name = 'Straatnaam';
}

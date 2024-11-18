<?php

namespace Sellvation\CCMV2\CrmCards\FieldValidators;

use Sellvation\CCMV2\CrmCards\Models\CrmField;

abstract class CrmFieldValidator
{
    public string $group;

    public string $name;

    abstract public function getRules(CrmField $crmField, ...$params): array;

    public function getMessages(...$params): array
    {
        return [];
    }
}

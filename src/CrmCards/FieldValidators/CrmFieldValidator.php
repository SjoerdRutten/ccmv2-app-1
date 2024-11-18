<?php

namespace Sellvation\CCMV2\CrmCards\FieldValidators;

use Sellvation\CCMV2\CrmCards\Models\CrmField;

abstract class CrmFieldValidator
{
    public string $group;

    public string $name;

    public bool $hasValue = true;

    abstract public function getRules(CrmField $crmField, ...$params): array;

    public function getMessages(...$params): array
    {
        return [];
    }
}

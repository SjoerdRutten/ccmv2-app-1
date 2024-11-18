<?php

namespace Sellvation\CCMV2\CrmCards\FieldValidators;

abstract class CrmFieldValidator
{
    public string $group;

    public string $name;

    protected string $message;

    abstract public function getRules($field, ...$params): array;
}

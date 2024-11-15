<?php

namespace Sellvation\CCMV2\CrmCards\FieldCorrectors;

abstract class CrmFieldCorrector
{
    public string $group = '';

    public string $name = '';

    protected ?string $pattern = null;

    public function __construct() {}

    abstract public function handle(mixed $value): mixed;

    protected function matchRegex($value): bool|array
    {
        $value = trim($value);

        $matches = [];
        $result = preg_match('/'.$this->pattern.'/ui', trim($value), $matches);

        return $result === false ? false : $matches;
    }
}

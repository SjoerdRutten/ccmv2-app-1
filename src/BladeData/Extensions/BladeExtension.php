<?php

namespace Sellvation\CCMV2\BladeData\Extensions;

abstract class BladeExtension
{
    public bool $showCMS = true;

    public bool $showEMS = true;

    abstract public function addData(array $data): array;

    abstract public function getVariables(): array;
}

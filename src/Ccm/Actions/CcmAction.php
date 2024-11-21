<?php

namespace Sellvation\CCMV2\Ccm\Actions;

abstract class CcmAction
{
    public string $name = '';

    public string $group = '';

    abstract public function handle(): void;
}

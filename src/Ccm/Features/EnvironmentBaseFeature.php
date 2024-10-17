<?php

namespace Sellvation\CCMV2\Ccm\Features;

use Sellvation\CCMV2\Environments\Models\Environment;

abstract class EnvironmentBaseFeature
{
    public function resolve(Environment $environment): mixed
    {
        return $environment->hasFeature(static::class);
    }
}

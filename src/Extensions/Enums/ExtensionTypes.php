<?php

namespace Sellvation\CCMV2\Extensions\Enums;

enum ExtensionTypes
{
    case JOB;

    public function name(): string
    {
        return match ($this) {
            self::JOB => 'Job',
        };
    }
}

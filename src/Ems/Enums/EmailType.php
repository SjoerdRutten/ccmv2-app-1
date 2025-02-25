<?php

namespace Sellvation\CCMV2\Ems\Enums;

enum EmailType: string
{
    case TRANSACTIONAL = 'transactional';
    case SERVICE = 'service';

    case MARKETING = 'marketing';

    public function name(): string
    {
        return match ($this) {
            self::TRANSACTIONAL => 'Transactionele mail',
            self::SERVICE => 'Service mail',
            self::MARKETING => 'Marketing mail',
        };
    }
}

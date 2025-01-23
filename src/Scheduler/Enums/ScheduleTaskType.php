<?php

namespace Sellvation\CCMV2\Scheduler\Enums;

enum ScheduleTaskType: string
{
    case EXTENSION = 'extension';
    case SET_VALUE = 'set_value';

    public function name(): string
    {
        return match ($this) {
            self::EXTENSION => 'Systeemextensie uitvoeren',
            self::SET_VALUE => 'Waarden in CRM-veld plaatsen',
        };
    }
}

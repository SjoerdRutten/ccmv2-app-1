<?php

namespace Sellvation\CCMV2\Scheduler\Enums;

enum ScheduleIntervals
{
    case everySecond;
    case everyTwoSeconds;
    case everyThreeSeconds;
    case everyFourSeconds;
    case everyFiveSeconds;
    case everyTenSeconds;
    case everyFifteenSeconds;
    case everyThirtySeconds;
    case everyMinute;
    case everyTwoMinutes;
    case everyThreeMinutes;
    case everyFourMinutes;
    case everyFiveMinutes;
    case everyTenMinutes;
    case everyFifteenMinutes;
    case everyThirtyMinutes;
    case hourly;
    case everyTwoHours;
    case everyThreeHours;
    case everyFourHours;
    case everySixHours;
    case everyOddHours;
    case dailyAt;
    case weeklyOn;
    case monthlyOn;
    case yearlyOn;

    public function name(): string
    {
        return match ($this) {
            self::everySecond => 'Iedere seconde',
            self::everyTwoSeconds => 'Iedere 2 seconde',
            self::everyThreeSeconds => 'Iedere 3 seconde',
            self::everyFourSeconds => 'Iedere 4 seconde',
            self::everyFiveSeconds => 'Iedere 5 seconde',
            self::everyTenSeconds => 'Iedere 10 seconde',
            self::everyFifteenSeconds => 'Iedere 15 seconde',
            self::everyThirtySeconds => 'Iedere 30 seconde',
            self::everyMinute => 'Iedere minuut',
            self::everyTwoMinutes => 'Iedere 2 minuten',
            self::everyThreeMinutes => 'Iedere 3 minuten',
            self::everyFourMinutes => 'Iedere 4 minuten',
            self::everyFiveMinutes => 'Iedere 5 minuten',
            self::everyTenMinutes => 'Iedere 10 minuten',
            self::everyFifteenMinutes => 'Iedere 15 minuten',
            self::everyThirtyMinutes => 'Iedere 30 minuten',
            self::hourly => 'Ieder uur',
            self::everyTwoHours => 'Iedere 2 uur',
            self::everyThreeHours => 'Iedere 3 uur',
            self::everyFourHours => 'Iedere 4 uur',
            self::everySixHours => 'Iedere 6 uur',
            self::everyOddHours => 'Even uren',
            self::dailyAt => 'Iedere dag op..',
            self::weeklyOn => 'Iedere week op..',
            self::monthlyOn => 'Iedere maand op..',
            self::yearlyOn => 'Iedere jaar op..',
        };
    }
}

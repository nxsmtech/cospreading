<?php

namespace App\Enums;

enum RiskLevel
{
    case NO_RISK;
    case LOW;
    case MEDIUM;
    case HIGH;
    case CRITICAL;

    public const RISK_LEVELS = [
        1 => self::NO_RISK,
        2 => self::LOW,
        3 => self::MEDIUM,
        4 => self::HIGH,
        5 => self::CRITICAL,
    ];

    public function level(): string
    {
        return match ($this) {
            self::NO_RISK => 'No risk',
            self::LOW => 'Low',
            self::MEDIUM => 'Medium',
            self::HIGH => 'High',
            self::CRITICAL => 'Critical',
        };
    }
}

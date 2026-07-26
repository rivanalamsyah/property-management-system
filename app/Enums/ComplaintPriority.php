<?php

namespace App\Enums;

enum ComplaintPriority: string
{
    case LOW = 'low';
    case NORMAL = 'normal';
    case HIGH = 'high';
    case CRITICAL = 'critical';
    case EMERGENCY = 'emergency';

    public function label(): string
    {
        return match ($this) {
            self::LOW => 'Low',
            self::NORMAL => 'Normal',
            self::HIGH => 'High Priority',
            self::CRITICAL => 'Critical',
            self::EMERGENCY => 'Emergency!',
        };
    }
}

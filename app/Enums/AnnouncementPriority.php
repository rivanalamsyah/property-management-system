<?php

namespace App\Enums;

enum AnnouncementPriority: string
{
    case LOW = 'low';
    case NORMAL = 'normal';
    case IMPORTANT = 'important';
    case HIGH = 'high';
    case EMERGENCY = 'emergency';

    public function label(): string
    {
        return match ($this) {
            self::LOW => 'Low priority',
            self::NORMAL => 'Normal Info',
            self::IMPORTANT => 'Important Info',
            self::HIGH => 'High Warning',
            self::EMERGENCY => 'Emergency Alert!',
        };
    }
}

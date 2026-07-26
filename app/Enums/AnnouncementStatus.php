<?php

namespace App\Enums;

enum AnnouncementStatus: string
{
    case DRAFT = 'draft';
    case SCHEDULED = 'scheduled';
    case PUBLISHED = 'published';
    case EXPIRED = 'expired';
    case ARCHIVED = 'archived';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::SCHEDULED => 'Scheduled Release',
            self::PUBLISHED => 'Published Alert',
            self::EXPIRED => 'Expired Alert',
            self::ARCHIVED => 'Archived Alert',
            self::CANCELLED => 'Cancelled Alert',
        };
    }
}

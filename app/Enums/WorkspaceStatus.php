<?php

namespace App\Enums;

enum WorkspaceStatus: string
{
    case PENDING = 'pending';
    case TRIAL = 'trial';
    case ACTIVE = 'active';
    case SUSPENDED = 'suspended';
    case BLOCKED = 'blocked';
    case ARCHIVED = 'archived';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending Onboarding',
            self::TRIAL => 'Trial',
            self::ACTIVE => 'Active',
            self::SUSPENDED => 'Suspended',
            self::BLOCKED => 'Blocked',
            self::ARCHIVED => 'Archived',
        };
    }
}

<?php

namespace App\Enums;

enum ContractStatus: string
{
    case DRAFT = 'draft';
    case PENDING_APPROVAL = 'pending_approval';
    case ACTIVE = 'active';
    case EXPIRING_SOON = 'expiring_soon';
    case RENEWED = 'renewed';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
    case TERMINATED = 'terminated';
    case EXPIRED = 'expired';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft Agreement',
            self::PENDING_APPROVAL => 'Pending Approval',
            self::ACTIVE => 'Active Contract',
            self::EXPIRING_SOON => 'Expiring Soon',
            self::RENEWED => 'Renewed (Archived Version)',
            self::COMPLETED => 'Completed (Graceful Exit)',
            self::CANCELLED => 'Cancelled',
            self::TERMINATED => 'Terminated (Broke Lease)',
            self::EXPIRED => 'Expired',
        };
    }
}

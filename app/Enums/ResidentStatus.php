<?php

namespace App\Enums;

enum ResidentStatus: string
{
    case PENDING = 'pending';
    case RESERVED = 'reserved';
    case ACTIVE = 'active';
    case LATE_PAYMENT = 'late_payment';
    case MOVING_OUT = 'moving_out';
    case FORMER = 'former';
    case BLACKLISTED = 'blacklisted';
    case INACTIVE = 'inactive';

    /**
     * Get label values for statuses.
     */
    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending Review',
            self::RESERVED => 'Reserved',
            self::ACTIVE => 'Active Resident',
            self::LATE_PAYMENT => 'Late Payment Warning',
            self::MOVING_OUT => 'Moving Out Schedule',
            self::FORMER => 'Former Tenant (Checked Out)',
            self::BLACKLISTED => 'Blacklisted',
            self::INACTIVE => 'Inactive Account',
        };
    }
}

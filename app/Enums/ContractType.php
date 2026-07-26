<?php

namespace App\Enums;

enum ContractType: string
{
    case MONTHLY = 'monthly';
    case QUARTERLY = 'quarterly';
    case SEMI_ANNUAL = 'semi_annual';
    case ANNUAL = 'annual';
    case CUSTOM = 'custom';

    public function label(): string
    {
        return match ($this) {
            self::MONTHLY => 'Monthly Rental',
            self::QUARTERLY => 'Quarterly Rental',
            self::SEMI_ANNUAL => 'Semi-Annual Rental',
            self::ANNUAL => 'Annual Rental',
            self::CUSTOM => 'Custom Duration Rental',
        };
    }
}

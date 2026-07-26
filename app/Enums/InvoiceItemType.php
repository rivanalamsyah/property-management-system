<?php

namespace App\Enums;

enum InvoiceItemType: string
{
    case MONTHLY_RENT = 'monthly_rent';
    case ELECTRICITY = 'electricity';
    case WATER = 'water';
    case INTERNET = 'internet';
    case PARKING = 'parking';
    case LAUNDRY = 'laundry';
    case CLEANING = 'cleaning';
    case MAINTENANCE = 'maintenance';
    case ADDITIONAL = 'additional';
    case SECURITY_DEPOSIT = 'security_deposit';
    case PENALTY = 'penalty';
    case MANUAL = 'manual';

    public function label(): string
    {
        return match ($this) {
            self::MONTHLY_RENT => 'Monthly Room Lease Rent',
            self::ELECTRICITY => 'Electricity Token Fee',
            self::WATER => 'Water Utility Fee',
            self::INTERNET => 'High-Speed Internet connection',
            self::PARKING => 'Parking Lot Allocation Fee',
            self::LAUNDRY => 'Laundry service',
            self::CLEANING => 'Room Cleaning service',
            self::MAINTENANCE => 'Maintenance support',
            self::ADDITIONAL => 'Additional Charges',
            self::SECURITY_DEPOSIT => 'Refundable Security Deposit',
            self::PENALTY => 'Overdue Late Payment Penalty',
            self::MANUAL => 'Manual administrative fee',
        };
    }
}

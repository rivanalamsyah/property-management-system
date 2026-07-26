<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case PENDING = 'pending';
    case WAITING_VERIFICATION = 'waiting_verification';
    case VERIFIED = 'verified';
    case COMPLETED = 'completed';
    case FAILED = 'failed';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Payment Pending',
            self::WAITING_VERIFICATION => 'Waiting Verification',
            self::VERIFIED => 'Payment Verified',
            self::COMPLETED => 'Completed',
            self::FAILED => 'Payment Failed',
            self::CANCELLED => 'Payment Cancelled',
        };
    }
}

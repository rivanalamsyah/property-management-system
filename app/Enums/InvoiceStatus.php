<?php

namespace App\Enums;

enum InvoiceStatus: string
{
    case DRAFT = 'draft';
    case PENDING = 'pending';
    case SENT = 'sent';
    case VIEWED = 'viewed';
    case PARTIALLY_PAID = 'partially_paid';
    case PAID = 'paid';
    case OVERDUE = 'overdue';
    case CANCELLED = 'cancelled';
    case VOIDED = 'voided';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft Invoice',
            self::PENDING => 'Pending Payment',
            self::SENT => 'Invoice Sent',
            self::VIEWED => 'Invoice Viewed',
            self::PARTIALLY_PAID => 'Partially Paid',
            self::PAID => 'Invoice Paid',
            self::OVERDUE => 'Invoice Overdue',
            self::CANCELLED => 'Cancelled',
            self::VOIDED => 'Voided',
        };
    }
}

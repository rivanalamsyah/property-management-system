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
            self::DRAFT          => 'Draft Tagihan',
            self::PENDING        => 'Menunggu Pembayaran',
            self::SENT           => 'Tagihan Dikirim',
            self::VIEWED         => 'Tagihan Dibuka',
            self::PARTIALLY_PAID => 'Dibayar Sebagian',
            self::PAID           => 'Lunas',
            self::OVERDUE        => 'Jatuh Tempo',
            self::CANCELLED      => 'Dibatalkan',
            self::VOIDED         => 'Dibatalkan (Void)',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::DRAFT          => 'bg-slate-100 text-slate-700',
            self::PENDING        => 'bg-amber-100 text-amber-700',
            self::SENT           => 'bg-blue-100 text-blue-700',
            self::VIEWED         => 'bg-indigo-100 text-indigo-700',
            self::PARTIALLY_PAID => 'bg-orange-100 text-orange-700',
            self::PAID           => 'bg-emerald-100 text-emerald-700',
            self::OVERDUE        => 'bg-rose-100 text-rose-700',
            self::CANCELLED      => 'bg-slate-100 text-slate-500',
            self::VOIDED         => 'bg-slate-100 text-slate-400',
        };
    }

    public function dot(): string
    {
        return match ($this) {
            self::DRAFT          => 'bg-slate-400',
            self::PENDING        => 'bg-amber-500',
            self::SENT           => 'bg-blue-500',
            self::VIEWED         => 'bg-indigo-500',
            self::PARTIALLY_PAID => 'bg-orange-500',
            self::PAID           => 'bg-emerald-500',
            self::OVERDUE        => 'bg-rose-500',
            self::CANCELLED      => 'bg-slate-300',
            self::VOIDED         => 'bg-slate-200',
        };
    }
}

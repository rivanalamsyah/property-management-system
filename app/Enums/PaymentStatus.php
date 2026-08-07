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
            self::PENDING              => 'Menunggu',
            self::WAITING_VERIFICATION => 'Menunggu Verifikasi',
            self::VERIFIED             => 'Terverifikasi',
            self::COMPLETED            => 'Selesai',
            self::FAILED               => 'Gagal',
            self::CANCELLED            => 'Dibatalkan',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PENDING              => 'bg-slate-100 text-slate-700',
            self::WAITING_VERIFICATION => 'bg-amber-100 text-amber-700',
            self::VERIFIED             => 'bg-blue-100 text-blue-700',
            self::COMPLETED            => 'bg-emerald-100 text-emerald-700',
            self::FAILED               => 'bg-rose-100 text-rose-700',
            self::CANCELLED            => 'bg-slate-100 text-slate-400',
        };
    }

    public function dot(): string
    {
        return match ($this) {
            self::PENDING              => 'bg-slate-400',
            self::WAITING_VERIFICATION => 'bg-amber-500',
            self::VERIFIED             => 'bg-blue-500',
            self::COMPLETED            => 'bg-emerald-500',
            self::FAILED               => 'bg-rose-500',
            self::CANCELLED            => 'bg-slate-300',
        };
    }
}

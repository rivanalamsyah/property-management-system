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
            self::DRAFT            => 'Draft Kontrak',
            self::PENDING_APPROVAL => 'Menunggu Persetujuan',
            self::ACTIVE           => 'Kontrak Aktif',
            self::EXPIRING_SOON    => 'Segera Berakhir',
            self::RENEWED          => 'Diperbarui',
            self::COMPLETED        => 'Selesai',
            self::CANCELLED        => 'Dibatalkan',
            self::TERMINATED       => 'Diputus',
            self::EXPIRED          => 'Kedaluwarsa',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::DRAFT            => 'bg-slate-100 text-slate-700',
            self::PENDING_APPROVAL => 'bg-amber-100 text-amber-700',
            self::ACTIVE           => 'bg-emerald-100 text-emerald-700',
            self::EXPIRING_SOON    => 'bg-orange-100 text-orange-700',
            self::RENEWED          => 'bg-blue-100 text-blue-700',
            self::COMPLETED        => 'bg-indigo-100 text-indigo-700',
            self::CANCELLED        => 'bg-slate-100 text-slate-500',
            self::TERMINATED       => 'bg-rose-100 text-rose-700',
            self::EXPIRED          => 'bg-slate-100 text-slate-400',
        };
    }

    public function dot(): string
    {
        return match ($this) {
            self::DRAFT            => 'bg-slate-400',
            self::PENDING_APPROVAL => 'bg-amber-500',
            self::ACTIVE           => 'bg-emerald-500',
            self::EXPIRING_SOON    => 'bg-orange-500',
            self::RENEWED          => 'bg-blue-500',
            self::COMPLETED        => 'bg-indigo-500',
            self::CANCELLED        => 'bg-slate-300',
            self::TERMINATED       => 'bg-rose-500',
            self::EXPIRED          => 'bg-slate-200',
        };
    }
}

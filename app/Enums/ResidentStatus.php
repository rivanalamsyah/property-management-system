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
            self::PENDING => 'Menunggu Review',
            self::RESERVED => 'Dipesan',
            self::ACTIVE => 'Penghuni Aktif',
            self::LATE_PAYMENT => 'Terlambat Bayar',
            self::MOVING_OUT => 'Proses Pindah',
            self::FORMER => 'Mantan Penghuni',
            self::BLACKLISTED => 'Daftar Hitam',
            self::INACTIVE => 'Tidak Aktif',
        };
    }
}

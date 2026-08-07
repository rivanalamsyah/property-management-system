<?php

namespace App\Enums;

enum ComplaintStatus: string
{
    case OPEN = 'open';
    case REVIEWED = 'reviewed';
    case ASSIGNED = 'assigned';
    case IN_PROGRESS = 'in_progress';
    case WAITING_PARTS = 'waiting_parts';
    case COMPLETED = 'completed';
    case VERIFIED = 'verified';
    case CLOSED = 'closed';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::OPEN => 'Komplain Terbuka',
            self::REVIEWED => 'Kasus Ditinjau',
            self::ASSIGNED => 'Teknisi Ditugaskan',
            self::IN_PROGRESS => 'Sedang Dikerjakan',
            self::WAITING_PARTS => 'Menunggu Suku Cadang',
            self::COMPLETED => 'Pekerjaan Selesai',
            self::VERIFIED => 'Terverifikasi Selesai',
            self::CLOSED => 'Kasus Ditutup',
            self::CANCELLED => 'Laporan Dibatalkan',
        };
    }
}

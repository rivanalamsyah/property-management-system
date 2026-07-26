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
            self::OPEN => 'Open Complaint',
            self::REVIEWED => 'Case Reviewed',
            self::ASSIGNED => 'Technician Assigned',
            self::IN_PROGRESS => 'Repair In Progress',
            self::WAITING_PARTS => 'Waiting Parts',
            self::COMPLETED => 'Work Completed',
            self::VERIFIED => 'Verified Resolved',
            self::CLOSED => 'Case Closed',
            self::CANCELLED => 'Cancelled Case',
        };
    }
}

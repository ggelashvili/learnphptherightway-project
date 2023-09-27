<?php

namespace App\Enums;

class Status
{
    public const PAID = 'paid';
    public const PENDING = 'pending';
    private const DECLINE = 'decline';

    public const ALL_STATUSES = [
        self::PAID => 'Paid',
        self::PENDING => 'Pending',
        self::DECLINE => 'Decline',
    ];
}

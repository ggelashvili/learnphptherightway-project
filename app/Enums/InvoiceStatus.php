<?php

declare(strict_types = 1);

namespace App\Enums;

class InvoiceStatus
{
    const Pending = 0;
    const Paid    = 1;
    const Void    = 2;
    const Failed  = 3;

    public static function toString(int $status): string
    {
        return match ($status) {
            self::Paid   => 'Paid',
            self::Failed => 'Declined',
            self::Void   => 'Void',
            default      => 'Pending'
        };
    }
}

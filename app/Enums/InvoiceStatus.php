<?php

declare(strict_types = 1);

namespace App\Enums;

enum InvoiceStatus: int
{
    case Pending = 0;
    case Paid    = 1;
    case Void    = 2;
    case Failed  = 3;

    public static function toString(InvoiceStatus $status): string
    {
        return match ($status) {
            self::Paid   => 'Paid',
            self::Failed => 'Declined',
            self::Void   => 'Void',
            default      => 'Pending'
        };
    }
}

<?php

declare(strict_types = 1);

namespace App\Enums;

enum InvoiceStatus: int
{
    case Pending = 0;
    case Paid    = 1;
    case Void    = 2;
    case Failed  = 3;

    public function toString(): string
    {
        return match($this) {
            self::Paid   => 'Paid',
            self::Failed => 'Declined',
            self::Void   => 'Void',
            default      => 'Pending'
        };
    }

    public function color(): Color
    {
        return match($this) {
            self::Paid   => Color::Green,
            self::Failed => Color::Red,
            self::Void   => Color::Gray,
            default      => Color::Orange
        };
    }

    public static function fromColor(Color $color): InvoiceStatus
    {
        return match($color) {
            Color::Green => self::Paid,
            Color::Gray  => self::Void,
            Color::Red   => self::Failed,
            default      => self::Pending
        };
    }
}

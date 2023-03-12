<?php

declare(strict_types=1);

namespace App\Utilities;

class Currency
{
    public static function formatDollarAmount(float $amount): string
    {
        $isNegative = $amount < 0;
        return ($isNegative ? '-' : '') . '$' . number_format(abs($amount), 2);
    }
}

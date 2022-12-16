<?php

declare(strict_types=1);

namespace App\Services;

class CommonHelper
{
    public function currency($amount)
    {
        $amount = (float) $amount;

        $isNegative = $amount < 0;

        return ($isNegative ? '-' : '').'$'.number_format(abs($amount));
    }

    public function dateFormat(string $date)
    {
        return date('M j, Y', strtotime($date));
    }
}

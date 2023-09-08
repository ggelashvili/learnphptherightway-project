<?php

declare(strict_types=1);

namespace App\Utils;

class PriceFormater
{
    public static function prepareForOutput(float|string $amount): string
    {
        if (is_numeric($amount)) {
            $amount = number_format((float)$amount, 2, '.', ',');
            return ($amount < 0)
                ? str_replace('-', '-$', $amount)
                : "\${$amount}";
        }

        return (string) $amount;
    }

    public static function assingColorClass(float $amount): string
    {
        if ($amount < 0) return 'red';

        return 'green';
    }
}

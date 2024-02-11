<?php

namespace App\Ui;

class UsdCurrencyFormatter
{
    public function format(float $amount): string
    {
        $isNegative = $amount < 0;

        return ($isNegative ? '-' : '').'$'.number_format(abs($amount), 2);
    }
}
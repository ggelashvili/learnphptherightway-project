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

    public function dateFormat(string $date, string $inputFormat = 'm/d/Y', string $returnFormat = 'Y-m-d')
    {
        $dateObj = \DateTime::createFromFormat($inputFormat, $date);
        if (!$dateObj) {
            throw new \UnexpectedValueException("Could not parse the date: {$date}");
        }

        return $dateObj->format($returnFormat);
    }
}

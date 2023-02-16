<?php

declare(strict_types = 1);

namespace App\Helpers;

class MainHelper
{
    public static function dateFormat(string $date): string
    {
      return date('M j, Y', strtotime($date));
    }
    public static function amountFormat(float $amount): string
    {
      if ($amount < 0) {
        return '-$' . abs($amount);
      }
      return '$' . $amount;
    }
}
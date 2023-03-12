<?php

declare(strict_types=1);

namespace App\Utilities;

class DateTime
{
    public static function formatDate(string $date): string
    {
        return date('M d, Y', strtotime($date));
    }
}

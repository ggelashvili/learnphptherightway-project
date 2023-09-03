<?php 

    declare(strict_types=1);

    function formatDate(string $date) {
        return date("M j,Y", strtotime($date));
    }

    function formatDollarAmount(float $amount): string {
        $isNegative = $amount < 0;
        return ($isNegative ? '-' : '') . '$' . number_format(abs($amount), 2);
    }

?>
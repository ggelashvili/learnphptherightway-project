<?php

namespace App\Models;

class Transaction extends Model
{
    protected string $table = 'transactions';

    public static function parseDate(string $date): string
    {
        return (new \DateTime($date))->format('M j, Y');
    }

    public static function parseAmount(float $amount)
    {
        $isNegative = $amount < 0;
        return ($isNegative ? '-' : '') . '$' . number_format(abs($amount), 2);
    }

    public static function calculateTotals(array $expenses): array
    {
        $totals = [
            'expenses' => 0,
            'incomes' => 0,
            'net' => 0
        ];

        foreach ($expenses as $expense)
        {
            $totals['net'] += $expense['amount'];

            if($expense['amount'] < 0) {
                $totals['expenses'] += $expense['amount'];
            } else {
                $totals['incomes'] += $expense['amount'];
            }
        }

        return $totals;
    }
}
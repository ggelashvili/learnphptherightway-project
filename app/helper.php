<?php

declare(strict_types=1);

function dollarFormatter(float $number)
{
    if ($number > 0)
    {
        return '$'.number_format($number, 2, '.', ',');
    }
    else
        return '-$'.number_format(abs($number), 2, '.', ',');
}

function dateFormatter(string $date)
{
    $date = date_create($date);
    return date_format($date, 'M d, Y');
}

function getIncome(array $transactions) : float
{
    $totalIncome = 0.0;
    foreach ($transactions as $transaction)
    {
        if($transaction['amount'] > 0)
        {
            $totalIncome += $transaction['amount'];
        }

    }
    return $totalIncome;
}

function getExpense(array $transactions) : float
{
    $totalIncome = 0.0;
    foreach ($transactions as $transaction)
    {
        if($transaction['amount'] < 0)
        {
            $totalIncome += $transaction['amount'];
        }

    }
    return $totalIncome;
}
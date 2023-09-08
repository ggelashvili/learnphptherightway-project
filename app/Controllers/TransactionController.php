<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\TransactionModel;
use App\View;

use App\Utils\PriceFormater;

class TransactionController
{
    public function index(): View
    {
        $transactions = new TransactionModel();

        return View::make('transactions', [
            'records'        => $transactions->getRecords(),
            'totalIncome'    => $transactions->getTotalIncome(),
            'totalExpense'   => $transactions->getTotalExpese(),
            'formatPrice'    => [PriceFormater::class, 'prepareForOutput'],
            'getAmountClass' => [PriceFormater::class, 'assingColorClass']
        ]);
    }
}

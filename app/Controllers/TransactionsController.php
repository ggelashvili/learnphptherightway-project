<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\Models\TransactionModel;
use App\View;

class TransactionsController
{
    public function index(): View
    {
        $transactionModel = new TransactionModel();
        $transactions = $transactionModel->getTransactions();

        return View::make('transactions', ['transactions' => $transactions]);
    }


}
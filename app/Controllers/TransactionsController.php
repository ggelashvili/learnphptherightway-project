<?php

declare(strict_types=1);

namespace App\Controllers;

use App\View;
use App\Models\Transaction;

class TransactionsController
{
    private Transaction $transaction;

    public function __construct()
    {
        $this->transaction = new Transaction();
    }

    public function index(): View
    {
        return View::make('transactions', [
            'transactions' => $this->transaction->all(),
            'totalIncome' => $this->transaction->totalIncome(),
            'totalExpense' => $this->transaction->totalExpense(),
            'netTotal' => $this->transaction->netTotal()
        ]);
    }
}

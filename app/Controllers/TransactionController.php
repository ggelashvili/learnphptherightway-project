<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\View;
use App\Models\Transaction;

class TransactionController
{
    public function index(): View
    {
        $transaction = new Transaction();
        $transactions = $transaction->getAll();
        $totals = [
            'totalIncome' => $transaction->getTotalIncome(),
            'totalExpense' => $transaction->getTotalExpense(),
            'netTotal' => $transaction->getNetTotal(),
        ];

        return View::make('transactions', ['transactions' => $transactions, 'totals' => $totals]);
    }

    public function upload()
    {
        $transaction = new Transaction();

        $transaction->handleUpload($_FILES['table']);

        $transaction->createMany();

        return View::make('messages/success');
    }
}
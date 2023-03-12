<?php

declare(strict_types=1);

namespace App\Controllers;

use App\View;
use App\Models\Transaction;

class TransactionController
{
    public function index(): View
    {
        return View::make('transactions/index');
    }

    public function listTransactions(): View
    {
        $transaction = new Transaction();
        $rawTransactions = $transaction->findAll();

        $params = $this->getFormattedTransactionParams($rawTransactions);
        return View::make(
            'transactions/list',
            $params
        );
    }

    private function getFormattedTransactionParams(array $rawTransactions)
    {
        $transactions = [];
        $totals = [
            'totalIncome' => 0,
            'totalExpense' => 0,
            'netTotal' => 0
        ];
        foreach ($rawTransactions as $transaction) {
            $transactions[] = [
                'date' => $transaction['created_on'],
                'checkNumber' => $transaction['check_number'],
                'description' => $transaction['description'],
                'amount' => (float) $transaction['amount'],
            ];

            if ($transaction['amount'] < 0) {
                $totals['totalExpense'] += $transaction['amount'];
            } else {
                $totals['totalIncome'] += $transaction['amount'];
            }
            $totals['netTotal'] += $transaction['amount'];
        }

        return [
            'transactions' => $transactions,
            'totals' => $totals
        ];
    }

    public function upload(): string
    {
        $transaction = new Transaction();
        $transaction->import();

        header('Location: /transactions/view');
        exit;
    }
}

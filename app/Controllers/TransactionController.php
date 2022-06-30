<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Transaction;
use App\View;

class TransactionController
{
    public function index(): View
    {
        return View::make('upload');
    }

    public function process(): View
    {
        $newUrl = STORAGE_PATH . '/' . $_FILES['transactionsFile']['name'];
        move_uploaded_file(
            $_FILES['transactionsFile']['tmp_name'],
            $newUrl
        );

        $file = fopen($newUrl, 'r');
        $rowCount = 0;

        while (($row = fgetcsv($file)) !== false) {
            if ($rowCount > 0) {
                $transaction = new Transaction(
                    \DateTime::createFromFormat('m/d/Y', $row[0]),
                    (int)$row[1],
                    $row[2],
                    (float)str_replace('$', '', $row[3]),
                );

                $transaction->create();
            }
            $rowCount++;
        }

        return View::make('transactions', ["transactions" => Transaction::fetchAll()]);
    }

    public function transactions()
    {
        $totalIncome = 0;
        $totalExpense = 0;
        $netTotal = 0;

        $transactions = Transaction::fetchAll();

        foreach ($transactions as $transaction) {
            if($transaction->getAmount() > 0) {
                $totalIncome += $transaction->getAmount();
            } else {
                $totalExpense += $transaction->getAmount();
            }

            $netTotal += $transaction->getAmount();
        }


        return View::make('transactions', [
            "totalIncome" => $totalIncome,
            "totalExpense" => $totalExpense,
            "netTotal" => $netTotal,
            "transactions" => Transaction::fetchAll()
        ]);
    }
}
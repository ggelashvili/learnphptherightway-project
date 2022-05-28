<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\Models\TransactionModel;
use App\View;

class TransactionsController
{
    public function index(): View
    {
        $transaction = new TransactionModel();
        $transactions = $transaction->loadAll();
        $total_income = 0;
        $total_expense = 0;
        foreach ($transactions as $transaction) {
            $amount = $transaction['amount'];
            if ($amount > 0) {
                $total_income += $amount;
            }
            else {
                $total_expense += $amount;
            }
        }
        return View::make('transactions', [
            'transactions' => $transactions,
            'total_income' => $total_income,
            'total_expense' => $total_expense
        ]);
    }

    public function upload()
    {
        $transactions = $_FILES['transactions-file'];
        foreach ($transactions['tmp_name'] as $tmp_name) {
            if (($handle = fopen($tmp_name, 'rb')) !== false) {
                // Get rid of headers row.
                fgetcsv($handle);
                while (($data = fgetcsv($handle)) !== false) {
                    [$date, $check_number, $description, $amount] = $data;
                    $datetime = \DateTime::createFromFormat('m/d/Y', $date);
                    $date = $datetime->format('Y-m-d');
                    $amount = str_replace(['$', ','], '', $amount);
                    $check_number = (empty($check_number)) ? null : (int) $check_number;

                    $transaction = new TransactionModel();
                    $transaction->create($date, $check_number, $description, $amount);
                }
            }
        }

        header('Location: /transactions');
        exit;
    }

    private function formatAmount(float $amount): string
    {
        $prefix = ($amount > 0) ? '$' : '-$';
        $formatted_amount = number_format(abs($amount));
        return $prefix . $formatted_amount;
    }
}

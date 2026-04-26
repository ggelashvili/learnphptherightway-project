<?php

namespace App\Services;

use App\Models\Transaction;

class TransactionService
{
    public Transaction $model;

    public function __construct()
    {
        $this->model = new Transaction();
    }

    public function getTransactionsFiles(string $dirPath) : array
    {
        $files = [];

        foreach (scandir($dirPath) as $file) {
            if(is_dir($file)){
                continue;
            }

            $files[] = $dirPath . DIRECTORY_SEPARATOR . $file;
        }

        return $files;
    }

    public function getTransactionsFromFile(string $fileName): array
    {
        if(! file_exists($fileName)) {
            trigger_error('Such file does not exist');
        }

        $file = fopen($fileName, 'r');

        fgetcsv($file);

        $transactions = [];

        while (($transaction = fgetcsv($file)) != false)
        {
            $transactions[] = $transaction;
        }

        return $transactions;
    }

    public function uploadTransactionsToDb(array $transactions): bool
    {
        try {
            foreach ($transactions as $transaction)
            {

                [$date, $checkNumber, $description, $amount] = $transaction;

                $checkNumber = $checkNumber === '' ? null : $checkNumber;

                $date = \DateTime::createFromFormat('m/d/Y', $date)->format('Y-m-d');

                $amount = (float) str_replace(['$', ',', ' '], '', $amount);

                $this->model->create($date, $description, $amount, $checkNumber);
            }
            return true;
        } catch (\Exception $e) {
            error_log("Failed to upload transactions: " . $e->getMessage());
            return false;
        }
    }

    public function getTotals(array $transactions) :array
    {
        $totals = ['netTotal' => 0, 'totalIncome' => 0, 'totalExpense' => 0];

        foreach ($transactions as $transaction)
        {
            $totals['netTotal'] += $transaction['amount'];

            if($transaction['amount'] >= 0) {
                $totals['totalIncome'] += $transaction['amount'];
            } else {
                $totals['totalExpense'] += $transaction['amount'];
            }
        }

        return $totals;
    }
}
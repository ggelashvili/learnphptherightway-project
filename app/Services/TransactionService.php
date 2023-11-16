<?php

namespace App\Services;

use App\Models\Transaction;

class TransactionService
{

    public function handleTransactionFile($filePath)
    {
        $transactions = [];
        $transactions = $this->readFile($filePath);

        $this->saveTransactions($transactions);
    }
    private function readFile($filePath): array
    {
        if(! file_exists($filePath)) {
            throw new \Exception('File not found');
        }

        $file = fopen($filePath, 'r');

        fgetcsv($file);

        $transactions = [];

        while (($line = fgetcsv($file)) !== false)
        {
            $transactions[] = $this->parseTransaction($line);
        }

        fclose($file);

        return $transactions;
    }

    private function parseTransaction(array $transaction): array
    {
        [$date, $check, $description, $amount] = $transaction;
        $amount = str_replace(['$', ','], '', $amount);

        $date = (new \DateTime($date))->format('Y-m-d');

        $data = [
            'date' => $date ,
            'description' => $description,
            'amount' => (float) $amount
        ];

        if($check) {
          $data['check_num'] = $check;
        }
        return $data;
    }

    private function saveTransactions(array $transactions): void
    {
        $transactionObj = new Transaction();

        foreach ($transactions as $transaction) {
            $transactionObj->create($transaction);
        }
    }
}
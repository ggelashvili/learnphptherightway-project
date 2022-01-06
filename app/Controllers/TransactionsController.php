<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\TransactionModel;
use App\View;
use App\Exceptions\FileUploadException;

class TransactionsController
{
    public function index(): View
    {
        $transactionModel = new TransactionModel();
        $transactions = $transactionModel->getTransactions();
        $total = [
            'totalIncome' => $transactionModel->getTotalIncome(),
            'totalExpense' => $transactionModel->getTotalExpense(),
            'netTotal' => $transactionModel->getNetTotal(),
        ];

        return View::make('transactions', ['transactions' => $transactions, 'total' => $total]);
    }

    /**
     * @throws FileUploadException
     */
    public function upload(): View
    {
        if ($_FILES['table']['error'] > 0) {
            throw new FileUploadException('File not Found');
        }

        if (!$_FILES['table']['type'] == 'application/vnd.ms-excel') {
            throw new FileUploadException('Wrong filetype. We need .csv');
        }

        $transactionModel = new TransactionModel();

        $file = fopen($_FILES['table']['tmp_name'], 'r');

        fgetcsv($file);
        $transactions = [];
        while (($line = fgetcsv($file)) !== false) {
            [$date, $checkNumber, $description, $amount] = $line;

            $date = (new \DateTime($date))->format('y-m-d',);
            $amount = (float)str_replace(['$', ','], '', $amount);
            $checkNumber = $checkNumber != '' ? (int)$checkNumber : null;

            $transactions[] = [
                'date' => $date,
                'checkNumber' => $checkNumber,
                'description' => $description,
                'amount' => $amount
            ];

        }
        $transactionModel->createMany($transactions);
        fclose($file);

        return View::make('upload_success');
    }


}
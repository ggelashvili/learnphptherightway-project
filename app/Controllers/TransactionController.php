<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Exceptions\FileUploadException;
use App\Models\Transaction;
use App\View;

class TransactionController
{

    public function index(): View
    {
        $transactions = (new Transaction())->getAll();

        for ($i = 0; $i < count($transactions); $i++)
            $transactions[$i] = $this->extractTransaction($transactions[$i]);

        return View::make('transactions', ['transactions' => $transactions]);
    }

    public function transactionUploadPage(): View
    {
        return View::make('transactions-upload');
    }

    public function storeFromFilesToDB()
    {
        $files = $_FILES['csvs'];
        $transaction = new Transaction();

        for ($i = 0; $i < count($files['name']); $i++) {

            if ($files['error'][$i] > 0) {
                throw new FileUploadException('File not Found');
            }
            if ($files['type'][$i] !== 'text/csv') {
                throw new FileUploadException('Wrong filetype. We need .csv');
            }

            $tmpFilePath = $files['tmp_name'][$i];

            if ($tmpFilePath != "") {
                $newFilePath = STORAGE_PATH . '/' . $files['name'][$i];

                if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                    if (($open = fopen(STORAGE_PATH . "/" . $files['name'][$i], "r")) !== FALSE) {
                        fgetcsv($open); // first row is not data.
                        $transactionData = [];
                        while (($data = fgetcsv($open)) !== FALSE) {
                            $transactionData[] = [
                                'date' => $data[0],
                                'check' => $data[1],
                                'desc' => $data[2],
                                'amount' => $data[3]
                            ];
                        }
                        $transaction->createMany($transactionData);
                        fclose($open);
                    }
                }
            }
        }

        header('Location: /MVC-file-parse/transactions');
    }

    private function extractTransaction(array $transactionRow): array
    {
        $amount = str_replace(['$', ','], '', $transactionRow['t_amount']);
        return [
            'date' => $transactionRow['t_date'],
            'check' => $transactionRow['t_check'],
            'description' => $transactionRow['t_desc'],
            'amount' => (float)$amount
        ];
    }
}
<?php

declare(strict_types=1);

namespace App\Controllers;

use App\File;
use App\Models\ProcessTransaction;
use App\Models\Transaction;
use App\View;

class TransactionController
{
    public function index(): View
    {
        $transactions = (new Transaction())->all();
        $processTransaction = new ProcessTransaction($transactions);
        $processTransaction->process();

        return View::make('transactions.index', ['processedTransaction' => $processTransaction]);
    }

    public function prepareUpload(): View
    {
        return View::make('transactions.upload');
    }

    public function upload()
    {
        $files = File::normalize('files');

        foreach ($files as $file) {
            if (!file_exists($file['path']) || !is_readable($file['path'])) {
                continue;
            }

            if (File::isCSV($file['path'])) {
                Transaction::processUploadFile($file['path']);
            }
        }

        header('Location: /transactions');
    }
}

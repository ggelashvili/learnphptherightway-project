<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\TransactionModel;
use App\Services\CSVHelper;

class ScanAllFilesController
{
    protected TransactionModel $transaction;
    protected CSVHelper $csvHelper;

    public function __construct()
    {
        $this->transaction = new TransactionModel();
        $this->csvHelper = new CSVHelper();
    }

    protected function scanAllFiles(): void
    {
        $path = STORAGE_PATH.'/';

        $allFilesTransactions = [];
        foreach (glob($path.'*.csv') as $file) {
            $allFilesTransactions[] = $this->csvHelper->scanFileByPath($file);
        }

        foreach ($allFilesTransactions as $transactions) {
            $this->transaction->bulkCreate($transactions);
        }
    }
}

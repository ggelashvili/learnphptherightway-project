<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\TransactionModel;
use App\Services\CSVHelper;

class UploadController
{
    protected TransactionModel $transaction;
    protected CSVHelper $csvHelper;

    public function __construct()
    {
        $this->transaction = new TransactionModel();
        $this->csvHelper = new CSVHelper();
    }

    public function upload(): void
    {
        $fileName = 'transaction_file';
        $files = $_FILES[$fileName];

        $count = count($_FILES['transaction_file']['name']);

        for ($i = 0; $i < $count; ++$i) {
            if (0 == $files['error'][$i]) {
                $filePath = STORAGE_PATH.'/'.$files['name'][$i];

                move_uploaded_file($files['tmp_name'][$i], $filePath);
                $_SESSION['success_msg'] = ($i + 1).' file(s) uploaded successfully.';

                $transactions = $this->csvHelper->scanFileByPath($filePath);

                $this->transaction->bulkCreate($transactions);
                header('location: /transactions');
            } else {
                $_SESSION['error_msg'] = $files['name'][$i].' file upload error.';
                header('location: /');
            }
        }
    }
}

<?php

declare(strict_types=1);

namespace App\Controllers;

use App\View;
use App\CsvReader;
use App\FileUtils;
use App\Models\Transaction;

class FileUploadController
{

    private Transaction $transaction;

    public function __construct()
    {
        $this->transaction = new Transaction();
    }

    public function index(): View
    {
        return View::make('upload');
    }

    public function store(): View
    {
        $message = '';
        $transactionCount = 0;
        $uploadedFiles = $_FILES['transactions'];

        $uploadedFilesCount = count($uploadedFiles['name']);

        for ($i = 0; $i < $uploadedFilesCount; $i++) {

            $filePath = FileUtils::store($uploadedFiles['name'][$i], $uploadedFiles['tmp_name'][$i]);

            $file = new CsvReader($filePath);

            while ($row = $file->parseTransactionRow()) {
                $this->transaction->create(...$row);
                $transactionCount++;
            }
        }

        if ($transactionCount > 0 && $uploadedFilesCount > 0)
            $message = "$transactionCount transaction(s) from $uploadedFilesCount file(s), have been successfully uploaded.";

        return View::make('upload', ['message' => $message]);
    }
}

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

        $filePath = FileUtils::store($_FILES['transactions']);

        $file = new CsvReader($filePath);
        $transactionCount = 0;

        while ($row = $file->parseTransactionRow()) {
            $this->transaction->create(...$row);
            $transactionCount++;
        }

        if ($transactionCount > 0)
            $message = "$transactionCount transactions have been successfully uploaded.";

        return View::make('upload', ['message' => $message]);
    }
}

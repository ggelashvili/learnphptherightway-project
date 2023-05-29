<?php

declare(strict_types=1);

namespace App\Controllers;

use App\View;
use App\CsvReader;
use App\Exceptions\FileUploadFailedException;
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

        $uploadedFilesCount = is_array($uploadedFiles['name']) ? count($uploadedFiles['name']) : 1;

        for ($i = 0; $i < $uploadedFilesCount; $i++) {

            try {
                $filePath = FileUtils::store($uploadedFiles['name'][$i], $uploadedFiles['tmp_name'][$i]);
            } catch (FileUploadFailedException) {
                return View::make('upload', ['message' => "File upload failed or no files were uploaded",'msgColor' => 'red']);
            }

            $file = new CsvReader($filePath);

            while ($row = $file->parseTransactionRow()) {
                $this->transaction->create(...$row);
                $transactionCount++;
            }
        }

        if ($transactionCount > 0 && $uploadedFilesCount > 0)
            $message = "$transactionCount transaction(s) from $uploadedFilesCount file(s), have been successfully uploaded.";

        return View::make('upload', ['message' => $message, 'msgColor' => 'green']);
    }
}

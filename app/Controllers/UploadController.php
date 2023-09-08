<?php

declare(strict_types=1);

namespace App\Controllers;

use App\View;
use App\Helper\File;
use App\Helper\XMLParser;
use App\Models\TransactionModel;

class UploadController
{
    public function index(): View
    {
        return View::make('upload');
    }

    public function moveFilesToTheServer()
    {
        $transactionModel = new TransactionModel();

        $files = File::getFileInfo($_FILES['files']);

        foreach ($files as  $file) {
            File::upload($file['name'], $file['tmp_name']);
            $transactionModel->parseCsv($file['name'], [XMLParser::class, 'parse']);
        }

        header('Location: /transactions');
    }
}

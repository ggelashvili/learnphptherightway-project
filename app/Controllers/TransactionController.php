<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\ProcessTransaction;
use App\Models\Transaction;
use App\View;

class TransactionController
{
    public function index()
    {
        $transactions = (new Transaction())->all();
        $processTransaction = new ProcessTransaction($transactions);
        $processTransaction->process();

        return View::make('transactions', ['processedTransaction' => $processTransaction]);
    }

    public function prepareUpload()
    {
        //TODO: view do form para upload do arquivo
    }

    public function upload()
    {
        //TODO: trata o upload do arquivo
    }
}

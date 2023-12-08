<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Transaction;
use App\View;

class TransactionController
{
    public function index(): View
    {
        return View::make('transactions', [
            'transactions' => (new Transaction())->all(),
        ]);
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

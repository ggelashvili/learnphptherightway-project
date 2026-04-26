<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\TransactionService;
use App\View;

class TransactionController
{
    public TransactionService $service;
    public function __construct()
    {
        $this->service = new TransactionService();
    }
    public function index(): View
    {
        $transactions = $this->service->model->all();

        $totals = [];

        if(count($transactions) > 0) {
            $totals = $this->service->getTotals($transactions);
        }

        return View::make('transactions', compact('transactions', 'totals'));
    }

    public function import()
    {
        $files = $this->service->getTransactionsFiles(TRANSACTIONS_PATH);

        $transactions = [];

        foreach ($files as $file)
        {
            $transactions = array_merge($transactions, $this->service->getTransactionsFromFile($file));
        }

        $this->service->uploadTransactionsToDb($transactions);

        header('Location: /transactions');
        exit;
    }
}
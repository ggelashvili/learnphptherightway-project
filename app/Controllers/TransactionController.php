<?php

namespace App\Controllers;

use App\Models\Transaction;
use App\Services\TransactionService;
use App\View;

class TransactionController
{
    private TransactionService $transactionService;

    public function __construct()
    {
        $this->transactionService = new TransactionService();
    }

    public function index(): View
    {
        $transactionObj = new Transaction();

        $transactions = $transactionObj->find();

        $totals = $transactionObj::calculateTotals($transactions);

        return View::make('transaction/index', [
            'transactions' => $transactions,
            'totals' => $totals
            ]
        );
    }

    public function create(): View
    {
        return View::make('transaction/create');
    }

    public function store()
    {
        $filePath = STORAGE_PATH . '/' . $_FILES['file']['name'];

        move_uploaded_file($_FILES['file']['tmp_name'], $filePath);

        $this->transactionService->handleTransactionFile($filePath);

        header('Location:/transactions');
    }
}
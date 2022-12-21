<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\TransactionModel;
use App\Services\CommonHelper;
use App\View;

class TransactionController
{
    public function index(): View
    {
        $transactionModel = new TransactionModel();
        $transactions = $transactionModel->findAll();

        $totals = $transactionModel->calculateTotals($transactions);
        $totals = $transactionModel->formatAmountByTotal($totals);

        return View::make('transactions', [
            'transactions' => $transactions,
            'totals' => $totals,
            'commonHelper' => new CommonHelper(),
        ]);
    }

    public function delete(): void
    {
        $id = isset($_GET['id']) ? (int) $_GET['id'] : null;

        if (!$id) {
            $_SESSION['error_msg'] = 'Delete ID not found.';
            header('location: /transactions');

            exit;
        }

        $transactionModel = new TransactionModel();
        $transactionModel->delete($id);

        $_SESSION['success_msg'] = 'Deleted successfully.';
        header('location: /transactions');
    }
}

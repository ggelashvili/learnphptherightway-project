<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\Models\Transactions;
use App\View;

class TransactionsController
{
    public function transactions(): View
    {
      return View::make('transactions',
      [
        'transactions' => Transactions::getTransactions(),
        'totals' => Transactions::calculateTotals(),
      ]);
    }
    public function upload(): void
    {
        header('Location: /transactions');
        Transactions::uploadTransactions($_FILES['transactions']["tmp_name"]);
        exit;
    }
}

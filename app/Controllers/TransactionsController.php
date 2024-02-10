<?php

namespace App\Controllers;

use App\Ui\View;

class TransactionsController
{
    public function index(): View
    {
        return View::make('transactions');
    }
}
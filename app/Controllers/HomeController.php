<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Transaction;
use App\View;

class HomeController
{
	public function index(): View
	{
		$transactions = Transaction::getAll();
		$positive = array_filter($transactions, fn($transaction) => $transaction->getAmount() >= 0);
		$negative = array_filter($transactions, fn($transaction) => $transaction->getAmount() < 0);
		$income = array_reduce($positive, fn($sum, Transaction $transaction) => $transaction->getAmount() + $sum, 0);
		$expense = array_reduce($negative, fn($sum, Transaction $transaction) => $transaction->getAmount() + $sum, 0);
		return View::make('transactions', array('transactions' => $transactions, 'income' => $income, 'expense' => $expense));
	}
}

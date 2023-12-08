<?php


declare(strict_types=1);

namespace App\Models;

class ProcessTransaction
{
    private float $totalIncome;
    private float $totalExpenses;
    private TransactionCollection $transactions;

    public function __construct(TransactionCollection $transactions)
    {
        $this->totalIncome = 0;
        $this->totalExpenses = 0;
        $this->transactions = $transactions;
    }

    public function process(): void
    {
        /** @var Transaction $transaction */
        foreach ($this->transactions as $transaction) {
            if ($transaction->amount >= 0) {
                $this->totalIncome += $transaction->amount;
            } else {
                $this->totalExpenses -= $transaction->amount;
            }
        }
    }

    public function getTotalIncome(): float
    {
        return $this->totalIncome;
    }

    public function getTotalExpense(): float
    {
        return $this->totalExpenses;
    }

    public function getNetTotal(): float
    {
        return $this->totalIncome - $this->totalExpenses;
    }

    public function getTransactions(): TransactionCollection
    {
        return $this->transactions;
    }
}

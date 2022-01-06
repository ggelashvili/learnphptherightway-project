<?php

namespace App\Models;

use App\Model;

class TransactionModel extends Model
{
    public function getTransactions(): array
    {
        $query = 'select * from transactions';
        $statement = $this->db->prepare($query);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function getTotalIncome(): float
    {
        $query = 'select sum(amount) as totalIncome from transactions where amount > 0';
        $statement = $this->db->prepare($query);
        $statement->execute();
        $row = $statement->fetch();

        return $row['totalIncome'] ?? 0;
    }

    public function getTotalExpense(): float
    {
        $query = 'select sum(amount) as totalExpense from transactions where amount < 0';
        $statement = $this->db->prepare($query);
        $statement->execute();
        $row = $statement->fetch();

        return $row['totalExpense'] ?? 0;
    }

    public function getNetTotal(): float
    {
        $query = 'select sum(amount) as netTotal from transactions';
        $statement = $this->db->prepare($query);
        $statement->execute();
        $row = $statement->fetch();

        return $row['netTotal'] ?? 0;
    }

    public function create(string $date, ?int $checkNumber, string $description, float $amount)
    {
        $query = 'insert into transactions(`check #`, `description`, `amount`, `date`)
                  values (:checkNumber, :description, :amount, :date)';
        $statement = $this->db->prepare($query);
        $statement->execute([
            'checkNumber' => $checkNumber,
            'description' => $description,
            'amount' => $amount,
            'date' => $date
        ]);
    }

    public function createMany(array $transactions)
    {
        $query = 'insert into transactions(`check #`, `description`, `amount`, `date`)
                  values (:checkNumber, :description, :amount, :date)';
        $statement = $this->db->prepare($query);
        foreach ($transactions as $key => $transaction) {
            $statement->execute($transaction);
        }
    }

}
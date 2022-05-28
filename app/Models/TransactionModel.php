<?php

declare(strict_types=1);

namespace App\Models;

use App\Model;

class TransactionModel extends Model
{
    public function create(string $date, ?int $check_number, string $description, string $amount): int
    {
        $statement = $this->db->prepare(
          'INSERT INTO transactions (date, description, amount, check_number)
            VALUES (:date, :description, :amount, :check_number)'
        );

        $statement->bindValue(':date', $date);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':amount', $amount);
        $statement->bindValue(':check_number', $check_number);
        $statement->execute();

        return (int) $this->db->lastInsertId();
    }

    public function loadAll(): array
    {
        $statement = $this->db->prepare(
            'SELECT date, check_number, description, amount
            FROM transactions'
        );
        $statement->execute();
        return $statement->fetchAll();
    }
}
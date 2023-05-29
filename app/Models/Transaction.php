<?php

declare(strict_types=1);

namespace App\Models;

use App\Model;
use DateTime;

class Transaction extends Model
{

    public function create(DateTime $date, ?int $check_number, string $description, float $amount)
    {
        $query = 'INSERT INTO transactions (date,check_number,description,amount) 
        VALUES (:date, :check_number, :description, :amount)';

        $stmt = $this->db->prepare($query);

        $stmt->execute(
            [
                'date' => $date->format('Y-m-d'),
                'check_number' => $check_number,
                'description' => $description,
                'amount' => $amount
            ]
        );
    }

    public function all(): array
    {
        $query = 'SELECT * FROM transactions';

        $stmt = $this->db->prepare($query);

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function totalExpense(): float
    {
        $query = 'SELECT SUM(amount) as "total" FROM transactions WHERE amount < 0';

        $stmt = $this->db->prepare($query);

        $stmt->execute();

        return (float) $stmt->fetch()['total'];
    }

    public function totalIncome(): float
    {
        $query = 'SELECT SUM(amount) as "total" FROM transactions WHERE amount > 0';

        $stmt = $this->db->prepare($query);

        $stmt->execute();

        return (float) $stmt->fetch()['total'];
    }

    public function netTotal(): float
    {
        $query = 'SELECT SUM(amount) as total FROM transactions';

        $stmt = $this->db->prepare($query);

        $stmt->execute();

        return (float) $stmt->fetch()['total'];
    }
}

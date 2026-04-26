<?php

namespace App\Models;

use App\Model;

class Transaction extends Model
{

    public function create(string $date, string $description, float $amount, ?string $checkNumber = null): int
    {
        $stmt = $this->db->prepare('INSERT INTO transactions (date, checkNumber, description, amount)
                                            VALUES (?, ?, ?, ?)');

        $stmt->execute([$date, $checkNumber, $description, $amount]);

        return $this->db->lastInsertId();
    }

    public function all() :array
    {
        $stmt = $this->db->query('SELECT * FROM transactions ORDER BY date DESC ');

        return $stmt->fetchAll();
    }

}
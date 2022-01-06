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
}
<?php

declare(strict_types=1);

namespace App\Models;

use App\Config;
use App\DB;
use PDO;

class Transaction
{
    private DB $db;

    public function __construct(Config $config)
    {
        $this->db = new DB($config->__get('db'));
    }

    public function insert(array $data): void
    {
        $stmt = $this->db->prepare('INSERT INTO transactions (transaction_date, cheque_number, transaction_description, transaction_amount) 
            VALUES (:trnx_date, :cheque_number, :transaction_description, :transaction_amount);
        ');

        $stmt->bindParam(':trnx_date', $data['trnx_date'], PDO::PARAM_STR);
        $stmt->bindParam(':cheque_number', $data['chk_num'], PDO::PARAM_STR);
        $stmt->bindParam(':transaction_description', $data['trnx_desc'], PDO::PARAM_STR);
        $stmt->bindParam(':transaction_amount', $data['trnx_amt'], PDO::PARAM_STR);
        $stmt->execute();
    }

    public function get(): array
    {
        $stmt = $this->db->query('
            SELECT transaction_date, cheque_number, transaction_description, transaction_amount 
            FROM transactions;
        ');

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
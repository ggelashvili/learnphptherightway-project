<?php
declare(strict_types=1);


namespace App\Models;

use App\Model;
use PDO;

class Transaction extends Model
{

    public function getAll() : array
    {
        return $this->db->query('SELECT * FROM transactions')->fetchAll();
    }

    public function create(string $date, string $check , string $desc, string $amount) : int
    {
        $stmt = $this->db->prepare('INSERT INTO transactions (t_date, t_check, t_desc, t_amount)
                VALUES (:date, :check, :desc, :amount)');

        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->bindParam(':check', $check, PDO::PARAM_STR);
        $stmt->bindParam(':desc', $desc, PDO::PARAM_STR);
        $stmt->bindParam(':amount', $amount,PDO::PARAM_STR);

        $stmt->execute();

        return (int)$this->db->lastInsertId();
    }

    public function createMany(array $transactions)
    {
        $query = 'INSERT INTO transactions (t_date, t_check, t_desc, t_amount)
                VALUES (:date, :check, :desc, :amount)';
        $statement = $this->db->prepare($query);
        foreach ($transactions as $transaction) {
            $statement->execute([
                ':date' => $transaction['date'],
                ':check' => $transaction['check'],
                ':desc' => $transaction['desc'],
                ':amount' => $transaction['amount'],
            ]);
        }
    }
}
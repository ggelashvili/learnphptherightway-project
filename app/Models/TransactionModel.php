<?php

declare(strict_types=1);

namespace App\Models;

use App\Model;

class TransactionModel extends Model
{

    public function getRecords(): array
    {
        $query = "SELECT * FROM transactions;";

        $transactions = $this->db->query($query);

        return $transactions->fetchAll();
    }

    public function getTotalExpese(): float
    {
        $query = "SELECT SUM(amount) as totalExpense FROM transactions WHERE amount < 0;";
        $res = $this->db->prepare($query);
        $res->execute();

        $row = $res->fetch(\PDO::FETCH_ASSOC);

        return (float) $row['totalExpense'];
    }

    public function getTotalIncome(): float
    {
        $query = "SELECT SUM(amount) as totalIncome FROM transactions WHERE amount > 0;";
        $res = $this->db->prepare($query);
        $res->execute();
        $row = $res->fetch(\PDO::FETCH_ASSOC);

        return (float) $row['totalIncome'];
    }

    public function insert(
        string $date,
        string $check,
        string $description,
        float $amount
    ): int|string {
        $query = "INSERT INTO transactions (date, transactions.check, description, amount) VALUES (:date, :check, :description, :amount);";

        $transaction = $this->db->prepare($query);

        try {
            $this->db->beginTransaction();

            $transaction->execute([
                'date'        => (new \DateTime($date))->format('Y/m/d h:i:s'),
                'check'       => $check,
                'description' => $description,
                'amount'      => $amount
            ]);

            $this->db->commit();
        } catch (\PDOException) {
            $this->db->rollback();
        }

        return $this->db->lastInsertId();
    }

    public function parseCsv(string $filename, callable $callback)
    {
        $filename = STORAGE_PATH . "/" . $filename;

        try {
            $fp = fopen($filename, 'r');

            fgets($fp);

            while (($line = fgets($fp)) !== false) {
                $xmlData = $callback($line);

                $insert_id = $this->insert(
                    date: $xmlData['date'],
                    check: $xmlData['check'],
                    description: $xmlData['description'],
                    amount: (float) $xmlData['amount']
                );
            }

            fclose($fp);
        } catch (\Error $e) {
            throw $e;
        }
    }
}

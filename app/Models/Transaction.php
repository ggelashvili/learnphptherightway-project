<?php

namespace App\Models;

use App\Model;
use App\Exceptions\UploadException;
use DateTime;

class Transaction extends Model
{
    protected array $transactions = [];

    public function handleUpload(array $fileData): void
    {
        if ($fileData['error'] || $fileData['type'] !== 'text/csv') {
            throw new UploadException;
        }

        $file = fopen($fileData['tmp_name'], 'r');

        $data = [];

        fgetcsv($file);

        while (($line = fgetcsv($file)) !== false) {
            $data[] = $line;
        }

        $this->formatData($data);
    }

    private function formatData(array $data): void
    {
        foreach ($data as $dataEl) {
            $this->transactions[] = [
                'date' => (new DateTime($dataEl[0]))->format('y-m-d'),
                'check_num' => $dataEl[1] ? (int)$dataEl[1] : null,
                'description' => $dataEl[2],
                'amount' => (float)str_replace(['$', ','], '', $dataEl[3]),
            ];
        }
    }

    public function createMany(): void
    {
        $query = 'INSERT INTO transactions(`check_num`, `description`, `amount`, `date`)
                  VALUES (:check_num, :description, :amount, :date)';
        $statement = $this->db->prepare($query);
        $transactions = $this->transactions;

        foreach ($transactions as $transaction) {
            $statement->execute($transaction);
        }
    }

    public function getAll(): array
    {
        $query = 'SELECT * FROM transactions';
        $statement = $this->db->prepare($query);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function getTotalIncome(): float
    {
        $query = 'SELECT sum(amount) AS totalIncome FROM transactions WHERE amount > 0';
        $statement = $this->db->prepare($query);
        $statement->execute();
        $row = $statement->fetch();

        return $row['totalIncome'] ?? 0;
    }

    public function getTotalExpense(): float
    {
        $query = 'SELECT sum(amount) AS totalExpense FROM transactions WHERE amount < 0';
        $statement = $this->db->prepare($query);
        $statement->execute();
        $row = $statement->fetch();

        return $row['totalExpense'] ?? 0;
    }

    public function getNetTotal(): float
    {
        $query = 'SELECT sum(amount) AS netTotal FROM transactions';
        $statement = $this->db->prepare($query);
        $statement->execute();
        $row = $statement->fetch();

        return $row['netTotal'] ?? 0;
    }
}
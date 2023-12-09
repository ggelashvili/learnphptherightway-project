<?php

declare(strict_types=1);

namespace App\Models;

use App\Model;
use DateTime;
use Exception;

class Transaction extends Model
{
    protected int $id;
    public DateTime $date;
    public string $check;
    public string $description;
    public float $amount;


    public function all(): TransactionCollection
    {
        $query = 'select id, date, check_number, description, amount from transactions';

        $statement = $this->db->query($query);

        $transactions = [];

        while (($row = $statement->fetch()) !== false) {
            $transactions[] = $this->createFromRow($row);
        }

        return new TransactionCollection($transactions);
    }

    public function save(): bool
    {
        $query = 'insert into transactions (date, check_number, description, amount) 
                    values (:date, :check_number, :description, :amount)';

        $statement = $this->db->prepare($query);
        $statement->execute([
            ':date' => $this->date->format('Y-m-d'),
            ':check_number' => $this->check,
            ':description' => $this->description,
            ':amount' => $this->amount,
        ]);

        $this->id = (int)$this->db->lastInsertId();

        return $this->id > 0;
    }

    public function saveAll(TransactionCollection $transactionCollection): bool
    {
        $query = 'insert into transactions (date, check_number, description, amount) 
                    values (:date, :check_number, :description, :amount)';

        if ($this->db->inTransaction()) {
            throw new \PDOException('Uma transação já está em andamento');
        }

        try {
            $this->db->beginTransaction();

            $statement = $this->db->prepare($query);

            /** @var Transaction $transaction */
            foreach ($transactionCollection as $transaction) {
                $statement->execute([
                    ':date' => $transaction->date->format('Y-m-d'),
                    ':check_number' => $transaction->check,
                    ':description' => $transaction->description,
                    ':amount' => $transaction->amount,
                ]);

                $transaction->id = (int)$this->db->lastInsertId();
            }

            return $this->db->commit();
        } catch(\PDOException $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public static function processUploadFile(string $path): void
    {
        if (!file_exists($path) || !is_readable($path)) {
            throw new Exception('O arquivo não existe ou não está disponível');
        }

        if (($handle = fopen($path, 'r')) !== false) {
            $transactions = [];

            //Remove header
            fgetcsv($handle);

            while (($data = fgetcsv($handle)) !== false) {
                $transactions[] = Transaction::create(
                    DateTime::createFromFormat('d/m/Y', $data[0]),
                    (string)$data[1],
                    (string)$data[2],
                    (float) str_replace(['$', ','], '', $data[3])
                );
            }

            $transactionsCollection = new TransactionCollection($transactions);
            (new Transaction())->saveAll($transactionsCollection);
        }
    }

    public static function create(DateTime $date, string $check, string $description, float $amount): static
    {
        $transaction = new static();
        $transaction->date = $date;
        $transaction->check = $check;
        $transaction->description = $description;
        $transaction->amount = $amount;

        return $transaction;
    }
    public function createFromRow(array $row): static
    {
        $id = (int) $row['id'];
        $date = DateTime::createFromFormat('Y-m-d', $row['date']);
        $check = (string) $row['check_number'];
        $description = (string) $row['description'];
        $amount = (float) $row['amount'];

        $transaction = Transaction::create($date, $check, $description, $amount);
        $transaction->id = $id;

        return $transaction;
    }
}
